<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Page;
use Database\Seeders\MenuSeeder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    /**
     * Display Menu Builder interface.
     */
    public function index(Request $request): View
    {
        $location = $request->query('location', 'header');
        if (! in_array($location, ['header', 'footer'], true)) {
            $location = 'header';
        }

        $menuItems = MenuItem::location($location)
            ->topLevel()
            ->orderBy('order', 'asc')
            ->with(['page', 'children' => function ($query) {
                $query->with('page')->orderBy('order', 'asc');
            }])
            ->get();

        $allItems = MenuItem::location($location)
            ->orderBy('order', 'asc')
            ->get()
            ->keyBy('id');

        $pages = Page::orderBy('title', 'asc')->get();
        $availableRoutes = MenuItem::getAvailableRoutes();
        $parentItems = MenuItem::location($location)->topLevel()->orderBy('order', 'asc')->get();

        return view('admin.menus.index', compact('menuItems', 'allItems', 'location', 'pages', 'availableRoutes', 'parentItems'));
    }

    /**
     * Store a newly created menu item.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'location' => 'required|in:header,footer',
            'parent_id' => 'nullable|exists:menu_items,id',
            'type' => 'required|in:page,route,custom',
            'page_id' => 'nullable|required_if:type,page|exists:pages,id',
            'route_name' => 'nullable|required_if:type,route|string',
            'url' => 'nullable|string',
            'title' => 'nullable|string|max:255',
            'target' => 'required|in:_self,_blank',
            'icon' => 'nullable|string|max:100',
            'badge' => 'nullable|string|max:50',
            'badge_color' => 'nullable|string|max:30',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $title = $validated['title'] ?? null;

        // Auto-fill title if empty
        if (empty($title)) {
            if ($validated['type'] === 'page' && ! empty($validated['page_id'])) {
                $page = Page::find($validated['page_id']);
                $title = $page ? $page->title : 'Halaman';
            } elseif ($validated['type'] === 'route' && ! empty($validated['route_name'])) {
                $routes = MenuItem::getAvailableRoutes();
                $title = $routes[$validated['route_name']] ?? $validated['route_name'];
            } elseif ($validated['type'] === 'custom') {
                $title = ! empty($validated['url']) && $validated['url'] !== '#' ? $validated['url'] : 'Menu Baru';
            }
        }

        $order = $validated['order'] ?? null;
        if ($order === null) {
            $maxOrder = MenuItem::where('location', $validated['location'])
                ->where('parent_id', $validated['parent_id'] ?? null)
                ->max('order') ?? 0;
            $order = $maxOrder + 1;
        }

        MenuItem::create([
            'location' => $validated['location'],
            'parent_id' => $validated['parent_id'] ?? null,
            'title' => $title ?? 'Menu Baru',
            'type' => $validated['type'],
            'page_id' => $validated['type'] === 'page' ? $validated['page_id'] : null,
            'route_name' => $validated['type'] === 'route' ? $validated['route_name'] : null,
            'url' => $validated['type'] === 'custom' ? ($validated['url'] ?: '#') : null,
            'target' => $validated['target'] ?? '_self',
            'icon' => $validated['icon'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'badge_color' => $validated['badge_color'] ?? 'emerald',
            'order' => $order,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.menus.index', ['location' => $validated['location']])
            ->with('success', 'Item menu berhasil ditambahkan ke navigasi!');
    }

    /**
     * Update the specified menu item.
     */
    public function update(Request $request, MenuItem $menu): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'type' => 'required|in:page,route,custom',
            'page_id' => 'nullable|required_if:type,page|exists:pages,id',
            'route_name' => 'nullable|required_if:type,route|string',
            'url' => 'nullable|string',
            'target' => 'required|in:_self,_blank',
            'icon' => 'nullable|string|max:100',
            'badge' => 'nullable|string|max:50',
            'badge_color' => 'nullable|string|max:30',
            'order' => 'required|integer',
            'is_active' => 'nullable|boolean',
        ]);

        // Prevent item from setting itself as parent
        $parentId = $validated['parent_id'] ?? null;
        if ($parentId && (int) $parentId === (int) $menu->id) {
            $parentId = null;
        }

        // Prevent a parent that currently has children from becoming a child (max 2 levels)
        if ($parentId && $menu->children()->exists()) {
            return redirect()->back()
                ->with('error', 'Item menu ini memiliki sub-menu. Anda tidak dapat menjadikannya sub-menu dari menu lain.');
        }

        $menu->update([
            'title' => $validated['title'],
            'parent_id' => $parentId,
            'type' => $validated['type'],
            'page_id' => $validated['type'] === 'page' ? $validated['page_id'] : null,
            'route_name' => $validated['type'] === 'route' ? $validated['route_name'] : null,
            'url' => $validated['type'] === 'custom' ? ($validated['url'] ?: '#') : null,
            'target' => $validated['target'],
            'icon' => $validated['icon'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'badge_color' => $validated['badge_color'] ?? 'emerald',
            'order' => $validated['order'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.menus.index', ['location' => $menu->location])
            ->with('success', 'Item menu berhasil diperbarui!');
    }

    /**
     * Move menu item up or down.
     */
    public function move(Request $request, MenuItem $menu, string $direction): RedirectResponse
    {
        $direction = strtolower($direction);

        $siblings = MenuItem::where('location', $menu->location)
            ->where('parent_id', $menu->parent_id)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $currentIndex = $siblings->search(fn ($item) => $item->id === $menu->id);

        if ($currentIndex !== false) {
            $targetIndex = $direction === 'up' ? $currentIndex - 1 : $currentIndex + 1;

            if (isset($siblings[$targetIndex])) {
                $targetItem = $siblings[$targetIndex];

                // Normalize sibling order values if identical
                if ($menu->order === $targetItem->order) {
                    foreach ($siblings as $i => $sibling) {
                        $sibling->update(['order' => ($i + 1) * 10]);
                    }
                    $menu->refresh();
                    $targetItem->refresh();
                }

                $currentOrder = $menu->order;
                $menu->update(['order' => $targetItem->order]);
                $targetItem->update(['order' => $currentOrder]);
            }
        }

        return redirect()->route('admin.menus.index', ['location' => $menu->location])
            ->with('success', 'Urutan menu berhasil diubah.');
    }

    /**
     * Remove the specified menu item.
     */
    public function destroy(MenuItem $menu): RedirectResponse
    {
        $location = $menu->location;
        $menu->delete();

        return redirect()->route('admin.menus.index', ['location' => $location])
            ->with('success', 'Item menu berhasil dihapus.');
    }

    /**
     * Seed or restore default website menus.
     */
    public function seedDefaults(Request $request): RedirectResponse
    {
        $location = $request->input('location', 'header');

        $seeder = new MenuSeeder;
        $seeder->seedLocation($location);

        return redirect()->route('admin.menus.index', ['location' => $location])
            ->with('success', "Menu default untuk [{$location}] berhasil dimuat kembali!");
    }
}
