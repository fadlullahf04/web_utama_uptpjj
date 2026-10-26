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
        MenuItem::query()->delete();

        // 1. Seed Sample Dynamic Pages
        $samplePage = $this->seedSamplePage();
        $edusharePage = $this->seedEdusharePage();
        $upbjjPage = $this->seedUpbjjPage();

        // 2. Seed Header Menu
        $this->seedHeaderMenu($samplePage, $edusharePage, $upbjjPage);

        // 3. Seed Footer Menu
        $this->seedFooterMenu($samplePage);
    }

    /**
     * Seed a specific location on-demand.
     */
    public function seedLocation(string $location): void
    {
        $samplePage = Page::where('slug', 'maklumat-pelayanan-upt-pjj')->first() ?? $this->seedSamplePage();
        $edusharePage = Page::where('slug', 'edushare')->first() ?? $this->seedEdusharePage();
        $upbjjPage = Page::where('slug', 'upbjj')->first() ?? $this->seedUpbjjPage();

        MenuItem::where('location', $location)->delete();

        if ($location === 'header') {
            $this->seedHeaderMenu($samplePage, $edusharePage, $upbjjPage);
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

    protected function seedEdusharePage(): Page
    {
        $admin = User::first();

        return Page::firstOrCreate(
            ['slug' => 'edushare'],
            [
                'title' => 'EduShare - Repositori Sumber Belajar Terbuka & Microlearning UPT PJJ',
                'excerpt' => 'Platform berbagi materi kuliah digital, open educational resources (OER), modul SCORM, rekaman kuliah studio, dan podcast akademik UIN Siber Syekh Nurjati Cirebon.',
                'content' => '
<h2>Selamat Datang di EduShare UIN Siber Syekh Nurjati Cirebon</h2>
<p><strong>EduShare UPT PJJ UINSSC</strong> adalah portal repositori digital terbuka (<em>Open Educational Resources / OER</em>) yang dikembangkan untuk memperluas akses pengetahuan keislaman dan sains siber ke seluruh lapisan masyarakat. Di platform ini, mahasiswa, dosen, guru madrasah, dan pembelajar mandiri di seluruh penjuru dunia dapat mengakses modul kuliah bermutu tinggi secara legal, gratis, dan fleksibel.</p>

<div class="my-6 p-5 rounded-2xl bg-emerald-50 border border-emerald-200">
    <h3 class="text-emerald-900 font-bold mb-2">Pilar Utama Ekosistem EduShare</h3>
    <ul class="space-y-2 text-sm text-emerald-950">
        <li><strong>1. Modul Kuliah Digital Modular:</strong> Ratusan modul terstruktur standar CPL nasional yang dilengkapi rangkuman, latihan interaktif, dan lembar kerja mandiri.</li>
        <li><strong>2. Rekaman MOOC Berstandar Studio 4K:</strong> Tayangan video instruksional yang diproduksi secara profesional di Studio Multimedia UPT PJJ bersama pakar dan guru besar.</li>
        <li><strong>3. Podcast & Audio Kajian Keislaman:</strong> Materi audio asinkron yang dapat didengarkan kapan saja saat beraktivitas untuk kemudahan belajar tanpa batasan kuota.</li>
        <li><strong>4. Bank Soal & Evaluasi Daring Mandiri:</strong> Fitur kuis formatif untuk menguji pemahaman konsep sebelum menempuh ujian terawasi.</li>
    </ul>
</div>

<h3>Integrasi EduShare dengan LMS Pillar</h3>
<p>Bagi mahasiswa resmi Program Studi PJJ (S1 dan S2), seluruh materi EduShare telah terintegrasi secara otomatis ke dalam akun portal perkuliahan <strong>LMS Pillar</strong>. Nilai pengerjaan modul, partisipasi forum, dan kuis otomatis tersinkronisasi ke transkrip akademik semester aktif.</p>

<div class="my-6 flex flex-wrap gap-3">
    <a href="https://sso-lms.uinssc.ac.id" target="_blank" class="px-5 py-2.5 rounded-xl bg-[#006837] text-white font-bold text-xs inline-flex items-center gap-2">
        <i class="fa-solid fa-graduation-cap"></i> Buka Portal LMS Pillar
    </a>
    <a href="/panduan-lms" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs inline-flex items-center gap-2">
        <i class="fa-solid fa-book-open"></i> Panduan Course & Tutorial LMS
    </a>
</div>
                ',
                'template' => 'default',
                'is_published' => true,
                'published_at' => now(),
                'views_count' => 280,
                'meta_title' => 'EduShare - Sumber Belajar Digital UPT PJJ UINSSC',
                'meta_description' => 'Platform EduShare UIN Siber Syekh Nurjati Cirebon menyediakan modul pembelajaran terbuka, video kuliah siber, dan podcast akademik.',
                'user_id' => $admin?->id,
            ]
        );
    }

    protected function seedUpbjjPage(): Page
    {
        $admin = User::first();

        return Page::firstOrCreate(
            ['slug' => 'upbjj'],
            [
                'title' => 'UPBJJ & Sentra Layanan Pendidikan Jarak Jauh UINSSC',
                'excerpt' => 'Informasi jaringan sentra layanan mahasiswa, laboratorium ujian CBT daerah, pendampingan akademik, dan kemitraan wilayah UPT PJJ UIN Siber Syekh Nurjati Cirebon.',
                'content' => '
<h2>Sentra Layanan & Jaringan UPBJJ UIN Siber Syekh Nurjati Cirebon</h2>
<p>Sebagai Cyber Islamic University pertama di Indonesia, UIN Siber Syekh Nurjati Cirebon menyelenggarakan perkuliahan 100% online yang didukung oleh <strong>Sentra Layanan Belajar Jarak Jauh (UPBJJ)</strong> dan pos kemitraan wilayah. Sentra ini bertindak sebagai perpanjangan tangan kampus utama dalam memberikan pelayanan prima bagi sivitas akademika di berbagai pulau dan pelosok nusantara.</p>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-6">
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs">
        <h4 class="font-bold text-slate-900 text-emerald-800 mb-1"><i class="fa-solid fa-headset mr-1"></i> Helpdesk & Admisi Terpadu</h4>
        <p class="text-xs text-slate-600">Pelayanan registrasi, validasi berkas fisik PMB, pengurusan surat keterangan kuliah, dan informasi beasiswa Kemenag / LPDP.</p>
    </div>
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs">
        <h4 class="font-bold text-slate-900 text-emerald-800 mb-1"><i class="fa-solid fa-laptop mr-1"></i> Lab Ujian CBT Terawasi</h4>
        <p class="text-xs text-slate-600">Penyediaan fasilitas workstation komputer dan koneksi internet stabil bagi mahasiswa yang membutuhkan ruang ujian semester mandiri.</p>
    </div>
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs">
        <h4 class="font-bold text-slate-900 text-emerald-800 mb-1"><i class="fa-solid fa-chalkboard-user mr-1"></i> Klinik Akademik & Konseling</h4>
        <p class="text-xs text-slate-600">Konsultasi bimbingan akademik bersama tutor daerah, pendampingan belajar, dan pelatihan literasi teknologi LMS Pillar.</p>
    </div>
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs">
        <h4 class="font-bold text-slate-900 text-emerald-800 mb-1"><i class="fa-solid fa-handshake mr-1"></i> Kemitraan Kemenag & Pemda</h4>
        <p class="text-xs text-slate-600">Koordinasi sinergis dengan Kantor Wilayah Kementerian Agama, Pokjawas Madrasah, dan organisasi mitra di seluruh provinsi.</p>
    </div>
</div>

<h3>Kantor Pusat Operasional & Koordinasi Sentra</h3>
<p>Seluruh sistem sentra layanan terkoordinasi secara terpusat di Kantor UPT Pendidikan Jarak Jauh (UPT PJJ) Lantai 3 Gedung Siber UINSSC Cirebon. Mahasiswa dapat memanfaatkan helpdesk digital 24/7 tanpa harus datang langsung ke lokasi fisik.</p>

<div class="my-6 p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-700 space-y-1">
    <p><strong>Alamat Kantor Pusat:</strong> Gedung Siber Lt. 3, Kampus UIN Siber Syekh Nurjati Cirebon, Jl. Perjuangan By Pass Sunyaragi, Kota Cirebon, Jawa Barat 45132</p>
    <p><strong>Helpdesk WhatsApp Resmi:</strong> +62 811-2345-678</p>
    <p><strong>Email Resmi Layanan:</strong> pjj@uinssc.ac.id</p>
</div>
                ',
                'template' => 'default',
                'is_published' => true,
                'published_at' => now(),
                'views_count' => 310,
                'meta_title' => 'UPBJJ & Sentra Layanan UPT PJJ UINSSC',
                'meta_description' => 'Sentra Layanan Belajar Jarak Jauh (UPBJJ) UIN Siber Syekh Nurjati Cirebon menghadirkan pendampingan akademik, ujian online, dan helpdesk daerah.',
                'user_id' => $admin?->id,
            ]
        );
    }

    protected function seedHeaderMenu(Page $samplePage, ?Page $edusharePage = null, ?Page $upbjjPage = null): void
    {
        $edusharePage ??= $this->seedEdusharePage();
        $upbjjPage ??= $this->seedUpbjjPage();

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

        // 4. Layanan (Dropdown with LMS Pillar & Course Tutorial)
        $layanan = MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Layanan',
            'type' => 'route',
            'route_name' => 'services.index',
            'order' => 4,
            'is_active' => true,
        ]);

        $layananChildren = [
            ['title' => 'LMS Pillar (Platform Belajar)', 'type' => 'custom', 'url' => '/layanan/lms-pillar', 'icon' => 'fa-solid fa-graduation-cap', 'badge' => 'Utama', 'badge_color' => 'emerald', 'order' => 1],
            ['title' => 'Tutorial & Course LMS', 'type' => 'route', 'route_name' => 'lms-guide', 'icon' => 'fa-solid fa-chalkboard-user', 'badge' => 'Course', 'badge_color' => 'amber', 'order' => 2],
            ['title' => 'Studio Multimedia MOOC', 'type' => 'custom', 'url' => '/layanan/studio-multimedia-mooc', 'icon' => 'fa-solid fa-video', 'order' => 3],
            ['title' => 'Helpdesk Terpadu 24/7', 'type' => 'custom', 'url' => '/layanan/helpdesk-terpadu', 'icon' => 'fa-solid fa-headset', 'order' => 4],
            ['title' => 'Lab Siber & Virtual Classroom', 'type' => 'custom', 'url' => '/layanan/lab-siber-virtual-classroom', 'icon' => 'fa-solid fa-server', 'order' => 5],
            ['title' => 'Pengembangan Bahan Ajar', 'type' => 'custom', 'url' => '/layanan/pengembangan-bahan-ajar-modular', 'icon' => 'fa-solid fa-book-open', 'order' => 6],
            ['title' => 'Aplikasi Mobile SiberGo!', 'type' => 'custom', 'url' => '/layanan/aplikasi-mobile-sibergo', 'icon' => 'fa-solid fa-mobile-screen', 'order' => 7],
            ['title' => 'Semua Layanan & Fasilitas →', 'type' => 'route', 'route_name' => 'services.index', 'icon' => 'fa-solid fa-arrow-right', 'order' => 8],
        ];

        foreach ($layananChildren as $child) {
            MenuItem::create(array_merge($child, [
                'location' => 'header',
                'parent_id' => $layanan->id,
                'is_active' => true,
            ]));
        }

        // 5. EduShare
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'EduShare',
            'type' => 'page',
            'page_id' => $edusharePage->id,
            'icon' => 'fa-solid fa-book-bookmark',
            'badge' => 'OER',
            'badge_color' => 'teal',
            'order' => 5,
            'is_active' => true,
        ]);

        // 6. UPBJJ
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'UPBJJ',
            'type' => 'page',
            'page_id' => $upbjjPage->id,
            'icon' => 'fa-solid fa-network-wired',
            'badge' => 'Sentra',
            'badge_color' => 'blue',
            'order' => 6,
            'is_active' => true,
        ]);

        // 7. Pengumuman
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Pengumuman',
            'type' => 'route',
            'route_name' => 'announcements.index',
            'order' => 7,
            'is_active' => true,
        ]);

        // 8. Berita
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Berita',
            'type' => 'route',
            'route_name' => 'posts.index',
            'order' => 8,
            'is_active' => true,
        ]);

        // 9. FAQs
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'FAQs',
            'type' => 'route',
            'route_name' => 'faqs',
            'order' => 9,
            'is_active' => true,
        ]);

        // 10. Downloads
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Downloads',
            'type' => 'route',
            'route_name' => 'downloads.index',
            'order' => 10,
            'is_active' => true,
        ]);

        // 11. Kontak
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Kontak',
            'type' => 'route',
            'route_name' => 'contact.index',
            'order' => 11,
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
