@extends('layouts.app')

@section('title', $announcement->title . ' - UPT Pendidikan Jarak Jauh UINSSC')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($announcement->content), 155))

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-2">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <a href="{{ route('announcements.index') }}" class="hover:underline">Pengumuman</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>{{ $announcement->category }}</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight max-w-4xl">
            {{ $announcement->title }}
        </h1>
        <div class="flex items-center gap-3 text-xs text-emerald-100 pt-2 border-t border-white/20">
            <span><i class="fa-regular fa-calendar mr-1"></i> Dipublikasikan: {{ $announcement->published_at ? $announcement->published_at->format('d F Y') : $announcement->created_at->format('d F Y') }}</span>
            <span>•</span>
            <span class="text-amber-300 font-bold uppercase">{{ $announcement->category }}</span>
        </div>
    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        
        <!-- Left: Main Announcement Body (8 cols) -->
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <div class="article-content text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
                    @if(strip_tags($announcement->content) !== $announcement->content)
                        {!! $announcement->clean_content !!}
                    @else
                        {!! nl2br(e($announcement->content)) !!}
                    @endif
                </div>

                @if($announcement->attachment_file)
                    <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between p-5 rounded-2xl bg-emerald-50/70 border border-emerald-200 gap-4">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-xl shrink-0 shadow-2xs">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <div>
                                <h4 class="text-xs sm:text-sm font-bold text-slate-900">{{ $announcement->attachment_name ?? 'Dokumen Lampiran Pengumuman' }}</h4>
                                <p class="text-[11px] text-slate-500">Berkas Resmi Format PDF</p>
                            </div>
                        </div>
                        <a href="{{ $announcement->attachment_url }}" target="_blank" class="px-5 py-2.5 rounded-full bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition flex items-center gap-2 shadow shrink-0">
                            <i class="fa-solid fa-download"></i> Unduh File
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Information Box & Other Announcements (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider text-[#006837] pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-bullhorn"></i> Informasi Pengumuman
                </h4>
                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500 font-medium">Kategori:</span>
                        <span class="font-bold text-amber-800 bg-amber-50 px-2.5 py-0.5 rounded-full">{{ $announcement->category }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500 font-medium">Status:</span>
                        <span class="font-bold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full">Resmi UPT PJJ</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500 font-medium">Tanggal:</span>
                        <span class="font-bold text-slate-700">{{ $announcement->published_at ? $announcement->published_at->format('d M Y') : $announcement->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5">
                        <span class="text-slate-500 font-medium">Pertanyaan:</span>
                        <a href="{{ route('contact.index') }}" class="font-bold text-[#006837] hover:underline">Helpdesk Akademik</a>
                    </div>
                </div>
            </div>

            @if($recentAnnouncements->count() > 0)
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider text-[#006837] pb-3 border-b border-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left"></i> Pengumuman Lainnya
                    </h4>
                    <div class="space-y-3">
                        @foreach($recentAnnouncements as $ra)
                            <a href="{{ route('announcements.show', $ra->slug) }}" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200/80 hover:border-emerald-300 transition block group">
                                <span class="text-[10px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded font-bold uppercase">{{ $ra->category }}</span>
                                <h5 class="text-xs font-bold text-slate-900 group-hover:text-[#006837] transition mt-1.5 line-clamp-2">{{ $ra->title }}</h5>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    </div>
</div>
@endsection
