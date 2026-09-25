<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('kategori');
        $search = $request->query('cari');

        $query = Post::published()->with(['category', 'author']);

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(9)->withQueryString();
        $categories = Category::withCount(['posts' => function ($q) {
            $q->published();
        }])->get();
        $popularPosts = Post::published()->orderBy('views_count', 'desc')->take(5)->get();

        return view('pages.posts.index', compact('posts', 'categories', 'popularPosts', 'categorySlug', 'search'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->published()->with(['category', 'author'])->firstOrFail();
        
        // Increment views
        $post->increment('views_count');

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->take(3)
            ->get();

        if ($relatedPosts->isEmpty()) {
            $relatedPosts = Post::published()->where('id', '!=', $post->id)->take(3)->get();
        }

        return view('pages.posts.show', compact('post', 'relatedPosts'));
    }
}
