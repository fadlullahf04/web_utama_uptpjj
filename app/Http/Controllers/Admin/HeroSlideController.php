<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('order', 'asc')->get();

        return view('admin.slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.slides.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'badge' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'highlight_text' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|url',
            'primary_btn_text' => 'nullable|string|max:100',
            'primary_btn_url' => 'nullable|string|max:255',
            'secondary_btn_text' => 'nullable|string|max:100',
            'secondary_btn_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $imagePath = $request->input('image_url');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('slides', 'public');
        }

        HeroSlide::create(array_merge($validated, [
            'image' => $imagePath,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]));

        return redirect()->route('admin.slides.index')->with('success', 'Slide banner berhasil ditambahkan!');
    }

    public function edit(HeroSlide $slide)
    {
        return view('admin.slides.edit', compact('slide'));
    }

    public function update(Request $request, HeroSlide $slide)
    {
        $validated = $request->validate([
            'badge' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'highlight_text' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|url',
            'primary_btn_text' => 'nullable|string|max:100',
            'primary_btn_url' => 'nullable|string|max:255',
            'secondary_btn_text' => 'nullable|string|max:100',
            'secondary_btn_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $imagePath = $slide->image;
        if ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        }
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('slides', 'public');
        }

        $slide->update(array_merge($validated, [
            'image' => $imagePath,
            'order' => $validated['order'] ?? $slide->order,
            'is_active' => $request->boolean('is_active'),
        ]));

        return redirect()->route('admin.slides.index')->with('success', 'Slide banner berhasil diperbarui!');
    }

    public function destroy(HeroSlide $slide)
    {
        $slide->delete();

        return redirect()->route('admin.slides.index')->with('success', 'Slide banner berhasil dihapus.');
    }
}
