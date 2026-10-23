@extends('layouts.app')

@section('title', ($page->meta_title ?: $page->title) . ' - UPT Pendidikan Jarak Jauh UINSSC')
@section('meta_description', $page->meta_description ?: ($page->excerpt ?: Str::limit(strip_tags($page->content), 160)))

@section('content')
<!-- Page Header / Hero Banner -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-12 sm:py-16 text-white relative overflow-hidden">
    <!-- Subtle Background Pattern Decoration -->
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-sm text-emerald-200 text-xs font-semibold mb-4 border border-white/10">
            <a href="{{ route('home') }}" class="hover:text-white transition flex items-center gap-1.5">
                <i class="fa-solid fa-house text-[11px]"></i>
                <span>Beranda</span>
            </a>
            <i class="fa-solid fa-chevron-right text-[9px] text-emerald-300/70"></i>
            <span class="text-white/80">Halaman</span>
            <i class="fa-solid fa-chevron-right text-[9px] text-emerald-300/70"></i>
            <span class="text-white truncate max-w-[200px] sm:max-w-md">{{ $page->title }}</span>
        </nav>

        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white tracking-tight leading-snug">
            {{ $page->title }}
        </h1>

        @if($page->excerpt)
            <p class="text-xs sm:text-sm text-emerald-100 mt-3 max-w-3xl leading-relaxed">
                {{ $page->excerpt }}
            </p>
        @endif

        <!-- Meta info -->
        <div class="flex flex-wrap items-center gap-4 text-xs text-emerald-200/90 mt-5 pt-4 border-t border-white/10">
            <span class="flex items-center gap-1.5">
                <i class="fa-solid fa-calendar-day text-amber-300"></i>
                <span>{{ $page->published_at ? $page->published_at->translatedFormat('d F Y') : $page->created_at->translatedFormat('d F Y') }}</span>
            </span>
            <span class="text-white/30">•</span>
            <span class="flex items-center gap-1.5">
                <i class="fa-solid fa-eye text-emerald-300"></i>
                <span>{{ number_format($page->views_count) }}x dibaca</span>
            </span>
            @if(! $page->is_published)
                <span class="text-white/30">•</span>
                <span class="px-2 py-0.5 rounded-full bg-amber-500/80 text-white font-bold text-[10px] uppercase tracking-wider">
                    Draft Preview
                </span>
            @endif
        </div>
    </div>
</div>

<!-- Main Body Content -->
<div class="py-12 sm:py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    @if($page->template === 'full-width')
        <!-- Full Width Layout -->
        <div class="w-full space-y-8">
            @if($page->featured_image_url)
                <div class="rounded-3xl overflow-hidden border border-slate-200 shadow-md max-h-[480px]">
                    <img src="{{ $page->featured_image_url }}" alt="{{ $page->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <article class="bg-white p-6 sm:p-10 md:p-14 rounded-3xl border border-slate-200/90 shadow-sm">
                <div class="article-content text-slate-800 text-sm sm:text-base leading-relaxed space-y-4">
                    {!! $page->content !!}
                </div>
            </article>
        </div>

    @elseif($page->template === 'blank')
        <!-- Clean Blank Layout -->
        <div class="max-w-4xl mx-auto space-y-8">
            <article class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-sm">
                <div class="article-content text-slate-800 text-sm sm:text-base leading-relaxed space-y-4">
                    {!! $page->content !!}
                </div>
            </article>
        </div>

    @else
        <!-- Default Layout (Standard Width with Sidebar) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Left: Main Article (8 cols) -->
            <div class="lg:col-span-8 space-y-8">
                
                @if($page->featured_image_url)
                    <div class="rounded-3xl overflow-hidden border border-slate-200 shadow-md max-h-[420px]">
                        <img src="{{ $page->featured_image_url }}" alt="{{ $page->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <article class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200/90 shadow-sm space-y-6">
                    <div class="article-content text-slate-800 text-sm sm:text-base leading-relaxed space-y-4">
                        {!! $page->content !!}
                    </div>

                    <!-- Article Footer / Share & Tags -->
                    <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                            <i class="fa-solid fa-share-nodes text-[#006837]"></i>
                            <span>Bagikan Halaman:</span>
                            <div class="flex items-center gap-1.5 ml-1">
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($page->title . ' - ' . url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition flex items-center justify-center text-xs" title="Bagikan ke WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition flex items-center justify-center text-xs" title="Bagikan ke Facebook">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($page->title) }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 text-slate-700 hover:bg-slate-900 hover:text-white transition flex items-center justify-center text-xs" title="Bagikan ke X">
                                    <i class="fa-brands fa-x-twitter"></i>
                                </a>
                            </div>
                        </div>

                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#006837] hover:underline">
                            <span>Kembali ke Beranda</span>
                            <i class="fa-solid fa-arrow-right text-[11px]"></i>
                        </a>
                    </div>
                </article>

            </div>

            <!-- Right: Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Widget: Halaman Terkait Lainnya -->
                @if(isset($otherPages) && $otherPages->count() > 0)
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                            <i class="fa-solid fa-file-lines text-[#006837]"></i> Halaman Lainnya
                        </h4>
                        <div class="space-y-3">
                            @foreach($otherPages as $op)
                                <a href="{{ route('pages.show', $op->slug) }}" class="group flex items-start gap-3 p-2 rounded-xl hover:bg-slate-50 transition">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-50 text-[#006837] group-hover:bg-[#006837] group-hover:text-white transition flex items-center justify-center shrink-0 text-xs mt-0.5">
                                        <i class="fa-solid fa-angle-right"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-slate-800 group-hover:text-[#006837] transition leading-snug line-clamp-2">
                                            {{ $op->title }}
                                        </p>
                                        <span class="text-[10px] text-slate-400 mt-0.5 block">
                                            {{ $op->published_at ? $op->published_at->format('d M Y') : '' }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Widget: Layanan Cepat & Helpdesk -->
                <div class="bg-gradient-to-br from-emerald-950 to-slate-900 text-white p-6 rounded-3xl shadow-lg relative overflow-hidden">
                    <div class="relative z-10 space-y-3">
                        <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            Pusat Informasi
                        </span>
                        <h4 class="text-base font-extrabold text-white leading-snug">
                            Butuh Informasi Tambahan?
                        </h4>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Hubungi tim helpdesk dan sekretariat UPT Pendidikan Jarak Jauh UIN Siber Syekh Nurjati Cirebon.
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition shadow-md">
                                <i class="fa-solid fa-headset"></i>
                                <span>Hubungi Helpdesk Kami</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Widget: Program Studi PJJ Quick Links -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-graduation-cap text-amber-600"></i> Program Studi PJJ
                    </h4>
                    <div class="space-y-1.5 text-xs font-medium text-slate-700">
                        <a href="{{ route('programs.show', 'pjj-pendidikan-agama-islam') }}" class="flex items-center justify-between p-2 rounded-xl hover:bg-emerald-50 hover:text-[#006837] transition">
                            <span>PJJ Pendidikan Agama Islam (S1)</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-100 text-[#006837] font-bold">Unggul</span>
                        </a>
                        <a href="{{ route('programs.show', 'pjj-pendidikan-guru-madrasah-ibtidaiyah') }}" class="flex items-center justify-between p-2 rounded-xl hover:bg-emerald-50 hover:text-[#006837] transition">
                            <span>PJJ PGMI (S1)</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-teal-100 text-teal-800 font-bold">Baik Sekali</span>
                        </a>
                        <a href="{{ route('programs.show', 'pjj-pendidikan-bahasa-arab') }}" class="flex items-center justify-between p-2 rounded-xl hover:bg-emerald-50 hover:text-[#006837] transition">
                            <span>PJJ Bahasa Arab (S1)</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold">Baik Sekali</span>
                        </a>
                        <a href="{{ route('programs.show', 'pjj-magister-pendidikan-agama-islam-s2') }}" class="flex items-center justify-between p-2 rounded-xl hover:bg-emerald-50 hover:text-[#006837] transition">
                            <span>PJJ PAI S2 Pascasarjana</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold">Unggul</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    @endif

</div>
@endsection
