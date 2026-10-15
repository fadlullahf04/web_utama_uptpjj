<?php

namespace App\Http\Controllers;

use App\Models\DownloadDocument;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('kategori');
        $search = $request->query('cari');

        $query = DownloadDocument::active();

        if ($category) {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $documents = $query->paginate(12)->withQueryString();
        $categories = DownloadDocument::select('category')->distinct()->pluck('category');

        return view('pages.downloads.index', compact('documents', 'categories', 'category', 'search'));
    }

    public function download($id)
    {
        $doc = DownloadDocument::findOrFail($id);
        $doc->increment('downloads_count');

        if ($doc->external_url) {
            $scheme = parse_url($doc->external_url, PHP_URL_SCHEME);
            if (in_array(strtolower((string) $scheme), ['http', 'https'], true)) {
                return redirect()->away($doc->external_url);
            }

            return back()->with('error', 'Tautan unduhan eksternal tidak valid.');
        }

        if ($doc->file_path) {
            if (str_starts_with($doc->file_path, 'http://') || str_starts_with($doc->file_path, 'https://')) {
                return redirect()->away($doc->file_path);
            }

            $baseStorage = realpath(storage_path('app/public'));
            $filePath = storage_path('app/public/'.$doc->file_path);
            $realPath = realpath($filePath);

            // Prevent path traversal outside storage directory
            if ($baseStorage && $realPath && str_starts_with($realPath, $baseStorage) && file_exists($realPath)) {
                $cleanTitle = preg_replace('/[^a-zA-Z0-9_\-\. ]/', '', $doc->title);
                $ext = preg_replace('/[^a-zA-Z0-9]/', '', $doc->file_type ?? 'pdf');
                $filename = ($cleanTitle ?: 'dokumen-uptpjj').'.'.($ext ?: 'pdf');

                return response()->download($realPath, $filename);
            }
        }

        return back()->with('error', 'File tidak ditemukan di server.');
    }
}
