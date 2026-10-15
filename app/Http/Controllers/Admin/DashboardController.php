<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\ContactMessage;
use App\Models\DownloadDocument;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Service;
use App\Models\StudyProgram;
use App\Models\TeamMember;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'total_announcements' => Announcement::count(),
            'total_programs' => StudyProgram::count(),
            'total_services' => Service::count(),
            'total_downloads' => DownloadDocument::count(),
            'total_download_clicks' => DownloadDocument::sum('downloads_count'),
            'total_views' => Post::sum('views_count'),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'total_messages' => ContactMessage::count(),
            'total_teams' => TeamMember::count(),
            'total_faqs' => Faq::count(),
            'total_users' => User::count(),
        ];

        $recentMessages = ContactMessage::orderBy('created_at', 'desc')->take(5)->get();
        $recentPosts = Post::with('category')->orderBy('created_at', 'desc')->take(5)->get();
        $popularPosts = Post::orderBy('views_count', 'desc')->take(5)->get();
        $recentAnnouncements = Announcement::orderBy('created_at', 'desc')->take(4)->get();

        return view('admin.dashboard', compact('stats', 'recentMessages', 'recentPosts', 'popularPosts', 'recentAnnouncements'));
    }
}
