<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'attachment_name' => 'nullable|string|max:255',
            'attachment_file' => 'nullable|file|max:10240',
            'attachment_url' => 'nullable|url',
            'is_pinned' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
        ]);

        $filePath = $request->input('attachment_url');
        if ($request->hasFile('attachment_file')) {
            $filePath = $request->file('attachment_file')->store('announcements', 'public');
        }

        Announcement::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . Str::random(4),
            'category' => $validated['category'],
            'content' => $validated['content'],
            'attachment_name' => $validated['attachment_name'],
            'attachment_file' => $filePath,
            'is_pinned' => $request->boolean('is_pinned'),
            'is_published' => $request->boolean('is_published', true),
            'published_at' => $validated['published_at'] ?? now(),
            'expires_at' => $validated['expires_at'],
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'attachment_name' => 'nullable|string|max:255',
            'attachment_file' => 'nullable|file|max:10240',
            'attachment_url' => 'nullable|url',
            'is_pinned' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
        ]);

        $filePath = $announcement->attachment_file;
        if ($request->filled('attachment_url')) {
            $filePath = $request->input('attachment_url');
        }
        if ($request->hasFile('attachment_file')) {
            $filePath = $request->file('attachment_file')->store('announcements', 'public');
        }

        $announcement->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'content' => $validated['content'],
            'attachment_name' => $validated['attachment_name'],
            'attachment_file' => $filePath,
            'is_pinned' => $request->boolean('is_pinned'),
            'is_published' => $request->boolean('is_published'),
            'published_at' => $validated['published_at'] ?? $announcement->published_at,
            'expires_at' => $validated['expires_at'],
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
