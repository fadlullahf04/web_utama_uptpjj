<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('kategori');
        $query = Announcement::active();

        if ($category) {
            $query->where('category', $category);
        }

        $announcements = $query->paginate(10)->withQueryString();
        $categories = Announcement::select('category')->distinct()->pluck('category');

        return view('pages.announcements.index', compact('announcements', 'categories', 'category'));
    }

    public function show($slug)
    {
        $announcement = Announcement::where('slug', $slug)->active()->firstOrFail();
        $recentAnnouncements = Announcement::active()->where('id', '!=', $announcement->id)->take(4)->get();

        return view('pages.announcements.show', compact('announcement', 'recentAnnouncements'));
    }
}
