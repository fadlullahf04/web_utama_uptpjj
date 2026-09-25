@extends('layouts.app')

@section('title', 'Profil Lulusan - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Profil</span> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Profil Lulusan</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Profil Lulusan & Capaian Pembelajaran</h1>
        <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">Kompetensi unggul yang dimiliki oleh para lulusan sarjana (S1) dan magister (S2) PJJ UIN Siber Syekh Nurjati Cirebon.</p>
    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3 border-t-4 border-t-[#006837]">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#006837] flex items-center justify-center text-lg">
                <i class="fa-solid fa-laptop-code"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900">Digital Pedagogy Mastery</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Menguasai keahlian pedagogi berbasis digital, pembuatan media edukasi interaktif, perancangan modul e-learning, dan pengelolaan kelas virtual modern.
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3 border-t-4 border-t-teal-600">
            <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center text-lg">
                <i class="fa-solid fa-book-quran"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900">Integrasi Keilmuan Islam</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Memiliki pemahaman keislaman yang moderat (wasathiyah), berkarakter tauhid, dan mampu mengontekstualisasikan ajaran Islam dengan perkembangan sains dan teknologi.
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3 border-t-4 border-t-amber-500">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-lg">
                <i class="fa-solid fa-briefcase"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900">Kepemimpinan & Profesional</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Siap memimpin madrasah/sekolah, menjadi praktisi hukum syariah, mediator, pengembang modul MOOC, maupun melanjutkan studi ke jenjang doktoral (S3).
            </p>
        </div>
    </div>

    <!-- Career Pathways -->
    <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
        <h2 class="text-xl font-bold text-slate-900 text-[#006837]">Peluang & Prospek Karir Lulusan PJJ</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                <h4 class="font-bold text-slate-900 text-sm flex items-center gap-1.5"><i class="fa-solid fa-chalkboard-user text-[#006837]"></i> Pendidik Profesional</h4>
                <p class="text-slate-600">Guru PAI, Guru MI/SD, Guru Bahasa Arab di sekolah umum maupun madrasah di seluruh Indonesia.</p>
            </div>
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                <h4 class="font-bold text-slate-900 text-sm flex items-center gap-1.5"><i class="fa-solid fa-scale-balanced text-purple-600"></i> Praktisi Hukum Syariah</h4>
                <p class="text-slate-600">Penghulu, staf KUA, mediator non-hakim di Pengadilan Agama, advokat syariah, dan konsultan keluarga sakinah.</p>
            </div>
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                <h4 class="font-bold text-slate-900 text-sm flex items-center gap-1.5"><i class="fa-solid fa-clapperboard text-teal-600"></i> Konten Edukator</h4>
                <p class="text-slate-600">Instructional designer, pembuat modul MOOC, edukator digital, dan spesialis kurikulum online.</p>
            </div>
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                <h4 class="font-bold text-slate-900 text-sm flex items-center gap-1.5"><i class="fa-solid fa-user-tie text-amber-600"></i> Manajer Pendidikan (S2)</h4>
                <p class="text-slate-600">Kepala Madrasah, Pengawas Pendidikan Kemenag, Widyaiswara BDK, dan Dosen di perguruan tinggi.</p>
            </div>
        </div>
    </div>

</div>
@endsection
