<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('order', 'asc')->get();

        return view('admin.team.index', compact('members'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'division' => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'photo_url' => 'nullable|url',
            'bio' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $photoPath = $request->input('photo_url');
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('team', 'public');
        }

        TeamMember::create(array_merge($validated, [
            'photo' => $photoPath,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]));

        return redirect()->route('admin.team.index')->with('success', 'Anggota tim/struktur berhasil ditambahkan!');
    }

    public function edit(TeamMember $team)
    {
        return view('admin.team.edit', ['member' => $team]);
    }

    public function update(Request $request, TeamMember $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'division' => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'photo_url' => 'nullable|url',
            'bio' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $photoPath = $team->photo;
        if ($request->filled('photo_url')) {
            $photoPath = $request->input('photo_url');
        }
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('team', 'public');
        }

        $team->update(array_merge($validated, [
            'photo' => $photoPath,
            'order' => $validated['order'] ?? $team->order,
            'is_active' => $request->boolean('is_active'),
        ]));

        return redirect()->route('admin.team.index')->with('success', 'Data tim/struktur berhasil diperbarui!');
    }

    public function destroy(TeamMember $team)
    {
        $team->delete();

        return redirect()->route('admin.team.index')->with('success', 'Anggota tim berhasil dihapus.');
    }
}
