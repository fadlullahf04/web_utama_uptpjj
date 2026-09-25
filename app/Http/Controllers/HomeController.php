<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeroSlide;
use App\Models\StudyProgram;
use App\Models\Post;
use App\Models\Announcement;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\GalleryItem;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\Faq;

class HomeController extends Controller
{
    public function index()
    {
        $heroSlides = HeroSlide::active()->get();
        $studyPrograms = StudyProgram::active()->get();
        $featuredPosts = Post::published()->featured()->take(3)->get();
        $latestPosts = Post::published()->take(6)->get();
        $pinnedAnnouncements = Announcement::active()->where('is_pinned', true)->take(3)->get();
        $latestAnnouncements = Announcement::active()->take(4)->get();
        $services = Service::active()->take(6)->get();
        $testimonials = Testimonial::active()->take(3)->get();
        $galleries = GalleryItem::orderBy('order', 'asc')->take(4)->get();
        $faqs = Faq::active()->take(5)->get();

        return view('pages.home', compact(
            'heroSlides',
            'studyPrograms',
            'featuredPosts',
            'latestPosts',
            'pinnedAnnouncements',
            'latestAnnouncements',
            'services',
            'testimonials',
            'galleries',
            'faqs'
        ));
    }
}
