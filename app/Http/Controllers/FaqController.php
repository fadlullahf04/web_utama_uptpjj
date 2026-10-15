<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('kategori');
        $search = $request->query('cari');

        $query = Faq::active();

        if ($category) {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                    ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        $faqs = $query->get()->groupBy('category');
        $allCategories = Faq::select('category')->distinct()->pluck('category');

        return view('pages.faqs.index', compact('faqs', 'allCategories', 'category', 'search'));
    }
}
