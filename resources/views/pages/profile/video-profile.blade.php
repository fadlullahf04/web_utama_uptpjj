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

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
    
    <!-- Video Player Frame -->
    <div class="bg-white p-4 rounded-3xl border border-slate-200 shadow-md">
        <div class="relative w-full rounded-2xl overflow-hidden shadow bg-black" style="padding-top: 56.25%;">
            <iframe class="absolute inset-0 w-full h-full" src="{{ $mainVideoUrl }}" title="Video Profil UPT PJJ UINSSC" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
    </div>

    @if($videos->isNotEmpty())
        <div class="space-y-5">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900">Koleksi Video Profil &amp; Dokumentasi</h2>
                    <p class="text-xs text-slate-500 mt-1">Tayangan profil lembaga, layanan akademik, dan aktivitas sivitas UPT PJJ UINSSC.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($videos as $video)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                        <div class="relative w-full bg-black" style="padding-top: 56.25%;">
                            <iframe class="absolute inset-0 w-full h-full" src="{{ $video->embed_url }}" title="{{ $video->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                        <div class="p-5 space-y-1.5 flex-1">
                            <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-[#006837] bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                                {{ $video->category }}
                            </span>
                            <h3 class="text-sm font-extrabold text-slate-900 leading-snug">{{ $video->title }}</h3>
                            @if(!empty($video->description))
                                <p class="text-xs text-slate-600 leading-relaxed">{{ strip_tags(html_entity_decode($video->description)) }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

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
