@extends('layouts.app')

@section('title', 'Tutorial & Panduan LMS Pillar - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Course & Tutorial</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Tutorial Penggunaan LMS Pillar</h1>
        <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">Panduan langkah demi langkah bagi dosen dan mahasiswa dalam memanfaatkan seluruh fitur perkuliahan digital di LMS Pillar UINSSC.</p>
        
        <div class="mt-6 flex flex-wrap items-center gap-4">
            <a href="{{ \App\Models\Setting::get('lms_url', 'https://pillar.uinssc.ac.id') }}" target="_blank" class="px-6 py-3 rounded-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold text-xs uppercase tracking-wider shadow-lg transition flex items-center gap-2">
                <i class="fa-solid fa-graduation-cap text-sm"></i> Buka LMS Pillar Sekarang
            </a>
            <a href="#video-tutorial" class="px-5 py-3 rounded-full bg-white/15 hover:bg-white/25 text-white font-bold text-xs uppercase tracking-wider transition flex items-center gap-2">
                <i class="fa-solid fa-play text-emerald-300"></i> Video Panduan
            </a>
        </div>
    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
    
    <!-- 4 Langkah Cepat Memulai Belajar di LMS -->
    <div class="space-y-8">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-xs font-bold uppercase text-[#006837] tracking-wider bg-emerald-50 px-3 py-1 rounded-full">Quick Start Guide</span>
            <h2 class="text-2xl font-extrabold text-slate-900">4 Langkah Mudah Belajar di LMS Pillar</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3 relative">
                <div class="w-10 h-10 rounded-xl bg-[#006837] text-white flex items-center justify-center font-extrabold text-sm shadow">01</div>
                <h3 class="text-sm font-bold text-slate-900">Aktivasi Akun & Login</h3>
                <p class="text-xs text-slate-600">Gunakan NIM sebagai username dan email kampus @mhs.uinssc.ac.id yang telah diverifikasi.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3 relative">
                <div class="w-10 h-10 rounded-xl bg-teal-700 text-white flex items-center justify-center font-extrabold text-sm shadow">02</div>
                <h3 class="text-sm font-bold text-slate-900">Akses Modul & Video</h3>
                <p class="text-xs text-slate-600">Buka mata kuliah terdaftar, pelajari video instruksional dari studio siber, dan baca modul SCORM.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3 relative">
                <div class="w-10 h-10 rounded-xl bg-amber-600 text-white flex items-center justify-center font-extrabold text-sm shadow">03</div>
                <h3 class="text-sm font-bold text-slate-900">Diskusi & Kuis</h3>
                <p class="text-xs text-slate-600">Aktif di forum diskusi asinkron, kerjakan latihan mandiri, dan submit tugas modul berkala.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3 relative">
                <div class="w-10 h-10 rounded-xl bg-blue-700 text-white flex items-center justify-center font-extrabold text-sm shadow">04</div>
                <h3 class="text-sm font-bold text-slate-900">Ujian Online & Nilai</h3>
                <p class="text-xs text-slate-600">Ikuti UTS dan UAS online berbasis CBT, pantau progress capaian nilai secara transparan di dashboard.</p>
            </div>
        </div>
    </div>

    <!-- Video Tutorial Section -->
    <div id="video-tutorial" class="space-y-6 pt-6">
        <h2 class="text-xl font-bold text-slate-900 text-[#006837] flex items-center gap-2">
            <i class="fa-solid fa-video"></i> Video Tutorial LMS Pillar
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                <div class="relative w-full rounded-2xl overflow-hidden bg-black" style="padding-top: 56.25%;">
                    <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Tutorial Mahasiswa" frameborder="0" allowfullscreen></iframe>
                </div>
                <h4 class="text-sm font-bold text-slate-900">Tutorial Panduan Lengkap untuk Mahasiswa</h4>
                <p class="text-xs text-slate-600">Menjelaskan cara login, submit tugas, presensi perkuliahan, dan penggunaan forum asinkron.</p>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                <div class="relative w-full rounded-2xl overflow-hidden bg-black" style="padding-top: 56.25%;">
                    <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Tutorial Dosen" frameborder="0" allowfullscreen></iframe>
                </div>
                <h4 class="text-sm font-bold text-slate-900">Panduan Pengelolaan Kelas & Penilaian untuk Dosen Pengampu</h4>
                <p class="text-xs text-slate-600">Tata cara pembuatan rubrik evaluasi, setting kuis interaktif, dan penjadwalan virtual classroom.</p>
            </div>
        </div>
    </div>

    <!-- Downloadable LMS Manuals -->
    <div class="space-y-6">
        <h2 class="text-xl font-bold text-slate-900 text-[#006837] flex items-center gap-2">
            <i class="fa-solid fa-book-bookmark"></i> Buku Manual & Petunjuk Teknis (PDF)
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($lmsDocs as $doc)
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-3">
                    <div class="space-y-2">
                        <div class="w-9 h-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-sm font-bold">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <h4 class="text-xs font-bold text-slate-900">{{ $doc->title }}</h4>
                        <p class="text-[11px] text-slate-600 line-clamp-2">{{ $doc->description }}</p>
                    </div>
                    <a href="{{ route('downloads.file', $doc->id) }}" class="text-center py-2 rounded-full bg-emerald-50 hover:bg-[#006837] text-[#006837] hover:text-white font-bold text-xs transition flex items-center justify-center gap-1.5 border border-emerald-200">
                        <i class="fa-solid fa-download"></i> Unduh Buku Manual
                    </a>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
