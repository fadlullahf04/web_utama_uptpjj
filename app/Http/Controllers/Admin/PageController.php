<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display a listing of dynamic pages.
     */
    public function index(Request $request): View
    {
        $search = $request->query('cari');
        $status = $request->query('status');

        $query = Page::query()->latest('created_at');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($status === 'published') {
            $query->where('is_published', true);
        } elseif ($status === 'draft') {
            $query->where('is_published', false);
        }

        $pages = $query->paginate(15)->withQueryString();

        return view('admin.pages.index', compact('pages', 'search', 'status'));
    }

    /**
     * Show the form for creating a new dynamic page.
     */
    public function create(): View
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created dynamic page in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'featured_image_url' => 'nullable|url',
            'template' => 'required|in:default,full-width,blank',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $imagePath = $request->input('featured_image_url');
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('pages', 'public');
        }

        $slug = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        // Check unique slug fallback
        if (Page::where('slug', $slug)->exists()) {
            $slug .= '-'.Str::random(4);
        }

        Page::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'template' => $validated['template'],
            'is_published' => $request->boolean('is_published', true),
            'published_at' => $validated['published_at'] ?? now(),
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman dinamis baru berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified dynamic page.
     */
    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified dynamic page in storage.
     */
    public function update(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,'.$page->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'featured_image_url' => 'nullable|url',
            'template' => 'required|in:default,full-width,blank',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $imagePath = $page->featured_image;

        if ($request->filled('featured_image_url')) {
            $imagePath = $request->input('featured_image_url');
        }

        if ($request->hasFile('featured_image')) {
            if ($page->featured_image && ! Str::startsWith($page->featured_image, ['http://', 'https://'])) {
                Storage::disk('public')->delete($page->featured_image);
            }
            $imagePath = $request->file('featured_image')->store('pages', 'public');
        }

        $page->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'template' => $validated['template'],
            'is_published' => $request->boolean('is_published'),
            'published_at' => $validated['published_at'] ?? $page->published_at,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman dinamis berhasil diperbarui!');
    }

    /**
     * Remove the specified dynamic page from storage.
     */
    public function destroy(Page $page): RedirectResponse
    {
        if ($page->featured_image && ! Str::startsWith($page->featured_image, ['http://', 'https://'])) {
            Storage::disk('public')->delete($page->featured_image);
        }

        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Halaman dinamis berhasil dihapus.');
    }
}
