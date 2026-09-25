@extends('layouts.app')

@section('title', 'Program Studi PJJ - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Program Studi</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Program Studi Pendidikan Jarak Jauh</h1>
        <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">Pilihan program studi jenjang Sarjana (S1) dan Magister (S2) berakreditasi resmi dengan sistem perkuliahan 100% online.</p>
        
        <!-- Filter Tabs -->
        <div class="mt-6 flex flex-wrap items-center gap-2">
            <a href="{{ route('programs.index') }}" class="px-4 py-2 rounded-full text-xs font-bold transition {{ !$degree ? 'bg-amber-500 text-slate-950 shadow-md' : 'bg-white/15 text-white hover:bg-white/25' }}">
                Semua Jenjang ({{ $programs->count() }})
            </a>
            <a href="{{ route('programs.index', ['degree' => 'S1']) }}" class="px-4 py-2 rounded-full text-xs font-bold transition {{ $degree === 'S1' ? 'bg-amber-500 text-slate-950 shadow-md' : 'bg-white/15 text-white hover:bg-white/25' }}">
                Sarjana (S1)
            </a>
            <a href="{{ route('programs.index', ['degree' => 'S2']) }}" class="px-4 py-2 rounded-full text-xs font-bold transition {{ $degree === 'S2' ? 'bg-amber-500 text-slate-950 shadow-md' : 'bg-white/15 text-white hover:bg-white/25' }}">
                Pascasarjana (S2)
            </a>
        </div>
    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($programs as $prodi)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                
                <div>
                    <div class="relative h-52 overflow-hidden bg-slate-100">
                        <img src="{{ $prodi->image_url }}" alt="{{ $prodi->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-3 left-3 flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-full {{ $prodi->degree === 'S2' ? 'bg-amber-500 text-slate-950' : 'bg-[#006837] text-white' }} text-[11px] font-extrabold uppercase">
                                {{ $prodi->degree }}
                            </span>
                            <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-[#006837] text-[10px] font-bold border border-emerald-200">
                                Akreditasi {{ $prodi->accreditation }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <span class="text-[11px] font-semibold text-[#006837] block mb-1">{{ $prodi->faculty }}</span>
                            <h3 class="text-base font-extrabold text-slate-900 group-hover:text-[#006837] transition">
                                <a href="{{ route('programs.show', $prodi->slug) }}">{{ $prodi->name }}</a>
                            </h3>
                        </div>
                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                            {{ $prodi->short_description }}
                        </p>

                        <div class="space-y-2 pt-3 border-t border-slate-100 text-xs text-slate-700">
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="text-slate-500"><i class="fa-solid fa-clock text-[#006837] mr-1.5"></i> Durasi:</span>
                                <span class="font-semibold">{{ $prodi->study_duration }}</span>
                            </div>
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="text-slate-500"><i class="fa-solid fa-award text-amber-600 mr-1.5"></i> Gelar:</span>
                                <span class="font-semibold text-slate-900">{{ $prodi->graduate_title }}</span>
                            </div>
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="text-slate-500"><i class="fa-solid fa-user-tie text-teal-600 mr-1.5"></i> Kaprodi:</span>
                                <span class="font-semibold text-slate-800">{{ $prodi->head_of_program ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-0 grid grid-cols-2 gap-2">
                    <a href="{{ route('programs.show', $prodi->slug) }}" class="text-center py-2.5 px-3 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition">
                        Detail Prodi
                    </a>
                    <a href="{{ $prodi->registration_url ?? \App\Models\Setting::get('pmb_url', 'https://pmb.uinssc.ac.id') }}" target="_blank" class="text-center py-2.5 px-3 rounded-full bg-[#006837] hover:bg-[#004d29] text-white text-xs font-extrabold transition shadow-sm">
                        Daftar PMB
                    </a>
                </div>

            </div>
        @empty
            <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-slate-200">
                <p class="text-slate-500 text-sm">Tidak ada program studi ditemukan untuk filter ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
