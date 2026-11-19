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
    <div class="space-y-4">

        <!-- Level 1: Kepala UPT PJJ -->
        <div class="flex flex-col items-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#006837] text-white text-[11px] font-bold uppercase tracking-wider shadow-sm mb-4">
                <i class="fa-solid fa-crown text-amber-300 text-[10px]"></i> Kepala UPT PJJ
            </span>

            @if($kepalaUpt->isNotEmpty())
                <div class="w-full max-w-md space-y-4">
                    @foreach($kepalaUpt as $lead)
                        <div class="bg-white p-6 rounded-3xl border-2 border-[#006837]/20 shadow-md text-center space-y-3">
                            <img src="{{ $lead->photo_url }}" alt="{{ $lead->name }}" class="w-24 h-24 rounded-2xl mx-auto object-cover border-2 border-[#006837] shadow">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#006837] px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200">
                                    {{ $lead->title }}
                                </span>
                                <h3 class="text-lg font-extrabold text-slate-900 mt-2">{{ $lead->name }}</h3>
                                @if(!empty($lead->nip))
                                    <p class="text-xs text-slate-500">NIP. {{ $lead->nip }}</p>
                                @endif
                            </div>
                            @if(!empty($lead->bio))
                                <p class="text-xs text-slate-600 leading-relaxed">{{ strip_tags(html_entity_decode($lead->bio)) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="w-full max-w-md bg-white p-6 rounded-3xl border border-dashed border-slate-300 text-center text-xs text-slate-500">
                    Data Kepala UPT PJJ belum ditambahkan.
                </div>
            @endif
        </div>

        <!-- Connector -->
        <div class="flex flex-col items-center py-1">
            <div class="w-0.5 h-8 bg-[#006837]/50"></div>
            <div class="w-2.5 h-2.5 rounded-full bg-[#006837]"></div>
            <div class="w-0.5 h-6 bg-[#006837]/50"></div>
        </div>

        <!-- Level 2: Sekretaris UPT PJJ -->
        <div class="flex flex-col items-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-700 text-white text-[11px] font-bold uppercase tracking-wider shadow-sm mb-4">
                <i class="fa-solid fa-user-tie text-emerald-200 text-[10px]"></i> Sekretaris UPT PJJ
            </span>

            @if($sekretarisUpt->isNotEmpty())
                <div class="flex flex-wrap justify-center gap-5 w-full max-w-3xl">
                    @foreach($sekretarisUpt as $sek)
                        <div class="w-full sm:w-80 bg-white p-5 rounded-2xl border border-emerald-200 shadow-sm text-center space-y-2.5">
                            <img src="{{ $sek->photo_url }}" alt="{{ $sek->name }}" class="w-20 h-20 rounded-2xl mx-auto object-cover border-2 border-emerald-600 shadow-sm">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200">
                                    {{ $sek->title }}
                                </span>
                                <h3 class="text-base font-extrabold text-slate-900 mt-2">{{ $sek->name }}</h3>
                                @if(!empty($sek->nip))
                                    <p class="text-xs text-slate-500">NIP. {{ $sek->nip }}</p>
                                @endif
                            </div>
                            @if(!empty($sek->bio))
                                <p class="text-xs text-slate-600 leading-relaxed">{{ strip_tags(html_entity_decode($sek->bio)) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="w-full max-w-sm bg-white p-5 rounded-2xl border border-dashed border-slate-300 text-center text-xs text-slate-500">
                    Data Sekretaris UPT PJJ belum ditambahkan.
                </div>
            @endif
        </div>

        <!-- Connector -->
        <div class="flex flex-col items-center py-1">
            <div class="w-0.5 h-8 bg-[#006837]/50"></div>
            <div class="w-2.5 h-2.5 rounded-full bg-[#006837]"></div>
            <div class="w-0.5 h-6 bg-[#006837]/50"></div>
        </div>

        <!-- Level 3: Pimpinan Jurusan (Jurusan, Ketua Jurusan & Sekretaris Jurusan) -->
        <div class="flex flex-col items-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-700 text-white text-[11px] font-bold uppercase tracking-wider shadow-sm mb-4">
                <i class="fa-solid fa-graduation-cap text-teal-200 text-[10px]"></i> Pimpinan Jurusan
            </span>

            @if($jurusanGroups->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 w-full">
                    @foreach($jurusanGroups as $group)
                        <div class="bg-white rounded-2xl border border-teal-200 shadow-sm hover:border-teal-500 transition overflow-hidden flex flex-col">
                            <div class="bg-gradient-to-r from-teal-700 to-emerald-700 px-3.5 py-2.5 text-white">
                                <div class="text-[9px] font-bold uppercase tracking-wider text-teal-100">Jurusan / Prodi</div>
                                <h4 class="text-xs font-extrabold leading-snug mt-0.5 line-clamp-2">{{ $group['jurusan'] }}</h4>
                            </div>

                            <div class="p-3.5 space-y-3 flex-1">
                                <!-- Ketua Jurusan -->
                                <div>
                                    <span class="inline-block text-[9px] font-bold uppercase tracking-wider text-teal-700 px-2 py-0.5 rounded-full bg-teal-50 border border-teal-200 mb-1.5">
                                        Ketua Jurusan
                                    </span>
                                    @if($group['ketua']->isNotEmpty())
                                        <div class="space-y-2">
                                            @foreach($group['ketua'] as $kajur)
                                                <div class="flex items-center gap-2.5">
                                                    <img src="{{ $kajur->photo_url }}" alt="{{ $kajur->name }}" class="w-9 h-9 rounded-lg object-cover border border-teal-200 shadow-sm shrink-0">
                                                    <div class="min-w-0">
                                                        <p class="text-[11px] font-extrabold text-slate-900 leading-snug">{{ $kajur->name }}</p>
                                                        @if(!empty($kajur->nip))
                                                            <p class="text-[10px] text-slate-400 truncate">NIP. {{ $kajur->nip }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-[11px] text-slate-400 italic">Belum diisi</p>
                                    @endif
                                </div>

                                <!-- Sekretaris Jurusan -->
                                <div class="pt-2.5 border-t border-slate-100">
                                    <span class="inline-block text-[9px] font-bold uppercase tracking-wider text-cyan-700 px-2 py-0.5 rounded-full bg-cyan-50 border border-cyan-200 mb-1.5">
                                        Sekretaris Jurusan
                                    </span>
                                    @if($group['sekretaris']->isNotEmpty())
                                        <div class="space-y-2">
                                            @foreach($group['sekretaris'] as $sekjur)
                                                <div class="flex items-center gap-2.5">
                                                    <img src="{{ $sekjur->photo_url }}" alt="{{ $sekjur->name }}" class="w-9 h-9 rounded-lg object-cover border border-cyan-200 shadow-sm shrink-0">
                                                    <div class="min-w-0">
                                                        <p class="text-[11px] font-extrabold text-slate-900 leading-snug">{{ $sekjur->name }}</p>
                                                        @if(!empty($sekjur->nip))
                                                            <p class="text-[10px] text-slate-400 truncate">NIP. {{ $sekjur->nip }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-[11px] text-slate-400 italic">Belum diisi</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="w-full max-w-sm bg-white p-5 rounded-2xl border border-dashed border-slate-300 text-center text-xs text-slate-500">
                    Data Pimpinan Jurusan (Jurusan, Ketua &amp; Sekretaris Jurusan) belum ditambahkan.
                </div>
            @endif
        </div>

        <!-- Connector -->
        <div class="flex flex-col items-center py-1">
            <div class="w-0.5 h-8 bg-[#006837]/50"></div>
            <div class="w-2.5 h-2.5 rounded-full bg-[#006837]"></div>
            <div class="w-0.5 h-6 bg-[#006837]/50"></div>
        </div>

        <!-- Level 4: Staff UPT PJJ -->
        <div class="flex flex-col items-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-800 text-white text-[11px] font-bold uppercase tracking-wider shadow-sm mb-6">
                <i class="fa-solid fa-users text-emerald-300 text-[10px]"></i> Staff UPT PJJ
            </span>

            @if($staffUpt->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 w-full">
                    @foreach($staffUpt as $staff)
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-[#006837] transition flex items-start gap-3.5">
                            <img src="{{ $staff->photo_url }}" alt="{{ $staff->name }}" class="w-14 h-14 rounded-xl object-cover border border-slate-200 shadow-sm shrink-0">
                            <div class="min-w-0">
                                <h5 class="text-sm font-bold text-slate-900 leading-snug">{{ $staff->name }}</h5>
                                <p class="text-xs text-[#006837] font-semibold mt-0.5">{{ $staff->title }}</p>
                                @if($staff->division && $staff->division !== 'Staff UPT PJJ')
                                    <span class="inline-block mt-1 text-[10px] font-semibold px-2 py-0.5 rounded bg-slate-100 text-slate-600">{{ $staff->division }}</span>
                                @endif
                                @if(!empty($staff->nip))
                                    <p class="text-[11px] text-slate-400 mt-1">NIP. {{ $staff->nip }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="w-full max-w-sm bg-white p-5 rounded-2xl border border-dashed border-slate-300 text-center text-xs text-slate-500">
                    Data Staff UPT PJJ belum ditambahkan.
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
