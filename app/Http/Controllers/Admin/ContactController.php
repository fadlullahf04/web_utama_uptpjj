<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = ContactMessage::orderBy('created_at', 'desc');

        if ($status === 'unread') {
            $query->where('is_read', false);
        } elseif ($status === 'read') {
            $query->where('is_read', true);
        }

        $messages = $query->paginate(15)->withQueryString();
        $unreadCount = ContactMessage::where('is_read', false)->count();

        return view('admin.contacts.index', compact('messages', 'status', 'unreadCount'));
    }

    public function show(ContactMessage $contact)
    {
        if (! $contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('admin.contacts.show', ['message' => $contact]);
    }

    public function reply(Request $request, ContactMessage $contact)
    {
        $validated = $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $contact->update([
            'admin_reply' => $validated['admin_reply'],
            'replied_at' => now(),
            'is_read' => true,
        ]);

        return back()->with('success', 'Balasan respon telah disimpan untuk riwayat helpdesk.');
    }

    public function destroy(ContactMessage $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Pesan helpdesk berhasil dihapus.');
    }
}
