<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DownloadDocument;

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
            return redirect()->away($doc->external_url);
        }

        if ($doc->file_path) {
            if (str_starts_with($doc->file_path, 'http')) {
                return redirect()->away($doc->file_path);
            }
            $filePath = storage_path('app/public/' . $doc->file_path);
            if (file_exists($filePath)) {
                return response()->download($filePath, $doc->title . '.' . $doc->file_type);
            }
        }

        return back()->with('error', 'File tidak ditemukan di server.');
    }
}
