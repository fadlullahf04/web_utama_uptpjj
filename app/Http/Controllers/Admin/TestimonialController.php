<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('order', 'asc')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role_status' => 'required|string|max:255',
            'quote' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'avatar_url' => 'nullable|url',
            'avatar_file' => 'nullable|image|max:2048',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $avatar = $request->input('avatar_url');
        if ($request->hasFile('avatar_file')) {
            $avatar = asset('storage/' . $request->file('avatar_file')->store('testimonials', 'public'));
        }

        Testimonial::create([
            'name' => $validated['name'],
            'role_status' => $validated['role_status'],
            'quote' => $validated['quote'],
            'rating' => $validated['rating'],
            'avatar' => $avatar,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Testimoni berhasil ditambahkan!');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role_status' => 'required|string|max:255',
            'quote' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'avatar_url' => 'nullable|url',
            'avatar_file' => 'nullable|image|max:2048',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $avatar = $testimonial->avatar;
        if ($request->filled('avatar_url')) {
            $avatar = $request->input('avatar_url');
        }
        if ($request->hasFile('avatar_file')) {
            $avatar = asset('storage/' . $request->file('avatar_file')->store('testimonials', 'public'));
        }

        $testimonial->update([
            'name' => $validated['name'],
            'role_status' => $validated['role_status'],
            'quote' => $validated['quote'],
            'rating' => $validated['rating'],
            'avatar' => $avatar,
            'order' => $validated['order'] ?? $testimonial->order,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Testimoni berhasil diperbarui!');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Testimoni berhasil dihapus.');
    }
}
