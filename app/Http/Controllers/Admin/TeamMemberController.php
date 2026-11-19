<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationCategory;
use App\Models\StudyProgram;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TeamMemberController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('order', 'asc')->get();
        $categories = OrganizationCategory::allOrdered();
        $tierLabels = OrganizationCategory::TIER_LABELS;

        return view('admin.team.index', compact('members', 'categories', 'tierLabels'));
    }

    public function create()
    {
        $categories = OrganizationCategory::allOrdered();
        $studyPrograms = StudyProgram::orderBy('name', 'asc')->pluck('name');

        return view('admin.team.create', compact('categories', 'studyPrograms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'division' => 'required|string|max:100',
            'department' => 'nullable|string|max:150',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'photo_url' => 'nullable|url',
            'bio' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if (! Schema::hasColumn('team_members', 'department')) {
            unset($validated['department']);
        }

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
        $categories = OrganizationCategory::allOrdered();
        $studyPrograms = StudyProgram::orderBy('name', 'asc')->pluck('name');

        return view('admin.team.edit', [
            'member' => $team,
            'categories' => $categories,
            'studyPrograms' => $studyPrograms,
        ]);
    }

    public function update(Request $request, TeamMember $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'division' => 'required|string|max:100',
            'department' => 'nullable|string|max:150',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'photo_url' => 'nullable|url',
            'bio' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if (! Schema::hasColumn('team_members', 'department')) {
            unset($validated['department']);
        }

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

    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:organization_categories,name',
            'tier' => 'required|integer|in:1,2,3,4',
            'order' => 'nullable|integer|min:0',
        ]);

        OrganizationCategory::create([
            'name' => $validated['name'],
            'tier' => (int) $validated['tier'],
            'order' => $validated['order'] ?? (OrganizationCategory::max('order') + 1),
        ]);

        return redirect()->route('admin.team.index')->with('success', 'Kategori struktur organisasi berhasil ditambahkan!');
    }

    public function updateCategory(Request $request, OrganizationCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:organization_categories,name,'.$category->id,
            'tier' => 'required|integer|in:1,2,3,4',
            'order' => 'nullable|integer|min:0',
        ]);

        $oldName = $category->name;
        $category->update([
            'name' => $validated['name'],
            'tier' => (int) $validated['tier'],
            'order' => $validated['order'] ?? $category->order,
        ]);

        if ($oldName !== $validated['name']) {
            TeamMember::where('division', $oldName)->update(['division' => $validated['name']]);
        }

        return redirect()->route('admin.team.index')->with('success', 'Kategori struktur organisasi berhasil diperbarui!');
    }

    public function destroyCategory(OrganizationCategory $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.team.index')->with('success', 'Kategori struktur organisasi berhasil dihapus.');
    }
}
