<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Alter users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('admin')->after('password'); // admin, editor, staf
            $table->string('phone')->nullable()->after('role');
            $table->string('avatar')->nullable()->after('phone');
            $table->text('bio')->nullable()->after('avatar');
            $table->boolean('is_active')->default(true)->after('bio');
        });

        // 2. Settings table (Key-Value configuration for website)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('group')->default('general'); // general, contact, social, profile, branding, academic
            $table->string('type')->default('text'); // text, textarea, richtext, image, boolean
            $table->string('label')->nullable();
            $table->timestamps();
        });

        // 3. Hero Slides / Banner Carousel
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->nullable(); // e.g. "Pusat Pembelajaran Jarak Jauh Siber No.1 PTKIN"
            $table->string('title');
            $table->string('highlight_text')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('image')->nullable();
            $table->string('primary_btn_text')->nullable();
            $table->string('primary_btn_url')->nullable();
            $table->string('secondary_btn_text')->nullable();
            $table->string('secondary_btn_url')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Categories table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->default('berita'); // berita, pengumuman, download, faq
            $table->string('color')->nullable()->default('blue');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 5. Posts / Berita & Artikel
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->integer('views_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->string('tags')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        // 6. Announcements / Pengumuman
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Akademik'); // Akademik, Kemahasiswaan, Beasiswa, Layanan LMS, Umum
            $table->longText('content');
            $table->string('attachment_file')->nullable();
            $table->string('attachment_name')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        // 7. Study Programs / Prodi PJJ
        Schema::create('study_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "PJJ Pendidikan Agama Islam"
            $table->string('slug')->unique();
            $table->string('degree')->default('S1'); // S1, S2
            $table->string('faculty')->default('Fakultas Ilmu Tarbiyah dan Keguruan');
            $table->string('accreditation')->default('Unggul'); // Unggul, Baik Sekali, A, B
            $table->string('code')->nullable(); // e.g. "PAI-PJJ"
            $table->string('head_of_program')->nullable(); // Kaprodi
            $table->string('head_nip')->nullable();
            $table->string('graduate_title')->nullable(); // e.g. "S.Pd."
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('vision_mission')->nullable();
            $table->longText('curriculum')->nullable(); // JSON or rich text of curriculum modules
            $table->longText('career_prospects')->nullable(); // JSON or rich text
            $table->integer('total_credits')->default(144);
            $table->string('study_duration')->default('8 Semester (4 Tahun)');
            $table->string('learning_method')->default('100% Online Asinkron & Sinkron via LMS Pillar');
            $table->string('tuition_info')->nullable();
            $table->string('image')->nullable();
            $table->string('brochure_file')->nullable();
            $table->string('registration_url')->nullable();
            $table->string('website_url')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 8. Services / Layanan & Fasilitas
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Layanan Digital'); // Layanan Digital, Studio Multimedia, Akademik, Pelatihan & Helpdesk
            $table->text('short_description')->nullable();
            $table->longText('content')->nullable();
            $table->string('icon')->default('monitor'); // lucide icon identifier
            $table->string('image')->nullable();
            $table->string('portal_url')->nullable();
            $table->string('button_text')->default('Akses Layanan');
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 9. Team Members / Struktur Organisasi & Pengelola
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title'); // Jabatan: Kepala UPT, Sekretaris, Koordinator IT, dll.
            $table->string('nip')->nullable();
            $table->string('division')->default('Pimpinan'); // Pimpinan, Divisi Kurikulum, Divisi IT & LMS, Divisi Multimedia, Staf Administrasi
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->json('social_links')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 10. Download Documents / Unduhan
        Schema::create('download_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Panduan LMS'); // Pedoman Akademik, Panduan LMS, SK & Regulasi, Template & Format, Brosur PMB
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->string('file_type')->default('pdf');
            $table->string('file_size')->default('1.5 MB');
            $table->integer('downloads_count')->default(0);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 11. FAQs
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->longText('answer');
            $table->string('category')->default('Umum'); // Umum, PMB & Registrasi, LMS Pillar & Perkuliahan, Biaya & Pembayaran, Ujian & Kelulusan
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 12. Gallery / Sarana Prasarana & Multimedia
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->default('image'); // image, video, virtual_tour
            $table->string('category')->default('Gedung Siber'); // Gedung Siber, Studio Multimedia, Lab Komputer, Bimtek & Workshop, Wisuda & Kuliah Umum
            $table->string('media_url');
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // 13. Contact & Helpdesk Messages
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->string('category')->default('Pertanyaan Umum'); // Pertanyaan Umum, PMB Online, Kendala LMS Pillar, Layanan Mahasiswa, Kerjasama
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->text('admin_reply')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->timestamps();
        });

        // 14. Testimonials
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role_status'); // e.g. "Mahasiswa PJJ PAI S1 - Guru Madrasah di Jayapura"
            $table->string('avatar')->nullable();
            $table->text('quote');
            $table->integer('rating')->default(5);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('download_documents');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('services');
        Schema::dropIfExists('study_programs');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('hero_slides');
        Schema::dropIfExists('settings');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'avatar', 'bio', 'is_active']);
        });
    }
};
