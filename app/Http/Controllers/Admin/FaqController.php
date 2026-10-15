<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('order', 'asc')->get();

        return view('admin.faqs.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'category' => 'required|string|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        Faq::create(array_merge($validated, [
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]));

        return back()->with('success', 'FAQ berhasil ditambahkan!');
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'category' => 'required|string|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $faq->update(array_merge($validated, [
            'order' => $validated['order'] ?? $faq->order,
            'is_active' => $request->boolean('is_active'),
        ]));

        return back()->with('success', 'FAQ berhasil diperbarui!');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return back()->with('success', 'FAQ berhasil dihapus.');
    }
}
