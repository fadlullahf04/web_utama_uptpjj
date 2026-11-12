<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Service;
use App\Models\StudyProgram;
use App\Models\UpbjjZone;
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
        UpbjjZone::seedDefaultsIfEmpty();

        // 1. Seed Sample Dynamic Pages
        $samplePage = $this->seedSamplePage();
        $edusharePage = $this->seedEdusharePage();
        $upbjjPage = $this->seedUpbjjPage();
        $tutorPage = $this->seedTutorPage();

        // 2. Seed Header Menu
        $this->seedHeaderMenu($samplePage, $edusharePage, $upbjjPage, $tutorPage);

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
        $tutorPage = Page::where('slug', 'tutor')->first() ?? $this->seedTutorPage();

        MenuItem::where('location', $location)->delete();

        if ($location === 'header') {
            $this->seedHeaderMenu($samplePage, $edusharePage, $upbjjPage, $tutorPage);
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

        return Page::updateOrCreate(
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
    <a href="https://edushare.uinssc.ac.id/" target="_blank" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs inline-flex items-center gap-2 transition no-underline shadow-sm">
        <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Website EduShare UINSSC
    </a>
    <a href="https://sso-lms.uinssc.ac.id" target="_blank" class="px-5 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs inline-flex items-center gap-2 transition no-underline">
        <i class="fa-solid fa-graduation-cap"></i> Buka Portal LMS Pillar
    </a>
    <a href="/panduan-lms" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs inline-flex items-center gap-2 transition no-underline">
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

        return Page::updateOrCreate(
            ['slug' => 'upbjj'],
            [
                'title' => 'UPBJJ (Unit Program Belajar Jarak Jauh) & Sentra Layanan Daerah UINSSC',
                'excerpt' => 'Unit pelaksana layanan pendidikan jarak jauh di wilayah daerah untuk mendekatkan layanan administrasi akademik, tutorial, bahan ajar digital, ujian siber, serta pembinaan Sentra Layanan dan Kelompok Belajar (Pokjar) mahasiswa UIN Siber Syekh Nurjati Cirebon di seluruh Indonesia dan luar negeri.',
                'content' => '
<h2>Apa itu UPBJJ UIN Siber Syekh Nurjati Cirebon?</h2>
<p class="text-justify"><strong>Unit Program Belajar Jarak Jauh (UPBJJ)</strong> di lingkungan <strong>UPT Pendidikan Jarak Jauh UIN Siber Syekh Nurjati Cirebon (UINSSC)</strong> merupakan unit pelaksana operasional dan jaringan layanan wilayah yang dibentuk untuk mendekatkan akses pendidikan tinggi siber kepada mahasiswa yang tersebar di 38 provinsi di Indonesia maupun di luar negeri. Sebagaimana tata kelola pendidikan jarak jauh nasional, kehadiran UPBJJ memastikan mahasiswa tidak perlu datang ke kampus pusat di Cirebon untuk mengurus keperluan administrasi maupun akademik.</p>

<p class="text-justify">Seluruh operasional UPBJJ dikoordinasikan langsung oleh <strong>UPT PJJ UINSSC</strong> bekerja sama dengan jaringan Kantor Wilayah Kementerian Agama (Kanwil Kemenag), Perguruan Tinggi Keagamaan Islam (PTKI) Mitra, Pesantren, Madrasah, serta Atase Pendidikan/KBRI untuk melayani ribuan mahasiswa Program Studi PJJ jenjang Sarjana (S1) dan Magister (S2).</p>

<h3>Direktori Zona Wilayah Layanan UPBJJ UINSSC</h3>
<p class="text-justify">UPT Pendidikan Jarak Jauh UIN Siber Syekh Nurjati Cirebon melayani mahasiswa di seluruh wilayah Indonesia dan luar negeri yang terbagi ke dalam 7 (tujuh) Zona Koordinasi Layanan:</p>

<div class="overflow-x-auto my-6">
    <table class="w-full text-left border-collapse border border-slate-300 text-xs">
        <thead>
            <tr class="bg-emerald-50 text-emerald-950 font-bold">
                <th class="p-3 border border-slate-300">Kode Zona</th>
                <th class="p-3 border border-slate-300">Wilayah Layanan UPBJJ</th>
                <th class="p-3 border border-slate-300">Cakupan Provinsi & Sentra Pokjar</th>
                <th class="p-3 border border-slate-300">Mitra Koordinasi Wilayah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="p-3 border border-slate-300 font-bold text-[#006837]">ZONA 01</td>
                <td class="p-3 border border-slate-300 font-semibold">UPBJJ Wilayah Jawa Barat, DKI Jakarta & Banten (Pusat Cirebon)</td>
                <td class="p-3 border border-slate-300">Cirebon, Indramayu, Majalengka, Kuningan, Bandung, Bogor, Bekasi, Tangerang, Serang, DKI Jakarta</td>
                <td class="p-3 border border-slate-300">Kampus Pusat Gedung Siber UINSSC & Kanwil Kemenag Jabar/DKI/Banten</td>
            </tr>
            <tr class="bg-slate-50/60">
                <td class="p-3 border border-slate-300 font-bold text-[#006837]">ZONA 02</td>
                <td class="p-3 border border-slate-300 font-semibold">UPBJJ Wilayah Jawa Tengah, DI Yogyakarta & Jawa Timur</td>
                <td class="p-3 border border-slate-300">Semarang, Brebes, Tegal, Banyumas, Surakarta, Yogyakarta, Surabaya, Malang, Jember, Madura</td>
                <td class="p-3 border border-slate-300">Jaringan Kemenag Kab/Kota, Madrasah & Pesantren Mitra</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-300 font-bold text-[#006837]">ZONA 03</td>
                <td class="p-3 border border-slate-300 font-semibold">UPBJJ Wilayah Sumatera</td>
                <td class="p-3 border border-slate-300">Banda Aceh, Medan, Padang, Pekanbaru, Batam, Jambi, Palembang, Bengkulu, Bandar Lampung, Pangkalpinang</td>
                <td class="p-3 border border-slate-300">Sentra Layanan Daerah & Pokjar Guru Madrasah Sumatera</td>
            </tr>
            <tr class="bg-slate-50/60">
                <td class="p-3 border border-slate-300 font-bold text-[#006837]">ZONA 04</td>
                <td class="p-3 border border-slate-300 font-semibold">UPBJJ Wilayah Kalimantan</td>
                <td class="p-3 border border-slate-300">Pontianak, Palangkaraya, Banjarmasin, Samarinda, Balikpapan, Ibu Kota Nusantara (IKN), Tarakan</td>
                <td class="p-3 border border-slate-300">Sentra Layanan Daerah & Pokjar Kemenag Kalimantan</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-300 font-bold text-[#006837]">ZONA 05</td>
                <td class="p-3 border border-slate-300 font-semibold">UPBJJ Wilayah Sulawesi</td>
                <td class="p-3 border border-slate-300">Makassar, Parepare, Palu, Kendari, Mamuju, Gorontalo, Manado</td>
                <td class="p-3 border border-slate-300">Sentra Layanan Daerah & Pokjar Madrasah Sulawesi</td>
            </tr>
            <tr class="bg-slate-50/60">
                <td class="p-3 border border-slate-300 font-bold text-[#006837]">ZONA 06</td>
                <td class="p-3 border border-slate-300 font-semibold">UPBJJ Wilayah Bali, Nusa Tenggara, Maluku & Papua</td>
                <td class="p-3 border border-slate-300">Denpasar, Mataram, Kupang, Ambon, Ternate, Sorong, Manokwari, Jayapura, Merauke</td>
                <td class="p-3 border border-slate-300">Sentra Layanan Afirmasi 3T & Kemitraan Kemenag Timur</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-300 font-bold text-amber-700">ZONA LN</td>
                <td class="p-3 border border-slate-300 font-semibold">Unit Layanan Mahasiswa Luar Negeri (Overseas)</td>
                <td class="p-3 border border-slate-300">Malaysia, Singapura, Brunei Darussalam, Arab Saudi, Mesir, Taiwan, Hongkong, Jepang, Korea Selatan</td>
                <td class="p-3 border border-slate-300">Pusat Layanan Internasional UINSSC & Komunitas Pekerja/Mahasiswa RI</td>
            </tr>
        </tbody>
    </table>
</div>

<h3>Kantor Pusat Koordinasi UPBJJ & Layanan Digital 24/7</h3>
<p class="text-justify">Seluruh layanan administrasi dan akademik UPBJJ UINSSC telah terdigitalisasi secara penuh melalui <strong>Sistem Layanan Terpadu Satu Pintu</strong>. Mahasiswa dari zona wilayah mana pun maupun luar negeri dapat mengurus administrasi, mengakses tutorial, dan berkonsultasi secara daring 24/7, atau mengunjungi Kantor Pusat UPT PJJ UINSSC:</p>

<div class="my-6 p-5 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-700 space-y-2">
    <p><strong><i class="fa-solid fa-location-dot text-[#006837] mr-1.5"></i> Kantor Pusat UPT PJJ / UPBJJ Pusat:</strong> Gedung Siber Lt. 3, Kampus UIN Siber Syekh Nurjati Cirebon, Jl. Perjuangan By Pass Sunyaragi, Kota Cirebon, Jawa Barat 45132</p>
    <p><strong><i class="fa-solid fa-clock text-[#006837] mr-1.5"></i> Jam Operasional Layanan Tatap Muka:</strong> Senin – Jumat, Pukul 07.30 – 16.00 WIB (Helpdesk Online & LMS Pillar Aktif 24 Jam)</p>
    <p><strong><i class="fa-brands fa-whatsapp text-[#006837] mr-1.5"></i> Helpdesk WhatsApp Resmi:</strong> +62 811-2345-678</p>
    <p><strong><i class="fa-solid fa-envelope text-[#006837] mr-1.5"></i> Email Layanan UPBJJ & Pokjar:</strong> pjj@uinssc.ac.id</p>
</div>

<div class="my-6 flex flex-wrap gap-3">
    <a href="https://sso-lms.uinssc.ac.id" target="_blank" class="px-5 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs inline-flex items-center gap-2 transition no-underline">
        <i class="fa-solid fa-graduation-cap"></i> Masuk Portal LMS Pillar
    </a>
    <a href="https://pmb.uinssc.ac.id" target="_blank" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs inline-flex items-center gap-2 transition no-underline">
        <i class="fa-solid fa-user-plus"></i> Daftar Mahasiswa Baru (PMB PJJ)
    </a>
    <a href="/kontak" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs inline-flex items-center gap-2 transition no-underline">
        <i class="fa-solid fa-headset"></i> Hubungi Helpdesk & Pengajuan Pokjar
    </a>
</div>
                ',
                'template' => 'default',
                'is_published' => true,
                'published_at' => now(),
                'views_count' => 310,
                'meta_title' => 'UPBJJ (Unit Program Belajar Jarak Jauh) & Sentra Layanan Daerah - UPT PJJ UINSSC',
                'meta_description' => 'Informasi lengkap Unit Program Belajar Jarak Jauh (UPBJJ), Sentra Layanan PJJ, dan Kelompok Belajar (Pokjar) UIN Siber Syekh Nurjati Cirebon di seluruh Indonesia.',
                'user_id' => $admin?->id,
            ]
        );
    }

    protected function seedTutorPage(): Page
    {
        $admin = User::first();

        return Page::updateOrCreate(
            ['slug' => 'tutor'],
            [
                'title' => 'Rekrutmen Tutor Online UPT PJJ - UIN Siber Syekh Nurjati Cirebon',
                'excerpt' => 'Portal informasi dan pendaftaran Rekrutmen Tutor Online Pendidikan Jarak Jauh (PJJ) UIN Siber Syekh Nurjati Cirebon. Bergabunglah menjadi pengajar siber berstandar global.',
                'content' => '
<h2>Rekrutmen Tutor Online UPT PJJ UIN Siber Syekh Nurjati Cirebon</h2>
<p class="text-justify"><strong>Unit Pelaksana Teknis Pendidikan Jarak Jauh (UPT PJJ) UIN Siber Syekh Nurjati Cirebon (UINSSC)</strong> membuka kesempatan seluas-luasnya bagi para akademisi, dosen, peneliti, dan praktisi profesional di seluruh Indonesia maupun mancanegara untuk bergabung sebagai <strong>Tutor Online (Dosen Pengampu Tutorial Daring)</strong> pada ekosistem <em>World Class Cyber Islamic University</em>.</p>

<p class="text-justify">Sebagai Tutor Online PJJ UINSSC, Anda berperan strategis dalam memfasilitasi, membimbing, dan mengevaluasi proses belajar mandiri ribuan mahasiswa jarak jauh melalui platform pembelajaran digital <strong>LMS Pillar</strong> secara fleksibel, terukur, dan profesional.</p>

<div class="my-6 flex flex-wrap gap-3">
    <a href="https://tutor.uinssc.ac.id/" target="_blank" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs inline-flex items-center gap-2 transition no-underline shadow-sm">
        <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Portal Rekrutmen Tutor (tutor.uinssc.ac.id)
    </a>
    <a href="https://sso-lms.uinssc.ac.id" target="_blank" class="px-5 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs inline-flex items-center gap-2 transition no-underline">
        <i class="fa-solid fa-graduation-cap"></i> Masuk Portal LMS Pillar
    </a>
    <a href="/panduan-lms" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs inline-flex items-center gap-2 transition no-underline">
        <i class="fa-solid fa-book-open"></i> Panduan LMS Tutor
    </a>
</div>

<div class="my-6 p-5 rounded-2xl bg-emerald-50 border border-emerald-200">
    <h3 class="text-emerald-900 font-bold mb-2"><i class="fa-solid fa-award text-[#006837] mr-1.5"></i> Keunggulan & Benefit Menjadi Tutor Online PJJ UINSSC</h3>
    <ul class="space-y-2 text-sm text-emerald-950 text-justify">
        <li class="text-justify"><strong>1. Fleksibilitas Waktu & Tempat 100% Daring:</strong> Kegiatan tutorial, diskusi asinkron, dan penilaian dilakukan sepenuhnya secara online melalui LMS Pillar dari lokasi masing-masing.</li>
        <li class="text-justify"><strong>2. Honorarium & Insentif Kompetitif:</strong> Mendapatkan honorarium pengajaran, pembimbingan, dan koreksi evaluasi sesuai standar Badan Layanan Umum (BLU) UIN Siber Syekh Nurjati Cirebon.</li>
        <li class="text-justify"><strong>3. Sertifikasi & Bimtek Pedagogi Siber:</strong> Memperoleh pelatihan penyusunan bahan ajar digital interaktif, manajemen kelas maya, serta e-Sertifikat resmi Tutor PJJ Nasional.</li>
        <li class="text-justify"><strong>4. Surat Keputusan (SK) Rektor Resmi:</strong> Setiap tutor yang dinyatakan lulus dan ditugaskan akan mendapatkan SK Pengangkatan Tutor yang diakui untuk pemenuhan BKD/Sister dan portofolio akademik.</li>
    </ul>
</div>

<h3>Kualifikasi & Persyaratan Calon Tutor Online</h3>
<p class="text-justify">Calon pendaftar Rekrutmen Tutor Online UPT PJJ UIN Siber Syekh Nurjati Cirebon wajib memenuhi persyaratan umum dan khusus berikut:</p>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-6">
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs">
        <h4 class="font-bold text-slate-900 text-sm mb-1.5"><i class="fa-solid fa-user-graduate text-[#006837] mr-1.5"></i> Kualifikasi Akademik & Profesi</h4>
        <ul class="text-xs text-slate-600 space-y-1.5 text-justify">
            <li class="text-justify">Berpendidikan minimal <strong>Magister (S2)</strong> untuk tutor jenjang S1, dan <strong>Doktor (S3)</strong> untuk tutor jenjang Pascasarjana (S2), dari perguruan tinggi terakreditasi dengan bidang ilmu yang linear.</li>
            <li class="text-justify">Diutamakan berstatus Dosen (memiliki NIDN/NIDK/NUPTK) atau Praktisi/Profesional dengan pengalaman relevan minimal 2 tahun.</li>
        </ul>
    </div>
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs">
        <h4 class="font-bold text-slate-900 text-sm mb-1.5"><i class="fa-solid fa-laptop-code text-[#006837] mr-1.5"></i> Kompetensi Digital & Komitmen</h4>
        <ul class="text-xs text-slate-600 space-y-1.5 text-justify">
            <li class="text-justify">Terampil mengoperasikan komputer, perangkat konferensi video (Zoom/Google Meet), serta sistem pembelajaran daring (<em>Learning Management System</em>).</li>
            <li class="text-justify">Bersedia mengikuti Bimbingan Teknis (Bimtek) dan Refreshment LMS Pillar serta berkomitmen penuh mendampingi mahasiswa selama 1 (satu) semester penuh.</li>
        </ul>
    </div>
</div>

<h3>Dokumen Administrasi Pendaftaran</h3>
<p class="text-justify">Sebelum melakukan pendaftaran di laman resmi <a href="https://tutor.uinssc.ac.id/" target="_blank">tutor.uinssc.ac.id</a>, pastikan Anda telah menyiapkan pindaian (scan) dokumen dalam format PDF/JPG berikut:</p>
<ol class="text-sm text-slate-700 space-y-1.5">
    <li class="text-justify">Kartu Tanda Penduduk (KTP) dan NPWP aktif.</li>
    <li class="text-justify">Daftar Riwayat Hidup / <em>Curriculum Vitae</em> (CV) terbaru beserta riwayat pengajaran/publikasi.</li>
    <li class="text-justify">Ijazah dan Transkrip Nilai asli jenjang S1, S2, dan/atau S3 yang linear dengan mata kuliah pilihan.</li>
    <li class="text-justify">SK Jabatan Fungsional Dosen / Sertifikat Pendidik (Serdos) / Surat Keterangan Pengalaman Kerja Praktisi.</li>
    <li class="text-justify">Sertifikat Pelatihan LMS / E-Learning / Pekerti / AA (jika memiliki).</li>
    <li class="text-justify">Surat Pernyataan Komitmen & Pakta Integritas Tutor Online UPT PJJ UINSSC (format dapat diunduh di portal rekrutmen).</li>
</ol>

<h3>Formasi Program Studi PJJ yang Tersedia</h3>
<div class="overflow-x-auto my-6">
    <table class="w-full text-left border-collapse border border-slate-300 text-xs">
        <thead>
            <tr class="bg-emerald-50 text-emerald-950 font-bold">
                <th class="p-3 border border-slate-300">No</th>
                <th class="p-3 border border-slate-300">Program Studi PJJ</th>
                <th class="p-3 border border-slate-300">Jenjang</th>
                <th class="p-3 border border-slate-300">Kualifikasi Minimal Tutor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="p-3 border border-slate-300 font-bold text-[#006837]">1</td>
                <td class="p-3 border border-slate-300 font-semibold">PJJ Pendidikan Agama Islam (PAI)</td>
                <td class="p-3 border border-slate-300">Sarjana (S1)</td>
                <td class="p-3 border border-slate-300">Magister (S2) / Doktor (S3) PAI, Pendidikan Islam, Studi Islam</td>
            </tr>
            <tr class="bg-slate-50/60">
                <td class="p-3 border border-slate-300 font-bold text-[#006837]">2</td>
                <td class="p-3 border border-slate-300 font-semibold">PJJ Pendidikan Guru Madrasah Ibtidaiyah (PGMI)</td>
                <td class="p-3 border border-slate-300">Sarjana (S1)</td>
                <td class="p-3 border border-slate-300">Magister (S2) / Doktor (S3) PGMI, Pendidikan Dasar, Sains/Matematika/Bahasa Dasar</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-300 font-bold text-[#006837]">3</td>
                <td class="p-3 border border-slate-300 font-semibold">PJJ Pendidikan Bahasa Arab (PBA)</td>
                <td class="p-3 border border-slate-300">Sarjana (S1)</td>
                <td class="p-3 border border-slate-300">Magister (S2) / Doktor (S3) Pendidikan Bahasa Arab, Sastra Arab, Linguistik Arab</td>
            </tr>
            <tr class="bg-slate-50/60">
                <td class="p-3 border border-slate-300 font-bold text-[#006837]">4</td>
                <td class="p-3 border border-slate-300 font-semibold">PJJ Hukum Keluarga Islam / Ahwal Syakhshiyyah (HKI)</td>
                <td class="p-3 border border-slate-300">Sarjana (S1)</td>
                <td class="p-3 border border-slate-300">Magister (S2) / Doktor (S3) Hukum Keluarga Islam, Syariah, Ilmu Hukum</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-300 font-bold text-[#006837]">5</td>
                <td class="p-3 border border-slate-300 font-semibold">PJJ Sejarah Peradaban Islam (SPI)</td>
                <td class="p-3 border border-slate-300">Sarjana (S1)</td>
                <td class="p-3 border border-slate-300">Magister (S2) / Doktor (S3) Sejarah Peradaban Islam, Ilmu Sejarah, Filologi, Kebudayaan Islam</td>
            </tr>
            <tr class="bg-slate-50/60">
                <td class="p-3 border border-slate-300 font-bold text-amber-700">6</td>
                <td class="p-3 border border-slate-300 font-semibold">PJJ Magister Pendidikan Agama Islam (S2 PAI)</td>
                <td class="p-3 border border-slate-300">Magister (S2)</td>
                <td class="p-3 border border-slate-300">Doktor (S3) Pendidikan Agama Islam / Manajemen Pendidikan Islam (Bergelar Doktor)</td>
            </tr>
            <tr>
                <td class="p-3 border border-slate-300 font-bold text-[#006837]">7</td>
                <td class="p-3 border border-slate-300 font-semibold">Mata Kuliah Dasar Umum (MKDU & Penciri Siber)</td>
                <td class="p-3 border border-slate-300">Lintas Prodi</td>
                <td class="p-3 border border-slate-300">Magister (S2) / Doktor (S3) Pancasila, Kewarganegaraan, Bahasa Indonesia, Bahasa Inggris, TI/Literasi Digital</td>
            </tr>
        </tbody>
    </table>
</div>

<h3>Tugas Pokok & Tanggung Jawab Tutor Online</h3>
<ul class="text-sm text-slate-700 space-y-1.5">
    <li class="text-justify"><strong>1. Pengelolaan Kelas LMS Pillar:</strong> Menyiapkan pengantar inisiasi mingguan, memeriksa kelengkapan modul digital, video pembelajaran, dan bahan suplemen di kelas yang diampu.</li>
    <li class="text-justify"><strong>2. Fasilitasi Forum Diskusi Asinkron:</strong> Memantik diskusi ilmiah, menanggapi pertanyaan mahasiswa, dan memotivasi keaktifan belajar mahasiswa setiap sesi pekan perkuliahan.</li>
    <li class="text-justify"><strong>3. Tutorial Tatap Maya (Sinkron):</strong> Melaksanakan pertemuan tatap maya terjadwal (webinar/review materi) sesuai pedoman akademik UPT PJJ.</li>
    <li class="text-justify"><strong>4. Evaluasi & Penilaian Tepat Waktu:</strong> Memeriksa, memberikan umpan balik konstruktif, dan menginput nilai Tugas Tutorial, Kuis, UTS, serta UAS ke dalam sistem LMS Pillar sesuai kalender akademik.</li>
</ul>

<h3>Tahapan Seleksi Rekrutmen Tutor Online</h3>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 my-6">
    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
        <span class="text-[10px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded bg-emerald-100 text-[#006837]">Tahap 01</span>
        <h4 class="font-bold text-slate-900 text-xs mt-2 mb-1">Registrasi & Unggah Berkas</h4>
        <p class="text-[11px] text-slate-600 text-justify">Pendaftaran akun secara daring dan pengunggahan dokumen persyaratan melalui portal resmi tutor.uinssc.ac.id.</p>
    </div>
    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
        <span class="text-[10px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded bg-emerald-100 text-[#006837]">Tahap 02</span>
        <h4 class="font-bold text-slate-900 text-xs mt-2 mb-1">Seleksi Administrasi</h4>
        <p class="text-[11px] text-slate-600 text-justify">Verifikasi kelengkapan dokumen, keabsahan ijazah, serta kesesuaian linearitas bidang ilmu dengan mata kuliah PJJ.</p>
    </div>
    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
        <span class="text-[10px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded bg-emerald-100 text-[#006837]">Tahap 03</span>
        <h4 class="font-bold text-slate-900 text-xs mt-2 mb-1">Uji Kompetensi LMS & Wawancara</h4>
        <p class="text-[11px] text-slate-600 text-justify">Asesmen penguasaan teknologi pembelajaran daring, praktik pengelolaan LMS Pillar, dan micro-teaching siber.</p>
    </div>
    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
        <span class="text-[10px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded bg-amber-100 text-amber-800">Tahap 04</span>
        <h4 class="font-bold text-slate-900 text-xs mt-2 mb-1">Bimtek & Penugasan SK</h4>
        <p class="text-[11px] text-slate-600 text-justify">Pengumuman hasil akhir, pembekalan Bimtek Tutor PJJ, penerbitan SK Rektor, dan penugasan kelas semester aktif.</p>
    </div>
</div>

<div class="my-6 p-5 rounded-2xl bg-gradient-to-r from-[#006837] to-[#004d29] text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
        <h4 class="text-sm font-extrabold text-white">Siap Bergabung Menjadi Tutor Online UPT PJJ UINSSC?</h4>
        <p class="text-xs text-emerald-100 mt-1 text-justify">Kunjungi portal resmi Rekrutmen Tutor Online untuk melihat jadwal gelombang pendaftaran aktif dan membuat akun calon tutor.</p>
    </div>
    <a href="https://tutor.uinssc.ac.id/" target="_blank" class="px-5 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-xs inline-flex items-center gap-2 transition no-underline shrink-0 shadow-md">
        <i class="fa-solid fa-user-plus"></i> Daftar di tutor.uinssc.ac.id
    </a>
</div>
                ',
                'template' => 'default',
                'is_published' => true,
                'published_at' => now(),
                'views_count' => 340,
                'meta_title' => 'Rekrutmen Tutor Online UPT PJJ - UIN Siber Syekh Nurjati Cirebon',
                'meta_description' => 'Informasi resmi persyaratan, kualifikasi, tahapan seleksi, dan pendaftaran Rekrutmen Tutor Online UPT PJJ UIN Siber Syekh Nurjati Cirebon (tutor.uinssc.ac.id).',
                'user_id' => $admin?->id,
            ]
        );
    }

    protected function seedHeaderMenu(Page $samplePage, ?Page $edusharePage = null, ?Page $upbjjPage = null, ?Page $tutorPage = null): void
    {
        $edusharePage ??= $this->seedEdusharePage();
        $upbjjPage ??= $this->seedUpbjjPage();
        $tutorPage ??= $this->seedTutorPage();

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
            'type' => 'route',
            'route_name' => 'profile.overview',
            'icon' => 'fa-solid fa-landmark',
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
            ['title' => 'Semua Profil UPT PJJ →', 'type' => 'route', 'route_name' => 'profile.overview', 'icon' => 'fa-solid fa-arrow-right', 'order' => 9],
        ];

        foreach ($profilChildren as $child) {
            MenuItem::create(array_merge($child, [
                'location' => 'header',
                'parent_id' => $profil->id,
                'is_active' => true,
            ]));
        }

        // 3. Prodi PJJ (Dropdown) -> Klik menu langsung membuka halaman semua prodi
        $prodi = MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Prodi PJJ',
            'type' => 'route',
            'route_name' => 'programs.index',
            'icon' => 'fa-solid fa-graduation-cap',
            'order' => 3,
            'is_active' => true,
        ]);

        $programs = StudyProgram::orderBy('degree', 'asc')->orderBy('id', 'asc')->get();
        $prodiOrder = 1;
        if ($programs->isNotEmpty()) {
            foreach ($programs as $prog) {
                $icon = match (true) {
                    str_contains(strtolower($prog->name), 'bahasa arab') => 'fa-solid fa-language',
                    str_contains(strtolower($prog->name), 'madrasah ibtidaiyah') || str_contains(strtolower($prog->name), 'pgmi') => 'fa-solid fa-chalkboard-user',
                    str_contains(strtolower($prog->name), 'hukum keluarga') || str_contains(strtolower($prog->name), 'hki') => 'fa-solid fa-scale-balanced',
                    str_contains(strtolower($prog->name), 'sejarah peradaban') || str_contains(strtolower($prog->name), 'spi') => 'fa-solid fa-landmark',
                    str_contains(strtolower($prog->name), 's2') || $prog->degree === 'S2' => 'fa-solid fa-user-graduate',
                    default => 'fa-solid fa-book-quran',
                };

                $badgeColor = match (strtolower($prog->accreditation)) {
                    'unggul' => 'emerald',
                    'baik sekali' => 'teal',
                    default => 'blue',
                };

                MenuItem::create([
                    'location' => 'header',
                    'parent_id' => $prodi->id,
                    'title' => $prog->name,
                    'type' => 'custom',
                    'url' => '/prodi/'.$prog->slug,
                    'icon' => $icon,
                    'badge' => $prog->accreditation,
                    'badge_color' => $badgeColor,
                    'order' => $prodiOrder++,
                    'is_active' => true,
                ]);
            }
        } else {
            $defaultPrograms = [
                ['title' => 'PJJ PAI (S1)', 'url' => '/prodi/pjj-pendidikan-agama-islam', 'icon' => 'fa-solid fa-book-quran', 'badge' => 'Unggul', 'badge_color' => 'emerald'],
                ['title' => 'PJJ PGMI (S1)', 'url' => '/prodi/pjj-pendidikan-guru-madrasah-ibtidaiyah', 'icon' => 'fa-solid fa-chalkboard-user', 'badge' => 'Baik Sekali', 'badge_color' => 'teal'],
                ['title' => 'PJJ PBA (S1)', 'url' => '/prodi/pjj-pendidikan-bahasa-arab', 'icon' => 'fa-solid fa-language', 'badge' => 'Baik Sekali', 'badge_color' => 'amber'],
                ['title' => 'PJJ HKI (S1)', 'url' => '/prodi/pjj-hukum-keluarga-islam', 'icon' => 'fa-solid fa-scale-balanced', 'badge' => 'Baik Sekali', 'badge_color' => 'purple'],
                ['title' => 'PJJ SPI (S1)', 'url' => '/prodi/pjj-sejarah-peradaban-islam', 'icon' => 'fa-solid fa-landmark', 'badge' => 'Baik', 'badge_color' => 'blue'],
                ['title' => 'PJJ PAI S2', 'url' => '/prodi/pjj-magister-pendidikan-agama-islam-s2', 'icon' => 'fa-solid fa-graduation-cap', 'badge' => 'Unggul', 'badge_color' => 'amber'],
            ];
            foreach ($defaultPrograms as $dp) {
                MenuItem::create([
                    'location' => 'header',
                    'parent_id' => $prodi->id,
                    'title' => $dp['title'],
                    'type' => 'custom',
                    'url' => $dp['url'],
                    'icon' => $dp['icon'],
                    'badge' => $dp['badge'],
                    'badge_color' => $dp['badge_color'],
                    'order' => $prodiOrder++,
                    'is_active' => true,
                ]);
            }
        }

        MenuItem::create([
            'location' => 'header',
            'parent_id' => $prodi->id,
            'title' => 'Semua Program Studi (6 Prodi) →',
            'type' => 'route',
            'route_name' => 'programs.index',
            'icon' => 'fa-solid fa-arrow-right',
            'order' => $prodiOrder,
            'is_active' => true,
        ]);

        // 4. Layanan (Dropdown with LMS Pillar & Course Tutorial) -> Klik menu langsung membuka halaman semua layanan
        $layanan = MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Layanan',
            'type' => 'route',
            'route_name' => 'services.index',
            'icon' => 'fa-solid fa-hand-holding-hand',
            'order' => 4,
            'is_active' => true,
        ]);

        $services = Service::where('is_active', true)->orderBy('id', 'asc')->get();
        $srvOrder = 1;
        if ($services->isNotEmpty()) {
            foreach ($services as $srv) {
                $icon = match (true) {
                    str_contains(strtolower($srv->slug), 'lms') => 'fa-solid fa-graduation-cap',
                    str_contains(strtolower($srv->slug), 'multimedia') || str_contains(strtolower($srv->slug), 'studio') => 'fa-solid fa-video',
                    str_contains(strtolower($srv->slug), 'helpdesk') => 'fa-solid fa-headset',
                    str_contains(strtolower($srv->slug), 'lab') => 'fa-solid fa-server',
                    str_contains(strtolower($srv->slug), 'bahan-ajar') => 'fa-solid fa-book-open',
                    str_contains(strtolower($srv->slug), 'mobile') || str_contains(strtolower($srv->slug), 'sibergo') => 'fa-solid fa-mobile-screen',
                    default => 'fa-solid fa-gear',
                };

                $badge = str_contains(strtolower($srv->slug), 'lms') ? 'Utama' : null;
                $badgeColor = 'emerald';

                MenuItem::create([
                    'location' => 'header',
                    'parent_id' => $layanan->id,
                    'title' => $srv->title,
                    'type' => 'custom',
                    'url' => '/layanan/'.$srv->slug,
                    'icon' => $icon,
                    'badge' => $badge,
                    'badge_color' => $badgeColor,
                    'order' => $srvOrder++,
                    'is_active' => true,
                ]);
            }
        }

        MenuItem::create([
            'location' => 'header',
            'parent_id' => $layanan->id,
            'title' => 'Tutorial & Course LMS',
            'type' => 'route',
            'route_name' => 'lms-guide',
            'icon' => 'fa-solid fa-chalkboard-user',
            'badge' => 'Course',
            'badge_color' => 'amber',
            'order' => $srvOrder++,
            'is_active' => true,
        ]);

        MenuItem::create([
            'location' => 'header',
            'parent_id' => $layanan->id,
            'title' => 'Semua Layanan & Fasilitas →',
            'type' => 'route',
            'route_name' => 'services.index',
            'icon' => 'fa-solid fa-arrow-right',
            'order' => $srvOrder,
            'is_active' => true,
        ]);

        // 5. EduShare
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'EduShare',
            'type' => 'page',
            'page_id' => $edusharePage->id,
            'icon' => null,
            'badge' => null,
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
            'icon' => null,
            'badge' => null,
            'order' => 6,
            'is_active' => true,
        ]);

        // 7. Tutor (Rekrutmen Tutor Online UPT PJJ)
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Tutor',
            'type' => 'page',
            'page_id' => $tutorPage->id,
            'icon' => null,
            'badge' => null,
            'order' => 7,
            'is_active' => true,
        ]);

        // 8. Pengumuman
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Pengumuman',
            'type' => 'route',
            'route_name' => 'announcements.index',
            'order' => 8,
            'is_active' => true,
        ]);

        // 9. Berita
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Berita',
            'type' => 'route',
            'route_name' => 'posts.index',
            'order' => 9,
            'is_active' => true,
        ]);

        // 10. FAQs
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'FAQs',
            'type' => 'route',
            'route_name' => 'faqs',
            'order' => 10,
            'is_active' => true,
        ]);

        // 11. Downloads
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Downloads',
            'type' => 'route',
            'route_name' => 'downloads.index',
            'order' => 11,
            'is_active' => true,
        ]);

        // 12. Kontak
        MenuItem::create([
            'location' => 'header',
            'parent_id' => null,
            'title' => 'Kontak',
            'type' => 'route',
            'route_name' => 'contact.index',
            'order' => 12,
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
