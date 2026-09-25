@extends('layouts.app')

@section('title', 'Tim Pengelola & Tutor - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Profil</span> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Tim UPT PJJ</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Tim Pengelola & Pengembang PJJ</h1>
        <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">Para profesional di balik manajemen kurikulum siber, arsitektur IT, studio penyiaran, dan layanan mahasiswa UPT PJJ UINSSC.</p>
    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
    @foreach($teams as $divisionName => $members)
        <div class="space-y-6">
            <h2 class="text-base font-extrabold text-slate-900 uppercase tracking-wider text-[#006837] flex items-center gap-2 pb-2 border-b border-slate-200">
                <i class="fa-solid fa-layer-group text-sm"></i> {{ $divisionName }}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($members as $m)
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:border-[#006837] transition duration-300 flex flex-col justify-between space-y-4 text-center group">
                        <div class="space-y-3">
                            <div class="relative w-24 h-24 mx-auto rounded-2xl overflow-hidden border-2 border-slate-200 shadow group-hover:border-[#006837] transition">
                                <img src="{{ $m->photo_url }}" alt="{{ $m->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            </div>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-900 group-hover:text-[#006837] transition">{{ $m->name }}</h3>
                                <p class="text-xs font-semibold text-[#006837] mt-0.5">{{ $m->title }}</p>
                                @if($m->nip)
                                    <p class="text-[10px] text-slate-400 mt-0.5">NIP. {{ $m->nip }}</p>
                                @endif
                            </div>
                            @if($m->bio)
                                <p class="text-[11px] text-slate-600 line-clamp-3 leading-relaxed">{{ $m->bio }}</p>
                            @endif
                        </div>

                        @if($m->email)
                            <div class="pt-3 border-t border-slate-100">
                                <a href="mailto:{{ $m->email }}" class="text-[11px] text-slate-500 hover:text-[#006837] transition flex items-center justify-center gap-1">
                                    <i class="fa-solid fa-envelope text-[10px]"></i> {{ $m->email }}
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection
