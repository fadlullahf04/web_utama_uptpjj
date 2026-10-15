<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_xml_returns_valid_response(): void
    {
        $category = Category::create(['name' => 'Berita', 'slug' => 'berita']);
        $user = User::factory()->create();

        $post = Post::create([
            'title' => 'Berita PJJ Terkini',
            'slug' => 'berita-pjj-terkini',
            'category_id' => $category->id,
            'user_id' => $user->id,
            'excerpt' => 'Ringkasan berita.',
            'content' => '<p>Konten berita.</p>',
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        $this->assertStringContainsString('<urlset', $response->getContent());
        $this->assertStringContainsString(url('/'), $response->getContent());
        $this->assertStringContainsString(route('posts.show', $post->slug), $response->getContent());
    }

    public function test_article_page_renders_custom_seo_meta_tags_and_json_ld(): void
    {
        $category = Category::create(['name' => 'Berita', 'slug' => 'berita']);
        $user = User::factory()->create(['name' => 'Dr. Administrator']);

        $post = Post::create([
            'title' => 'Judul Artikel Utama',
            'slug' => 'judul-artikel-utama',
            'category_id' => $category->id,
            'user_id' => $user->id,
            'excerpt' => 'Ringkasan artikel default.',
            'content' => '<p>Isi artikel lengkap.</p>',
            'meta_title' => 'Judul SEO Khusus Google SERP',
            'meta_description' => 'Deskripsi meta khusus Google SERP maksimal 160 karakter.',
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertStatus(200);
        $response->assertSee('Judul SEO Khusus Google SERP - UPT PJJ UINSSC');
        $response->assertSee('Deskripsi meta khusus Google SERP maksimal 160 karakter.');
        $response->assertSee('property="og:title"', false);
        $response->assertSee('name="twitter:card"', false);
        $response->assertSee('"@type": "NewsArticle"', false);
        $response->assertSee('"@type": "BreadcrumbList"', false);
        $response->assertSee(route('posts.show', $post->slug));
    }

    public function test_admin_can_save_seo_meta_fields(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $category = Category::create(['name' => 'Berita', 'slug' => 'berita']);

        $response = $this->actingAs($admin)->post('/admin/posts', [
            'title' => 'Posting Berita Baru dengan SEO',
            'category_id' => $category->id,
            'excerpt' => 'Ringkasan singkat berita.',
            'content' => '<p>Konten panjang berita yang informatif.</p>',
            'meta_title' => 'Meta Title Optimal SEO',
            'meta_description' => 'Meta description yang kaya kata kunci dan menarik pembaca.',
            'is_published' => '1',
        ]);

        $response->assertRedirect('/admin/posts');

        $this->assertDatabaseHas('posts', [
            'title' => 'Posting Berita Baru dengan SEO',
            'meta_title' => 'Meta Title Optimal SEO',
            'meta_description' => 'Meta description yang kaya kata kunci dan menarik pembaca.',
        ]);
    }
}
