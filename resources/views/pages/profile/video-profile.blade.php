@extends('layouts.app')

@section('title', 'Video Profile & Tur Virtual - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Profil</span> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Video Profile</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Video Profil & Tur Virtual</h1>
        <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">Saksikan tayangan visual perjalanan, fasilitas studio, dan keunggulan ekosistem pembelajaran digital UPT PJJ UINSSC.</p>
    </div>
</div>

<div class="py-14 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
    
    <!-- Video Player Frame -->
    <div class="bg-white p-4 rounded-3xl border border-slate-200 shadow-md">
        <div class="relative w-full rounded-2xl overflow-hidden shadow bg-black" style="padding-top: 56.25%;">
            <iframe class="absolute inset-0 w-full h-full" src="{{ \App\Models\Setting::get('profile_video_url', 'https://www.youtube.com/embed/dQw4w9WgXcQ') }}" title="Video Profil UPT PJJ UINSSC" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4 text-center">
        <h3 class="text-lg font-bold text-slate-900">Ingin Mengetahui Lebih Dalam Tentang Kuliah PJJ?</h3>
        <p class="text-xs sm:text-sm text-slate-600 max-w-xl mx-auto">Kunjungi kanal resmi YouTube kami atau hubungi tim helpdesk kami untuk informasi lengkap seputar perkuliahan dan pendaftaran PMB.</p>
        <div class="pt-2 flex justify-center gap-4">
            <a href="{{ \App\Models\Setting::get('youtube_url', '#') }}" target="_blank" class="px-5 py-2.5 rounded-full bg-red-600 hover:bg-red-700 text-white font-bold text-xs transition flex items-center gap-2 shadow">
                <i class="fa-brands fa-youtube"></i> Kanal YouTube
            </a>
            <a href="{{ route('contact.index') }}" class="px-5 py-2.5 rounded-full bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs transition flex items-center gap-2 shadow">
                <i class="fa-solid fa-headset"></i> Hubungi Helpdesk
            </a>
        </div>
    </div>

</div>
@endsection
