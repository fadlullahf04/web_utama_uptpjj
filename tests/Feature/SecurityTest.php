<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Services\PostXmlImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_headers_are_present_on_web_responses(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Cross-Origin-Opener-Policy', 'same-origin-allow-popups');
        $this->assertTrue($response->headers->has('Content-Security-Policy'));
        $this->assertFalse($response->headers->has('X-Powered-By'));
    }

    public function test_login_rate_limiter_throttles_excessive_failed_attempts(): void
    {
        RateLimiter::clear('hacker@example.com|127.0.0.1');

        $user = User::factory()->create([
            'email' => 'hacker@example.com',
            'password' => bcrypt('StrongPassword123!'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => $user->email,
                'password' => 'WrongPassword',
            ]);
        }

        // 6th attempt should be blocked with 429 Too Many Requests
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'WrongPassword',
        ]);

        $response->assertStatus(429);
    }

    public function test_contact_form_honeypot_ignores_bot_submissions(): void
    {
        $response = $this->post(route('contact.store'), [
            '_hp_company' => 'Automated Bot Crawler',
            'name' => 'Spam Bot',
            'email' => 'bot@spammer.org',
            'phone' => '08123456789',
            'subject' => 'Spam Subject Offer',
            'category' => 'Pertanyaan Umum',
            'message' => 'This is an automated spam message that should not be saved in database.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseMissing('contact_messages', [
            'email' => 'bot@spammer.org',
        ]);
    }

    public function test_non_admin_cannot_access_settings_and_users(): void
    {
        $editor = User::factory()->create([
            'role' => 'editor',
            'is_active' => true,
        ]);

        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Editor forbidden
        $response = $this->actingAs($editor)->get(route('admin.settings.index'));
        $response->assertStatus(403);

        $response = $this->actingAs($editor)->get(route('admin.users.index'));
        $response->assertStatus(403);

        // Admin allowed
        $response = $this->actingAs($admin)->get(route('admin.settings.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));
        $response->assertStatus(200);
    }

    public function test_staff_role_permissions_are_properly_restricted(): void
    {
        $staff = User::factory()->create([
            'role' => 'staf',
            'is_active' => true,
        ]);

        // Allowed for Staff: Dashboard, Posts & XML, Categories, Announcements
        $this->actingAs($staff)->get(route('admin.dashboard'))->assertStatus(200);
        $this->actingAs($staff)->get(route('admin.posts.index'))->assertStatus(200);
        $this->actingAs($staff)->get(route('admin.posts.import'))->assertStatus(200);
        $this->actingAs($staff)->get(route('admin.posts.template.xml'))->assertStatus(200);
        $this->actingAs($staff)->get(route('admin.categories.index'))->assertStatus(200);
        $this->actingAs($staff)->get(route('admin.announcements.index'))->assertStatus(200);

        // Forbidden for Staff: Contacts & Helpdesk
        $this->actingAs($staff)->get(route('admin.contacts.index'))->assertStatus(403);

        // Forbidden for Staff: Admin-only modules
        $this->actingAs($staff)->get(route('admin.programs.index'))->assertStatus(403);
        $this->actingAs($staff)->get(route('admin.services.index'))->assertStatus(403);
        $this->actingAs($staff)->get(route('admin.slides.index'))->assertStatus(403);
        $this->actingAs($staff)->get(route('admin.team.index'))->assertStatus(403);
        $this->actingAs($staff)->get(route('admin.downloads.index'))->assertStatus(403);
        $this->actingAs($staff)->get(route('admin.faqs.index'))->assertStatus(403);
        $this->actingAs($staff)->get(route('admin.gallery.index'))->assertStatus(403);
        $this->actingAs($staff)->get(route('admin.testimonials.index'))->assertStatus(403);
        $this->actingAs($staff)->get(route('admin.settings.index'))->assertStatus(403);
        $this->actingAs($staff)->get(route('admin.users.index'))->assertStatus(403);
    }

    public function test_editor_role_permissions_are_properly_restricted(): void
    {
        $editor = User::factory()->create([
            'role' => 'editor',
            'is_active' => true,
        ]);

        // Allowed for Editor: Dashboard, Posts & XML, Categories, Announcements, Contacts
        $this->actingAs($editor)->get(route('admin.dashboard'))->assertStatus(200);
        $this->actingAs($editor)->get(route('admin.posts.index'))->assertStatus(200);
        $this->actingAs($editor)->get(route('admin.posts.import'))->assertStatus(200);
        $this->actingAs($editor)->get(route('admin.posts.template.xml'))->assertStatus(200);
        $this->actingAs($editor)->get(route('admin.categories.index'))->assertStatus(200);
        $this->actingAs($editor)->get(route('admin.announcements.index'))->assertStatus(200);
        $this->actingAs($editor)->get(route('admin.contacts.index'))->assertStatus(200);

        // Forbidden for Editor: Admin-only modules
        $this->actingAs($editor)->get(route('admin.programs.index'))->assertStatus(403);
        $this->actingAs($editor)->get(route('admin.services.index'))->assertStatus(403);
        $this->actingAs($editor)->get(route('admin.slides.index'))->assertStatus(403);
        $this->actingAs($editor)->get(route('admin.team.index'))->assertStatus(403);
        $this->actingAs($editor)->get(route('admin.downloads.index'))->assertStatus(403);
        $this->actingAs($editor)->get(route('admin.faqs.index'))->assertStatus(403);
        $this->actingAs($editor)->get(route('admin.gallery.index'))->assertStatus(403);
        $this->actingAs($editor)->get(route('admin.testimonials.index'))->assertStatus(403);
        $this->actingAs($editor)->get(route('admin.settings.index'))->assertStatus(403);
        $this->actingAs($editor)->get(route('admin.users.index'))->assertStatus(403);
    }

    public function test_xxe_payload_is_rejected_in_xml_import(): void
    {
        $xxePayload = <<<'XML'
<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE foo [  
  <!ELEMENT foo ANY >
  <!ENTITY xxe SYSTEM "file:///etc/passwd" >]>
<posts>
    <post>
        <title>&xxe;</title>
        <content>XXE Content Test</content>
    </post>
</posts>
XML;

        $service = new PostXmlImportService;
        $result = $service->import($xxePayload);

        $this->assertFalse($result['success']);
        $this->assertTrue(count($result['errors']) > 0);
        $this->assertStringContainsString('membahayakan', $result['errors'][0]);
    }

    public function test_rich_text_content_is_sanitized_against_xss(): void
    {
        $post = new Post([
            'title' => 'Test Post XSS',
            'content' => '<p>Normal text</p><script>alert("XSS")</script><a href="javascript:alert(1)" onclick="stealCookies()">Click me</a>',
        ]);

        $clean = $post->clean_content;

        $this->assertStringNotContainsString('<script>', $clean);
        $this->assertStringNotContainsString('alert("XSS")', $clean);
        $this->assertStringNotContainsString('onclick', $clean);
        $this->assertStringNotContainsString('javascript:alert(1)', $clean);
        $this->assertStringContainsString('<p>Normal text</p>', $clean);
    }

    public function test_guest_cannot_upload_post_content_image(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('photo.jpg');

        $response = $this->postJson(route('admin.posts.upload_image'), [
            'image' => $file,
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_admin_can_upload_valid_post_content_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $file = UploadedFile::fake()->image('campus_activity.webp', 800, 600);

        $response = $this->actingAs($admin)->postJson(route('admin.posts.upload_image'), [
            'image' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $this->assertNotEmpty($response->json('url'));
    }

    public function test_post_content_image_upload_rejects_non_image_files(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $fakeScript = UploadedFile::fake()->create('malicious.php', 10, 'text/x-php');

        $response = $this->actingAs($admin)->postJson(route('admin.posts.upload_image'), [
            'image' => $fakeScript,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['image']);
    }
}
