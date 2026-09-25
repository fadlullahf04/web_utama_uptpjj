<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'message' => 'required|string|min:10',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Terima kasih! Pesan dan pertanyaan Anda telah berhasil dikirim ke tim Helpdesk UPT PJJ UINSSC. Kami akan segera merespons ke email/nomor kontak Anda.');
    }
}
