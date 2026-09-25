@extends('layouts.app')

@section('title', 'Selayang Pandang - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Profil</span> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Selayang Pandang</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Selayang Pandang & Sambutan</h1>
        <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">Mengenal lebih dekat peran strategis UPT PJJ UIN Siber Syekh Nurjati Cirebon sebagai pelopor Cyber Islamic University di Indonesia.</p>
    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Main Article / Greetings -->
        <div class="lg:col-span-8 space-y-8">
            
            <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 pb-6 border-b border-slate-100">
                    <img src="{{ \App\Models\Setting::get('head_photo', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=600&auto=format&fit=crop') }}" alt="Kepala UPT PJJ" class="w-28 h-28 rounded-2xl object-cover shadow-md border-2 border-emerald-500">
                    <div class="text-center sm:text-left">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#006837] px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200">Sambutan Kepala Unit</span>
                        <h2 class="text-xl font-extrabold text-slate-900 mt-1">{{ \App\Models\Setting::get('head_name', 'Dr. Moh. Ali, M.Pd.I') }}</h2>
                        <p class="text-xs text-slate-500">{{ \App\Models\Setting::get('head_title', 'Kepala UPT Pendidikan Jarak Jauh UINSSC') }}</p>
                    </div>
                </div>

                <div class="text-slate-700 text-sm leading-relaxed space-y-4">
                    {!! nl2br(e(\App\Models\Setting::get('head_greeting'))) !!}
                </div>

                <div class="pt-6 border-t border-slate-100 text-xs text-slate-500 italic border-l-2 border-[#006837] pl-4">
                    "Teknologi siber adalah jembatan emas untuk meratakan akses pendidikan Islam berkualitas tinggi ke seluruh penjuru dunia."
                </div>

            </div>

            <!-- About Institution Context -->
            <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-landmark text-[#006837]"></i> Mandat Nasional Cyber Islamic University
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Universitas Islam Negeri Siber Syekh Nurjati Cirebon (UINSSC) merupakan institusi perguruan tinggi keagamaan Islam negeri pertama yang ditetapkan oleh Pemerintah Republik Indonesia melalui Kementerian Agama RI untuk bertransformasi penuh menjadi universitas berbasis siber.
                </p>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Unit Pelaksana Teknis Pendidikan Jarak Jauh (UPT PJJ) bertindak sebagai pusat komando operasional seluruh ekosistem pembelajaran daring jarak jauh, pengembangan kurikulum digital modular, manajemen Learning Management System (LMS Pillar), penjaminan mutu pedagogi siber, hingga layanan helpdesk terpadu bagi ribuan mahasiswa dari Sabang sampai Merauke.
                </p>
            </div>

        </div>

        <!-- Sidebar Navigation & Links -->
        <div class="lg:col-span-4 space-y-6">
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-[#006837]">Menu Profil</h4>
                <ul class="space-y-1.5 text-xs">
                    <li><a href="{{ route('profile.overview') }}" class="flex items-center justify-between p-2.5 rounded-xl bg-emerald-50 text-[#006837] font-bold border border-emerald-200"><span>Selayang Pandang</span> <i class="fa-solid fa-chevron-right text-[10px]"></i></a></li>
                    <li><a href="{{ route('profile.vision-mission') }}" class="flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-[#006837] transition font-medium"><span>Visi dan Misi</span> <i class="fa-solid fa-chevron-right text-[10px]"></i></a></li>
                    <li><a href="{{ route('profile.organization') }}" class="flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-[#006837] transition font-medium"><span>Struktur Organisasi</span> <i class="fa-solid fa-chevron-right text-[10px]"></i></a></li>
                    <li><a href="{{ route('profile.team') }}" class="flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-[#006837] transition font-medium"><span>Tim UPT PJJ</span> <i class="fa-solid fa-chevron-right text-[10px]"></i></a></li>
                    <li><a href="{{ route('profile.graduate-profile') }}" class="flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-[#006837] transition font-medium"><span>Profil Lulusan</span> <i class="fa-solid fa-chevron-right text-[10px]"></i></a></li>
                    <li><a href="{{ route('profile.facilities') }}" class="flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-[#006837] transition font-medium"><span>Sarana dan Prasarana</span> <i class="fa-solid fa-chevron-right text-[10px]"></i></a></li>
                    <li><a href="{{ route('profile.video-profile') }}" class="flex items-center justify-between p-2.5 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-[#006837] transition font-medium"><span>Video Profil</span> <i class="fa-solid fa-chevron-right text-[10px]"></i></a></li>
                </ul>
            </div>

            <!-- LMS & PMB CTA Card -->
            <div class="p-6 rounded-2xl bg-gradient-to-br from-[#006837] to-[#004d29] text-white text-center space-y-4 shadow-lg">
                <div class="w-12 h-12 rounded-xl bg-white/20 text-white mx-auto flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <h5 class="text-sm font-bold text-white">Mulai Kuliah PJJ</h5>
                    <p class="text-[11px] text-emerald-100 mt-1">Daftar secara online dan nikmati kemudahan belajar fleksibel.</p>
                </div>
                <a href="{{ \App\Models\Setting::get('pmb_url', 'https://pmb.uinssc.ac.id') }}" target="_blank" class="block w-full py-2.5 rounded-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition shadow">
                    Daftar PMB Sekarang
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
