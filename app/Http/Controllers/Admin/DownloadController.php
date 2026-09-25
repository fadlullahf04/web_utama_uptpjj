<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DownloadDocument;
use Illuminate\Support\Str;

class DownloadController extends Controller
{
    public function index()
    {
        $documents = DownloadDocument::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.downloads.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.downloads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:20480',
            'external_url' => 'nullable|url',
            'file_type' => 'nullable|string|max:20',
            'file_size' => 'nullable|string|max:20',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $filePath = null;
        $fileType = $validated['file_type'] ?? 'PDF';
        $fileSize = $validated['file_size'] ?? '1.2 MB';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('downloads', 'public');
            $fileType = strtoupper($file->getClientOriginalExtension());
            $bytes = $file->getSize();
            $fileSize = $bytes >= 1048576 ? round($bytes / 1048576, 1) . ' MB' : round($bytes / 1024, 0) . ' KB';
        }

        DownloadDocument::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . Str::random(4),
            'category' => $validated['category'],
            'description' => $validated['description'],
            'file_path' => $filePath,
            'external_url' => $validated['external_url'],
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.downloads.index')->with('success', 'Dokumen unduhan berhasil ditambahkan!');
    }

    public function edit(DownloadDocument $download)
    {
        return view('admin.downloads.edit', ['document' => $download]);
    }

    public function update(Request $request, DownloadDocument $download)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:20480',
            'external_url' => 'nullable|url',
            'file_type' => 'nullable|string|max:20',
            'file_size' => 'nullable|string|max:20',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $filePath = $download->file_path;
        $fileType = $download->file_type;
        $fileSize = $download->file_size;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('downloads', 'public');
            $fileType = strtoupper($file->getClientOriginalExtension());
            $bytes = $file->getSize();
            $fileSize = $bytes >= 1048576 ? round($bytes / 1048576, 1) . ' MB' : round($bytes / 1024, 0) . ' KB';
        }

        $download->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'file_path' => $filePath,
            'external_url' => $validated['external_url'] ?? $download->external_url,
            'file_type' => $validated['file_type'] ?? $fileType,
            'file_size' => $validated['file_size'] ?? $fileSize,
            'order' => $validated['order'] ?? $download->order,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.downloads.index')->with('success', 'Dokumen unduhan berhasil diperbarui!');
    }

    public function destroy(DownloadDocument $download)
    {
        $download->delete();
        return redirect()->route('admin.downloads.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
