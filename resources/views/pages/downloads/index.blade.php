@extends('layouts.app')

@section('title', 'Unduhan Dokumen & Pedoman - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Unduhan</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Dokumen, Pedoman & Regulasi</h1>
        <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">Unduh buku pedoman akademik, panduan teknis LMS Pillar, format dokumen penulisan tugas akhir, dan SK resmi penyelenggaraan PJJ.</p>

        <!-- Search Bar -->
        <div class="mt-6 max-w-xl">
            <form action="{{ route('downloads.index') }}" method="GET">
                <div class="relative">
                    <input type="text" name="cari" value="{{ $search }}" placeholder="Cari nama dokumen atau pedoman..." class="w-full pl-11 pr-24 py-3 bg-white border border-emerald-200 rounded-full text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-amber-400 shadow-md">
                    <i class="fa-solid fa-file-lines absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                    <button type="submit" class="absolute right-1.5 top-1.5 px-4 py-1.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs rounded-full transition">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Document Table / Cards (8 cols) -->
        <div class="lg:col-span-8 space-y-4">
            
            @if($category || $search)
                <div class="flex items-center justify-between p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-slate-700">
                    <div>
                        Menampilkan: 
                        @if($category) <span class="font-bold text-[#006837]">Kategori "{{ $category }}"</span> @endif
                        @if($search) <span class="font-bold text-[#006837]">Pencarian "{{ $search }}"</span> @endif
                    </div>
                    <a href="{{ route('downloads.index') }}" class="text-xs font-bold text-red-600 hover:underline">
                        Reset <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>
            @endif

            <div class="space-y-4">
                @forelse($documents as $doc)
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-3.5">
                            <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-200 text-[#006837] flex items-center justify-center text-lg shrink-0 mt-0.5">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#006837] px-2 py-0.5 rounded-full bg-emerald-50 border border-emerald-200">
                                        {{ $doc->category }}
                                    </span>
                                    <span class="text-[10px] text-slate-400">• {{ $doc->file_size ?? 'PDF' }}</span>
                                    <span class="text-[10px] text-emerald-700 font-semibold">• {{ number_format($doc->downloads_count) }}x diunduh</span>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900">{{ $doc->title }}</h3>
                                @if($doc->description)
                                    <p class="text-xs text-slate-600 leading-relaxed">{{ $doc->description }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="shrink-0 w-full sm:w-auto">
                            <a href="{{ route('downloads.file', $doc->id) }}" class="w-full sm:w-auto text-center px-4 py-2.5 rounded-full bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2 shadow-sm">
                                <i class="fa-solid fa-download"></i> Unduh File
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white rounded-2xl border border-slate-200">
                        <p class="text-slate-500 text-sm">Tidak ada dokumen unduhan yang sesuai filter.</p>
                    </div>
                @endforelse
            </div>

            <div class="pt-6">
                {{ $documents->links() }}
            </div>

        </div>

        <!-- Category Sidebar (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-[#006837] pb-2 border-b border-slate-100">
                    Kategori Dokumen
                </h4>
                <ul class="space-y-1 text-xs">
                    <li>
                        <a href="{{ route('downloads.index') }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-emerald-50 hover:text-[#006837] transition {{ !$category ? 'text-[#006837] font-bold bg-emerald-50' : 'text-slate-700' }}">
                            <span>Semua Kategori</span>
                        </a>
                    </li>
                    @foreach($categories as $catName)
                        <li>
                            <a href="{{ route('downloads.index', ['kategori' => $catName]) }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-emerald-50 hover:text-[#006837] transition {{ $category === $catName ? 'text-[#006837] font-bold bg-emerald-50' : 'text-slate-700' }}">
                                <span>{{ $catName }}</span>
                                <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Help Contact Box -->
            <div class="p-6 rounded-2xl bg-gradient-to-br from-[#006837] to-[#004d29] text-white space-y-3 text-xs shadow-lg">
                <h5 class="font-bold text-white text-sm">Butuh Dokumen Lain?</h5>
                <p class="text-emerald-100">Jika Anda membutuhkan SK atau dokumen akademik khusus yang belum tersedia, silakan ajukan permohonan ke tim helpdesk.</p>
                <a href="{{ route('contact.index') }}" class="block text-center py-2.5 rounded-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold transition">
                    Hubungi Layanan Administrasi
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
