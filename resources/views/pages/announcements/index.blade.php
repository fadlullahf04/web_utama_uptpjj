@extends('layouts.app')

@section('title', 'Pengumuman Akademik - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Pengumuman</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Pengumuman & Surat Edaran</h1>
        <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">Pusat informasi resmi mengenai kalender perkuliahan, registrasi KRS, jadwal UTS/UAS daring, dan beasiswa mahasiswa PJJ.</p>
    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="space-y-4">
        @forelse($announcements as $ann)
            <div class="bg-white p-6 rounded-2xl border {{ $ann->is_pinned ? 'border-amber-400 bg-amber-50/40' : 'border-slate-200' }} shadow-sm hover:shadow-md transition flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-2 max-w-3xl">
                    <div class="flex items-center gap-2 text-xs">
                        @if($ann->is_pinned)
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-500 text-slate-950 text-[10px] font-black uppercase tracking-wider">Disematkan</span>
                        @endif
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-[#006837] font-bold text-[10px] uppercase border border-emerald-200">
                            {{ $ann->category }}
                        </span>
                        <span class="text-slate-400">•</span>
                        <span class="text-slate-500 text-[11px]"><i class="fa-regular fa-calendar mr-1 text-[#006837]"></i> {{ $ann->published_at ? $ann->published_at->format('d M Y') : $ann->created_at->format('d M Y') }}</span>
                    </div>

                    <h3 class="text-base font-bold text-slate-900 hover:text-[#006837] transition">
                        <a href="{{ route('announcements.show', $ann->slug) }}">{{ $ann->title }}</a>
                    </h3>
                    <p class="text-xs text-slate-600 line-clamp-2">
                        {{ \Illuminate\Support\Str::limit(strip_tags($ann->content), 180) }}
                    </p>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    @if($ann->attachment_file)
                        <a href="{{ $ann->attachment_url }}" target="_blank" class="px-4 py-2 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-file-pdf"></i> Unduh Lampiran
                        </a>
                    @endif
                    <a href="{{ route('announcements.show', $ann->slug) }}" class="px-4 py-2 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs transition">
                        Detail →
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-2xl border border-slate-200">
                <p class="text-slate-500 text-sm">Tidak ada pengumuman saat ini.</p>
            </div>
        @endforelse

        <div class="pt-6">
            {{ $announcements->links() }}
        </div>
    </div>
</div>
@endsection
