@extends('layouts.admin')

@section('title', 'Dashboard Overview')
@section('header_title', 'Dashboard Overview')
@section('header_subtitle', 'Selamat datang di Panel Manajemen Konten UPT PJJ UINSSC')

@section('content')
<div class="space-y-8">
    
    <!-- Quick Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Berita -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Total Berita</span>
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_posts'] }}</div>
                <div class="text-[10px] text-[#006837] font-semibold">{{ number_format($stats['total_views']) }} total views</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#006837] flex items-center justify-center text-xl">
                <i class="fa-solid fa-newspaper"></i>
            </div>
        </div>

        <!-- Program Studi -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Program Studi</span>
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_programs'] }}</div>
                <div class="text-[10px] text-amber-700 font-semibold">Jenjang S1 & S2 Magister</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
        </div>

        <!-- Unduhan Dokumen -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Dokumen Unduhan</span>
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_downloads'] }}</div>
                <div class="text-[10px] text-[#006837] font-semibold">{{ number_format($stats['total_download_clicks']) }} kali diunduh</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#006837] flex items-center justify-center text-xl">
                <i class="fa-solid fa-file-arrow-down"></i>
            </div>
        </div>

        <!-- Pesan Masuk / Helpdesk -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Pesan Helpdesk</span>
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_messages'] }}</div>
                @if($stats['unread_messages'] > 0)
                    <div class="text-[10px] text-red-600 font-bold animate-pulse">{{ $stats['unread_messages'] }} pesan baru belum dibaca</div>
                @else
                    <div class="text-[10px] text-slate-400">Semua pesan sudah dibaca</div>
                @endif
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-xl">
                <i class="fa-solid fa-inbox"></i>
            </div>
        </div>

    </div>

    <!-- Quick Actions Bar -->
    <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-wrap items-center justify-between gap-4">
        <div class="space-y-1">
            <h3 class="text-sm font-bold text-slate-900">Aksi Cepat Pengelolaan</h3>
            <p class="text-xs text-slate-500">Pintasan menu untuk memperbarui konten website UPT PJJ.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.posts.create') }}" class="px-4 py-2 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs transition flex items-center gap-1.5 shadow-md shadow-[#006837]/20">
                <i class="fa-solid fa-pen-to-square"></i> Tulis Berita
            </a>
            <a href="{{ route('admin.announcements.create') }}" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs transition flex items-center gap-1.5">
                <i class="fa-solid fa-bullhorn"></i> Buat Pengumuman
            </a>
            <a href="{{ route('admin.downloads.create') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center gap-1.5 border border-slate-200">
                <i class="fa-solid fa-upload text-[#006837]"></i> Unggah Dokumen
            </a>
            <a href="{{ route('admin.settings.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center gap-1.5 border border-slate-200">
                <i class="fa-solid fa-sliders text-amber-600"></i> Pengaturan Situs
            </a>
        </div>
    </div>

    <!-- 2 Column Details: Recent Messages & Recent News -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left: Pesan Masuk Terbaru (7 cols) -->
        <div class="lg:col-span-7 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-envelope text-[#006837]"></i>
                    <h3 class="text-sm font-bold text-slate-900">Pesan Masuk Helpdesk Terbaru</h3>
                </div>
                <a href="{{ route('admin.contacts.index') }}" class="text-xs text-[#006837] font-semibold hover:underline">
                    Lihat Semua ({{ $stats['total_messages'] }}) →
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentMessages as $msg)
                    <a href="{{ route('admin.contacts.show', $msg->id) }}" class="block p-4 rounded-xl {{ !$msg->is_read ? 'bg-emerald-50/70 border border-emerald-300' : 'bg-slate-50 border border-slate-200' }} hover:border-[#006837] hover:bg-white transition">
                        <div class="flex items-center justify-between text-[11px] mb-1">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-900">{{ $msg->name }}</span>
                                @if(!$msg->is_read)
                                    <span class="px-1.5 py-0.5 rounded bg-red-500 text-white text-[9px] font-extrabold uppercase">Baru</span>
                                @endif
                            </div>
                            <span class="text-slate-400">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-xs font-semibold text-[#006837]">{{ $msg->subject }}</div>
                        <p class="text-[11px] text-slate-600 line-clamp-1 mt-1">{{ $msg->message }}</p>
                    </a>
                @empty
                    <p class="text-center py-6 text-xs text-slate-400">Belum ada pesan masuk.</p>
                @endforelse
            </div>
        </div>

        <!-- Right: Berita & Pengumuman Terbaru (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-newspaper text-[#006837]"></i>
                        <h3 class="text-sm font-bold text-slate-900">Berita Terbaru</h3>
                    </div>
                    <a href="{{ route('admin.posts.index') }}" class="text-xs text-[#006837] font-semibold hover:underline">Kelola →</a>
                </div>

                <div class="space-y-3">
                    @foreach($recentPosts as $p)
                        <div class="flex items-start justify-between gap-3 text-xs">
                            <div class="space-y-0.5">
                                <span class="text-[10px] text-[#006837] font-bold uppercase">{{ $p->category->name ?? 'Berita' }}</span>
                                <h4 class="font-bold text-slate-800 line-clamp-1 hover:text-[#006837]">
                                    <a href="{{ route('admin.posts.edit', $p->id) }}">{{ $p->title }}</a>
                                </h4>
                                <span class="text-[10px] text-slate-400">{{ $p->published_at ? $p->published_at->format('d M Y') : $p->created_at->format('d M Y') }} • {{ number_format($p->views_count) }} views</span>
                            </div>
                            <a href="{{ route('admin.posts.edit', $p->id) }}" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 shrink-0">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-bullhorn text-amber-600"></i>
                        <h3 class="text-sm font-bold text-slate-900">Pengumuman Aktif</h3>
                    </div>
                    <a href="{{ route('admin.announcements.index') }}" class="text-xs text-amber-600 font-semibold hover:underline">Kelola →</a>
                </div>

                <div class="space-y-3">
                    @foreach($recentAnnouncements as $a)
                        <div class="text-xs space-y-0.5">
                            <div class="flex items-center justify-between text-[10px] text-slate-400">
                                <span class="text-amber-600 font-bold">{{ $a->category }}</span>
                                <span>{{ $a->published_at ? $a->published_at->format('d M Y') : $a->created_at->format('d M Y') }}</span>
                            </div>
                            <h4 class="font-bold text-slate-800 line-clamp-1">
                                <a href="{{ route('admin.announcements.edit', $a->id) }}" class="hover:text-amber-600">{{ $a->title }}</a>
                            </h4>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
