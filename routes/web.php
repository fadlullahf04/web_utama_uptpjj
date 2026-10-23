<?php

use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DownloadController as AdminDownloadController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\HeroSlideController as AdminHeroSlideController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\StudyProgramController as AdminStudyProgramController;
use App\Http\Controllers\Admin\TeamMemberController as AdminTeamMemberController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LmsGuideController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StudyProgramController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes (UPT PJJ UINSSC Portal)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.xml');
Route::get('/sitemap', [SitemapController::class, 'index'])->name('sitemap');

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
    Route::post('/', [ContactController::class, 'store'])->name('store')->middleware('throttle:5,1');
});

// Dynamic Pages (Halaman Dinamis)
Route::get('/halaman/{slug}', [PageController::class, 'show'])->name('pages.show');
Route::get('/p/{slug}', [PageController::class, 'show'])->name('pages.show_short');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| CMS Admin Panel Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Posts XML Import & Template
    Route::get('/posts/import/xml', [AdminPostController::class, 'showImport'])->name('posts.import');
    Route::post('/posts/import/xml', [AdminPostController::class, 'importXml'])->name('posts.import.process')->middleware('throttle:10,1');
    Route::get('/posts/template/xml', [AdminPostController::class, 'downloadXmlTemplate'])->name('posts.template.xml');

    // Posts / Berita
    Route::post('/posts/upload-image', [AdminPostController::class, 'uploadContentImage'])->name('posts.upload_image');
    Route::resource('posts', AdminPostController::class);

    // Categories
    Route::resource('categories', AdminCategoryController::class)->except(['create', 'edit', 'show']);

    // Announcements / Pengumuman
    Route::resource('announcements', AdminAnnouncementController::class)->except(['show']);

    // Dynamic Pages / Halaman Dinamis
    Route::resource('pages', AdminPageController::class)->except(['show']);

    // Admin & Editor Only: Contact Messages / Helpdesk Inbox
    Route::middleware(['role:admin,editor'])->group(function () {
        Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
        Route::post('/contacts/{contact}/reply', [AdminContactController::class, 'reply'])->name('contacts.reply');
        Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
    });

    // Super Admin Only: Programs, Services, Slides, Team, Downloads, FAQs, Gallery, Testimonials, Settings & Users Management
    Route::middleware(['role:admin'])->group(function () {
        // Dynamic Menu Builder / Navigasi
        Route::get('/menus', [AdminMenuController::class, 'index'])->name('menus.index');
        Route::post('/menus', [AdminMenuController::class, 'store'])->name('menus.store');
        Route::put('/menus/{menu}', [AdminMenuController::class, 'update'])->name('menus.update');
        Route::delete('/menus/{menu}', [AdminMenuController::class, 'destroy'])->name('menus.destroy');
        Route::post('/menus/{menu}/move/{direction}', [AdminMenuController::class, 'move'])->name('menus.move');
        Route::post('/menus/seed-defaults', [AdminMenuController::class, 'seedDefaults'])->name('menus.seed_defaults');

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
        Route::resource('gallery', AdminGalleryController::class)->except(['create', 'edit', 'show']);

        // Testimonials
        Route::resource('testimonials', AdminTestimonialController::class)->except(['create', 'edit', 'show']);

        // Settings & Users Management
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
        Route::resource('users', AdminUserController::class)->except(['create', 'edit', 'show']);
    });
});
