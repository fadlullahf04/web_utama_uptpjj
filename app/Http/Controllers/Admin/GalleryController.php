<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GalleryItem;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = GalleryItem::orderBy('order', 'asc')->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:image,video,tour',
            'category' => 'required|string|max:100',
            'media_file' => 'nullable|image|max:4096',
            'media_url' => 'nullable|url',
            'description' => 'nullable|string',
            'order' => 'integer',
        ]);

        $mediaUrl = $request->input('media_url');
        if ($request->hasFile('media_file')) {
            $mediaUrl = asset('storage/' . $request->file('media_file')->store('gallery', 'public'));
        }

        if (!$mediaUrl) {
            return back()->with('error', 'Harap unggah file foto atau masukkan link media/video.');
        }

        GalleryItem::create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'category' => $validated['category'],
            'media_url' => $mediaUrl,
            'description' => $validated['description'],
            'order' => $validated['order'] ?? 0,
        ]);

        return back()->with('success', 'Foto/Sarana berhasil ditambahkan ke Galeri!');
    }

    public function destroy(GalleryItem $gallery)
    {
        $gallery->delete();
        return back()->with('success', 'Item galeri berhasil dihapus.');
    }
}
