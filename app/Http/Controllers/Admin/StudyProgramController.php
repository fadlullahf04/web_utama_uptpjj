<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudyProgramController extends Controller
{
    public function index()
    {
        $programs = StudyProgram::orderBy('order', 'asc')->get();

        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'degree' => 'required|in:S1,S2',
            'faculty' => 'required|string|max:255',
            'accreditation' => 'required|string|max:50',
            'code' => 'nullable|string|max:50',
            'head_of_program' => 'nullable|string|max:255',
            'head_nip' => 'nullable|string|max:50',
            'graduate_title' => 'nullable|string|max:50',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'vision_mission' => 'nullable|string',
            'curriculum' => 'nullable|string',
            'career_prospects' => 'nullable|string',
            'total_credits' => 'nullable|integer',
            'study_duration' => 'nullable|string',
            'learning_method' => 'nullable|string',
            'tuition_info' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_url' => 'nullable|url',
            'registration_url' => 'nullable|url',
            'website_url' => 'nullable|url',
            'order' => 'nullable|integer',
        ]);

        $imagePath = $request->input('image_url');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('programs', 'public');
        }

        StudyProgram::create(array_merge($validated, [
            'slug' => Str::slug($validated['name']),
            'image' => $imagePath,
            'order' => $validated['order'] ?? 0,
            'is_active' => true,
        ]));

        return redirect()->route('admin.programs.index')->with('success', 'Program Studi PJJ berhasil ditambahkan!');
    }

    public function edit(StudyProgram $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, StudyProgram $program)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'degree' => 'required|in:S1,S2',
            'faculty' => 'required|string|max:255',
            'accreditation' => 'required|string|max:50',
            'code' => 'nullable|string|max:50',
            'head_of_program' => 'nullable|string|max:255',
            'head_nip' => 'nullable|string|max:50',
            'graduate_title' => 'nullable|string|max:50',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'vision_mission' => 'nullable|string',
            'curriculum' => 'nullable|string',
            'career_prospects' => 'nullable|string',
            'total_credits' => 'nullable|integer',
            'study_duration' => 'nullable|string',
            'learning_method' => 'nullable|string',
            'tuition_info' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_url' => 'nullable|url',
            'registration_url' => 'nullable|url',
            'website_url' => 'nullable|url',
            'order' => 'nullable|integer',
        ]);

        $imagePath = $program->image;
        if ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        }
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('programs', 'public');
        }

        $program->update(array_merge($validated, [
            'image' => $imagePath,
            'order' => $validated['order'] ?? $program->order,
            'is_active' => true,
        ]));

        return redirect()->route('admin.programs.index')->with('success', 'Program Studi PJJ berhasil diperbarui!');
    }

    public function destroy(StudyProgram $program)
    {
        $program->delete();

        return redirect()->route('admin.programs.index')->with('success', 'Program Studi berhasil dihapus.');
    }
}
