<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class GraduateProfileController extends Controller
{
    public static function defaultCompetencies(): array
    {
        return [
            [
                'title' => 'Digital Pedagogy Mastery',
                'description' => 'Menguasai keahlian pedagogi berbasis digital, pembuatan media edukasi interaktif, perancangan modul e-learning, dan pengelolaan kelas virtual modern.',
                'icon' => 'fa-solid fa-laptop-code',
                'color' => 'emerald',
            ],
            [
                'title' => 'Integrasi Keilmuan Islam',
                'description' => 'Memiliki pemahaman keislaman yang moderat (wasathiyah), berkarakter tauhid, dan mampu mengontekstualisasikan ajaran Islam dengan perkembangan sains dan teknologi.',
                'icon' => 'fa-solid fa-book-quran',
                'color' => 'teal',
            ],
            [
                'title' => 'Kepemimpinan & Profesional',
                'description' => 'Siap memimpin madrasah/sekolah, menjadi praktisi hukum syariah, mediator, pengembang modul MOOC, maupun melanjutkan studi ke jenjang doktoral (S3).',
                'icon' => 'fa-solid fa-briefcase',
                'color' => 'amber',
            ],
        ];
    }

    public static function defaultCareers(): array
    {
        return [
            [
                'title' => 'Pendidik Profesional',
                'description' => 'Guru PAI, Guru MI/SD, Guru Bahasa Arab di sekolah umum maupun madrasah di seluruh Indonesia.',
                'icon' => 'fa-solid fa-chalkboard-user',
                'color' => 'emerald',
            ],
            [
                'title' => 'Praktisi Hukum Syariah',
                'description' => 'Penghulu, staf KUA, mediator non-hakim di Pengadilan Agama, advokat syariah, dan konsultan keluarga sakinah.',
                'icon' => 'fa-solid fa-scale-balanced',
                'color' => 'purple',
            ],
            [
                'title' => 'Konten Edukator',
                'description' => 'Instructional designer, pembuat modul MOOC, edukator digital, dan spesialis kurikulum online.',
                'icon' => 'fa-solid fa-clapperboard',
                'color' => 'teal',
            ],
            [
                'title' => 'Manajer Pendidikan (S2)',
                'description' => 'Kepala Madrasah, Pengawas Pendidikan Kemenag, Widyaiswara BDK, dan Dosen di perguruan tinggi.',
                'icon' => 'fa-solid fa-user-tie',
                'color' => 'amber',
            ],
        ];
    }

    public function index(): View
    {
        $title = Setting::get('graduate_profile_title', 'Profil Lulusan & Capaian Pembelajaran');
        $subtitle = Setting::get('graduate_profile_subtitle', 'Kompetensi unggul yang dimiliki oleh para lulusan sarjana (S1) dan magister (S2) PJJ UIN Siber Syekh Nurjati Cirebon.');
        $careersTitle = Setting::get('graduate_careers_title', 'Peluang & Prospek Karir Lulusan PJJ');

        $competencies = json_decode((string) Setting::get('graduate_competencies', ''), true);
        if (! is_array($competencies) || empty($competencies)) {
            $competencies = self::defaultCompetencies();
        }

        $careers = json_decode((string) Setting::get('graduate_careers', ''), true);
        if (! is_array($careers) || empty($careers)) {
            $careers = self::defaultCareers();
        }

        return view('admin.graduate-profile.index', compact(
            'title',
            'subtitle',
            'careersTitle',
            'competencies',
            'careers'
        ));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'graduate_profile_title' => 'required|string|max:255',
            'graduate_profile_subtitle' => 'nullable|string|max:500',
            'graduate_careers_title' => 'required|string|max:255',
            'competencies' => 'nullable|array',
            'competencies.*.title' => 'required|string|max:150',
            'competencies.*.description' => 'required|string|max:1000',
            'competencies.*.icon' => 'nullable|string|max:80',
            'competencies.*.color' => 'nullable|string|in:emerald,teal,amber,blue,purple',
            'careers' => 'nullable|array',
            'careers.*.title' => 'required|string|max:150',
            'careers.*.description' => 'required|string|max:1000',
            'careers.*.icon' => 'nullable|string|max:80',
            'careers.*.color' => 'nullable|string|in:emerald,teal,amber,blue,purple',
        ]);

        Setting::set('graduate_profile_title', $validated['graduate_profile_title'], 'graduate');
        Setting::set('graduate_profile_subtitle', $validated['graduate_profile_subtitle'] ?? '', 'graduate');
        Setting::set('graduate_careers_title', $validated['graduate_careers_title'], 'graduate');
        Setting::set('graduate_competencies', json_encode(array_values($validated['competencies'] ?? [])), 'graduate');
        Setting::set('graduate_careers', json_encode(array_values($validated['careers'] ?? [])), 'graduate');

        Cache::flush();

        return redirect()->route('admin.graduate-profile.index')->with('success', 'Konten Profil Lulusan berhasil diperbarui!');
    }
}
