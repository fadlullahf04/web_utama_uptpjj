@extends('layouts.app')

@section('title', 'Berita & Informasi - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Berita & Informasi</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Berita & Informasi Terkini</h1>
        <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">Ikuti perkembangan terbaru seputar kegiatan akademik, bimbingan teknis, LMS Pillar, dan transformasi pendidikan siber UPT PJJ UINSSC.</p>
    </div>
</div>

<div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

    <!-- Professional Filter & Search Toolbar (Fullscreen Layout) -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3.5 border-b border-slate-100">
            <div class="flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-slate-700">
                <span class="w-7 h-7 rounded-lg bg-emerald-50 text-[#006837] flex items-center justify-center border border-emerald-100">
                    <i class="fa-solid fa-layer-group text-[11px]"></i>
                </span>
                <span>Kategori Berita & Informasi</span>
            </div>

            <form action="{{ route('posts.index') }}" method="GET" class="w-full sm:w-80 shrink-0">
                @if($categorySlug)
                    <input type="hidden" name="kategori" value="{{ $categorySlug }}">
                @endif
                <div class="relative flex items-center">
                    <i class="fa-solid fa-search absolute left-3.5 text-slate-400 text-xs pointer-events-none"></i>
                    <input type="text" name="cari" value="{{ $search }}" placeholder="Cari berita atau artikel..." class="w-full pl-9 pr-16 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:bg-white focus:outline-none focus:border-[#006837] transition">
                    <button type="submit" class="absolute right-1.5 px-2.5 py-1 rounded-lg bg-[#006837] hover:bg-[#004d29] text-white text-[11px] font-bold transition cursor-pointer">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('posts.index', $search ? ['cari' => $search] : []) }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold border transition {{ !$categorySlug ? 'bg-[#006837] border-[#006837] text-white shadow-sm shadow-[#006837]/20' : 'bg-slate-50/80 border-slate-200 text-slate-700 hover:bg-emerald-50 hover:border-emerald-300 hover:text-[#006837]' }}">
                <i class="fa-solid fa-border-all text-[10px]"></i>
                <span>Semua Berita</span>
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('posts.index', array_filter(['kategori' => $cat->slug, 'cari' => $search])) }}"
                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold border transition {{ $categorySlug === $cat->slug ? 'bg-[#006837] border-[#006837] text-white shadow-sm shadow-[#006837]/20' : 'bg-slate-50/80 border-slate-200 text-slate-700 hover:bg-emerald-50 hover:border-emerald-300 hover:text-[#006837]' }}">
                    <span>{{ $cat->name }}</span>
                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md {{ $categorySlug === $cat->slug ? 'bg-white/20 text-white' : 'bg-white text-slate-500 border border-slate-200/80' }}">{{ $cat->posts_count }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Active Filter Badge -->
    @if($categorySlug || $search)
        <div class="flex items-center justify-between p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-slate-700">
            <div>
                Menampilkan hasil untuk: 
                @if($categorySlug) <span class="font-bold text-[#006837]">Kategori "{{ $categorySlug }}"</span> @endif
                @if($search) <span class="font-bold text-[#006837]">Pencarian "{{ $search }}"</span> @endif
            </div>
            <a href="{{ route('posts.index') }}" class="text-xs font-bold text-red-600 hover:underline">
                Reset Filter <i class="fa-solid fa-xmark"></i>
            </a>
        </div>
    @endif

    <!-- Fullscreen 3-Column Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($posts as $post)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                <div>
                    <div class="relative h-52 overflow-hidden bg-slate-100">
                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <span class="absolute top-3 left-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white/95 backdrop-blur-sm text-[#006837] border border-emerald-200/80 shadow-sm text-[10px] font-extrabold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#006837]"></span>
                                    {{ $post->category->name ?? 'Berita' }}
                                </span>
                    </div>

                    <div class="p-6 space-y-3">
                        <div class="flex items-center gap-3 text-[11px] text-slate-500">
                            <span><i class="fa-regular fa-calendar text-[#006837] mr-1"></i> {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                            <span><i class="fa-regular fa-eye text-emerald-600 mr-1"></i> {{ number_format($post->views_count) }} views</span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 group-hover:text-[#006837] transition line-clamp-2 leading-snug">
                            <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                            {{ $post->excerpt }}
                        </p>
                    </div>
                </div>

                <div class="p-6 pt-0">
                    <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition shadow-sm">
                        <span>Selengkapnya</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-slate-200">
                <p class="text-slate-500 text-sm">Tidak ada artikel atau berita yang sesuai dengan kriteria pencarian.</p>
            </div>
        @endforelse
    </div>

    <!-- Proportional Pagination Links -->
    <div class="pt-2">
        {{ $posts->links('partials.pagination') }}
    </div>

</div>
@endsection
