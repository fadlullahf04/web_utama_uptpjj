<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamMember;
use App\Models\GalleryItem;
use App\Models\Setting;

class ProfileController extends Controller
{
    public function overview()
    {
        return view('pages.profile.overview');
    }

    public function visionMission()
    {
        return view('pages.profile.vision-mission');
    }

    public function organization()
    {
        $leadership = TeamMember::active()->where('division', 'Pimpinan')->get();
        $divisions = TeamMember::active()->where('division', '!=', 'Pimpinan')->get()->groupBy('division');
        return view('pages.profile.organization', compact('leadership', 'divisions'));
    }

    public function team()
    {
        $teams = TeamMember::active()->get()->groupBy('division');
        return view('pages.profile.team', compact('teams'));
    }

    public function facilities()
    {
        $galleries = GalleryItem::orderBy('order', 'asc')->get()->groupBy('category');
        return view('pages.profile.facilities', compact('galleries'));
    }

    public function graduateProfile()
    {
        return view('pages.profile.graduate-profile');
    }

    public function videoProfile()
    {
        return view('pages.profile.video-profile');
    }
}
