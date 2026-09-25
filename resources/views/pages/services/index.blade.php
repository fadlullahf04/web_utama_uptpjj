@extends('layouts.app')

@section('title', 'Layanan & Fasilitas PJJ - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Layanan & Fasilitas</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Layanan & Fasilitas Pendidikan Jarak Jauh</h1>
        <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">Ekosistem lengkap yang dirancang untuk mendukung kelancaran perkuliahan mandiri, produksi media ajar, dan pendampingan mahasiswa 24/7.</p>
    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($services as $srv)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                <div>
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        <img src="{{ $srv->image_url }}" alt="{{ $srv->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-[#006837] text-white text-[10px] font-bold uppercase tracking-wider">
                            {{ $srv->category }}
                        </span>
                    </div>

                    <div class="p-6 space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900 group-hover:text-[#006837] transition">
                            <a href="{{ route('services.show', $srv->slug) }}">{{ $srv->title }}</a>
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $srv->short_description }}
                        </p>
                    </div>
                </div>

                <div class="p-6 pt-0 flex items-center justify-between border-t border-slate-100 mt-4">
                    <a href="{{ route('services.show', $srv->slug) }}" class="text-xs font-bold text-slate-700 hover:text-[#006837] transition">
                        Detail Informasi →
                    </a>
                    @if($srv->portal_url)
                        <a href="{{ $srv->portal_url }}" target="_blank" class="px-4 py-2 rounded-full bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition shadow-sm">
                            {{ $srv->button_text ?? 'Akses Portal' }}
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
