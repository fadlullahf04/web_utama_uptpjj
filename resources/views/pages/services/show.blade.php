@extends('layouts.app')

@section('title', $service->title . ' - UPT Pendidikan Jarak Jauh UINSSC')
@section('meta_description', $service->short_description ?: \Illuminate\Support\Str::limit(strip_tags($service->content), 155))

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-2">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <a href="{{ route('services.index') }}" class="hover:underline">Layanan</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>{{ $service->category }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            {{ $service->title }}
        </h1>
        <p class="text-xs sm:text-sm text-emerald-100 font-semibold max-w-3xl">{{ $service->short_description }}</p>
    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        
        <!-- Left Column: Main Detail (8 cols) -->
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white p-3 rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="w-full h-80 sm:h-96 object-cover rounded-2xl">
            </div>

            <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <h2 class="text-xl font-bold text-slate-900 text-[#006837]">Tentang Layanan Ini</h2>
                <div class="text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
                    <p>{{ $service->content ?? $service->short_description }}</p>
                </div>

                @if($service->portal_url)
                    <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center gap-4">
                        <a href="{{ $service->portal_url }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-full bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider shadow-md transition">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            <span>{{ $service->button_text ?? 'Akses Portal Layanan' }}</span>
                        </a>
                    </div>
                @endif
            </div>

            <!-- LMS Course Guide Integration Banner -->
            @if(str_contains(strtolower($service->slug), 'lms') || str_contains(strtolower($service->title), 'lms'))
                <div class="p-8 rounded-3xl bg-gradient-to-r from-emerald-900 to-teal-900 text-white shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-center justify-between gap-6 border border-emerald-700/50">
                    <div class="space-y-2 max-w-xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400 text-slate-950 text-[11px] font-extrabold uppercase tracking-wider">
                            <i class="fa-solid fa-book-open"></i> Course & Tutorial
                        </div>
                        <h3 class="text-xl font-bold text-white">Panduan & Tutorial Penggunaan LMS Pillar</h3>
                        <p class="text-xs text-emerald-100 leading-relaxed">
                            Panduan langkah demi langkah bagi dosen dan mahasiswa untuk aktivasi akun, presensi asinkron, pengerjaan modul kuis, dan ujian online di LMS Pillar.
                        </p>
                    </div>
                    <a href="{{ route('lms-guide') }}" class="px-6 py-3.5 rounded-full bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-xs uppercase tracking-wider shrink-0 transition shadow-lg flex items-center gap-2">
                        <i class="fa-solid fa-play"></i> Buka Tutorial Course
                    </a>
                </div>
            @endif
        </div>

        <!-- Right Column: Sidebar & Other Services (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Quick Facts Card -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider text-[#006837] pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info"></i> Informasi Ringkas
                </h4>
                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500 font-medium">Kategori:</span>
                        <span class="font-bold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full">{{ $service->category }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500 font-medium">Akses Layanan:</span>
                        <span class="font-bold text-slate-700">Dosen & Mahasiswa</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500 font-medium">Waktu Operasional:</span>
                        <span class="font-bold text-slate-700">24 Jam / 7 Hari</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5">
                        <span class="text-slate-500 font-medium">Helpdesk Terpadu:</span>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '628112345678')) }}" target="_blank" class="font-bold text-[#006837] hover:underline flex items-center gap-1">
                            <i class="fa-brands fa-whatsapp text-emerald-600"></i> WhatsApp
                        </a>
                    </div>
                </div>

                @if($service->portal_url)
                    <div class="pt-2">
                        <a href="{{ $service->portal_url }}" target="_blank" class="w-full text-center py-3 rounded-2xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider shadow transition block">
                            {{ $service->button_text ?? 'Akses Portal' }}
                        </a>
                    </div>
                @endif
            </div>

            <!-- Other Services List -->
            @if($otherServices->count() > 0)
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider text-[#006837] pb-3 border-b border-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-layer-group"></i> Layanan PJJ Lainnya
                    </h4>
                    <div class="space-y-3">
                        @foreach($otherServices as $os)
                            <a href="{{ route('services.show', $os->slug) }}" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200/80 hover:border-emerald-300 transition flex items-center gap-3 group block">
                                <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center shrink-0 text-[#006837] group-hover:scale-105 transition">
                                    <i class="fa-solid fa-graduation-cap text-sm"></i>
                                </div>
                                <div class="truncate">
                                    <span class="text-[10px] text-emerald-700 font-bold uppercase">{{ $os->category }}</span>
                                    <h5 class="text-xs font-bold text-slate-800 group-hover:text-[#006837] transition truncate">{{ $os->title }}</h5>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    </div>
</div>
@endsection
