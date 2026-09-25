@extends('layouts.app')

@section('title', $program->name . ' - UPT PJJ UINSSC')

@section('content')
<!-- Program Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-4">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <a href="{{ route('programs.index') }}" class="hover:underline">Program Studi</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>{{ $program->degree }}</span>
        </div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-3 max-w-3xl">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3 py-1 rounded-full {{ $program->degree === 'S2' ? 'bg-amber-500 text-slate-950' : 'bg-white text-[#006837]' }} text-xs font-extrabold uppercase">
                        Jenjang {{ $program->degree }}
                    </span>
                    <span class="px-3 py-1 rounded-full bg-emerald-900/60 border border-emerald-300/40 text-emerald-200 text-xs font-bold">
                        Akreditasi {{ $program->accreditation }}
                    </span>
                    @if($program->code)
                        <span class="px-3 py-1 rounded-full bg-black/20 text-white text-xs font-semibold">
                            Kode: {{ $program->code }}
                        </span>
                    @endif
                </div>

                <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    {{ $program->name }}
                </h1>
                <p class="text-xs sm:text-sm text-emerald-100 font-medium flex items-center gap-2">
                    <i class="fa-solid fa-university"></i> {{ $program->faculty }}
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ $program->registration_url ?? \App\Models\Setting::get('pmb_url', 'https://pmb.uinssc.ac.id') }}" target="_blank" class="px-6 py-3.5 rounded-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs uppercase tracking-wider shadow-lg transition transform hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus"></i> Daftar PMB Online
                </a>
                @if($program->website_url)
                    <a href="{{ $program->website_url }}" target="_blank" class="px-5 py-3.5 rounded-full bg-white/15 hover:bg-white/25 text-white font-bold text-xs uppercase tracking-wider transition flex items-center gap-2">
                        <i class="fa-solid fa-globe"></i> Website Prodi
                    </a>
                @endif
            </div>
        </div>

    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Main Content (8 cols) -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Cover Image -->
            <div class="bg-white p-3 rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <img src="{{ $program->image_url }}" alt="{{ $program->name }}" class="w-full h-80 object-cover rounded-2xl">
            </div>

            <!-- Ringkasan Profil & Deskripsi -->
            <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <h2 class="text-xl font-bold text-slate-900 text-[#006837] flex items-center gap-2">
                    <i class="fa-solid fa-circle-info"></i> Deskripsi Program Studi
                </h2>
                <div class="text-slate-700 text-sm leading-relaxed space-y-3">
                    <p>{{ $program->description ?? $program->short_description }}</p>
                </div>
            </div>

            <!-- Visi & Misi Prodi -->
            @if($program->vision_mission)
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                    <h2 class="text-xl font-bold text-slate-900 text-[#006837] flex items-center gap-2">
                        <i class="fa-solid fa-bullseye"></i> Visi & Misi Keilmuan
                    </h2>
                    <div class="text-slate-700 text-sm leading-relaxed bg-emerald-50/60 p-5 rounded-2xl border border-emerald-100">
                        <p class="italic text-emerald-950 font-medium">"{{ $program->vision_mission }}"</p>
                    </div>
                </div>
            @endif

            <!-- Metode Belajar & Sistem Kuliah Siber -->
            <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <h2 class="text-xl font-bold text-slate-900 text-[#006837] flex items-center gap-2">
                    <i class="fa-solid fa-laptop"></i> Metode Perkuliahan Siber
                </h2>
                <div class="text-slate-700 text-sm leading-relaxed space-y-2">
                    <p>{{ $program->learning_method ?? '100% Online melalui LMS Pillar, Micro-learning, Forum Diskusi Asinkron, Video Modul MOOC Studio, dan Virtual Classroom Berkala.' }}</p>
                </div>
            </div>

        </div>

        <!-- Sidebar Summary Cards (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Quick Facts Card -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-md space-y-5">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-[#006837] pb-2 border-b border-slate-100">
                    Informasi Akademik
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Jenjang:</span>
                        <span class="font-bold text-slate-900">{{ $program->degree }}</span>
                    </div>

                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Akreditasi:</span>
                        <span class="font-bold text-[#006837] bg-emerald-50 px-2 py-0.5 rounded">{{ $program->accreditation }}</span>
                    </div>

                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Gelar Lulusan:</span>
                        <span class="font-bold text-slate-900">{{ $program->graduate_title }}</span>
                    </div>

                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Masa Studi:</span>
                        <span class="font-bold text-slate-900">{{ $program->study_duration }}</span>
                    </div>

                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Beban SKS:</span>
                        <span class="font-bold text-slate-900">{{ $program->total_credits }} SKS</span>
                    </div>

                    @if($program->head_of_program)
                        <div class="pt-2">
                            <span class="text-slate-500 block text-[11px]">Ketua Program Studi:</span>
                            <span class="font-bold text-slate-900 text-xs mt-0.5 block">{{ $program->head_of_program }}</span>
                        </div>
                    @endif
                </div>

                <div class="pt-3">
                    <a href="{{ $program->registration_url ?? \App\Models\Setting::get('pmb_url', 'https://pmb.uinssc.ac.id') }}" target="_blank" class="block w-full text-center py-3 rounded-full bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider shadow-md transition">
                        Daftar PMB Online →
                    </a>
                </div>
            </div>

            <!-- Other Programs List -->
            @if($otherPrograms->count() > 0)
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Program Studi Lainnya</h4>
                    <div class="space-y-2.5">
                        @foreach($otherPrograms as $op)
                            <a href="{{ route('programs.show', $op->slug) }}" class="block p-3 rounded-xl bg-slate-50 hover:bg-emerald-50 hover:border-[#006837] border border-slate-200 transition">
                                <div class="flex items-center justify-between text-[10px] text-[#006837] font-bold mb-1">
                                    <span>Jenjang {{ $op->degree }}</span>
                                    <span class="bg-emerald-100 px-1.5 py-0.5 rounded text-emerald-800">{{ $op->accreditation }}</span>
                                </div>
                                <h5 class="text-xs font-bold text-slate-900 hover:text-[#006837] transition">{{ $op->name }}</h5>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    </div>
</div>
@endsection
