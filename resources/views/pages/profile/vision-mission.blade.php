@extends('layouts.app')

@section('title', 'Visi dan Misi - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Profil</span> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Visi & Misi</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Visi, Misi & Nilai Siber</h1>
        <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">Arah strategis dan komitmen fundamental UPT PJJ UINSSC dalam menyelenggarakan pendidikan jarak jauh bereputasi global.</p>
    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Visi Card -->
            <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-[#006837] text-white flex items-center justify-center font-bold text-lg shadow">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <h2 class="text-lg font-extrabold text-slate-900 uppercase tracking-wider">Visi UPT PJJ 2030</h2>
                </div>
                <p class="text-base sm:text-lg text-emerald-900 font-semibold leading-relaxed italic bg-emerald-50/70 p-6 rounded-2xl border border-emerald-100">
                    "{{ \App\Models\Setting::get('vision') }}"
                </p>
            </div>

            <!-- Misi Card -->
            <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-amber-600 text-white flex items-center justify-center font-bold text-lg shadow">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <h2 class="text-lg font-extrabold text-slate-900 uppercase tracking-wider">Misi Strategis</h2>
                </div>
                
                <div class="text-slate-700 text-sm leading-relaxed space-y-3">
                    {!! nl2br(e(\App\Models\Setting::get('mission'))) !!}
                </div>
            </div>

            <!-- 4 Nilai Utama Siber Keislaman -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-shapes text-[#006837]"></i> Nilai Budaya Siber Keislaman (CYBER VALUES)
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-[#006837] flex items-center justify-center font-bold text-xs">01</div>
                        <h4 class="text-sm font-bold text-slate-900">Inovatif & Mutakhir</h4>
                        <p class="text-xs text-slate-600">Terus mengembangkan pedagogi siber, AI learning assistant, dan modul interaktif yang adaptif terhadap era transformasi digital.</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                        <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-800 flex items-center justify-center font-bold text-xs">02</div>
                        <h4 class="text-sm font-bold text-slate-900">Inklusif & Merata</h4>
                        <p class="text-xs text-slate-600">Membuka kesempatan belajar tanpa diskriminasi ruang, batas geografis, maupun kondisi sosial-ekonomi.</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-xs">03</div>
                        <h4 class="text-sm font-bold text-slate-900">Bernafaskan Keislaman</h4>
                        <p class="text-xs text-slate-600">Mengintegrasikan nilai-nilai tauhid, moderasi beragama, dan etika akhlakul karimah dalam seluruh materi perkuliahan.</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-800 flex items-center justify-center font-bold text-xs">04</div>
                        <h4 class="text-sm font-bold text-slate-900">Standar Global</h4>
                        <p class="text-xs text-slate-600">Menjamin mutu kurikulum, akreditasi internasional, serta daya saing lulusan di kancah nasional maupun dunia.</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-[#006837]">Menu Profil</h4>
                <ul class="space-y-1.5 text-xs">
                    <li><a href="{{ route('profile.overview') }}" class="flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-[#006837] transition font-medium"><span>Selayang Pandang</span> <i class="fa-solid fa-chevron-right text-[10px]"></i></a></li>
                    <li><a href="{{ route('profile.vision-mission') }}" class="flex items-center justify-between p-2.5 rounded-xl bg-emerald-50 text-[#006837] font-bold border border-emerald-200"><span>Visi dan Misi</span> <i class="fa-solid fa-chevron-right text-[10px]"></i></a></li>
                    <li><a href="{{ route('profile.organization') }}" class="flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-[#006837] transition font-medium"><span>Struktur Organisasi</span> <i class="fa-solid fa-chevron-right text-[10px]"></i></a></li>
                    <li><a href="{{ route('profile.team') }}" class="flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-[#006837] transition font-medium"><span>Tim UPT PJJ</span> <i class="fa-solid fa-chevron-right text-[10px]"></i></a></li>
                    <li><a href="{{ route('profile.graduate-profile') }}" class="flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-[#006837] transition font-medium"><span>Profil Lulusan</span> <i class="fa-solid fa-chevron-right text-[10px]"></i></a></li>
                    <li><a href="{{ route('profile.facilities') }}" class="flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-[#006837] transition font-medium"><span>Sarana dan Prasarana</span> <i class="fa-solid fa-chevron-right text-[10px]"></i></a></li>
                    <li><a href="{{ route('profile.video-profile') }}" class="flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-[#006837] transition font-medium"><span>Video Profil</span> <i class="fa-solid fa-chevron-right text-[10px]"></i></a></li>
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
