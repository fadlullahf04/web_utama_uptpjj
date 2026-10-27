<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - CMS UPT PJJ UINSSC</title>
    
    <!-- Favicon / Tab Icons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Noto+Kufi+Arabic:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        @if(app()->getLocale() === 'ar')
            html, body {
                font-family: 'Noto Kufi Arabic', 'Plus Jakarta Sans', sans-serif !important;
            }
        @endif
    </style>
    @stack('styles')
</head>
<body class="h-full bg-slate-100 text-slate-800 font-sans antialiased selection:bg-[#006837] selection:text-white" x-data="{ sidebarOpen: false }">

    <div class="min-h-full flex">
        
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"></div>

        <!-- Sidebar Navigation -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto lg:flex">
            
            <!-- Sidebar Header / Logo -->
            <div class="h-20 flex items-center justify-center px-4 border-b border-slate-100 bg-white">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center w-full">
                    <img src="{{ asset('images/logo_uptpjj.png') }}" alt="CMS UPT PJJ UINSSC" class="h-10 max-w-[200px] w-auto object-contain">
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1">
                
                <div class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Utama</div>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-chart-pie text-sm {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-emerald-600' }}"></i> Dashboard Overview
                </a>

                <div class="pt-4 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Publikasi & Konten</div>
                
                <a href="{{ route('admin.posts.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.posts.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-newspaper text-sm {{ request()->routeIs('admin.posts.*') ? 'text-white' : 'text-emerald-600' }}"></i> Berita & Artikel
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full {{ request()->routeIs('admin.posts.*') ? 'bg-black/20 text-white' : 'bg-slate-100 text-slate-600' }} font-bold">{{ \App\Models\Post::count() }}</span>
                </a>


                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.categories.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-tags text-sm {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-emerald-600' }}"></i> Kategori Artikel
                </a>

                <a href="{{ route('admin.pages.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.pages.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-file-lines text-sm {{ request()->routeIs('admin.pages.*') ? 'text-white' : 'text-emerald-600' }}"></i> Halaman Dinamis
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full {{ request()->routeIs('admin.pages.*') ? 'bg-black/20 text-white' : 'bg-slate-100 text-slate-600' }} font-bold">{{ \App\Models\Page::count() }}</span>
                </a>

                <a href="{{ route('admin.announcements.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.announcements.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-bullhorn text-sm {{ request()->routeIs('admin.announcements.*') ? 'text-white' : 'text-amber-600' }}"></i> Pengumuman
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full {{ request()->routeIs('admin.announcements.*') ? 'bg-black/20 text-white' : 'bg-slate-100 text-slate-600' }} font-bold">{{ \App\Models\Announcement::count() }}</span>
                </a>

                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.slides.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.slides.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-images text-sm {{ request()->routeIs('admin.slides.*') ? 'text-white' : 'text-emerald-600' }}"></i> Banner / Hero Slider
                </a>

                <div class="pt-4 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Akademik & Layanan</div>
                
                <a href="{{ route('admin.programs.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.programs.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-graduation-cap text-sm {{ request()->routeIs('admin.programs.*') ? 'text-white' : 'text-emerald-600' }}"></i> Program Studi PJJ
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full {{ request()->routeIs('admin.programs.*') ? 'bg-black/20 text-white' : 'bg-emerald-100 text-emerald-800' }} font-bold">{{ \App\Models\StudyProgram::count() }}</span>
                </a>

                <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.services.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-server text-sm {{ request()->routeIs('admin.services.*') ? 'text-white' : 'text-emerald-600' }}"></i> Layanan & Fasilitas
                </a>

                <a href="{{ route('admin.downloads.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.downloads.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-file-arrow-down text-sm {{ request()->routeIs('admin.downloads.*') ? 'text-white' : 'text-amber-600' }}"></i> Unduhan Dokumen
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full {{ request()->routeIs('admin.downloads.*') ? 'bg-black/20 text-white' : 'bg-slate-100 text-slate-600' }} font-bold">{{ \App\Models\DownloadDocument::count() }}</span>
                </a>
                @endif

                @if(auth()->user()->isAdmin() || auth()->user()->isEditor())
                <div class="pt-4 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Profil & Interaksi</div>
                
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.team.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.team.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-users-gear text-sm {{ request()->routeIs('admin.team.*') ? 'text-white' : 'text-emerald-600' }}"></i> Tim & Struktur UPT
                </a>

                <a href="{{ route('admin.gallery.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.gallery.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-photo-film text-sm {{ request()->routeIs('admin.gallery.*') ? 'text-white' : 'text-amber-600' }}"></i> Galeri & Gedung Siber
                </a>

                <a href="{{ route('admin.faqs.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.faqs.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-circle-question text-sm {{ request()->routeIs('admin.faqs.*') ? 'text-white' : 'text-emerald-600' }}"></i> Tanya Jawab (FAQs)
                </a>

                <a href="{{ route('admin.testimonials.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.testimonials.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-comment-dots text-sm {{ request()->routeIs('admin.testimonials.*') ? 'text-white' : 'text-emerald-600' }}"></i> Testimoni Mahasiswa
                </a>
                @endif

                <a href="{{ route('admin.contacts.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.contacts.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-inbox text-sm {{ request()->routeIs('admin.contacts.*') ? 'text-white' : 'text-red-500' }}"></i> Pesan & Helpdesk
                    </div>
                    @php $unread = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                    @if($unread > 0)
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-red-500 text-white font-bold animate-pulse">{{ $unread }}</span>
                    @endif
                </a>
                @endif

                @if(auth()->user()->isAdmin())
                <div class="pt-4 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Pengaturan Sistem</div>
                
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.settings.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-sliders text-sm {{ request()->routeIs('admin.settings.*') ? 'text-white' : 'text-slate-400' }}"></i> Pengaturan Situs
                </a>

                <a href="{{ route('admin.menus.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.menus.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-compass text-sm {{ request()->routeIs('admin.menus.*') ? 'text-white' : 'text-emerald-600' }}"></i> Menu Builder
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full {{ request()->routeIs('admin.menus.*') ? 'bg-black/20 text-white' : 'bg-emerald-100 text-emerald-800' }} font-bold">{{ \App\Models\MenuItem::count() }}</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.users.*') ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-user-shield text-sm {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400' }}"></i> Manajemen Admin
                </a>
                @endif

            </div>

            <!-- Sidebar Footer / Quick View Site Link -->
            <div class="p-4 border-t border-slate-100">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-slate-50 hover:bg-[#006837] text-slate-700 hover:text-white font-semibold text-xs transition border border-slate-200 hover:border-[#006837]">
                    <i class="fa-solid fa-arrow-up-right-from-square text-amber-600"></i> Lihat Website Utama
                </a>
            </div>
        </aside>

        <!-- Main Admin Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-100">
            
            <!-- Admin Top Navigation Bar -->
            <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 relative z-30">
                
                <!-- Left: Sidebar Toggle & Page Title / Breadcrumb -->
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 lg:hidden">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900 tracking-tight">@yield('header_title', 'Dashboard')</h1>
                        <p class="text-xs text-slate-500">@yield('header_subtitle', 'Panel Pengelolaan Konten Portal UPT PJJ UINSSC')</p>
                    </div>
                </div>

                <!-- Right: Quick Action, Site Link & Profile Dropdown -->
                <div class="flex items-center gap-2.5 sm:gap-3">
                    
                    <!-- Admin Language Switcher -->
                    @include('partials.language-switcher', ['variant' => 'light'])

                    <a href="{{ route('admin.posts.create') }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs shadow-md transition">
                        <i class="fa-solid fa-plus"></i> Tambah Berita
                    </a>

                    <!-- User Profile Dropdown -->
                    <div class="relative" x-data="{ userMenu: false }">
                        <button @click="userMenu = !userMenu" class="flex items-center gap-3 p-1.5 rounded-xl hover:bg-slate-100 transition">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-9 h-9 rounded-lg object-cover border border-emerald-500/40">
                            <div class="text-left hidden md:block">
                                <div class="text-xs font-bold text-slate-800">{{ auth()->user()->name }}</div>
                                <div class="text-[10px] text-[#006837] capitalize font-semibold">{{ auth()->user()->role }}</div>
                            </div>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                        </button>

                        <div x-show="userMenu" x-cloak @click.away="userMenu = false" class="absolute {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} mt-2 w-56 bg-white border border-slate-200 rounded-xl shadow-2xl py-2 z-50">
                            <div class="px-4 py-2 border-b border-slate-100">
                                <div class="text-xs font-bold text-slate-900">{{ auth()->user()->name }}</div>
                                <div class="text-[11px] text-slate-500 truncate">{{ auth()->user()->email }}</div>
                            </div>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 transition">
                                <i class="fa-solid fa-gear text-slate-400"></i> Pengaturan
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar (Logout)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Page Content Body -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-slate-100">
                
                <!-- Flash Alerts -->
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-medium flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-triangle-exclamation text-red-600 text-base"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs">
                        <div class="font-bold mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-circle-exclamation text-red-600"></i> Terdapat kesalahan pengisian formulir:
                        </div>
                        <ul class="list-disc list-inside space-y-0.5 text-red-700">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
