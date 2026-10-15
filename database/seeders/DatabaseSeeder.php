<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\DownloadDocument;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\Post;
use App\Models\Service;
use App\Models\Setting;
use App\Models\StudyProgram;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users
        $admin = User::create([
            'name' => 'Administrator UPT PJJ',
            'email' => 'admin@uinssc.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '+6281234567890',
            'bio' => 'Super Administrator Portal UPT PJJ UIN Siber Syekh Nurjati Cirebon.',
            'is_active' => true,
        ]);

        $editor = User::create([
            'name' => 'Humas & Publikasi PJJ',
            'email' => 'editor@uinssc.ac.id',
            'password' => Hash::make('editor123'),
            'role' => 'editor',
            'phone' => '+6289876543210',
            'bio' => 'Tim Humas dan Pengelola Konten UPT PJJ.',
            'is_active' => true,
        ]);

        // 2. Settings
        $settings = [
            // General & Branding
            ['key' => 'site_name', 'value' => 'UPT Pendidikan Jarak Jauh', 'group' => 'general', 'label' => 'Nama Unit'],
            ['key' => 'site_institution', 'value' => 'UIN Siber Syekh Nurjati Cirebon', 'group' => 'general', 'label' => 'Nama Kampus'],
            ['key' => 'site_tagline', 'value' => 'Pionir Pendidikan Jarak Jauh Siber Berbasis Nilai Keislaman & Standar Global', 'group' => 'general', 'label' => 'Tagline'],
            ['key' => 'site_description', 'value' => 'Unit Pelaksana Teknis Pendidikan Jarak Jauh Universitas Islam Negeri Siber Syekh Nurjati Cirebon yang menyelenggarakan pendidikan tinggi berbasis siber berkelas dunia.', 'group' => 'general', 'label' => 'Deskripsi Situs'],
            ['key' => 'site_logo_text', 'value' => 'UPT PJJ UINSSC', 'group' => 'general', 'label' => 'Teks Logo'],

            // Profile & Greetings
            ['key' => 'head_name', 'value' => 'Dr. Muslihudin, M.Ag.', 'group' => 'profile', 'label' => 'Nama Kepala UPT'],
            ['key' => 'head_title', 'value' => 'Kepala UPT Pendidikan Jarak Jauh UINSSC', 'group' => 'profile', 'label' => 'Jabatan Kepala UPT'],
            ['key' => 'head_photo', 'value' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=600&auto=format&fit=crop', 'group' => 'profile', 'label' => 'Foto Kepala UPT'],
            ['key' => 'head_greeting', 'value' => "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\nSelamat datang di portal resmi UPT Pendidikan Jarak Jauh (UPT PJJ) UIN Siber Syekh Nurjati Cirebon. Sebagai World Class Cyber Islamic University pertama di Indonesia yang diamanatkan oleh Kementerian Agama RI, kami berkomitmen membuka akses seluas-luasnya bagi seluruh anak bangsa untuk mengenyam pendidikan tinggi Islam berkualitas tinggi secara fleksibel tanpa batasan geografis.\n\nMelalui ekosistem pembelajaran digital terkini dengan LMS Pillar, modul interaktif multimedia, serta didukung dosen berstandar global, UPT PJJ UINSSC siap mengantarkan Anda menjadi sarjana dan magister unggul, berkarakter, dan berdaya saing internasional.", 'group' => 'profile', 'label' => 'Sambutan Kepala UPT'],

            ['key' => 'vision', 'value' => 'Menjadi Unit Pelaksana Teknis Pendidikan Jarak Jauh (UPT-PJJ) yang inovatif dan inklusif, menghasilkan lulusan berkualitas global dalam bingkai nilai-nilai Islam, serta mendukung terwujudnya Universitas Islam Siber berkelas dunia untuk semua pada Tahun 2030.', 'group' => 'profile', 'label' => 'Visi'],
            ['key' => 'mission', 'value' => "1. Menyelenggarakan dan mengelola sistem pendidikan jarak jauh berbasis teknologi informasi yang mutakhir, adaptif, dan handal.\n2. Mengembangkan materi pembelajaran dan bahan ajar modular multimedia digital yang interaktif dan berstandar internasional.\n3. Memperluas akses pendidikan tinggi Islam yang inklusif dan merata bagi masyarakat di seluruh penjuru nusantara dan mancanegara.\n4. Mengembangkan riset, inovasi pedagogi siber, dan pengabdian kepada masyarakat berbasis digital.\n5. Membangun kolaborasi strategis dengan institusi pendidikan, industri teknologi, dan dunia usaha di tingkat nasional maupun internasional.", 'group' => 'profile', 'label' => 'Misi'],
            ['key' => 'profile_video_url', 'value' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'group' => 'profile', 'label' => 'Video Profil Embed URL'],
            ['key' => 'stats_students', 'value' => '8,500+', 'group' => 'profile', 'label' => 'Jumlah Mahasiswa PJJ'],
            ['key' => 'stats_lecturers', 'value' => '180+', 'group' => 'profile', 'label' => 'Dosen & Tutor Siber'],
            ['key' => 'stats_programs', 'value' => '6', 'group' => 'profile', 'label' => 'Program Studi PJJ'],
            ['key' => 'stats_modules', 'value' => '1,250+', 'group' => 'profile', 'label' => 'Modul & Video Pembelajaran'],

            // Contact & Social
            ['key' => 'address', 'value' => 'Gedung Siber Lt. 3, Kampus UIN Siber Syekh Nurjati Cirebon, Jl. Perjuangan By Pass Sunyaragi, Kota Cirebon, Jawa Barat 45132', 'group' => 'contact', 'label' => 'Alamat Kampus'],
            ['key' => 'email', 'value' => 'pjj@uinssc.ac.id', 'group' => 'contact', 'label' => 'Email Resmi'],
            ['key' => 'phone', 'value' => '(0231) 481264', 'group' => 'contact', 'label' => 'Telepon'],
            ['key' => 'whatsapp', 'value' => '+628112345678', 'group' => 'contact', 'label' => 'WhatsApp Helpdesk'],
            ['key' => 'work_hours', 'value' => 'Senin - Jumat: 07.30 - 16.00 WIB (Layanan Helpdesk Online 24/7)', 'group' => 'contact', 'label' => 'Jam Pelayanan'],
            ['key' => 'google_maps_iframe', 'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.368819556107!2d108.53982857499482!3d-6.737035693259163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ee2616fdf06a7%3A0xe21262dcf0e16853!2sUIN%20Siber%20Syekh%20Nurjati%20Cirebon!5e0!3m2!1sid!2sid!4v1711345678901!5m2!1sid!2sid" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>', 'group' => 'contact', 'label' => 'Google Maps Embed'],

            ['key' => 'facebook_url', 'value' => 'https://facebook.com/uinssc.official', 'group' => 'social', 'label' => 'Facebook'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/uptpjj_uinssc', 'group' => 'social', 'label' => 'Instagram'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/@uinssc', 'group' => 'social', 'label' => 'YouTube Channel'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/uinssc_official', 'group' => 'social', 'label' => 'Twitter/X'],
            ['key' => 'tiktok_url', 'value' => 'https://tiktok.com/@uinssc.official', 'group' => 'social', 'label' => 'TikTok'],

            // External Links & Portals
            ['key' => 'lms_url', 'value' => 'https://sso-lms.uinssc.ac.id', 'group' => 'links', 'label' => 'LMS Pillar URL'],
            ['key' => 'pmb_url', 'value' => 'https://pmb.uinssc.ac.id', 'group' => 'links', 'label' => 'PMB Online URL'],
            ['key' => 'main_campus_url', 'value' => 'https://uinssc.ac.id', 'group' => 'links', 'label' => 'Website Utama UINSSC'],
            ['key' => 'sibergo_url', 'value' => 'https://play.google.com/store/apps/details?id=com.uinssc.pustikom.sibergo', 'group' => 'links', 'label' => 'App SiberGo (PlayStore)'],
            ['key' => 'helpdesk_url', 'value' => 'https://helpdesk.uinssc.ac.id', 'group' => 'links', 'label' => 'Helpdesk Terpadu'],
        ];

        foreach ($settings as $s) {
            Setting::create($s);
        }

        // 3. Hero Slides
        HeroSlide::create([
            'badge' => 'Cyber Islamic University Terdepan di Indonesia',
            'title' => 'Kuliah Fleksibel Berkualitas Tanpa Batas Ruang & Waktu',
            'highlight_text' => 'Bersama UPT PJJ UINSSC',
            'subtitle' => 'Wujudkan impian sarjana & magister dengan sistem pembelajaran siber 100% online berstandar internasional yang diakui dan terakreditasi resmi.',
            'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1400&auto=format&fit=crop',
            'primary_btn_text' => 'Daftar PMB PJJ Online',
            'primary_btn_url' => 'https://pmb.uinssc.ac.id',
            'secondary_btn_text' => 'Eksplorasi Program Studi',
            'secondary_btn_url' => '/prodi',
            'order' => 1,
            'is_active' => true,
        ]);

        HeroSlide::create([
            'badge' => 'Platform LMS Pillar Terintegrasi',
            'title' => 'Ekosistem Pembelajaran Jarak Jauh Terpadu & Interaktif',
            'highlight_text' => 'Akses 24/7 di Mana Saja',
            'subtitle' => 'Akses materi kuliah modular, video interaktif dari studio siber, forum diskusi cerdas, hingga ujian asinkron dan sinkron dengan mudah melalui smartphone atau laptop Anda.',
            'image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=1400&auto=format&fit=crop',
            'primary_btn_text' => 'Masuk LMS Pillar',
            'primary_btn_url' => 'https://pillar.uinssc.ac.id',
            'secondary_btn_text' => 'Tutorial & Panduan LMS',
            'secondary_btn_url' => '/panduan-lms',
            'order' => 2,
            'is_active' => true,
        ]);

        HeroSlide::create([
            'badge' => 'Pemberdayaan Guru & Profesional',
            'title' => 'Tingkatkan Kualifikasi Akademik Tanpa Mengorbankan Karir',
            'highlight_text' => 'Solusi Guru & Profesional',
            'subtitle' => 'Didesain khusus untuk para pendidik, guru madrasah, aparatur sipil, dan profesional di seluruh nusantara untuk meraih gelar S1 dan S2 secara berdaya saing.',
            'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1400&auto=format&fit=crop',
            'primary_btn_text' => 'Pelajari Selengkapnya',
            'primary_btn_url' => '/profil/selayang-pandang',
            'secondary_btn_text' => 'Konsultasi PMB',
            'secondary_btn_url' => '/kontak',
            'order' => 3,
            'is_active' => true,
        ]);

        // 4. Categories
        $catBerita = Category::create(['name' => 'Berita & Informasi', 'slug' => 'berita-dan-informasi', 'type' => 'berita', 'color' => 'blue', 'description' => 'Berita terkini seputar kegiatan, kerjasama, dan perkembangan UPT PJJ UINSSC.']);
        $catPengumuman = Category::create(['name' => 'Pengumuman Akademik', 'slug' => 'pengumuman-akademik', 'type' => 'pengumuman', 'color' => 'amber', 'description' => 'Informasi penting mengenai kalender akademik, jadwal kuliah daring, dan ujian.']);
        $catBimtek = Category::create(['name' => 'Bimtek & Pelatihan', 'slug' => 'bimtek-pelatihan', 'type' => 'berita', 'color' => 'emerald', 'description' => 'Pelatihan dosen, penyusunan bahan ajar modular, dan workshop LMS Pillar.']);
        $catRiset = Category::create(['name' => 'Opini & Riset Siber', 'slug' => 'opini-riset-siber', 'type' => 'berita', 'color' => 'purple', 'description' => 'Kajian relasi keilmuan Islam, pedagogi siber, dan teknologi pendidikan masa depan.']);

        // 5. Study Programs (Prodi PJJ)
        $prodis = [
            [
                'name' => 'PJJ Pendidikan Agama Islam (PAI)',
                'slug' => 'pjj-pendidikan-agama-islam',
                'degree' => 'S1',
                'faculty' => 'Fakultas Ilmu Tarbiyah dan Keguruan (FITK)',
                'accreditation' => 'Unggul',
                'code' => 'PAI-PJJ-S1',
                'head_of_program' => 'Dr. H. Ahmad Asmuni, M.Ag',
                'graduate_title' => 'S.Pd.',
                'short_description' => 'Mencetak sarjana pendidik Agama Islam yang profesional, adaptif terhadap teknologi pembelajaran digital siber, serta berakhlak mulia.',
                'description' => 'Program Studi S1 Pendidikan Agama Islam Jarak Jauh (PJJ PAI) UIN Siber Syekh Nurjati Cirebon diselenggarakan untuk memfasilitasi para guru madrasah, guru PAI sekolah, dan praktisi pendidikan di seluruh Indonesia guna memperoleh kualifikasi sarjana tanpa meninggalkan tugas pengabdian di daerah masing-masing.',
                'vision_mission' => 'Menjadi Program Studi PJJ PAI terdepan dalam menghasilkan pendidik agama Islam yang unggul, berjiwa siber, inovatif, dan berakhlakul karimah pada tingkat Asia Tenggara tahun 2030.',
                'total_credits' => 144,
                'study_duration' => '8 Semester (Dapat ditempuh 7-8 Semester)',
                'learning_method' => '100% Online melalui LMS Pillar, Micro-learning Modules, Video Pembelajaran, dan Virtual Classroom.',
                'tuition_info' => 'UKT Sangat Terjangkau & Tersedia Jalur Beasiswa Kemenag / LPDP / Mandiri',
                'image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?q=80&w=800&auto=format&fit=crop',
                'registration_url' => 'https://pmb.uinssc.ac.id',
                'website_url' => 'https://pjjpai.uinssc.ac.id',
                'order' => 1,
            ],
            [
                'name' => 'PJJ Pendidikan Guru Madrasah Ibtidaiyah (PGMI)',
                'slug' => 'pjj-pendidikan-guru-madrasah-ibtidaiyah',
                'degree' => 'S1',
                'faculty' => 'Fakultas Ilmu Tarbiyah dan Keguruan (FITK)',
                'accreditation' => 'Baik Sekali',
                'code' => 'PGMI-PJJ-S1',
                'head_of_program' => 'Dr. Hj. Farihatun, M.Pd',
                'graduate_title' => 'S.Pd.',
                'short_description' => 'Mempersiapkan pendidik dasar (MI/SD) yang kompeten, berwawasan integrasi sains-Islam, dan terampil mengelola pembelajaran blended dan daring modern.',
                'description' => 'Prodi PJJ PGMI memberikan kesempatan emas bagi para guru kelas MI/SD di seluruh Indonesia untuk meningkatkan kompetensi pedagogik, keilmuan tematik integratif, serta kemampuan merancang media edukasi digital anak usia dasar.',
                'vision_mission' => 'Unggul dalam mencetak guru madrasah ibtidaiyah berwawasan siber yang humanis dan berkarakter islami.',
                'total_credits' => 144,
                'study_duration' => '8 Semester',
                'learning_method' => 'E-Learning Modular Asinkron, Simulasi Mengajar Virtual, Tugas Projek Digital.',
                'tuition_info' => 'Biaya Kuliah Terjangkau & Pembayaran Fleksibel per Semester',
                'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=800&auto=format&fit=crop',
                'registration_url' => 'https://pmb.uinssc.ac.id',
                'website_url' => 'https://pjjpgmi.uinssc.ac.id',
                'order' => 2,
            ],
            [
                'name' => 'PJJ Pendidikan Bahasa Arab (PBA)',
                'slug' => 'pjj-pendidikan-bahasa-arab',
                'degree' => 'S1',
                'faculty' => 'Fakultas Ilmu Tarbiyah dan Keguruan (FITK)',
                'accreditation' => 'Baik Sekali',
                'code' => 'PBA-PJJ-S1',
                'head_of_program' => 'Dr. Muhammad Ali, M.Pd',
                'graduate_title' => 'S.Pd.',
                'short_description' => 'Melahirkan pendidik dan pakar pengajaran Bahasa Arab dengan integrasi teknologi linguistik komputasional dan multimedia interaktif.',
                'description' => 'Membekali mahasiswa dengan 4 maharah berbahasa Arab (Istima\', Kalam, Qira\'ah, Kitabah) dengan pendekatan teknologi mutakhir, laboratorium bahasa virtual, serta kurikulum berstandar CEFR internasional.',
                'vision_mission' => 'Pusat keunggulan pendidikan bahasa Arab berbasis siber bertaraf internasional.',
                'total_credits' => 144,
                'study_duration' => '8 Semester',
                'learning_method' => 'Virtual Lab Bahasa, Live Interactive Native Coaching, Modul E-Arabic.',
                'tuition_info' => 'Tersedia Program Afirmasi & Jalur Prestasi',
                'image' => 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?q=80&w=800&auto=format&fit=crop',
                'registration_url' => 'https://pmb.uinssc.ac.id',
                'website_url' => 'https://pjjpba.uinssc.ac.id',
                'order' => 3,
            ],
            [
                'name' => 'PJJ Hukum Keluarga Islam / Ahwal Syakhshiyyah (HKI)',
                'slug' => 'pjj-hukum-keluarga-islam',
                'degree' => 'S1',
                'faculty' => 'Fakultas Syariah (FASYA)',
                'accreditation' => 'Baik Sekali',
                'code' => 'HKI-PJJ-S1',
                'head_of_program' => 'Dr. H. Saifuddin, M.H',
                'graduate_title' => 'S.H.',
                'short_description' => 'Mencetak praktisi hukum, mediator keluarga, dan akademisi syariah yang mumpuni dalam hukum perdata Islam di era peradilan elektronik (e-Court).',
                'description' => 'Kurikulum dirancang responsif terhadap perkembangan hukum keluarga kontemporer, peradilan agama online, mediasi digital, serta isu-isu perlindungan anak dan perempuan dalam perspektif maqashid syariah.',
                'vision_mission' => 'Menghasilkan sarjana hukum Islam yang profesional, berintegritas, dan cakap teknologi peradilan digital.',
                'total_credits' => 144,
                'study_duration' => '8 Semester',
                'learning_method' => 'Studi Kasus Hukum Interaktif, Peradilan Semu Siber, Diskusi Pakar Hukum Online.',
                'tuition_info' => 'Biaya Kuliah Kompetitif & Terbuka bagi Aparatur KUA / Mahkamah Syariah',
                'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?q=80&w=800&auto=format&fit=crop',
                'registration_url' => 'https://pmb.uinssc.ac.id',
                'website_url' => 'https://pjjhk.uinssc.ac.id',
                'order' => 4,
            ],
            [
                'name' => 'PJJ Sejarah Peradaban Islam (SPI)',
                'slug' => 'pjj-sejarah-peradaban-islam',
                'degree' => 'S1',
                'faculty' => 'Fakultas Ushuluddin dan Adab (FUA)',
                'accreditation' => 'Baik',
                'code' => 'SPI-PJJ-S1',
                'head_of_program' => 'Dr. Abdullah Khoir, M.Hum',
                'graduate_title' => 'S.Hum.',
                'short_description' => 'Mengembangkan studi historis peradaban Islam Nusantara dan Dunia dengan pendekatan digital humanities, preservasi manuskrip, dan kajian kebudayaan siber.',
                'description' => 'Program studi yang mendalami dinamika sejarah Islam dengan memanfaatkan kecanggihan digital archive, rekonstruksi sejarah 3D, dan riset historiografi berbasis data siber.',
                'vision_mission' => 'Menjadi pusat kajian sejarah dan kebudayaan Islam berbasis siber terkemuka.',
                'total_credits' => 144,
                'study_duration' => '8 Semester',
                'learning_method' => 'Digital Archives Tour, Virtual Museum Study, Modul Sejarah Visual.',
                'tuition_info' => 'Dukungan Beasiswa Riset & Mahasiswa Santri',
                'image' => 'https://images.unsplash.com/photo-1461360370896-922624d12aa1?q=80&w=800&auto=format&fit=crop',
                'registration_url' => 'https://pmb.uinssc.ac.id',
                'website_url' => 'https://pjjspi.uinssc.ac.id',
                'order' => 5,
            ],
            [
                'name' => 'PJJ Magister Pendidikan Agama Islam (S2 PAI)',
                'slug' => 'pjj-magister-pendidikan-agama-islam-s2',
                'degree' => 'S2',
                'faculty' => 'Pascasarjana UIN Siber Syekh Nurjati Cirebon',
                'accreditation' => 'Unggul',
                'code' => 'PAI-PJJ-S2',
                'head_of_program' => 'Prof. Dr. H. Didin Nurul Rosidin, Ph.D',
                'graduate_title' => 'M.Pd.',
                'short_description' => 'Program Magister Pascasarjana Jarak Jauh pertama yang fokus pada kepemimpinan pendidikan Islam, desain kurikulum digital, dan riset inovasi pembelajaran.',
                'description' => 'Disiapkan khusus bagi para kepala madrasah, pengawas pendidikan, dosen, widyaiswara, dan pimpinan lembaga pendidikan Islam di seluruh Indonesia yang ingin meraih gelar master secara efisien dan berkualitas tinggi.',
                'vision_mission' => 'Menjadi rujukan utama pendidikan pascasarjana siber di bidang pendidikan Islam di kawasan regional.',
                'total_credits' => 48,
                'study_duration' => '4 Semester (2 Tahun)',
                'learning_method' => 'Colloquium Riset Online, Bimbingan Tesis Virtual 1-on-1, International Digital Symposium.',
                'tuition_info' => 'Investasi Pendidikan Pascasarjana Terjangkau dengan Pembayaran Fleksibel',
                'image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800&auto=format&fit=crop',
                'registration_url' => 'https://pmb.uinssc.ac.id',
                'website_url' => 'https://pjj-s2pai.uinssc.ac.id',
                'order' => 6,
            ],
        ];

        foreach ($prodis as $prodi) {
            StudyProgram::create($prodi);
        }

        // 6. Posts (Berita & Informasi Terkini)
        Post::create([
            'title' => 'UIN Siber Syekh Nurjati dan Telkom University Jajaki Kolaborasi Pembelajaran Digital dan Layanan Bahasa',
            'slug' => 'uin-siber-syekh-nurjati-dan-telkom-university-jajaki-kolaborasi-pembelajaran-digital-dan-layanan-bahasa',
            'category_id' => $catBerita->id,
            'user_id' => $admin->id,
            'excerpt' => 'UIN Siber Syekh Nurjati Cirebon dan Telkom University menggelar pertemuan strategis guna menjajaki kerjasama pengembangan teknologi pembelajaran siber terpadu.',
            'content' => "<p><strong>CIREBON</strong> — Unit Pelaksana Teknis Pendidikan Jarak Jauh (UPT PJJ) UIN Siber Syekh Nurjati Cirebon bersama Telkom University menyepakati langkah awal inisiasi kolaborasi dalam penguatan ekosistem pembelajaran digital, pengembangan platform AI-learning, serta layanan peningkatan kemahiran bahasa asing.</p><p>Pertemuan yang dihadiri oleh pimpinan kedua universitas ini menyoroti pentingnya konvergensi teknologi telekomunikasi dan pedagogi modern dalam mendukung percepatan pendidikan inklusif bagi seluruh masyarakat Indonesia. 'Sebagai Cyber Islamic University, UINSSC terus membuka pintu sinergi dengan perguruan tinggi teknologi unggul demi menyajikan pengalaman belajar siber yang tak tertandingi,' ujar Kepala UPT PJJ.</p><p>Diharapkan dalam waktu dekat, implementasi sistem pertukaran kredit antar-kampus digital dan sertifikasi internasional dapat segera dinikmati oleh mahasiswa PJJ di seluruh prodi.</p>",
            'featured_image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=800&auto=format&fit=crop',
            'views_count' => 1420,
            'is_featured' => true,
            'is_published' => true,
            'published_at' => now()->subDays(2),
            'tags' => 'Kerjasama, Digital Learning, Telkom University, UINSSC',
        ]);

        Post::create([
            'title' => 'UIN Siber Syekh Nurjati Cirebon Dorong Mahasiswa PJJ Kaji Relasi Iman dan Eksploitasi Alam melalui FGD Seri 1',
            'slug' => 'uin-siber-syekh-nurjati-cirebon-dorong-mahasiswa-pjj-kaji-relasi-iman-dan-eksploitasi-alam-melalui-fgd-seri-1',
            'category_id' => $catRiset->id,
            'user_id' => $admin->id,
            'excerpt' => 'FGD Seri 1 UPT PJJ UINSSC mengupas tuntas etika lingkungan hidup dalam bingkai teologi Islam dan respons terhadap krisis iklim global.',
            'content' => "<p><strong>CIREBON</strong> — UPT Pendidikan Jarak Jauh (PJJ) UIN Siber Syekh Nurjati Cirebon menyelenggarakan Focus Group Discussion (FGD) Seri 1 bertajuk 'Relasi Iman, Etika Lingkungan, dan Tantangan Ekologis di Era Industri Siber'. Acara ini diikuti oleh lebih dari 1.200 mahasiswa PJJ dan dosen dari berbagai penjuru daerah secara daring via zoom dan kanal YouTube resmi.</p><p>Narasumber menekankan pentingnya integrasi nilai-nilai teologi tauhid dalam melestarikan ekosistem bumi, selaras dengan semangat Islam rahmatan lil 'alamin. Diskusi berlangsung dinamis dengan puluhan pertanyaan kritis dari para mahasiswa yang berprofesi sebagai pendidik dan aktivis masyarakat.</p>",
            'featured_image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800&auto=format&fit=crop',
            'views_count' => 980,
            'is_featured' => true,
            'is_published' => true,
            'published_at' => now()->subDays(6),
            'tags' => 'FGD, Riset, Lingkungan, Teologi Islam, Mahasiswa PJJ',
        ]);

        Post::create([
            'title' => 'UPT PJJ UIN Siber Syekh Nurjati Cirebon Gelar Bimtek dan Refreshment LMS Pillar bagi Dosen dan Mahasiswa Baru',
            'slug' => 'upt-pjj-uin-siber-syekh-nurjati-cirebon-gelar-bimtek-dan-refreshment-lms-pillar-bagi-dosen-dan-mahasiswa',
            'category_id' => $catBimtek->id,
            'user_id' => $editor->id,
            'excerpt' => 'Bimbingan teknis intensif digelar untuk memastikan kelancaran perkuliahan daring semester ganjil melalui platform LMS Pillar versi 3.0.',
            'content' => '<p><strong>CIREBON</strong> — Dalam rangka menyambut tahun akademik baru, UPT PJJ UIN Siber Syekh Nurjati Cirebon menggelar Bimbingan Teknis (Bimtek) dan Refreshment Penggunaan LMS Pillar bagi seluruh dosen pengampu dan mahasiswa baru angkatan 2026.</p><p>Materi yang disampaikan mencakup navigasi sistem micro-learning, aktivasi forum diskusi asinkron, sistem pengunggahan bahan ajar multimedia interaktif, hingga penggunaan fitur automated grading dan proctoring ujian online berbasis AI. Tim IT UPT PJJ juga memperkenalkan aplikasi mobile SiberGo yang mempermudah mahasiswa memantau jadwal dan notifikasi perkuliahan langsung dari genggaman.</p>',
            'featured_image' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?q=80&w=800&auto=format&fit=crop',
            'views_count' => 2150,
            'is_featured' => true,
            'is_published' => true,
            'published_at' => now()->subDays(12),
            'tags' => 'Bimtek, LMS Pillar, Dosen, Mahasiswa Baru, SiberGo',
        ]);

        Post::create([
            'title' => 'Mengapa Harus Kuliah PJJ di UIN Siber Syekh Nurjati Cirebon? Simak 7 Keunggulannya',
            'slug' => 'mengapa-harus-kuliah-pjj-di-uinssc',
            'category_id' => $catBerita->id,
            'user_id' => $admin->id,
            'excerpt' => 'Di era digital, kuliah berkualitas dunia dapat diakses dari mana saja. Temukan berbagai kemudahan dan keunggulan resmi program PJJ UINSSC.',
            'content' => '<p>Pendidikan tinggi kini berada di titik transformasi besar. UIN Siber Syekh Nurjati Cirebon sebagai Perguruan Tinggi Keagamaan Islam Negeri (PTKIN) Siber pertama di Indonesia menawarkan kemudahan belajar luar biasa:</p><ul><li><strong>1. Fleksibilitas Waktu 100%:</strong> Belajar kapan saja dan di mana saja tanpa harus cuti bekerja.</li><li><strong>2. Ijazah & Gelar Sah:</strong> Setara dengan perkuliahan reguler dan diakui penuh oleh Kemendikbudristek & Kemenag RI.</li><li><strong>3. Biaya Kuliah Terjangkau:</strong> Tanpa beban biaya kos, transportasi harian, atau akomodasi.</li><li><strong>4. Ekosistem LMS Terkini:</strong> Akses materi audio, video studio siber, dan e-book tanpa batas.</li><li><strong>5. Dosen Berpengalaman:</strong> Bimbingan langsung dari akademisi berkaliber nasional dan internasional.</li><li><strong>6. Komunitas Mahasiswa Lintas Batas:</strong> Berjejaring dengan ribuan teman sekelas dari Sabang hingga Merauke, bahkan luar negeri.</li><li><strong>7. Layanan Helpdesk Responsif 24 Jam:</strong> Tim support siap mendampingi setiap kendala teknis Anda.</li></ul>',
            'featured_image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=800&auto=format&fit=crop',
            'views_count' => 3400,
            'is_featured' => false,
            'is_published' => true,
            'published_at' => now()->subDays(15),
            'tags' => 'Keunggulan PJJ, PMB Online, Cyber University, Kuliah Fleksibel',
        ]);

        // 7. Announcements (Pengumuman)
        Announcement::create([
            'title' => 'Jadwal Pengisian KRS Online dan Perkuliahan Semester Ganjil T.A. 2026/2027 Mahasiswa PJJ',
            'slug' => 'jadwal-pengisian-krs-online-dan-perkuliahan-semester-ganjil-2026-2027',
            'category' => 'Akademik',
            'content' => 'Diberitahukan kepada seluruh mahasiswa Program Studi PJJ (S1 & S2) UIN Siber Syekh Nurjati Cirebon bahwa pengisian Kartu Rencana Studi (KRS) online melalui portal akademik dibuka mulai tanggal 1 s.d. 15 Oktober 2026. Perkuliahan aktif daring di LMS Pillar akan dimulai serentak pada tanggal 20 Oktober 2026.',
            'attachment_name' => 'Surat_Edaran_KRS_PJJ_2026.pdf',
            'attachment_file' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
            'is_pinned' => true,
            'is_published' => true,
            'published_at' => now()->subDays(1),
        ]);

        Announcement::create([
            'title' => 'Panduan Akses dan Aktivasi Akun LMS Pillar bagi Mahasiswa Baru Angkatan 2026',
            'slug' => 'panduan-akses-dan-aktivasi-akun-lms-pillar-2026',
            'category' => 'Layanan LMS',
            'content' => 'Akun LMS Pillar untuk seluruh mahasiswa baru telah digenerate secara otomatis menggunakan NIM dan email kampus @mhs.uinssc.ac.id. Silakan lakukan aktivasi pertama dan ubah kata sandi melalui menu Aktivasi Akun Baru di pillar.uinssc.ac.id.',
            'attachment_name' => 'Buku_Panduan_LMS_Pillar_Mhs_2026.pdf',
            'attachment_file' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
            'is_pinned' => true,
            'is_published' => true,
            'published_at' => now()->subDays(4),
        ]);

        Announcement::create([
            'title' => 'Pendaftaran Program Bantuan Subsidi Kuota Internet Pembelajaran Siber Kemenag RI',
            'slug' => 'pendaftaran-subsidi-kuota-internet-kemenag-2026',
            'category' => 'Kemahasiswaan',
            'content' => 'Mahasiswa aktif PJJ yang memenuhi kriteria dapat memvalidasi nomor handphone aktif di menu Profil Mahasiswa selambat-lambatnya tanggal 30 September 2026 guna sinkronisasi data bantuan kuota belajar.',
            'attachment_name' => 'Juknis_Bantuan_Kuota_PJJ.pdf',
            'attachment_file' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
            'is_pinned' => false,
            'is_published' => true,
            'published_at' => now()->subDays(8),
        ]);

        // 8. Services / Layanan & Fasilitas
        $services = [
            [
                'title' => 'LMS Pillar (Platform Pembelajaran Mandiri)',
                'slug' => 'lms-pillar',
                'category' => 'LMS & Cyber Platform',
                'short_description' => 'Sistem Manajemen Pembelajaran digital interaktif dengan fitur micro-learning, video modul, forum asinkron, dan auto-grading.',
                'content' => 'LMS Pillar dirancang khusus untuk kenyamanan belajar mandiri mahasiswa PJJ. Dilengkapi fitur tracking progress belajar, kuis interaktif, materi berbasis multimedia, dan repositori bahan bacaan lengkap.',
                'icon' => 'layout',
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=800&auto=format&fit=crop',
                'portal_url' => 'https://pillar.uinssc.ac.id',
                'button_text' => 'Buka LMS Pillar',
                'order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'Studio Produksi Multimedia & Penyiaran MOOC',
                'slug' => 'studio-multimedia-mooc',
                'category' => 'Studio Multimedia',
                'short_description' => 'Fasilitas studio rekaman audio-visual berstandar broadcast untuk pembuatan video kuliah, podcast akademik, dan live webinar.',
                'content' => 'Dilengkapi green screen 4K, teleprompter canggih, soundproof akustik profesional, serta tim multimedia berpengalaman yang mendampingi dosen dalam memproduksi video ajar beresolusi tinggi.',
                'icon' => 'video',
                'image' => 'https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?q=80&w=800&auto=format&fit=crop',
                'portal_url' => null,
                'button_text' => 'Lihat Fasilitas Studio',
                'order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'Helpdesk Terpadu & Careline 24/7',
                'slug' => 'helpdesk-terpadu',
                'category' => 'Helpdesk & Training',
                'short_description' => 'Layanan bantuan teknis dan customer service responsif siap membantu dosen dan mahasiswa kapan saja.',
                'content' => 'Kanal bantuan komprehensif melalui live chat WhatsApp, email ticketing, dan tutorial step-by-step untuk mengatasi kendala login, akses materi, hingga sinkronisasi data akademik.',
                'icon' => 'headphones',
                'image' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=800&auto=format&fit=crop',
                'portal_url' => 'https://helpdesk.uinssc.ac.id',
                'button_text' => 'Hubungi Helpdesk',
                'order' => 3,
                'is_featured' => true,
            ],
            [
                'title' => 'Laboratorium Komputer Siber & Virtual Classroom',
                'slug' => 'lab-siber-virtual-classroom',
                'category' => 'LMS & Cyber Platform',
                'short_description' => 'Infrastruktur cloud server dan server streaming berkecepatan tinggi untuk ujian CBT daring dan webinar interaktif.',
                'content' => 'Server berkapasitas ribuan concurrent user dengan sistem load balancing dan disaster recovery mutakhir guna memastikan ujian semester dan kuliah daring sinkron berlangsung lancar.',
                'icon' => 'server',
                'image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?q=80&w=800&auto=format&fit=crop',
                'portal_url' => null,
                'button_text' => 'Info Infrastruktur',
                'order' => 4,
                'is_featured' => false,
            ],
            [
                'title' => 'Pengembangan Bahan Ajar Modular Digital',
                'slug' => 'pengembangan-bahan-ajar-modular',
                'category' => 'Akademik',
                'short_description' => 'Layanan pendampingan kurikulum dan standarisasi buku modul digital, e-comic edukasi, dan materi interaktif SCORM.',
                'content' => 'Membantu dosen dalam menyusun modul pembelajaran terstandarisasi yang terintegrasi dengan capaian pembelajaran lulusan (CPL) dan akreditasi internasional.',
                'icon' => 'book-open',
                'image' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?q=80&w=800&auto=format&fit=crop',
                'portal_url' => null,
                'button_text' => 'Panduan Bahan Ajar',
                'order' => 5,
                'is_featured' => false,
            ],
            [
                'title' => 'Aplikasi Mobile SiberGo!',
                'slug' => 'aplikasi-mobile-sibergo',
                'category' => 'LMS & Cyber Platform',
                'short_description' => 'Aplikasi Android & iOS resmi untuk kemudahan akses presensi, notifikasi tugas, dan jadwal kuliah daring.',
                'content' => 'Pantau seluruh aktivitas akademik perkuliahan PJJ langsung dari smartphone dengan notifikasi real-time dan mode hemat kuota data.',
                'icon' => 'smartphone',
                'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?q=80&w=800&auto=format&fit=crop',
                'portal_url' => 'https://play.google.com/store/apps/details?id=com.uinssc.pustikom.sibergo',
                'button_text' => 'Unduh di Play Store',
                'order' => 6,
                'is_featured' => false,
            ],
        ];

        foreach ($services as $srv) {
            Service::create($srv);
        }

        // 9. Team Members (Struktur Organisasi & Tim UPT PJJ)
        $teams = [
            [
                'name' => 'Dr. Moh. Ali, M.Pd.I',
                'title' => 'Kepala UPT Pendidikan Jarak Jauh',
                'nip' => '197608122005011004',
                'division' => 'Pimpinan',
                'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=600&auto=format&fit=crop',
                'bio' => 'Doktor di bidang Teknologi Pendidikan Islam, memimpin transformasi penyelenggaraan cyber campus dan inovasi pedagogi jarak jauh UINSSC.',
                'email' => 'moh.ali@uinssc.ac.id',
                'phone' => '+6281222334455',
                'order' => 1,
            ],
            [
                'name' => 'Dr. H. Ahmad Asmuni, M.Ag',
                'title' => 'Koordinator Divisi Kurikulum & Bahan Ajar',
                'nip' => '197305141999031002',
                'division' => 'Divisi Kurikulum & Bahan Ajar',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=600&auto=format&fit=crop',
                'bio' => 'Bertanggung jawab atas standarisasi RPS, modul SCORM, micro-learning, dan penjaminan mutu konten akademik PJJ.',
                'email' => 'ahmad.asmuni@uinssc.ac.id',
                'phone' => '+6281333445566',
                'order' => 2,
            ],
            [
                'name' => 'Fahmi Hidayat, M.Kom',
                'title' => 'Koordinator Divisi IT, LMS & Infrastruktur Cloud',
                'nip' => '198804152015031003',
                'division' => 'Divisi IT & LMS',
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=600&auto=format&fit=crop',
                'bio' => 'Ahli arsitektur cloud dan pengembangan platform e-learning, mengelola reliabilitas LMS Pillar dan keamanan siber sistem kampus.',
                'email' => 'fahmi.h@uinssc.ac.id',
                'phone' => '+6281555667788',
                'order' => 3,
            ],
            [
                'name' => 'Rizky Pratama, M.Sn',
                'title' => 'Koordinator Divisi Multimedia & Studio MOOC',
                'nip' => '199109202019031005',
                'division' => 'Divisi Multimedia & Penyiaran',
                'photo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?q=80&w=600&auto=format&fit=crop',
                'bio' => 'Spesialis video produksi dan animasi edukasi, memimpin produksi ribuan video ajar beresolusi tinggi di Studio Siber UPT PJJ.',
                'email' => 'rizky.p@uinssc.ac.id',
                'phone' => '+6281777889900',
                'order' => 4,
            ],
            [
                'name' => 'Siti Nurhaliza, S.Sos',
                'title' => 'Sekretariat & Koordinator Layanan Mahasiswa PJJ',
                'nip' => '199411082020122010',
                'division' => 'Administrasi & Layanan',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=600&auto=format&fit=crop',
                'bio' => 'Mengelola pelayanan administrasi kemahasiswaan, verifikasi berkas PMB, serta koordinasi helpdesk 24/7.',
                'email' => 'siti.nurhaliza@uinssc.ac.id',
                'phone' => '+6281999001122',
                'order' => 5,
            ],
        ];

        foreach ($teams as $tm) {
            TeamMember::create($tm);
        }

        // 10. Download Documents
        $docs = [
            [
                'title' => 'Pedoman Akademik Pendidikan Jarak Jauh (PJJ) T.A. 2026/2027',
                'slug' => 'pedoman-akademik-pjj-2026-2027',
                'category' => 'Pedoman Akademik',
                'description' => 'Buku pedoman resmi mengenai peraturan perkuliahan, konversi nilai, ujian daring, dan kelulusan program PJJ UINSSC.',
                'file_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                'file_type' => 'PDF',
                'file_size' => '3.8 MB',
                'downloads_count' => 1845,
                'order' => 1,
            ],
            [
                'title' => 'Buku Manual Panduan LMS Pillar untuk Mahasiswa (Edisi 3.0)',
                'slug' => 'panduan-lms-pillar-mahasiswa-v3',
                'category' => 'Panduan LMS',
                'description' => 'Petunjuk lengkap cara aktivasi akun, mengikuti forum diskusi, submit tugas modul, dan pengerjaan kuis di LMS Pillar.',
                'file_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                'file_type' => 'PDF',
                'file_size' => '5.2 MB',
                'downloads_count' => 3210,
                'order' => 2,
            ],
            [
                'title' => 'Panduan Teknis Dosen Pengampu PJJ: Pengelolaan Kelas & Penilaian Daring',
                'slug' => 'panduan-dosen-pjj-lms-pillar',
                'category' => 'Panduan LMS',
                'description' => 'Tata cara pembuatan modul SCORM, pengaturan rubrik penilaian, presensi otomatis, dan webinar di LMS Pillar.',
                'file_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                'file_type' => 'PDF',
                'file_size' => '4.1 MB',
                'downloads_count' => 640,
                'order' => 3,
            ],
            [
                'title' => 'SK Rektor Penyelenggaraan Pendidikan Jarak Jauh UIN Siber Syekh Nurjati Cirebon',
                'slug' => 'sk-rektor-penyelenggaraan-pjj-uinssc',
                'category' => 'SK & Regulasi',
                'description' => 'Surat Keputusan Rektor tentang landasan hukum, tata kelola, dan struktur operasional UPT PJJ.',
                'file_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                'file_type' => 'PDF',
                'file_size' => '2.4 MB',
                'downloads_count' => 910,
                'order' => 4,
            ],
            [
                'title' => 'Brosur & Panduan Penerimaan Mahasiswa Baru (PMB) Jalur PJJ 2026/2027',
                'slug' => 'brosur-pmb-jalur-pjj-2026',
                'category' => 'Brosur PMB',
                'description' => 'Informasi syarat pendaftaran, biaya UKT, alur seleksi, serta profil prodi PJJ S1 dan S2.',
                'file_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                'file_type' => 'PDF',
                'file_size' => '8.6 MB',
                'downloads_count' => 4520,
                'order' => 5,
            ],
        ];

        foreach ($docs as $doc) {
            DownloadDocument::create($doc);
        }

        // 11. FAQs
        $faqs = [
            [
                'question' => 'Apakah ijazah lulusan PJJ sama dengan ijazah perkuliahan reguler tatap muka?',
                'answer' => 'Ya, sama persis. Ijazah yang diterbitkan oleh UIN Siber Syekh Nurjati Cirebon untuk program PJJ memiliki status hukum, legalitas, hak akademik, dan pengakuan yang setara dengan program reguler tatap muka, serta terdaftar resmi di Pangkalan Data Pendidikan Tinggi (PDDikti) Kemendikbudristek dan Kemenag RI.',
                'category' => 'Umum',
                'order' => 1,
            ],
            [
                'question' => 'Bagaimana sistem perkuliahan di PJJ UINSSC berlangsung?',
                'answer' => 'Perkuliahan diselenggarakan secara fleksibel melalui LMS Pillar (100% online). Mahasiswa belajar melalui bahan ajar modular, rekaman video dosen, podcast akademik, forum diskusi asinkron yang dapat diakses 24 jam sehari, serta sesi tatap maya berkala (sinkron) yang terjadwal.',
                'category' => 'LMS & Perkuliahan',
                'order' => 2,
            ],
            [
                'question' => 'Siapa saja yang dapat mendaftar kuliah di Program PJJ UINSSC?',
                'answer' => 'Program PJJ terbuka bagi lulusan SMA/SMK/MA/Pesantren sederajat dari seluruh wilayah Indonesia maupun luar negeri, termasuk guru madrasah, aparatur sipil negara, karyawan swasta, wirausahawan, serta siapa saja yang ingin melanjutkan kuliah tanpa kendala jarak dan waktu.',
                'category' => 'PMB & Registrasi',
                'order' => 3,
            ],
            [
                'question' => 'Apakah mahasiswa harus datang ke kampus di Cirebon?',
                'answer' => 'Seluruh proses pendaftaran, perkuliahan, pengerjaan tugas, bimbingan, hingga ujian akhir semester dilakukan secara online. Mahasiswa hanya diundang hadir ke kampus saat prosesi Wisuda, namun wisuda juga menyediakan opsi hybrid daring bagi mahasiswa yang berdomisili jauh.',
                'category' => 'Umum',
                'order' => 4,
            ],
            [
                'question' => 'Bagaimana jika saya mengalami kendala teknis saat mengakses LMS Pillar?',
                'answer' => 'UPT PJJ menyediakan layanan Helpdesk Terpadu dan tim Mahasiswa Care yang siap melayani 24/7 melalui WhatsApp, live chat, dan email tiket untuk membantu menyelesaikan setiap kendala teknis Anda.',
                'category' => 'LMS & Perkuliahan',
                'order' => 5,
            ],
            [
                'question' => 'Berapa biaya kuliah (UKT) di program PJJ UINSSC dan bagaimana sistem pembayarannya?',
                'answer' => 'Biaya pendidikan di UPT PJJ UINSSC sangat terjangkau karena disubsidi oleh pemerintah melalui skema BLU dan Kemenag. Pembayaran dapat dilakukan secara online melalui Virtual Account berbagai bank nasional, transfer ATM, hingga mobile banking.',
                'category' => 'Biaya & Pembayaran',
                'order' => 6,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        // 12. Gallery Items (Sarana & Prasarana Kampus Siber)
        $galleries = [
            [
                'title' => 'Gedung Siber UIN Siber Syekh Nurjati Cirebon',
                'type' => 'image',
                'category' => 'Gedung Siber',
                'media_url' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Pusat operasional dan server backbone pendidikan siber UINSSC dengan fasilitas data center Tier-3.',
                'order' => 1,
            ],
            [
                'title' => 'Studio Rekaman Video & Podcast Multimedia UPT PJJ',
                'type' => 'image',
                'category' => 'Studio Multimedia',
                'media_url' => 'https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Studio penyiaran dengan green screen 4K dan sound acoustics profesional untuk pembuatan modul ajar MOOC.',
                'order' => 2,
            ],
            [
                'title' => 'Laboratorium Komputer & Server Monitoring Room',
                'type' => 'image',
                'category' => 'Lab Komputer',
                'media_url' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Pusat pemantauan lalu lintas data LMS Pillar, stabilitas ujian CBT online, dan keamanan siber.',
                'order' => 3,
            ],
            [
                'title' => 'Kegiatan Bimtek & Refreshment Dosen Pengampu PJJ',
                'type' => 'image',
                'category' => 'Bimtek & Workshop',
                'media_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Pelatihan intensif pengembangan materi interaktif dan evaluasi pembelajaran daring berbasis AI.',
                'order' => 4,
            ],
        ];

        foreach ($galleries as $g) {
            GalleryItem::create($g);
        }

        // 13. Testimonials
        $testimonials = [
            [
                'name' => 'Ust. Mukhlis Ridwan, S.Pd',
                'role_status' => 'Alumni PJJ PAI S1 - Guru Madrasah di Merauke, Papua',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200&auto=format&fit=crop',
                'quote' => 'Kuliah di PJJ UINSSC adalah mukjizat bagi kami para pendidik di pelosok perbatasan. Materi modulnya sangat padat bergizi, aplikasinya mudah dibuka walau sinyal minim, dan dosennya sangat mengayomi. Alhamdulillah kini saya berijazah sarjana resmi!',
                'rating' => 5,
                'order' => 1,
            ],
            [
                'name' => 'Fathimah Azzahra, S.H.',
                'role_status' => 'Mahasiswa PJJ HKI S1 - Pengelola Lembaga Mediasi Syariah',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=200&auto=format&fit=crop',
                'quote' => 'Sistem pembelajaran di LMS Pillar sangat terstruktur dan interaktif. Saya bisa belajar malam hari setelah seharian bertugas, dan diskusi hukum keluarga dengan dosen pakar sangat memperluas wawasan saya.',
                'rating' => 5,
                'order' => 2,
            ],
            [
                'name' => 'Drs. Supriyanto, M.Pd.',
                'role_status' => 'Mahasiswa PJJ S2 PAI - Kepala Madrasah Aliyah di Riau',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=200&auto=format&fit=crop',
                'quote' => 'Program Magister PJJ UINSSC membuktikan bahwa jarak bukan lagi penghalang meraih gelar S2 berkualitas tinggi. Standar penulisan tesis dan bimbingan daringnya sangat ketat dan berstandar internasional.',
                'rating' => 5,
                'order' => 3,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::create($t);
        }

        // 14. Contact Message Samples
        ContactMessage::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad.fauzi@gmail.com',
            'phone' => '+6281233445566',
            'subject' => 'Informasi Pendaftaran PMB PJJ PAI Semester Genap',
            'category' => 'PMB Online',
            'message' => 'Selamat siang admin, saya guru madrasah di Kalimantan Tengah, ingin menanyakan alur pendaftaran jalur rekognisi pembelajaran lampau (RPL) untuk prodi PJJ PAI. Terima kasih.',
            'is_read' => true,
            'admin_reply' => 'Wa\'alaikumsalam Bapak Ahmad. Jalur RPL PJJ PAI dibuka setiap semester. Anda dapat mengunggah portofolio mengajar di pmb.uinssc.ac.id. Informasi lengkap telah kami kirimkan ke email Bapak.',
            'replied_at' => now()->subDay(),
        ]);

        ContactMessage::create([
            'name' => 'Nurul Hidayah',
            'email' => 'nurul.h@gmail.com',
            'phone' => '+6285677889900',
            'subject' => 'Kendala Reset Password LMS Pillar',
            'category' => 'Kendala LMS Pillar',
            'message' => 'Halo tim helpdesk, saya mahasiswa baru PJJ PGMI, ingin konfirmasi reset password karena tidak menerima link verifikasi di email. NIM: 2601020045.',
            'is_read' => false,
        ]);
    }
}
