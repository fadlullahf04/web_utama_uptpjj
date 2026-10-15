<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_announcement_with_rich_text_content(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $htmlContent = '<h2>Instruksi Registrasi</h2><p>Silakan ikuti poin-poin berikut:</p><ul><li>Buka portal LMS</li><li>Login dengan akun SSO</li></ul>';

        $response = $this->actingAs($admin)->post('/admin/announcements', [
            'title' => 'Pengumuman Jadwal UAS Semester Genap',
            'category' => 'Akademik',
            'content' => $htmlContent,
            'is_published' => '1',
        ]);

        $response->assertRedirect('/admin/announcements');

        $this->assertDatabaseHas('announcements', [
            'title' => 'Pengumuman Jadwal UAS Semester Genap',
            'category' => 'Akademik',
        ]);

        $announcement = Announcement::where('title', 'Pengumuman Jadwal UAS Semester Genap')->first();
        $this->assertNotNull($announcement);
        $this->assertStringContainsString('<h2>Instruksi Registrasi</h2>', $announcement->clean_content);
    }

    public function test_announcement_sanitizes_xss_in_clean_content(): void
    {
        $malicious = '<h3>Judul Aman</h3><p>Teks aman</p><script>alert("hacked")</script><img src="x" onerror="alert(1)">';

        $announcement = Announcement::create([
            'title' => 'Pengumuman Uji Keamanan',
            'slug' => 'pengumuman-uji-keamanan',
            'category' => 'Umum',
            'content' => $malicious,
            'is_published' => true,
        ]);

        $clean = $announcement->clean_content;

        $this->assertStringNotContainsString('<script>', $clean);
        $this->assertStringNotContainsString('onerror', $clean);
        $this->assertStringContainsString('<h3>Judul Aman</h3>', $clean);
    }

    public function test_announcement_show_page_renders_rich_html(): void
    {
        $announcement = Announcement::create([
            'title' => 'Sosialisasi Program Pertukaran Mahasiswa',
            'slug' => 'sosialisasi-program-pertukaran-mahasiswa',
            'category' => 'Kemahasiswaan',
            'content' => '<h3>Informasi Lengkap</h3><p>Pendaftaran dibuka sampai akhir bulan.</p>',
            'is_published' => true,
            'published_at' => now()->subHour(),
        ]);

        $response = $this->get(route('announcements.show', $announcement->slug));

        $response->assertStatus(200);
        $response->assertSee('<h3>Informasi Lengkap</h3>', false);
        $response->assertSee('article-content', false);
    }
}
