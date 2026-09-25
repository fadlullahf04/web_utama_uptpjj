<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DownloadDocument;
use App\Models\Faq;

class LmsGuideController extends Controller
{
    public function index()
    {
        $lmsDocs = DownloadDocument::active()->where('category', 'Panduan LMS')->get();
        $lmsFaqs = Faq::active()->where('category', 'like', '%LMS%')->get();
        return view('pages.lms-guide.index', compact('lmsDocs', 'lmsFaqs'));
    }
}
