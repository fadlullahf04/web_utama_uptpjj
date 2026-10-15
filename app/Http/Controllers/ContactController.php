<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact.index');
    }

    public function store(Request $request)
    {
        // Anti-bot honeypot check
        if ($request->filled('_hp_company')) {
            return back()->with('success', 'Terima kasih! Pesan Anda telah diterima.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'message' => 'required|string|min:10|max:5000',
        ]);

        // Sanitize text inputs to prevent HTML/script injection
        $cleanData = [
            'name' => strip_tags($validated['name']),
            'email' => filter_var($validated['email'], FILTER_SANITIZE_EMAIL),
            'phone' => isset($validated['phone']) ? strip_tags($validated['phone']) : null,
            'subject' => strip_tags($validated['subject']),
            'category' => strip_tags($validated['category']),
            'message' => strip_tags($validated['message']),
        ];

        ContactMessage::create($cleanData);

        return back()->with('success', 'Terima kasih! Pesan dan pertanyaan Anda telah berhasil dikirim ke tim Helpdesk UPT PJJ UINSSC. Kami akan segera merespons ke email/nomor kontak Anda.');
    }
}
