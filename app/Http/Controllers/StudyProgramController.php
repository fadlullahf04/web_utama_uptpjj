<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudyProgram;

class StudyProgramController extends Controller
{
    public function index(Request $request)
    {
        $degree = $request->query('degree');
        $query = StudyProgram::active();

        if ($degree && in_array($degree, ['S1', 'S2'])) {
            $query->where('degree', $degree);
        }

        $programs = $query->get();
        return view('pages.programs.index', compact('programs', 'degree'));
    }

    public function show($slug)
    {
        $program = StudyProgram::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $otherPrograms = StudyProgram::active()->where('id', '!=', $program->id)->take(3)->get();
        return view('pages.programs.show', compact('program', 'otherPrograms'));
    }
}
