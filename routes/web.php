<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LmsGuideController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\StudyProgramController as AdminStudyProgramController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\HeroSlideController as AdminHeroSlideController;
use App\Http\Controllers\Admin\TeamMemberController as AdminTeamMemberController;
use App\Http\Controllers\Admin\DownloadController as AdminDownloadController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes (UPT PJJ UINSSC Portal)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Profile Sub-pages
Route::prefix('profil')->name('profile.')->group(function () {
    Route::get('/selayang-pandang', [ProfileController::class, 'overview'])->name('overview');
    Route::get('/visi-dan-misi', [ProfileController::class, 'visionMission'])->name('vision-mission');
    Route::get('/struktur-organisasi', [ProfileController::class, 'organization'])->name('organization');
    Route::get('/tim-upt-pjj', [ProfileController::class, 'team'])->name('team');
    Route::get('/sarana-dan-prasarana', [ProfileController::class, 'facilities'])->name('facilities');
    Route::get('/profil-lulusan', [ProfileController::class, 'graduateProfile'])->name('graduate-profile');
    Route::get('/video-profile', [ProfileController::class, 'videoProfile'])->name('video-profile');
});

// Study Programs (Prodi PJJ)
Route::prefix('prodi')->name('programs.')->group(function () {
    Route::get('/', [StudyProgramController::class, 'index'])->name('index');
    Route::get('/{slug}', [StudyProgramController::class, 'show'])->name('show');
});

// Services & Facilities (Layanan PJJ)
Route::prefix('layanan')->name('services.')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::get('/{slug}', [ServiceController::class, 'show'])->name('show');
});

// News & Articles (Berita & Informasi)
Route::prefix('berita')->name('posts.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/{slug}', [PostController::class, 'show'])->name('show');
});

// Announcements (Pengumuman)
Route::prefix('pengumuman')->name('announcements.')->group(function () {
    Route::get('/', [AnnouncementController::class, 'index'])->name('index');
    Route::get('/{slug}', [AnnouncementController::class, 'show'])->name('show');
});

// Downloads (Unduhan)
Route::prefix('downloads')->name('downloads.')->group(function () {
    Route::get('/', [DownloadController::class, 'index'])->name('index');
    Route::get('/unduh/{id}', [DownloadController::class, 'download'])->name('file');
});

// FAQs
Route::get('/faqs', [FaqController::class, 'index'])->name('faqs');

// LMS Pillar Guide & Tutorials
Route::get('/panduan-lms', [LmsGuideController::class, 'index'])->name('lms-guide');
Route::get('/course-tutorial-penggunaan-lms-pilar-upt-pjj-uin-siber-syekh-nurjati-cirebon', [LmsGuideController::class, 'index'])->name('lms-guide.alias');

// Contact & Helpdesk
Route::prefix('kontak')->name('contact.')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::post('/', [ContactController::class, 'store'])->name('store');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| CMS Admin Panel Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Posts / Berita
    Route::resource('posts', AdminPostController::class);
    
    // Categories
    Route::resource('categories', AdminCategoryController::class)->except(['create', 'edit', 'show']);

    // Announcements / Pengumuman
    Route::resource('announcements', AdminAnnouncementController::class)->except(['show']);

    // Study Programs / Prodi PJJ
    Route::resource('programs', AdminStudyProgramController::class)->except(['show']);

    // Services / Layanan
    Route::resource('services', AdminServiceController::class)->except(['show']);

    // Hero Slides / Banner
    Route::resource('slides', AdminHeroSlideController::class)->except(['show']);

    // Team Members / Struktur
    Route::resource('team', AdminTeamMemberController::class)->except(['show']);

    // Downloads / Dokumen
    Route::resource('downloads', AdminDownloadController::class)->except(['show']);

    // FAQs
    Route::resource('faqs', AdminFaqController::class)->except(['create', 'edit', 'show']);

    // Gallery
    Route::resource('gallery', AdminGalleryController::class)->except(['create', 'edit', 'show', 'update']);

    // Contact Messages / Helpdesk Inbox
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::post('/contacts/{contact}/reply', [AdminContactController::class, 'reply'])->name('contacts.reply');
    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');

    // Testimonials
    Route::resource('testimonials', AdminTestimonialController::class)->except(['create', 'edit', 'show']);

    // Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Users Management
    Route::resource('users', AdminUserController::class)->except(['create', 'edit', 'show']);
});
