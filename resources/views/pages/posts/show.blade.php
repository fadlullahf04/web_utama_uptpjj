@extends('layouts.app')

@section('title', $post->title . ' - UPT Pendidikan Jarak Jauh UINSSC')
@section('meta_description', $post->excerpt)

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-2">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <a href="{{ route('posts.index') }}" class="hover:underline">Berita</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>{{ $post->category->name ?? 'Informasi' }}</span>
        </div>

        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight">
            {{ $post->title }}
        </h1>

        <div class="flex flex-wrap items-center gap-4 text-xs text-emerald-100 pt-2 border-t border-white/20">
            <span class="flex items-center gap-1.5"><i class="fa-solid fa-user-pen text-amber-300"></i> {{ $post->author->name ?? 'Humas UPT PJJ' }}</span>
            <span>•</span>
            <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar-days text-emerald-300"></i> {{ $post->published_at ? $post->published_at->format('d F Y') : $post->created_at->format('d F Y') }}</span>
            <span>•</span>
            <span class="flex items-center gap-1.5"><i class="fa-regular fa-eye text-amber-300"></i> {{ number_format($post->views_count) }} kali dibaca</span>
            <span>•</span>
            <span class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-teal-300"></i> {{ $post->reading_time }} menit baca</span>
        </div>

    </div>
</div>

<div class="py-14 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
    
    <!-- Cover Image -->
    <div class="bg-white p-3 rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-[420px] object-cover rounded-2xl">
    </div>

    <!-- Article Content -->
    <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-6">
        <div class="text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
            {!! $post->content !!}
        </div>

        <!-- Tags & Share Strip -->
        <div class="pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            @if($post->tags)
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="text-slate-500 font-bold"><i class="fa-solid fa-tags text-[#006837] mr-1"></i> Tags:</span>
                    @foreach(explode(',', $post->tags) as $tag)
                        <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-medium border border-slate-200">#{{ trim($tag) }}</span>
                    @endforeach
                </div>
            @endif

            <div class="flex items-center gap-2 text-xs">
                <span class="text-slate-500 font-bold">Bagikan:</span>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white flex items-center justify-center transition shadow" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-blue-600 hover:bg-blue-500 text-white flex items-center justify-center transition shadow" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-900 hover:bg-slate-800 text-white flex items-center justify-center transition shadow" title="X"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
        </div>
    </div>

    <!-- Related Articles -->
    @if($relatedPosts->count() > 0)
        <div class="space-y-6 pt-6">
            <h3 class="text-xl font-bold text-slate-900 text-[#006837]">Berita & Informasi Terkait</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedPosts as $rel)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition overflow-hidden group flex flex-col justify-between">
                        <div class="relative h-40 overflow-hidden bg-slate-100">
                            <img src="{{ $rel->image_url }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <div class="p-4 space-y-2">
                            <span class="text-[10px] text-[#006837] font-bold uppercase">{{ $rel->category->name ?? 'Berita' }}</span>
                            <h4 class="text-xs font-bold text-slate-900 group-hover:text-[#006837] transition line-clamp-2 leading-snug">
                                <a href="{{ route('posts.show', $rel->slug) }}">{{ $rel->title }}</a>
                            </h4>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
