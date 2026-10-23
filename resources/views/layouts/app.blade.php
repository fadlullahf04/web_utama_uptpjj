<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UPT Pendidikan Jarak Jauh - UIN Siber Syekh Nurjati Cirebon')</title>
    <meta name="description" content="@yield('meta_description', 'Portal Resmi Unit Pelaksana Teknis Pendidikan Jarak Jauh (UPT PJJ) UIN Siber Syekh Nurjati Cirebon. World Class Cyber Islamic University.')">
    <meta name="keywords" content="@yield('meta_keywords', 'UPT PJJ, UINSSC, PJJ UIN Cirebon, Kuliah Online, Cyber Islamic University, LMS Pillar, PMB PJJ, S1 PAI PJJ, S2 PAI PJJ')">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon / Tab Icons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Open Graph (Facebook / WhatsApp / LinkedIn) -->
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="@yield('meta_type', 'website')">
    <meta property="og:site_name" content="UPT PJJ UIN Siber Syekh Nurjati Cirebon">
    <meta property="og:title" content="@yield('title', 'UPT Pendidikan Jarak Jauh - UIN Siber Syekh Nurjati Cirebon')">
    <meta property="og:description" content="@yield('meta_description', 'Portal Resmi Unit Pelaksana Teknis Pendidikan Jarak Jauh (UPT PJJ) UIN Siber Syekh Nurjati Cirebon. World Class Cyber Islamic University.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('meta_image', asset('images/logo_uptpjj.png'))">

    <!-- Twitter / X Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'UPT Pendidikan Jarak Jauh - UIN Siber Syekh Nurjati Cirebon')">
    <meta name="twitter:description" content="@yield('meta_description', 'Portal Resmi Unit Pelaksana Teknis Pendidikan Jarak Jauh (UPT PJJ) UIN Siber Syekh Nurjati Cirebon. World Class Cyber Islamic University.')">
    <meta name="twitter:image" content="@yield('meta_image', asset('images/logo_uptpjj.png'))">

    <!-- Schema.org Organization Structured Data -->
    <script type="application/ld+json">
    {
        "{{ '@context' }}": "https://schema.org",
        "@type": "EducationalOrganization",
        "name": "UPT Pendidikan Jarak Jauh UIN Siber Syekh Nurjati Cirebon",
        "alternateName": "UPT PJJ UINSSC",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/logo_uptpjj.png') }}",
        "email": "{{ \App\Models\Setting::get('email', 'pjj@uinssc.ac.id') }}",
        "telephone": "{{ \App\Models\Setting::get('phone', '(0231) 481264') }}"
    }
    </script>
    @stack('schema')
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased selection:bg-[#006837] selection:text-white" x-data="{ mobileMenu: false, searchModal: false }">

    <!-- 1. Top Bar (Dark University Bar like uptpjj.uinssc.ac.id) -->
    <div class="bg-[#0f172a] text-slate-300 text-xs py-2 px-4 border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3">
            
            <!-- Left Contact & Social Icons -->
            <div class="flex items-center space-x-4 text-xs">
                <a href="mailto:{{ \App\Models\Setting::get('email', 'pjj@uinssc.ac.id') }}" class="hover:text-emerald-400 transition flex items-center gap-1.5" title="Email UPT PJJ">
                    <i class="fa-solid fa-envelope text-emerald-400"></i>
                    <span class="hidden sm:inline">{{ \App\Models\Setting::get('email', 'pjj@uinssc.ac.id') }}</span>
                </a>
                <span class="text-slate-700 hidden sm:inline">|</span>
                <a href="tel:{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('phone', '0231481264')) }}" class="hover:text-emerald-400 transition flex items-center gap-1.5" title="Telepon">
                    <i class="fa-solid fa-phone text-emerald-400"></i>
                    <span class="hidden md:inline">{{ \App\Models\Setting::get('phone', '(0231) 481264') }}</span>
                </a>
                <span class="text-slate-700">|</span>
                <div class="flex items-center space-x-3 text-slate-300">
                    <a href="{{ \App\Models\Setting::get('facebook_url', 'https://facebook.com') }}" target="_blank" class="hover:text-emerald-400 transition" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="{{ \App\Models\Setting::get('twitter_url', 'https://twitter.com') }}" target="_blank" class="hover:text-emerald-400 transition" title="Twitter/X"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="{{ \App\Models\Setting::get('instagram_url', 'https://instagram.com') }}" target="_blank" class="hover:text-emerald-400 transition" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="{{ \App\Models\Setting::get('youtube_url', 'https://youtube.com') }}" target="_blank" class="hover:text-emerald-400 transition" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <!-- Right Quick University Links & Language -->
            <div class="flex items-center space-x-4 text-xs font-medium">
                <a href="https://uinssc.ac.id" target="_blank" class="hover:text-emerald-400 transition hidden md:inline-flex items-center gap-1">
                    <i class="fa-solid fa-building-columns text-emerald-400"></i> UINSSC
                </a>
                <a href="https://info.syekhnurjati.ac.id" target="_blank" class="hover:text-emerald-400 transition hidden lg:inline-flex items-center gap-1">
                    <i class="fa-solid fa-newspaper text-teal-400"></i> Berita Kampus
                </a>
                <a href="{{ \App\Models\Setting::get('pmb_url', 'https://pmb.uinssc.ac.id') }}" target="_blank" class="hover:text-amber-400 transition flex items-center gap-1 text-amber-300 font-semibold">
                    <i class="fa-solid fa-user-graduate"></i> Informasi Penerimaan
                </a>
                <span class="text-slate-700">|</span>
                <!-- Language Selector -->
                <div class="flex items-center gap-1.5 px-2 py-0.5 rounded bg-slate-800/90 text-[11px] text-white font-semibold">
                    <span>🇮🇩 ID</span>
                </div>
                <span class="text-slate-700">|</span>
                <a href="{{ route('login') }}" class="hover:text-emerald-400 transition flex items-center gap-1 text-slate-300" title="Login CMS Admin">
                    <i class="fa-solid fa-lock text-emerald-400"></i> CMS
                </a>
            </div>

        </div>
    </div>

    <!-- 2. Main Navigation Header (Clean White / Frosted with Proportional Spacing) -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/90 shadow-sm transition-all duration-300" id="main-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-3">
                
                <!-- Logo & Official Branding (UINSSC + BLU + CIU Badges & Green Typography) -->
                <a href="{{ route('home') }}" class="flex items-center group shrink-0 py-1">
                    <img src="{{ asset('images/logo_uptpjj.png') }}" alt="Logo UPT Pendidikan Jarak Jauh UIN Siber Syekh Nurjati Cirebon" class="h-10 sm:h-11 md:h-12 w-auto max-w-[240px] sm:max-w-none object-contain transition-transform duration-300 group-hover:scale-[1.02]">
                </a>

                <!-- Desktop Navigation Menu (Proportional, Balanced, Clean Typography, Never Wrapped) -->
                @php
                    $headerNavItems = \App\Models\MenuItem::getTree('header');
                @endphp
                <nav class="hidden lg:flex items-center space-x-0.5 xl:space-x-1.5 2xl:space-x-2">
                    @if($headerNavItems->isNotEmpty())
                        @foreach($headerNavItems as $navItem)
                            @if($navItem->activeChildren->isNotEmpty())
                                <!-- Dropdown Menu -->
                                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                    <button class="whitespace-nowrap px-2.5 xl:px-3 py-2 text-[13px] xl:text-[13.5px] font-semibold rounded-lg transition-colors flex items-center gap-1.5 {{ $navItem->isActiveRoute() ? 'text-[#006837] bg-emerald-50/90 font-bold border-b-2 border-[#006837] rounded-b-none' : 'text-slate-700 hover:text-[#006837] hover:bg-slate-100/70' }}">
                                        @if($navItem->icon)
                                            <i class="{{ $navItem->icon }} text-xs opacity-75"></i>
                                        @endif
                                        <span>{{ $navItem->title }}</span>
                                        @if($navItem->badge)
                                            <span class="text-[9px] px-1.5 py-0.2 rounded-full font-bold bg-{{ $navItem->badge_color }}-100 text-{{ $navItem->badge_color }}-800">{{ $navItem->badge }}</span>
                                        @endif
                                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform" :class="{'rotate-180': open}"></i>
                                    </button>
                                    <div x-show="open" x-cloak 
                                         x-transition:enter="transition ease-out duration-200" 
                                         x-transition:enter-start="opacity-0 translate-y-2" 
                                         x-transition:enter-end="opacity-100 translate-y-0" 
                                         x-transition:leave="transition ease-in duration-150" 
                                         x-transition:leave-start="opacity-100 translate-y-0" 
                                         x-transition:leave-end="opacity-0 translate-y-2" 
                                         class="absolute left-0 mt-1 min-w-[240px] max-w-xs rounded-2xl bg-white border border-slate-200 shadow-2xl py-2 z-50">
                                        @foreach($navItem->activeChildren as $childNav)
                                            <a href="{{ $childNav->getUrl() }}" target="{{ $childNav->target }}" class="flex items-center justify-between px-4 py-2 text-xs font-semibold text-slate-700 hover:text-[#006837] hover:bg-emerald-50/80 transition">
                                                <span class="flex items-center gap-2.5 truncate">
                                                    @if($childNav->icon)
                                                        <i class="{{ $childNav->icon }} text-[#006837] w-4 text-center"></i>
                                                    @else
                                                        <i class="fa-solid fa-angle-right text-emerald-600 w-4 text-center text-[10px]"></i>
                                                    @endif
                                                    <span class="truncate">{{ $childNav->title }}</span>
                                                </span>
                                                @if($childNav->badge)
                                                    <span class="text-[9px] px-2 py-0.5 rounded-full font-bold bg-{{ $childNav->badge_color }}-100 text-{{ $childNav->badge_color }}-800 shrink-0 ml-2">{{ $childNav->badge }}</span>
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ $navItem->getUrl() }}" target="{{ $navItem->target }}" class="whitespace-nowrap px-2.5 xl:px-3 py-2 text-[13px] xl:text-[13.5px] font-semibold rounded-lg transition-colors flex items-center gap-1.5 {{ $navItem->isActiveRoute() ? 'text-[#006837] bg-emerald-50/90 font-bold border-b-2 border-[#006837] rounded-b-none' : 'text-slate-700 hover:text-[#006837] hover:bg-slate-100/70' }}">
                                    @if($navItem->icon)
                                        <i class="{{ $navItem->icon }} text-xs opacity-75"></i>
                                    @endif
                                    <span>{{ $navItem->title }}</span>
                                    @if($navItem->badge)
                                        <span class="text-[9px] px-1.5 py-0.2 rounded-full font-bold bg-{{ $navItem->badge_color }}-100 text-{{ $navItem->badge_color }}-800">{{ $navItem->badge }}</span>
                                    @endif
                                </a>
                            @endif
                        @endforeach
                    @else
                        <!-- Fallback Standard Navigation -->
                        <a href="{{ route('home') }}" class="whitespace-nowrap px-2.5 xl:px-3 py-2 text-[13px] font-semibold rounded-lg {{ request()->routeIs('home') ? 'text-[#006837] bg-emerald-50 font-bold' : 'text-slate-700 hover:text-[#006837]' }}">Home</a>
                        <a href="{{ route('profile.overview') }}" class="whitespace-nowrap px-2.5 xl:px-3 py-2 text-[13px] font-semibold rounded-lg text-slate-700 hover:text-[#006837]">Profil</a>
                        <a href="{{ route('programs.index') }}" class="whitespace-nowrap px-2.5 xl:px-3 py-2 text-[13px] font-semibold rounded-lg text-slate-700 hover:text-[#006837]">Prodi PJJ</a>
                        <a href="{{ route('services.index') }}" class="whitespace-nowrap px-2.5 xl:px-3 py-2 text-[13px] font-semibold rounded-lg text-slate-700 hover:text-[#006837]">Layanan</a>
                        <a href="{{ route('announcements.index') }}" class="whitespace-nowrap px-2.5 xl:px-3 py-2 text-[13px] font-semibold rounded-lg text-slate-700 hover:text-[#006837]">Pengumuman</a>
                        <a href="{{ route('faqs') }}" class="whitespace-nowrap px-2.5 xl:px-3 py-2 text-[13px] font-semibold rounded-lg text-slate-700 hover:text-[#006837]">FAQs</a>
                        <a href="{{ route('lms-guide') }}" class="whitespace-nowrap px-2.5 xl:px-3 py-2 text-[13px] font-semibold rounded-lg text-slate-700 hover:text-[#006837]">Course</a>
                        <a href="{{ route('downloads.index') }}" class="whitespace-nowrap px-2.5 xl:px-3 py-2 text-[13px] font-semibold rounded-lg text-slate-700 hover:text-[#006837]">Downloads</a>
                        <a href="{{ route('contact.index') }}" class="whitespace-nowrap px-2.5 xl:px-3 py-2 text-[13px] font-semibold rounded-lg text-slate-700 hover:text-[#006837]">Kontak</a>
                    @endif
                </nav>

                <!-- Action Items (Clean, Proportional Search Button) -->
                <div class="hidden lg:flex items-center shrink-0">
                    <button @click="searchModal = true" class="flex items-center gap-2 px-3 py-2 rounded-xl bg-slate-100/80 hover:bg-emerald-50 text-slate-600 hover:text-[#006837] border border-slate-200/80 transition text-xs font-medium shadow-sm group" title="Pencarian Situs">
                        <i class="fa-solid fa-magnifying-glass text-slate-400 group-hover:text-[#006837] text-xs"></i>
                        <span class="text-slate-500 group-hover:text-[#006837]">Cari</span>
                    </button>
                </div>

                <!-- Mobile Navigation Toggle -->
                <div class="flex items-center gap-2 lg:hidden">
                    <button @click="searchModal = true" class="p-2.5 rounded-xl bg-slate-100 text-slate-700 hover:text-[#006837]">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </button>
                    <button @click="mobileMenu = !mobileMenu" class="p-2.5 rounded-xl bg-slate-100 text-slate-700 hover:text-[#006837] transition">
                        <i class="fa-solid text-lg" :class="mobileMenu ? 'fa-xmark' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div x-show="mobileMenu" x-cloak 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 -translate-y-4" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100 translate-y-0" 
             x-transition:leave-end="opacity-0 -translate-y-4" 
             class="lg:hidden bg-white border-b border-slate-200 px-5 pt-3 pb-6 space-y-3 shadow-2xl max-h-[85vh] overflow-y-auto">
            
            @if(isset($headerNavItems) && $headerNavItems->isNotEmpty())
                @foreach($headerNavItems as $mItem)
                    @if($mItem->activeChildren->isNotEmpty())
                        <div class="rounded-xl border border-slate-200/80 overflow-hidden bg-slate-50/70 transition-all" x-data="{ open: false }">
                            <button @click="open = !open" type="button" class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm font-semibold text-slate-800 hover:bg-slate-100/80 transition-colors">
                                <span class="flex items-center gap-2.5">
                                    @if($mItem->icon)
                                        <i class="{{ $mItem->icon }} text-[#006837] text-xs w-4"></i>
                                    @else
                                        <i class="fa-solid fa-folder text-[#006837] text-xs w-4"></i>
                                    @endif
                                    <span>{{ $mItem->title }}</span>
                                </span>
                                <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-200" :class="{ 'rotate-180 text-[#006837]': open }"></i>
                            </button>
                            <div x-show="open" x-cloak class="px-3 pb-2.5 pt-1 space-y-1 border-t border-slate-200/60 bg-white">
                                @foreach($mItem->activeChildren as $mChild)
                                    <a href="{{ $mChild->getUrl() }}" target="{{ $mChild->target }}" class="flex items-center justify-between pl-3 pr-2 py-1.5 text-xs font-medium text-slate-700 hover:text-[#006837] hover:bg-emerald-50/60 rounded-lg transition">
                                        <span class="flex items-center gap-2 truncate">
                                            @if($mChild->icon)
                                                <i class="{{ $mChild->icon }} text-[#006837] text-[10px] w-3.5"></i>
                                            @else
                                                <i class="fa-solid fa-angle-right text-emerald-600 text-[10px] w-3.5"></i>
                                            @endif
                                            <span class="truncate">{{ $mChild->title }}</span>
                                        </span>
                                        @if($mChild->badge)
                                            <span class="text-[9px] px-1.5 py-0.5 rounded font-bold bg-{{ $mChild->badge_color }}-100 text-{{ $mChild->badge_color }}-800 shrink-0 ml-1">{{ $mChild->badge }}</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $mItem->getUrl() }}" target="{{ $mItem->target }}" class="block px-3 py-2 rounded-lg text-sm font-bold {{ $mItem->isActiveRoute() ? 'bg-emerald-50 text-[#006837]' : 'text-slate-700 hover:bg-slate-50' }}">
                            @if($mItem->icon)
                                <i class="{{ $mItem->icon }} text-[#006837] mr-2"></i>
                            @endif
                            <span>{{ $mItem->title }}</span>
                        </a>
                    @endif
                @endforeach
            @else
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-bold text-slate-700 hover:bg-slate-50">Home</a>
            @endif

            <div class="pt-3 border-t border-slate-200">
                <a href="{{ \App\Models\Setting::get('pmb_url', 'https://pmb.uinssc.ac.id') }}" target="_blank" class="w-full text-center py-2.5 rounded-full bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs uppercase tracking-wider shadow-md block">
                    <i class="fa-solid fa-user-plus mr-1"></i> DAFTAR PMB ONLINE
                </a>
            </div>
        </div>
    </header>

    <!-- Global Search Modal -->
    <div x-show="searchModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="searchModal = false" class="relative w-full max-w-2xl bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-2xl">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass text-[#006837]"></i> Pencarian Portal UPT PJJ
                </h3>
                <button @click="searchModal = false" class="text-slate-400 hover:text-slate-700">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <form action="{{ route('posts.index') }}" method="GET" class="mt-5">
                <div class="relative">
                    <input type="text" name="cari" placeholder="Ketik kata kunci pencarian (misal: LMS Pillar, PMB, kurikulum, pedoman...)" class="w-full pl-11 pr-24 py-3.5 bg-slate-50 border border-slate-300 rounded-2xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:border-[#006837] focus:ring-2 focus:ring-[#006837]/20">
                    <i class="fa-solid fa-search absolute left-4 top-4 text-slate-400"></i>
                    <button type="submit" class="absolute right-2 top-2 px-5 py-2 bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs rounded-xl shadow transition">
                        Cari
                    </button>
                </div>
            </form>
            <div class="mt-4 flex flex-wrap gap-2 text-xs text-slate-500">
                <span class="font-semibold text-slate-700">Topik Populer:</span>
                <a href="{{ route('posts.index', ['cari' => 'LMS Pillar']) }}" class="px-2.5 py-1 rounded-full bg-slate-100 hover:bg-emerald-50 hover:text-[#006837] transition font-medium">#LMS Pillar</a>
                <a href="{{ route('posts.index', ['cari' => 'PMB']) }}" class="px-2.5 py-1 rounded-full bg-slate-100 hover:bg-emerald-50 hover:text-[#006837] transition font-medium">#PMB Online</a>
                <a href="{{ route('posts.index', ['cari' => 'PAI S1']) }}" class="px-2.5 py-1 rounded-full bg-slate-100 hover:bg-emerald-50 hover:text-[#006837] transition font-medium">#PAI S1</a>
                <a href="{{ route('posts.index', ['cari' => 'Pedoman']) }}" class="px-2.5 py-1 rounded-full bg-slate-100 hover:bg-emerald-50 hover:text-[#006837] transition font-medium">#Pedoman Akademik</a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed bottom-6 right-6 z-50 max-w-md bg-emerald-900 border border-emerald-500 text-white px-5 py-4 rounded-2xl shadow-2xl flex items-start gap-3 backdrop-blur-lg">
            <i class="fa-solid fa-circle-check text-emerald-300 text-xl mt-0.5"></i>
            <div class="flex-1 text-sm font-medium">
                {{ session('success') }}
            </div>
            <button @click="show = false" class="text-emerald-300 hover:text-white">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed bottom-6 right-6 z-50 max-w-md bg-red-900 border border-red-500 text-white px-5 py-4 rounded-2xl shadow-2xl flex items-start gap-3 backdrop-blur-lg">
            <i class="fa-solid fa-triangle-exclamation text-red-300 text-xl mt-0.5"></i>
            <div class="flex-1 text-sm font-medium">
                {{ session('error') }}
            </div>
            <button @click="show = false" class="text-red-300 hover:text-white">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- Main Content Yield -->
    <main class="min-h-[70vh]">
        @yield('content')
    </main>

    <!-- 3. University Footer (Matches exact 4-column layout of uptpjj.uinssc.ac.id) -->
    <footer class="bg-[#18181b] text-slate-300 pt-16 pb-8 relative overflow-hidden border-t-4 border-[#006837]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 pb-12 border-b border-slate-800">
                
                <!-- Col 1: UINSSC Identity & PMB Button -->
                <div class="space-y-4">
                    <div class="bg-white p-2.5 rounded-2xl inline-block shadow-sm">
                        <img src="{{ asset('images/logo_uptpjj.png') }}" alt="UPT Pendidikan Jarak Jauh UINSSC" class="h-10 w-auto object-contain">
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Pelopor Universitas Islam Siber terakreditasi resmi di Indonesia. Menghadirkan pendidikan tinggi berkualitas, fleksibel, dan inklusif untuk semua.
                    </p>
                    
                    <div class="pt-2">
                        <a href="{{ \App\Models\Setting::get('pmb_url', 'https://uinssc.ac.id/pmb') }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-[#006837] text-white text-xs font-bold transition-all border border-slate-700">
                            <i class="fa-solid fa-user-graduate text-amber-400"></i>
                            <span>Informasi Penerimaan →</span>
                        </a>
                    </div>
                </div>

                @php
                    $footerNavItems = \App\Models\MenuItem::getTree('footer');
                    $col2Items = $footerNavItems->slice(0, 6);
                    $col3Items = $footerNavItems->slice(6);
                @endphp

                <!-- Col 2: Tentang & Navigasi -->
                <div>
                    <h4 class="text-sm font-bold text-white tracking-wider uppercase mb-4 text-emerald-400 flex items-center gap-2">
                        <i class="fa-solid fa-graduation-cap"></i> Informasi & Layanan
                    </h4>
                    <div class="flex flex-col space-y-2">
                        @forelse($col2Items as $fItem)
                            <a href="{{ $fItem->getUrl() }}" target="{{ $fItem->target }}" class="px-3.5 py-2 rounded-xl bg-[#27272a] hover:bg-[#006837] text-slate-200 text-xs font-medium transition flex items-center gap-2">
                                <i class="{{ $fItem->icon ?: 'fa-solid fa-angle-right' }} text-emerald-400 text-[11px]"></i>
                                <span>{{ $fItem->title }}</span>
                            </a>
                        @empty
                            <a href="{{ route('profile.vision-mission') }}" class="px-3.5 py-2 rounded-xl bg-[#27272a] text-slate-200 text-xs font-medium">Visi dan Misi</a>
                            <a href="{{ route('profile.facilities') }}" class="px-3.5 py-2 rounded-xl bg-[#27272a] text-slate-200 text-xs font-medium">Sarana Prasarana</a>
                            <a href="{{ route('programs.index') }}" class="px-3.5 py-2 rounded-xl bg-[#27272a] text-slate-200 text-xs font-medium">Program Studi PJJ</a>
                        @endforelse
                    </div>
                </div>

                <!-- Col 3: Link Cepat & Eksternal -->
                <div>
                    <h4 class="text-sm font-bold text-white tracking-wider uppercase mb-4 text-emerald-400 flex items-center gap-2">
                        <i class="fa-solid fa-link"></i> Link Terkait
                    </h4>
                    <div class="flex flex-col space-y-2">
                        @forelse($col3Items as $fItem)
                            <a href="{{ $fItem->getUrl() }}" target="{{ $fItem->target }}" class="px-3.5 py-2 rounded-xl bg-[#27272a] hover:bg-[#006837] text-slate-200 text-xs font-medium transition flex items-center gap-2">
                                <i class="{{ $fItem->icon ?: 'fa-solid fa-globe' }} text-emerald-400 text-[11px]"></i>
                                <span>{{ $fItem->title }}</span>
                            </a>
                        @empty
                            <a href="https://uinssc.ac.id" target="_blank" class="px-3.5 py-2 rounded-xl bg-[#27272a] text-slate-200 text-xs font-medium">Website UINSSC</a>
                        @endforelse
                    </div>
                </div>

                <!-- Col 4: Lokasi Kampus & SiberGo Mobile App -->
                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-white tracking-wider uppercase mb-2 text-emerald-400 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot"></i> Lokasi Kampus
                    </h4>
                    <p class="text-xs text-slate-400">
                        {{ \App\Models\Setting::get('address', 'Jl. Perjuangan By Pass Sunyaragi, Cirebon, Jawa Barat 45132') }}
                    </p>

                    <!-- Google Map Preview Card -->
                    <div class="rounded-xl overflow-hidden border border-slate-700 bg-slate-800 p-2 shadow-inner">
                        <div class="flex items-center justify-between text-[11px] text-slate-300 mb-1.5 px-1 font-semibold">
                            <span><i class="fa-solid fa-map-pin text-red-500 mr-1"></i> Kampus UINSSC</span>
                            <a href="https://maps.google.com/?q=UIN+Siber+Syekh+Nurjati+Cirebon" target="_blank" class="text-emerald-400 hover:underline">Maps ↗</a>
                        </div>
                        <div class="w-full h-24 bg-slate-700 rounded-lg overflow-hidden relative flex items-center justify-center">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.378775083756!2d108.5367688758832!3d-6.735817265857218!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ee26515b6d761%3A0x8898165b630e20f2!2sIAIN%20Syekh%20Nurjati%20Cirebon!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" class="w-full h-full border-0" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>

                    <!-- SiberGo App Download Badge -->
                    <div class="p-3 rounded-xl bg-[#27272a] border border-slate-700 flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xs font-bold text-white flex items-center gap-1.5">
                                <span class="text-amber-400 font-extrabold">SiberGo!</span>
                                <span class="text-[10px] text-slate-400 font-normal">App Mahasiswa</span>
                            </div>
                            <div class="text-[10px] text-slate-400">Tersedia di Google Play Store</div>
                        </div>
                        <a href="{{ \App\Models\Setting::get('sibergo_url', 'https://play.google.com/store/apps/details?id=com.uinssc.pustikom.sibergo&hl=id') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-[11px] font-bold shrink-0 transition flex items-center gap-1.5 shadow">
                            <i class="fa-brands fa-google-play"></i> Unduh
                        </a>
                    </div>

                    <!-- Social Icons -->
                    <div class="flex items-center space-x-3 pt-1 text-slate-400">
                        <a href="{{ \App\Models\Setting::get('facebook_url', '#') }}" target="_blank" class="w-8 h-8 rounded-lg bg-[#27272a] hover:bg-[#006837] hover:text-white flex items-center justify-center text-xs transition"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="{{ \App\Models\Setting::get('twitter_url', '#') }}" target="_blank" class="w-8 h-8 rounded-lg bg-[#27272a] hover:bg-[#006837] hover:text-white flex items-center justify-center text-xs transition"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="{{ \App\Models\Setting::get('instagram_url', '#') }}" target="_blank" class="w-8 h-8 rounded-lg bg-[#27272a] hover:bg-[#006837] hover:text-white flex items-center justify-center text-xs transition"><i class="fa-brands fa-instagram"></i></a>
                        <a href="{{ \App\Models\Setting::get('youtube_url', '#') }}" target="_blank" class="w-8 h-8 rounded-lg bg-[#27272a] hover:bg-[#006837] hover:text-white flex items-center justify-center text-xs transition"><i class="fa-brands fa-youtube"></i></a>
                    </div>

                </div>
            </div>

            <!-- Bottom Copyright Bar (Matches live site footer) -->
            <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>© {{ date('Y') }} Pusat Teknologi Informasi dan Komunikasi UINSSC. All Rights Reserved.</p>
                <div class="flex items-center space-x-4 text-slate-400">
                    <a href="{{ route('profile.overview') }}" class="hover:text-white transition">Tentang Kami</a>
                    <span>•</span>
                    <a href="{{ route('contact.index') }}" class="hover:text-white transition">Helpdesk</a>
                    <span>•</span>
                    <a href="{{ route('login') }}" class="text-emerald-400 hover:underline font-semibold">Login CMS</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Helpdesk WhatsApp Widget -->
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '628112345678')) }}?text=Halo%20Admin%20UPT%20PJJ%20UINSSC,%20saya%20ingin%20bertanya" target="_blank" class="fixed bottom-6 left-6 z-40 flex items-center gap-2.5 px-4 py-3 rounded-full bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs shadow-2xl shadow-emerald-950/40 transition transform hover:scale-105 group" title="Chat WhatsApp Helpdesk PJJ">
        <i class="fa-brands fa-whatsapp text-lg text-emerald-300"></i>
        <span class="hidden md:inline">Helpdesk PJJ 24/7</span>
    </a>

    @stack('scripts')
</body>
</html>
