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

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Articles List (8 cols) -->
        <div class="lg:col-span-8 space-y-8">
            
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($posts as $post)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                        <div>
                            <div class="relative h-48 overflow-hidden bg-slate-100">
                                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-[#006837] text-white text-[10px] font-bold uppercase tracking-wider">
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
                    <div class="col-span-2 text-center py-12 bg-white rounded-2xl border border-slate-200">
                        <p class="text-slate-500 text-sm">Tidak ada artikel atau berita yang sesuai dengan kriteria pencarian.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Links -->
            <div class="pt-4">
                {{ $posts->links() }}
            </div>

        </div>

        <!-- Sidebar Widgets (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Search Widget -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-[#006837] mb-3">Pencarian Berita</h4>
                <form action="{{ route('posts.index') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="cari" value="{{ $search }}" placeholder="Cari artikel..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:border-[#006837]">
                        <i class="fa-solid fa-search absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                    </div>
                </form>
            </div>

            <!-- Categories Widget -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-[#006837] pb-2 border-b border-slate-100">Kategori</h4>
                <ul class="space-y-1 text-xs">
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('posts.index', ['kategori' => $cat->slug]) }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-emerald-50 hover:text-[#006837] transition {{ $categorySlug === $cat->slug ? 'text-[#006837] font-bold bg-emerald-50' : 'text-slate-700' }}">
                                <span>{{ $cat->name }}</span>
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-semibold">{{ $cat->posts_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Popular Posts Widget -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-[#006837] pb-2 border-b border-slate-100">Artikel Populer</h4>
                <div class="space-y-3">
                    @foreach($popularPosts as $pop)
                        <a href="{{ route('posts.show', $pop->slug) }}" class="flex items-start gap-3 group">
                            <img src="{{ $pop->image_url }}" alt="{{ $pop->title }}" class="w-14 h-14 rounded-xl object-cover shrink-0 border border-slate-200">
                            <div>
                                <h5 class="text-xs font-semibold text-slate-900 group-hover:text-[#006837] transition line-clamp-2 leading-snug">{{ $pop->title }}</h5>
                                <span class="text-[10px] text-slate-500 mt-1 block"><i class="fa-regular fa-eye text-[#006837] mr-1"></i> {{ number_format($pop->views_count) }} kali</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
