<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the specified dynamic page.
     */
    public function show(string $slug): View
    {
        $user = Auth::user();
        $isStaffOrAdmin = $user && ($user->isAdmin() || $user->isEditor());

        $query = Page::query()->where('slug', $slug);

        if (! $isStaffOrAdmin) {
            $query->published();
        }

        $page = $query->firstOrFail();

        // Increment view count for public visitors
        if (! $isStaffOrAdmin) {
            $page->increment('views_count');
        }

        // Sidebar widgets: recent published pages and popular articles
        $otherPages = Page::published()
            ->where('id', '!=', $page->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('pages.dynamic.show', compact('page', 'otherPages'));
    }
}
