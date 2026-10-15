<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Post;
use App\Models\Service;
use App\Models\StudyProgram;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML sitemap for SEO crawlers.
     */
    public function index(): Response
    {
        $urls = [];

        // Static core pages
        $staticPages = [
            ['url' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => route('profile.overview'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('profile.vision-mission'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('profile.organization'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('profile.team'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('profile.facilities'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('profile.graduate-profile'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('profile.video-profile'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('programs.index'), 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => route('services.index'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('posts.index'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => route('announcements.index'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['url' => route('downloads.index'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => route('faqs'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => route('lms-guide'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('contact.index'), 'priority' => '0.7', 'changefreq' => 'monthly'],
        ];

        foreach ($staticPages as $page) {
            $urls[] = [
                'loc' => $page['url'],
                'lastmod' => now()->tz('UTC')->toAtomString(),
                'changefreq' => $page['changefreq'],
                'priority' => $page['priority'],
            ];
        }

        // Published Posts / Berita
        $posts = Post::published()->get();
        foreach ($posts as $post) {
            $urls[] = [
                'loc' => route('posts.show', $post->slug),
                'lastmod' => $post->updated_at ? $post->updated_at->tz('UTC')->toAtomString() : now()->tz('UTC')->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // Active Announcements / Pengumuman
        $announcements = Announcement::active()->get();
        foreach ($announcements as $announcement) {
            $urls[] = [
                'loc' => route('announcements.show', $announcement->slug),
                'lastmod' => $announcement->updated_at ? $announcement->updated_at->tz('UTC')->toAtomString() : now()->tz('UTC')->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        // Study Programs
        $programs = StudyProgram::orderBy('order')->get();
        foreach ($programs as $program) {
            $urls[] = [
                'loc' => route('programs.show', $program->slug),
                'lastmod' => $program->updated_at ? $program->updated_at->tz('UTC')->toAtomString() : now()->tz('UTC')->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // Active Services
        $services = Service::where('is_active', true)->orderBy('order')->get();
        foreach ($services as $service) {
            $urls[] = [
                'loc' => route('services.show', $service->slug),
                'lastmod' => $service->updated_at ? $service->updated_at->tz('UTC')->toAtomString() : now()->tz('UTC')->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }

        return response()->view('sitemap', ['urls' => $urls], 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
