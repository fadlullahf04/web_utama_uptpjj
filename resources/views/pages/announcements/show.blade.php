@extends('layouts.app')

@section('title', $announcement->title . ' - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-2">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <a href="{{ route('announcements.index') }}" class="hover:underline">Pengumuman</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>{{ $announcement->category }}</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight">
            {{ $announcement->title }}
        </h1>
        <div class="flex items-center gap-3 text-xs text-emerald-100 pt-2 border-t border-white/20">
            <span><i class="fa-regular fa-calendar mr-1"></i> Dipublikasikan: {{ $announcement->published_at ? $announcement->published_at->format('d F Y') : $announcement->created_at->format('d F Y') }}</span>
            <span>•</span>
            <span class="text-amber-300 font-bold uppercase">{{ $announcement->category }}</span>
        </div>
    </div>
</div>

<div class="py-14 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
    <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-6">
        <div class="text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
            {!! nl2br(e($announcement->content)) !!}
        </div>

        @if($announcement->attachment_file)
            <div class="pt-6 border-t border-slate-100 flex items-center justify-between p-4 rounded-2xl bg-emerald-50/60 border border-emerald-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-900">{{ $announcement->attachment_name ?? 'Dokumen Lampiran Pengumuman' }}</h4>
                        <p class="text-[11px] text-slate-500">Format Dokumen Resmi (PDF)</p>
                    </div>
                </div>
                <a href="{{ $announcement->attachment_url }}" target="_blank" class="px-5 py-2.5 rounded-full bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition flex items-center gap-2 shadow">
                    <i class="fa-solid fa-download"></i> Unduh File
                </a>
            </div>
        @endif
    </div>

    @if($recentAnnouncements->count() > 0)
        <div class="space-y-4 pt-4">
            <h3 class="text-base font-bold text-slate-900 text-[#006837]">Pengumuman Akademik Lainnya</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($recentAnnouncements as $ra)
                    <a href="{{ route('announcements.show', $ra->slug) }}" class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-[#006837] hover:shadow-md transition block">
                        <span class="text-[10px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded font-bold uppercase">{{ $ra->category }}</span>
                        <h5 class="text-xs font-bold text-slate-900 hover:text-[#006837] transition mt-1.5 line-clamp-2">{{ $ra->title }}</h5>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
