<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\UpbjjZone;
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

        // Dynamically inject live UPBJJ zones table when viewing the UPBJJ page
        if ($page->slug === 'upbjj') {
            $page->content = preg_replace(
                '/<div class="upbjj-dynamic-directory">.*?<\/table>\s*<\/div>\s*<\/div>|<div class="overflow-x-auto my-6">\s*<table.*?<\/table>\s*<\/div>/s',
                UpbjjZone::renderHtmlTable(),
                $page->content,
                1
            ) ?: $page->content;
        }

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
