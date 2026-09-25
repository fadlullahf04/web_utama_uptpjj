<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order', 'asc')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'short_description' => 'required|string',
            'content' => 'nullable|string',
            'icon' => 'required|string',
            'image_url' => 'nullable|url',
            'portal_url' => 'nullable|url',
            'button_text' => 'nullable|string',
            'order' => 'integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        Service::create(array_merge($validated, [
            'slug' => Str::slug($validated['title']),
            'image' => $validated['image_url'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
        ]));

        return redirect()->route('admin.services.index')->with('success', 'Layanan PJJ berhasil ditambahkan!');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'short_description' => 'required|string',
            'content' => 'nullable|string',
            'icon' => 'required|string',
            'image_url' => 'nullable|url',
            'portal_url' => 'nullable|url',
            'button_text' => 'nullable|string',
            'order' => 'integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $service->update(array_merge($validated, [
            'image' => $validated['image_url'] ?? $service->image,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ]));

        return redirect()->route('admin.services.index')->with('success', 'Layanan PJJ berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
