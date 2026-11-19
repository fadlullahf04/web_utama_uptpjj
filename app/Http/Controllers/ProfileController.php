<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\GraduateProfileController;
use App\Models\GalleryItem;
use App\Models\OrganizationCategory;
use App\Models\Setting;
use App\Models\StudyProgram;
use App\Models\TeamMember;
use Illuminate\Support\Collection;

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
        $members = TeamMember::active()->get();
        $tierByCategory = OrganizationCategory::allOrdered()->pluck('tier', 'name');

        $kepalaUpt = $members->filter(fn (TeamMember $m): bool => $this->resolveMemberTier($m, $tierByCategory) === OrganizationCategory::TIER_KEPALA)->values();
        $sekretarisUpt = $members->filter(fn (TeamMember $m): bool => $this->resolveMemberTier($m, $tierByCategory) === OrganizationCategory::TIER_SEKRETARIS)->values();
        $pimpinanJurusanMembers = $members->filter(fn (TeamMember $m): bool => $this->resolveMemberTier($m, $tierByCategory) === OrganizationCategory::TIER_PIMPINAN_JURUSAN)->values();
        $staffUpt = $members->filter(fn (TeamMember $m): bool => $this->resolveMemberTier($m, $tierByCategory) === OrganizationCategory::TIER_STAFF)->values();

        // Group Pimpinan Jurusan by Jurusan (department) showing Ketua Jurusan & Sekretaris Jurusan
        $jurusanGroups = collect();

        foreach ($pimpinanJurusanMembers as $member) {
            $jurusanName = trim((string) ($member->department ?? ''));
            if ($jurusanName === '') {
                $jurusanName = 'Jurusan / Program Studi';
            }

            if (! $jurusanGroups->has($jurusanName)) {
                $jurusanGroups->put($jurusanName, [
                    'jurusan' => $jurusanName,
                    'ketua' => collect(),
                    'sekretaris' => collect(),
                ]);
            }

            $group = $jurusanGroups->get($jurusanName);
            $isSekretaris = str_contains(strtolower($member->division.' '.$member->title), 'sekretaris');

            if ($isSekretaris) {
                $group['sekretaris']->push($member);
            } else {
                $group['ketua']->push($member);
            }
        }

        // Merge active StudyPrograms if not already covered by TeamMember department
        $studyPrograms = StudyProgram::active()->get();
        foreach ($studyPrograms as $program) {
            $hasHead = ! empty($program->head_of_program);
            $hasSec = ! empty($program->secretary_of_program);
            if (! $hasHead && ! $hasSec) {
                continue;
            }

            $group = $jurusanGroups->get($program->name, [
                'jurusan' => $program->name,
                'ketua' => collect(),
                'sekretaris' => collect(),
            ]);

            if ($group['ketua']->isEmpty() && $hasHead) {
                $group['ketua']->push((object) [
                    'name' => $program->head_of_program,
                    'title' => 'Ketua Jurusan',
                    'nip' => null,
                    'photo_url' => 'https://ui-avatars.com/api/?name='.urlencode($program->head_of_program).'&background=006837&color=ffffff&bold=true',
                ]);
            }

            if ($group['sekretaris']->isEmpty() && $hasSec) {
                $group['sekretaris']->push((object) [
                    'name' => $program->secretary_of_program,
                    'title' => 'Sekretaris Jurusan',
                    'nip' => null,
                    'photo_url' => 'https://ui-avatars.com/api/?name='.urlencode($program->secretary_of_program).'&background=0f766e&color=ffffff&bold=true',
                ]);
            }

            $jurusanGroups->put($program->name, $group);
        }

        $jurusanGroups = $jurusanGroups->values();

        return view('pages.profile.organization', compact(
            'kepalaUpt',
            'sekretarisUpt',
            'jurusanGroups',
            'staffUpt'
        ));
    }

    public function team()
    {
        $members = TeamMember::active()->get();
        $tierByCategory = OrganizationCategory::allOrdered()->pluck('tier', 'name');

        $kepala = $members->filter(fn (TeamMember $m): bool => $this->resolveMemberTier($m, $tierByCategory) === OrganizationCategory::TIER_KEPALA)->values();
        $sekretaris = $members->filter(fn (TeamMember $m): bool => $this->resolveMemberTier($m, $tierByCategory) === OrganizationCategory::TIER_SEKRETARIS)->values();
        $pimpinanJurusan = $members->filter(fn (TeamMember $m): bool => $this->resolveMemberTier($m, $tierByCategory) === OrganizationCategory::TIER_PIMPINAN_JURUSAN)->values();
        $staff = $members->filter(fn (TeamMember $m): bool => $this->resolveMemberTier($m, $tierByCategory) === OrganizationCategory::TIER_STAFF)->values();

        if ($pimpinanJurusan->isEmpty()) {
            $pimpinanJurusan = StudyProgram::active()->get()->flatMap(function (StudyProgram $program): array {
                $items = [];
                if (! empty($program->head_of_program)) {
                    $items[] = (object) [
                        'name' => $program->head_of_program,
                        'title' => 'Ketua Jurusan',
                        'department' => $program->name,
                        'nip' => null,
                        'bio' => null,
                        'email' => null,
                        'photo_url' => 'https://ui-avatars.com/api/?name='.urlencode($program->head_of_program).'&background=006837&color=ffffff&bold=true',
                    ];
                }
                if (! empty($program->secretary_of_program)) {
                    $items[] = (object) [
                        'name' => $program->secretary_of_program,
                        'title' => 'Sekretaris Jurusan',
                        'department' => $program->name,
                        'nip' => null,
                        'bio' => null,
                        'email' => null,
                        'photo_url' => 'https://ui-avatars.com/api/?name='.urlencode($program->secretary_of_program).'&background=0f766e&color=ffffff&bold=true',
                    ];
                }

                return $items;
            });
        }

        $teams = collect([
            'Kepala UPT PJJ' => $kepala,
            'Sekretaris UPT PJJ' => $sekretaris,
            'Pimpinan Jurusan' => $pimpinanJurusan,
            'Staff UPT PJJ' => $staff,
        ])->filter(fn (Collection $group): bool => $group->isNotEmpty());

        return view('pages.profile.team', compact('teams'));
    }

    protected function resolveMemberTier(TeamMember $member, Collection $tierByCategory): int
    {
        if ($tierByCategory->has($member->division)) {
            return (int) $tierByCategory->get($member->division);
        }

        if ($member->division === 'Pimpinan') {
            return str_contains(strtolower($member->title), 'sekretaris')
                ? OrganizationCategory::TIER_SEKRETARIS
                : OrganizationCategory::TIER_KEPALA;
        }

        return OrganizationCategory::TIER_STAFF;
    }

    public function facilities()
    {
        $galleries = GalleryItem::orderBy('order', 'asc')->get()->groupBy('category');

        return view('pages.profile.facilities', compact('galleries'));
    }

    public function graduateProfile()
    {
        $title = Setting::get('graduate_profile_title', 'Profil Lulusan & Capaian Pembelajaran');
        $subtitle = Setting::get('graduate_profile_subtitle', 'Kompetensi unggul yang dimiliki oleh para lulusan sarjana (S1) dan magister (S2) PJJ UIN Siber Syekh Nurjati Cirebon.');
        $careersTitle = Setting::get('graduate_careers_title', 'Peluang & Prospek Karir Lulusan PJJ');

        $competencies = json_decode((string) Setting::get('graduate_competencies', ''), true);
        if (! is_array($competencies) || empty($competencies)) {
            $competencies = GraduateProfileController::defaultCompetencies();
        }

        $careers = json_decode((string) Setting::get('graduate_careers', ''), true);
        if (! is_array($careers) || empty($careers)) {
            $careers = GraduateProfileController::defaultCareers();
        }

        return view('pages.profile.graduate-profile', compact(
            'title',
            'subtitle',
            'careersTitle',
            'competencies',
            'careers'
        ));
    }

    public function videoProfile()
    {
        $videos = GalleryItem::where(function ($query): void {
            $query->where('type', 'video')
                ->orWhere('category', 'Video Profil');
        })
            ->orderBy('order', 'asc')
            ->orderByDesc('id')
            ->get()
            ->map(function (GalleryItem $item): GalleryItem {
                $item->embed_url = $this->toYoutubeEmbedUrl($item->media_url);

                return $item;
            });

        $settingVideoUrl = Setting::get('profile_video_url', '');
        $mainVideoUrl = $this->toYoutubeEmbedUrl($settingVideoUrl);

        if (! $mainVideoUrl && $videos->isNotEmpty()) {
            $mainVideoUrl = $videos->first()->embed_url;
        }

        if (! $mainVideoUrl) {
            $mainVideoUrl = 'https://www.youtube.com/embed/dQw4w9WgXcQ';
        }

        return view('pages.profile.video-profile', compact('mainVideoUrl', 'videos'));
    }

    protected function toYoutubeEmbedUrl(?string $url): ?string
    {
        $url = trim((string) $url);
        if ($url === '') {
            return null;
        }

        if (str_contains($url, 'youtube.com/embed/')) {
            return $url;
        }

        if (preg_match('~(?:youtube\.com/watch\?v=|youtu\.be/|youtube\.com/shorts/)([A-Za-z0-9_-]{11})~', $url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        return $url;
    }
}
