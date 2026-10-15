<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PostXmlImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_xml_import_page(): void
    {
        $response = $this->get(route('admin.posts.import'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_view_xml_import_page(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.posts.import'));
        $response->assertStatus(200);
        $response->assertSee('Import Berita dari XML');
    }

    public function test_admin_can_download_xml_template(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.posts.template.xml'));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml; charset=utf-8');
        $response->assertSee('<posts>', false);
        $response->assertSee('</posts>', false);
    }

    public function test_import_posts_via_custom_xml_string(): void
    {
        $admin = User::factory()->create();
        $category = Category::create([
            'name' => 'Berita & Informasi',
            'slug' => 'berita-dan-informasi',
            'type' => 'berita',
        ]);

        $xml = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<posts>
    <post>
        <title>Berita Uji Coba 1</title>
        <category>Berita &amp; Informasi</category>
        <excerpt>Ringkasan uji coba 1</excerpt>
        <content><![CDATA[<p>Isi lengkap berita uji coba 1</p>]]></content>
        <featured_image>https://images.unsplash.com/test1.jpg</featured_image>
        <tags>uji, coba, xml</tags>
        <published_at>2026-10-14 10:00:00</published_at>
        <is_published>1</is_published>
    </post>
    <post>
        <title>Berita Uji Coba 2 dengan Kategori Baru</title>
        <category>Inovasi Digital</category>
        <excerpt>Ringkasan uji coba 2</excerpt>
        <content><![CDATA[<p>Isi lengkap berita uji coba 2</p>]]></content>
        <featured_image>https://images.unsplash.com/test2.jpg</featured_image>
        <tags>digital, inovasi</tags>
        <published_at>2026-10-13 08:00:00</published_at>
        <is_published>1</is_published>
    </post>
</posts>
XML;

        $response = $this->actingAs($admin)->post(route('admin.posts.import.process'), [
            'xml_content' => $xml,
            'default_category_id' => $category->id,
            'auto_create_category' => '1',
            'status_mode' => 'keep',
            'duplicate_handling' => 'allow',
        ]);

        $response->assertRedirect(route('admin.posts.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('posts', [
            'title' => 'Berita Uji Coba 1',
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Berita Uji Coba 2 dengan Kategori Baru',
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Inovasi Digital',
        ]);
    }

    public function test_import_posts_via_uploaded_xml_file(): void
    {
        $admin = User::factory()->create();

        $xmlContent = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<posts>
    <post>
        <title>Artikel dari File Unggahan</title>
        <content><![CDATA[<p>Konten artikel yang diunggah melalui file xml</p>]]></content>
    </post>
</posts>
XML;

        $file = UploadedFile::fake()->createWithContent('berita.xml', $xmlContent);

        $response = $this->actingAs($admin)->post(route('admin.posts.import.process'), [
            'xml_file' => $file,
            'auto_create_category' => '1',
            'status_mode' => 'publish',
            'duplicate_handling' => 'allow',
        ]);

        $response->assertRedirect(route('admin.posts.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('posts', [
            'title' => 'Artikel dari File Unggahan',
            'is_published' => true,
        ]);
    }

    public function test_import_wordpress_wxr_format(): void
    {
        $admin = User::factory()->create();

        $wxrXml = <<<'XML'
<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0"
    xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:wp="http://wordpress.org/export/1.2/"
>
<channel>
    <title>Situs Berita Contoh</title>
    <item>
        <title>Berita Ekspor WordPress</title>
        <dc:creator><![CDATA[admin]]></dc:creator>
        <category domain="category" nicename="berita-kampus"><![CDATA[Berita Kampus]]></category>
        <category domain="post_tag" nicename="pjj"><![CDATA[PJJ]]></category>
        <category domain="post_tag" nicename="uin"><![CDATA[UIN]]></category>
        <content:encoded><![CDATA[<p>Ini adalah isi artikel yang diekspor dari sistem WordPress.</p>]]></content:encoded>
        <wp:post_date><![CDATA[2026-10-10 12:00:00]]></wp:post_date>
        <wp:status><![CDATA[publish]]></wp:status>
        <wp:post_type><![CDATA[post]]></wp:post_type>
    </item>
    <item>
        <title>Halaman Statis Yang Harus Dilewati</title>
        <wp:post_type><![CDATA[page]]></wp:post_type>
        <content:encoded><![CDATA[Halaman statis ini harus dilewati oleh importer]]></content:encoded>
    </item>
</channel>
</rss>
XML;

        $response = $this->actingAs($admin)->post(route('admin.posts.import.process'), [
            'xml_content' => $wxrXml,
            'auto_create_category' => '1',
            'status_mode' => 'keep',
            'duplicate_handling' => 'allow',
        ]);

        $response->assertRedirect(route('admin.posts.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('posts', [
            'title' => 'Berita Ekspor WordPress',
        ]);

        $this->assertDatabaseMissing('posts', [
            'title' => 'Halaman Statis Yang Harus Dilewati',
        ]);
    }
}
