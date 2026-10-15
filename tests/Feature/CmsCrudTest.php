<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\Post;
use App\Models\Service;
use App\Models\Setting;
use App\Models\StudyProgram;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CmsCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    public function test_can_update_and_delete_category(): void
    {
        $category = Category::create([
            'name' => 'Kategori Lama',
            'slug' => 'kategori-lama',
            'type' => 'berita',
            'color' => 'emerald',
            'description' => 'Deskripsi lama',
        ]);

        $updateResponse = $this->actingAs($this->admin)->put("/admin/categories/{$category->id}", [
            'name' => 'Kategori Baru Diperbarui',
            'type' => 'pengumuman',
            'color' => 'blue',
            'description' => 'Deskripsi baru',
        ]);

        $updateResponse->assertRedirect();
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Kategori Baru Diperbarui',
            'slug' => 'kategori-baru-diperbarui',
            'type' => 'pengumuman',
        ]);

        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/categories/{$category->id}");
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

    public function test_can_update_and_delete_faq(): void
    {
        $faq = Faq::create([
            'question' => 'Pertanyaan awal?',
            'answer' => 'Jawaban awal.',
            'category' => 'Umum',
            'order' => 1,
            'is_active' => true,
        ]);

        $updateResponse = $this->actingAs($this->admin)->put("/admin/faqs/{$faq->id}", [
            'question' => 'Pertanyaan telah diedit?',
            'answer' => 'Jawaban lengkap baru.',
            'category' => 'Biaya & Pembayaran',
            'order' => 5,
            'is_active' => '1',
        ]);

        $updateResponse->assertRedirect();
        $this->assertDatabaseHas('faqs', [
            'id' => $faq->id,
            'question' => 'Pertanyaan telah diedit?',
            'order' => 5,
        ]);

        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/faqs/{$faq->id}");
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('faqs', [
            'id' => $faq->id,
        ]);
    }

    public function test_can_update_and_delete_testimonial(): void
    {
        $testimonial = Testimonial::create([
            'name' => 'Siswa A',
            'role_status' => 'Mahasiswa PJJ',
            'quote' => 'Kuliah sangat seru.',
            'rating' => 5,
            'order' => 1,
            'is_active' => true,
        ]);

        $updateResponse = $this->actingAs($this->admin)->put("/admin/testimonials/{$testimonial->id}", [
            'name' => 'Siswa A, S.Kom',
            'role_status' => 'Alumni PJJ PAI',
            'quote' => 'Materi sangat berbobot dan fleksibel.',
            'rating' => 5,
            'order' => 2,
            'is_active' => '1',
        ]);

        $updateResponse->assertRedirect();
        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'name' => 'Siswa A, S.Kom',
            'order' => 2,
        ]);

        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/testimonials/{$testimonial->id}");
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('testimonials', [
            'id' => $testimonial->id,
        ]);
    }

    public function test_can_update_and_delete_cms_user(): void
    {
        $editor = User::factory()->create([
            'name' => 'Editor CMS',
            'email' => 'editor@uinssc.ac.id',
            'role' => 'editor',
            'is_active' => true,
        ]);

        $updateResponse = $this->actingAs($this->admin)->put("/admin/users/{$editor->id}", [
            'name' => 'Editor Senior',
            'email' => 'editor@uinssc.ac.id',
            'role' => 'editor',
            'phone' => '08123456789',
            'is_active' => '1',
        ]);

        $updateResponse->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $editor->id,
            'name' => 'Editor Senior',
            'phone' => '08123456789',
        ]);

        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/users/{$editor->id}");
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('users', [
            'id' => $editor->id,
        ]);
    }

    public function test_cannot_delete_self_user(): void
    {
        $response = $this->actingAs($this->admin)->delete("/admin/users/{$this->admin->id}");
        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
        ]);
    }

    public function test_can_update_and_delete_gallery_item(): void
    {
        $gallery = GalleryItem::create([
            'title' => 'Studio Foto Awal',
            'type' => 'image',
            'category' => 'Studio Multimedia',
            'media_url' => 'https://images.unsplash.com/photo-test',
            'order' => 1,
        ]);

        $updateResponse = $this->actingAs($this->admin)->put("/admin/gallery/{$gallery->id}", [
            'title' => 'Studio Rekaman MOOC Cyber',
            'type' => 'image',
            'category' => 'Studio Multimedia',
            'media_url' => 'https://images.unsplash.com/photo-test-updated',
            'order' => 3,
        ]);

        $updateResponse->assertRedirect();
        $this->assertDatabaseHas('gallery_items', [
            'id' => $gallery->id,
            'title' => 'Studio Rekaman MOOC Cyber',
            'order' => 3,
        ]);

        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/gallery/{$gallery->id}");
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('gallery_items', [
            'id' => $gallery->id,
        ]);
    }

    public function test_edit_pages_render_without_missing_route_errors(): void
    {
        $program = StudyProgram::create([
            'name' => 'PJJ Pendidikan Agama Islam',
            'slug' => 'pjj-pendidikan-agama-islam',
            'degree' => 'S1',
            'faculty' => 'Fakultas Tarbiyah dan Keguruan',
            'accreditation' => 'Unggul',
            'short_description' => 'Program studi PJJ PAI unggulan.',
        ]);

        $service = Service::create([
            'title' => 'LMS Pillar Cyber',
            'slug' => 'lms-pillar-cyber',
            'category' => 'LMS & Cyber Platform',
            'icon' => 'fa-solid fa-laptop-code',
            'short_description' => 'Platform perkuliahan asinkron.',
        ]);

        $category = Category::create([
            'name' => 'Akademik',
            'slug' => 'akademik',
            'type' => 'berita',
        ]);

        $post = Post::create([
            'title' => 'Uji Coba Berita PJJ',
            'slug' => 'uji-coba-berita-pjj',
            'category_id' => $category->id,
            'user_id' => $this->admin->id,
            'content' => '<p>Konten berita uji coba.</p>',
            'is_published' => true,
        ]);

        $team = TeamMember::create([
            'name' => 'Dr. H. Contoh Nama, M.Ag',
            'title' => 'Ketua UPT PJJ',
            'division' => 'Pimpinan',
        ]);

        // Verify edit pages render with 200 OK
        $this->actingAs($this->admin)->get("/admin/programs/{$program->id}/edit")->assertOk();
        $this->actingAs($this->admin)->get("/admin/services/{$service->id}/edit")->assertOk();
        $this->actingAs($this->admin)->get("/admin/posts/{$post->id}/edit")->assertOk();
        $this->actingAs($this->admin)->get("/admin/team/{$team->id}/edit")->assertOk();
    }

    public function test_can_update_leadership_settings_with_uploaded_photo_and_rich_greeting(): void
    {
        Storage::fake('public');

        $photoFile = UploadedFile::fake()->image('head_leader.jpg', 400, 400);

        $response = $this->actingAs($this->admin)->put(route('admin.settings.update'), [
            '_active_tab' => 'profile',
            'head_name' => 'Prof. Dr. Pembina Siber, M.Ag',
            'head_title' => 'Direktur Eksekutif UPT PJJ',
            'head_photo_file' => $photoFile,
            'head_greeting' => '<p>Sambutan resmi pimpinan dengan format <strong>tebal</strong> dan foto.</p>',
            'vision' => 'Visi siber terdepan 2030.',
            'mission' => 'Misi inovasi pembelajaran digital.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('active_tab', 'profile');

        // Assert file stored in storage/settings
        Storage::disk('public')->assertExists('settings/'.$photoFile->hashName());

        // Assert settings updated
        $this->assertEquals('Prof. Dr. Pembina Siber, M.Ag', Setting::get('head_name'));
        $this->assertStringContainsString('settings/'.$photoFile->hashName(), Setting::get('head_photo'));
        $this->assertStringContainsString('Sambutan resmi pimpinan', Setting::get('head_greeting'));

        // Assert overview page renders greeting and photo
        $overviewResponse = $this->get(route('profile.overview'));
        $overviewResponse->assertOk();
        $overviewResponse->assertSee('Prof. Dr. Pembina Siber, M.Ag');
        $overviewResponse->assertSee('Sambutan resmi pimpinan');
    }
}
