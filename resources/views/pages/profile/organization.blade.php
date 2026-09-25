@extends('layouts.app')

@section('title', 'Struktur Organisasi - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Profil</span> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Struktur Organisasi</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Struktur Organisasi</h1>
        <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">Bagan kepemimpinan dan divisi tata kelola penyelenggaraan Pendidikan Jarak Jauh UIN Siber Syekh Nurjati Cirebon.</p>
    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="space-y-10">
        
        <!-- Pimpinan Top Card -->
        <div class="max-w-md mx-auto">
            @foreach($leadership as $lead)
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-md text-center space-y-3">
                    <img src="{{ $lead->photo_url }}" alt="{{ $lead->name }}" class="w-24 h-24 rounded-2xl mx-auto object-cover border-2 border-[#006837] shadow">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#006837] px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200">
                            {{ $lead->title }}
                        </span>
                        <h3 class="text-lg font-extrabold text-slate-900 mt-2">{{ $lead->name }}</h3>
                        <p class="text-xs text-slate-500">NIP. {{ $lead->nip ?? '-' }}</p>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">{{ $lead->bio }}</p>
                </div>
            @endforeach
        </div>

        <!-- Connector Line -->
        <div class="w-1 h-8 bg-emerald-600 mx-auto rounded-full"></div>

        <!-- Divisions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($divisions as $divName => $members)
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-[#006837] pb-2 border-b border-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-network-wired text-xs"></i> {{ $divName }}
                    </h4>
                    
                    <div class="space-y-4">
                        @foreach($members as $m)
                            <div class="flex items-start gap-3 pt-2">
                                <img src="{{ $m->photo_url }}" alt="{{ $m->name }}" class="w-12 h-12 rounded-xl object-cover border border-slate-200 shadow-sm">
                                <div>
                                    <h5 class="text-xs font-bold text-slate-900">{{ $m->name }}</h5>
                                    <p class="text-[11px] text-[#006837] font-semibold">{{ $m->title }}</p>
                                    @if($m->nip)
                                        <p class="text-[10px] text-slate-400">NIP. {{ $m->nip }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
