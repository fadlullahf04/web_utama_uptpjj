<?php

namespace Tests\Feature;

use App\Models\MenuItem;
use App\Models\Page;
use App\Models\User;
use Database\Seeders\MenuSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageAndMenuBuilderTest extends TestCase
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

    public function test_admin_can_access_pages_list_and_create_dynamic_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/pages');
        $response->assertStatus(200);

        $storeResponse = $this->actingAs($this->admin)->post('/admin/pages', [
            'title' => 'Panduan Registrasi Mahasiswa Baru 2026',
            'slug' => 'panduan-registrasi-2026',
            'excerpt' => 'Informasi lengkap alur pendaftaran mahasiswa baru PJJ.',
            'content' => '<p>Langkah-langkah registrasi online...</p>',
            'template' => 'default',
            'is_published' => true,
            'published_at' => now()->format('Y-m-d\TH:i'),
        ]);

        $storeResponse->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseHas('pages', [
            'title' => 'Panduan Registrasi Mahasiswa Baru 2026',
            'slug' => 'panduan-registrasi-2026',
            'is_published' => true,
        ]);
    }

    public function test_public_can_view_published_dynamic_page_and_views_increment(): void
    {
        $page = Page::factory()->create([
            'title' => 'Maklumat Hak Akses Mahasiswa',
            'slug' => 'maklumat-hak-akses',
            'content' => '<p>Isi maklumat hak akses...</p>',
            'is_published' => true,
            'views_count' => 10,
        ]);

        $response = $this->get('/halaman/'.$page->slug);
        $response->assertStatus(200);
        $response->assertSee('Maklumat Hak Akses Mahasiswa');
        $response->assertSee('Isi maklumat hak akses...');

        $this->assertEquals(11, $page->fresh()->views_count);
    }

    public function test_guest_cannot_view_draft_page_but_admin_can(): void
    {
        $draftPage = Page::factory()->create([
            'title' => 'Halaman Draf Rahasia',
            'slug' => 'halaman-draf-rahasia',
            'is_published' => false,
        ]);

        // Guest receives 404
        $guestResponse = $this->get('/halaman/'.$draftPage->slug);
        $guestResponse->assertStatus(404);

        // Admin can view preview
        $adminResponse = $this->actingAs($this->admin)->get('/halaman/'.$draftPage->slug);
        $adminResponse->assertStatus(200);
        $adminResponse->assertSee('Halaman Draf Rahasia');
        $adminResponse->assertSee('Draft Preview');
    }

    public function test_admin_can_update_and_delete_dynamic_page(): void
    {
        $page = Page::factory()->create([
            'title' => 'Judul Lama',
            'slug' => 'judul-lama',
            'content' => '<p>Konten lama</p>',
            'template' => 'default',
        ]);

        $updateResponse = $this->actingAs($this->admin)->put("/admin/pages/{$page->id}", [
            'title' => 'Judul Baru Diperbarui',
            'slug' => 'judul-baru-diperbarui',
            'excerpt' => 'Excerpt baru',
            'content' => '<p>Konten baru yang sudah diperbarui</p>',
            'template' => 'full-width',
            'is_published' => true,
        ]);

        $updateResponse->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'title' => 'Judul Baru Diperbarui',
            'template' => 'full-width',
        ]);

        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/pages/{$page->id}");
        $deleteResponse->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }

    public function test_admin_can_create_menu_item_linked_to_dynamic_page(): void
    {
        $page = Page::factory()->create([
            'title' => 'Pedoman Akademik Online',
            'slug' => 'pedoman-akademik-online',
        ]);

        $response = $this->actingAs($this->admin)->post('/admin/menus', [
            'location' => 'header',
            'type' => 'page',
            'page_id' => $page->id,
            'title' => 'Pedoman Kuliah',
            'target' => '_self',
            'icon' => 'fa-solid fa-book',
            'badge' => 'Penting',
            'badge_color' => 'amber',
            'is_active' => true,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('menu_items', [
            'location' => 'header',
            'type' => 'page',
            'page_id' => $page->id,
            'title' => 'Pedoman Kuliah',
            'badge' => 'Penting',
        ]);

        $menuItem = MenuItem::where('page_id', $page->id)->first();
        $this->assertNotNull($menuItem);
        $this->assertEquals(route('pages.show', $page->slug), $menuItem->getUrl());
    }

    public function test_admin_can_create_menu_with_parent_and_submenu_children(): void
    {
        $parent = MenuItem::create([
            'location' => 'header',
            'title' => 'Layanan Mahasiswa',
            'type' => 'custom',
            'url' => '#',
            'order' => 1,
            'is_active' => true,
        ]);

        $page = Page::factory()->create([
            'title' => 'Helpdesk Tiket',
            'slug' => 'helpdesk-tiket',
        ]);

        $childResponse = $this->actingAs($this->admin)->post('/admin/menus', [
            'location' => 'header',
            'parent_id' => $parent->id,
            'type' => 'page',
            'page_id' => $page->id,
            'title' => 'Bantuan Helpdesk',
            'target' => '_self',
            'order' => 1,
            'is_active' => true,
        ]);

        $childResponse->assertRedirect();
        $this->assertDatabaseHas('menu_items', [
            'location' => 'header',
            'parent_id' => $parent->id,
            'title' => 'Bantuan Helpdesk',
        ]);

        $tree = MenuItem::getTree('header');
        $this->assertTrue($tree->contains('id', $parent->id));
        $this->assertEquals(1, $parent->fresh()->children()->count());
    }

    public function test_admin_can_reorder_and_delete_menu_item(): void
    {
        $item1 = MenuItem::create([
            'location' => 'header',
            'title' => 'Item 1',
            'type' => 'custom',
            'url' => '/item-1',
            'order' => 1,
            'is_active' => true,
        ]);

        $item2 = MenuItem::create([
            'location' => 'header',
            'title' => 'Item 2',
            'type' => 'custom',
            'url' => '/item-2',
            'order' => 2,
            'is_active' => true,
        ]);

        // Move item2 up
        $this->actingAs($this->admin)->post("/admin/menus/{$item2->id}/move/up");
        $this->assertEquals(1, $item2->fresh()->order);
        $this->assertEquals(2, $item1->fresh()->order);

        // Delete item1
        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/menus/{$item1->id}");
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('menu_items', ['id' => $item1->id]);
    }

    public function test_admin_can_seed_default_menus(): void
    {
        MenuItem::query()->delete();
        $this->assertEquals(0, MenuItem::count());

        $response = $this->actingAs($this->admin)->post('/admin/menus/seed-defaults', [
            'location' => 'header',
        ]);

        $response->assertRedirect();
        $this->assertGreaterThan(0, MenuItem::where('location', 'header')->count());
    }

    public function test_frontend_navbar_and_footer_renders_dynamic_menu_items(): void
    {
        $this->seed(MenuSeeder::class);

        $response = $this->get('/');
        $response->assertStatus(200);

        // Check seeded dynamic page links in navbar
        $response->assertSee('Maklumat Pelayanan');
        $response->assertSee('/halaman/maklumat-pelayanan-upt-pjj');
        $response->assertSee('EduShare');
        $response->assertSee('/halaman/edushare');
        $response->assertSee('UPBJJ');
        $response->assertSee('/halaman/upbjj');
        $response->assertSee('Tutorial & Course LMS');
    }

    public function test_admin_can_update_menu_item_and_toggle_active_status(): void
    {
        $item = MenuItem::create([
            'location' => 'header',
            'title' => 'Menu Sebelum Diedit',
            'type' => 'custom',
            'url' => '/link-awal',
            'target' => '_self',
            'icon' => 'fa-solid fa-star',
            'badge' => 'Old',
            'badge_color' => 'emerald',
            'order' => 1,
            'is_active' => true,
        ]);

        $updateResponse = $this->actingAs($this->admin)->put("/admin/menus/{$item->id}", [
            'title' => 'Menu Sesudah Diedit',
            'type' => 'custom',
            'url' => '/link-baru',
            'target' => '_blank',
            'icon' => 'fa-solid fa-graduation-cap',
            'badge' => 'Terbaru',
            'badge_color' => 'amber',
            'order' => 5,
            'is_active' => 0,
        ]);

        $updateResponse->assertRedirect();
        $fresh = $item->fresh();

        $this->assertEquals('Menu Sesudah Diedit', $fresh->title);
        $this->assertEquals('/link-baru', $fresh->url);
        $this->assertEquals('_blank', $fresh->target);
        $this->assertEquals('fa-solid fa-graduation-cap', $fresh->icon);
        $this->assertEquals('Terbaru', $fresh->badge);
        $this->assertEquals('amber', $fresh->badge_color);
        $this->assertEquals(5, $fresh->order);
        $this->assertFalse($fresh->is_active);
    }

    public function test_parent_menu_with_children_cannot_be_set_as_child_of_another_menu(): void
    {
        $parent1 = MenuItem::create([
            'location' => 'header',
            'title' => 'Induk 1',
            'type' => 'custom',
            'url' => '#',
            'order' => 1,
            'is_active' => true,
        ]);

        $child1 = MenuItem::create([
            'location' => 'header',
            'parent_id' => $parent1->id,
            'title' => 'Anak Induk 1',
            'type' => 'custom',
            'url' => '/anak-1',
            'order' => 1,
            'is_active' => true,
        ]);

        $parent2 = MenuItem::create([
            'location' => 'header',
            'title' => 'Induk 2',
            'type' => 'custom',
            'url' => '#',
            'order' => 2,
            'is_active' => true,
        ]);

        // Trying to set parent1 as child of parent2 should fail because parent1 has child1
        $response = $this->actingAs($this->admin)->put("/admin/menus/{$parent1->id}", [
            'title' => 'Induk 1 Berubah',
            'parent_id' => $parent2->id,
            'type' => 'custom',
            'url' => '#',
            'target' => '_self',
            'order' => 1,
            'is_active' => 1,
        ]);

        $response->assertSessionHas('error');
        $this->assertNull($parent1->fresh()->parent_id);
    }

    public function test_admin_menu_index_renders_without_syntax_errors_and_passes_all_items_data(): void
    {
        $this->seed(MenuSeeder::class);

        $response = $this->actingAs($this->admin)->get('/admin/menus?location=header');
        $response->assertStatus(200);

        // Check that openEditModal is called with integer ID, not raw broken JSON
        $firstItem = MenuItem::where('location', 'header')->first();
        $this->assertNotNull($firstItem);
        $response->assertSee("openEditModal({$firstItem->id})", false);
        $response->assertSee('itemsMap:', false);
    }
}
