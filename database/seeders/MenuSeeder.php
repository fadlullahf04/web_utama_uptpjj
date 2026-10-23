<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Sample Dynamic Page
        $samplePage = $this->seedSamplePage();

        // 2. Seed Header Menu
        $this->seedHeaderMenu($samplePage);

        // 3. Seed Footer Menu
        $this->seedFooterMenu($samplePage);
    }

    /**
     * Seed a specific location on-demand.
     */
    public function seedLocation(string $location): void
    {
        $samplePage = Page::where('slug', 'maklumat-pelayanan-upt-pjj')->first() ?? $this->seedSamplePage();

        MenuItem::where('location', $location)->delete();

        if ($location === 'header') {
            $this->seedHeaderMenu($samplePage);
        } elseif ($location === 'footer') {
            $this->seedFooterMenu($samplePage);
        }
    }

    protected function seedSamplePage(): Page
    {
        $admin = User::first();

        return Page::firstOrCreate(
            ['slug' => 'maklumat-pelayanan-upt-pjj'],
            [
                'title' => 'Maklumat Pelayanan UPT Pendidikan Jarak Jauh',
                'excerpt' => 'Komitmen mutu, standar integritas, dan jaminan penyelenggaraan layanan pendidikan tinggi siber di UPT PJJ UIN Siber Syekh Nurjati Cirebon.',
                'content' => '
<h2>Komitmen Pelayanan Prima UPT PJJ</h2>
<p>Unit Pelaksana Teknis Pendidikan Jarak Jauh (UPT PJJ) Universitas Islam Negeri Siber Syekh Nurjati Cirebon berkomitmen dengan sungguh-sungguh untuk menyelenggarakan pelayanan perkuliahan, registrasi, administrasi akademik, dan bantuan teknis berbasis digital dengan prinsip:</p>
<ul>
    <li><strong>Aksesibilitas Tinggi:</strong> Memastikan seluruh sistem portal dan Learning Management System (LMS Pillar) dapat diakses 24/7 dari seluruh penjuru Indonesia dan mancanegara.</li>
    <li><strong>Transparansi & Akuntabilitas:</strong> Menyediakan informasi kurikulum, biaya perkuliahan, pedoman akademik, dan jadwal perkuliahan secara terbuka dan jelas.</li>
    <li><strong>Responsif & Solutif:</strong> Melayani konsultasi dan kendala mahasiswa melalui Helpdesk terpadu dengan respon cepat dalam waktu maksimal 1x24 jam kerja.</li>
    <li><strong>Kualitas Islami Berstandar Global:</strong> Mengintegrasikan nilai-nilai keislaman moderat dalam ekosistem pembelajaran siber masa depan yang adaptif dan inklusif.</li>
</ul>

<h3>Standar Waktu Layanan Kami</h3>
<div class="overflow-x-auto my-6">
    <table class="w-full text-left border-collapse border border-slate-300">
        <thead>
            <tr class="bg-emerald-50 text-emerald-950 font-bold">
                <th class="p-3 border border-slate-300">Jenis Layanan</th>
                <th class="p-3 border border-slate-300">Media / Kanal</th>
                <th class="p-3 border border-slate-300">Standar Waktu Penyelesaian</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="p-3 border border-slate-300">Aktivasi & Reset Akun LMS</td>
                <td class="p-3 border border-slate-300">Helpdesk & WhatsApp UPT</td>
                <td class="p-3 border border-slate-300">Maksimal 2 Jam Kerja</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-300">Konsultasi Akademik & PMB</td>
                <td class="p-3 border border-slate-300">Email & Tiket Portal</td>
                <td class="p-3 border border-slate-300">Maksimal 1 x 24 Jam Kerja</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-300">Penerbitan Surat Keterangan Kuliah PJJ</td>
                <td class="p-3 border border-slate-300">Portal Layanan Terpadu</td>
                <td class="p-3 border border-slate-300">1 - 2 Hari Kerja</td>
            </tr>
        </tbody>
    </table>
</div>

<p>Apabila terdapat pelayanan yang tidak sesuai dengan standar maklumat ini, masyarakat dan sivitas akademika dapat menyampaikan pengaduan resmi melalui kanal kontak helpdesk UPT PJJ atau datang langsung ke Gedung Siber UINSSC Cirebon.</p>
                ',
                'template' => 'default',
                'is_published' => true,
                'published_at' => now(),
                'views_count' => 125,
                'meta_title' => 'Maklumat Pelayanan UPT PJJ UINSSC',
                'meta_description' => 'Maklumat resmi standar pelayanan publik UPT Pendidikan Jarak Jauh UIN Siber Syekh Nurjati Cirebon.',
                'user_id' => $admin?->id,
            ]
        );
    }

    protected function seedHeaderMenu(Page $samplePage): void
    {
        // 1. Home
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Home',
            'type' => 'route',
            'route_name' => 'home',
            'order' => 1,
            'is_active' => true,
        ]);

        // 2. Profil (Dropdown)
        $profil = MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Profil',
            'type' => 'custom',
            'url' => '#',
            'order' => 2,
            'is_active' => true,
        ]);

        $profilChildren = [
            ['title' => 'Selayang Pandang', 'type' => 'route', 'route_name' => 'profile.overview', 'icon' => 'fa-solid fa-quote-left', 'order' => 1],
            ['title' => 'Visi dan Misi', 'type' => 'route', 'route_name' => 'profile.vision-mission', 'icon' => 'fa-solid fa-bullseye', 'order' => 2],
            ['title' => 'Struktur Organisasi', 'type' => 'route', 'route_name' => 'profile.organization', 'icon' => 'fa-solid fa-sitemap', 'order' => 3],
            ['title' => 'Profil Lulusan', 'type' => 'route', 'route_name' => 'profile.graduate-profile', 'icon' => 'fa-solid fa-user-graduate', 'order' => 4],
            ['title' => 'Tim UPT PJJ', 'type' => 'route', 'route_name' => 'profile.team', 'icon' => 'fa-solid fa-users', 'order' => 5],
            ['title' => 'Video Profile', 'type' => 'route', 'route_name' => 'profile.video-profile', 'icon' => 'fa-brands fa-youtube', 'order' => 6],
            ['title' => 'Sarana dan Prasarana', 'type' => 'route', 'route_name' => 'profile.facilities', 'icon' => 'fa-solid fa-building-columns', 'order' => 7],
            [
                'title' => 'Maklumat Pelayanan',
                'type' => 'page',
                'page_id' => $samplePage->id,
                'icon' => 'fa-solid fa-certificate',
                'badge' => 'Resmi',
                'badge_color' => 'emerald',
                'order' => 8,
            ],
        ];

        foreach ($profilChildren as $child) {
            MenuItem::create(array_merge($child, [
                'location' => 'header',
                'parent_id' => $profil->id,
                'is_active' => true,
            ]));
        }

        // 3. Prodi PJJ (Dropdown)
        $prodi = MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Prodi PJJ',
            'type' => 'route',
            'route_name' => 'programs.index',
            'order' => 3,
            'is_active' => true,
        ]);

        $prodiChildren = [
            ['title' => 'PJJ PAI (S1)', 'type' => 'custom', 'url' => '/prodi/pjj-pendidikan-agama-islam', 'icon' => 'fa-solid fa-book-quran', 'badge' => 'Unggul', 'badge_color' => 'emerald', 'order' => 1],
            ['title' => 'PJJ PGMI (S1)', 'type' => 'custom', 'url' => '/prodi/pjj-pendidikan-guru-madrasah-ibtidaiyah', 'icon' => 'fa-solid fa-chalkboard-user', 'badge' => 'Baik Sekali', 'badge_color' => 'teal', 'order' => 2],
            ['title' => 'PJJ PBA (S1)', 'type' => 'custom', 'url' => '/prodi/pjj-pendidikan-bahasa-arab', 'icon' => 'fa-solid fa-language', 'badge' => 'Baik Sekali', 'badge_color' => 'amber', 'order' => 3],
            ['title' => 'PJJ HKI (S1)', 'type' => 'custom', 'url' => '/prodi/pjj-hukum-keluarga-islam', 'icon' => 'fa-solid fa-scale-balanced', 'badge' => 'Baik Sekali', 'badge_color' => 'purple', 'order' => 4],
            ['title' => 'PJJ SPI (S1)', 'type' => 'custom', 'url' => '/prodi/pjj-sejarah-peradaban-islam', 'icon' => 'fa-solid fa-landmark', 'badge' => 'Baik', 'badge_color' => 'blue', 'order' => 5],
            ['title' => 'PJJ PAI S2', 'type' => 'custom', 'url' => '/prodi/pjj-magister-pendidikan-agama-islam-s2', 'icon' => 'fa-solid fa-graduation-cap', 'badge' => 'Unggul', 'badge_color' => 'amber', 'order' => 6],
            ['title' => 'Semua Program Studi →', 'type' => 'route', 'route_name' => 'programs.index', 'icon' => 'fa-solid fa-arrow-right', 'order' => 7],
        ];

        foreach ($prodiChildren as $child) {
            MenuItem::create(array_merge($child, [
                'location' => 'header',
                'parent_id' => $prodi->id,
                'is_active' => true,
            ]));
        }

        // 4. Layanan
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Layanan',
            'type' => 'route',
            'route_name' => 'services.index',
            'order' => 4,
            'is_active' => true,
        ]);

        // 5. Pengumuman
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Pengumuman',
            'type' => 'route',
            'route_name' => 'announcements.index',
            'order' => 5,
            'is_active' => true,
        ]);

        // 6. FAQs
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'FAQs',
            'type' => 'route',
            'route_name' => 'faqs',
            'order' => 6,
            'is_active' => true,
        ]);

        // 7. Course LMS
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Course',
            'type' => 'route',
            'route_name' => 'lms-guide',
            'order' => 7,
            'is_active' => true,
        ]);

        // 8. Downloads
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Downloads',
            'type' => 'route',
            'route_name' => 'downloads.index',
            'order' => 8,
            'is_active' => true,
        ]);

        // 9. Kontak
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Kontak',
            'type' => 'route',
            'route_name' => 'contact.index',
            'order' => 9,
            'is_active' => true,
        ]);
    }

    protected function seedFooterMenu(Page $samplePage): void
    {
        $footerItems = [
            ['title' => 'Visi dan Misi', 'type' => 'route', 'route_name' => 'profile.vision-mission', 'icon' => 'fa-solid fa-bullseye', 'order' => 1],
            ['title' => 'Sarana Prasarana', 'type' => 'route', 'route_name' => 'profile.facilities', 'icon' => 'fa-solid fa-building', 'order' => 2],
            ['title' => 'Profil Lulusan', 'type' => 'route', 'route_name' => 'profile.graduate-profile', 'icon' => 'fa-solid fa-user-graduate', 'order' => 3],
            ['title' => 'Program Studi PJJ', 'type' => 'route', 'route_name' => 'programs.index', 'icon' => 'fa-solid fa-book-open', 'order' => 4],
            ['title' => 'Layanan & Fasilitas', 'type' => 'route', 'route_name' => 'services.index', 'icon' => 'fa-solid fa-hand-holding-hand', 'order' => 5],
            ['title' => 'Downloads', 'type' => 'route', 'route_name' => 'downloads.index', 'icon' => 'fa-solid fa-download', 'order' => 6],
            ['title' => 'Maklumat Pelayanan', 'type' => 'page', 'page_id' => $samplePage->id, 'icon' => 'fa-solid fa-certificate', 'order' => 7],
            ['title' => 'Website UINSSC', 'type' => 'custom', 'url' => 'https://uinssc.ac.id', 'target' => '_blank', 'icon' => 'fa-solid fa-globe', 'order' => 8],
            ['title' => 'Website Fakultas FITK', 'type' => 'custom', 'url' => 'https://fitk.uinssc.ac.id', 'target' => '_blank', 'icon' => 'fa-solid fa-landmark', 'order' => 9],
            ['title' => 'Berita Kampus', 'type' => 'custom', 'url' => 'https://info.syekhnurjati.ac.id', 'target' => '_blank', 'icon' => 'fa-solid fa-newspaper', 'order' => 10],
            ['title' => 'Perpustakaan Digital', 'type' => 'custom', 'url' => 'https://perpustakaan.uinssc.ac.id', 'target' => '_blank', 'icon' => 'fa-solid fa-book-bookmark', 'order' => 11],
            ['title' => 'Helpdesk Terpadu', 'type' => 'custom', 'url' => 'https://helpdesk.uinssc.ac.id', 'target' => '_blank', 'icon' => 'fa-solid fa-headset', 'order' => 12],
        ];

        foreach ($footerItems as $item) {
            MenuItem::create(array_merge($item, [
                'location' => 'footer',
                'parent_id' => null,
                'is_active' => true,
            ]));
        }
    }
}
