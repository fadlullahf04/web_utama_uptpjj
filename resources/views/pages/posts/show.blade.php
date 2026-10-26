@extends('layouts.app')

@section('title', ($post->meta_title ?: $post->title) . ' - UPT PJJ UINSSC')
@section('meta_description', $post->meta_description ?: ($post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 155)))
@section('meta_image', $post->image_url)
@section('meta_type', 'article')

@push('schema')
<script type="application/ld+json">
{
    "{{ '@context' }}": "https://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ url()->current() }}"
    },
    "headline": {{ json_encode($post->meta_title ?: $post->title) }},
    "image": [
        "{{ $post->image_url }}"
    ],
    "datePublished": "{{ ($post->published_at ?? $post->created_at)->toIso8601String() }}",
    "dateModified": "{{ $post->updated_at->toIso8601String() }}",
    "author": {
        "@type": "Person",
        "name": {{ json_encode($post->author->name ?? 'Humas UPT PJJ') }}
    },
    "publisher": {
        "@type": "EducationalOrganization",
        "name": "UPT Pendidikan Jarak Jauh UINSSC",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('images/logo_uptpjj.png') }}"
        }
    },
    "description": {{ json_encode($post->meta_description ?: ($post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 155))) }}
}
</script>
<script type="application/ld+json">
{
    "{{ '@context' }}": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": "Beranda",
            "item": "{{ route('home') }}"
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": "Berita",
            "item": "{{ route('posts.index') }}"
        },
        {
            "@type": "ListItem",
            "position": 3,
            "name": {{ json_encode($post->title) }},
            "item": "{{ url()->current() }}"
        }
    ]
}
</script>
@endpush

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-2">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <a href="{{ route('posts.index') }}" class="hover:underline">Berita</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>{{ $post->category->name ?? 'Informasi' }}</span>
        </div>

        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight max-w-5xl">
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

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        
        <!-- Left Column: Article Content (8 cols) -->
        <div class="lg:col-span-8 space-y-8">
            <!-- Cover Image -->
            <div class="bg-white p-3 rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-[400px] sm:h-[480px] object-cover rounded-2xl">
            </div>

            <!-- Article Content -->
            <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <div class="article-content text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
                    {!! $post->clean_content !!}
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
        </div>

        <!-- Right Column: Sidebar (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Redaksi & Publikasi Card -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider text-[#006837] pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-newspaper"></i> Informasi Berita
                </h4>
                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500 font-medium">Penulis:</span>
                        <span class="font-bold text-slate-800">{{ $post->author->name ?? 'Humas UPT PJJ' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500 font-medium">Kategori:</span>
                        <span class="font-bold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full">{{ $post->category->name ?? 'Berita' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500 font-medium">Waktu Baca:</span>
                        <span class="font-bold text-slate-700">{{ $post->reading_time }} menit</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5">
                        <span class="text-slate-500 font-medium">Pembaca:</span>
                        <span class="font-bold text-slate-700">{{ number_format($post->views_count) }} kali</span>
                    </div>
                </div>
            </div>

            <!-- Quick PMB Online CTA -->
            <div class="p-6 rounded-3xl bg-gradient-to-br from-[#006837] to-[#004d29] text-white space-y-4 shadow-lg">
                <div class="flex items-center gap-2 text-amber-300 text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-user-graduate"></i> PMB Online UPT PJJ
                </div>
                <h4 class="text-base font-extrabold text-white">Kuliah Fleksibel 100% Online di UIN Siber</h4>
                <p class="text-xs text-emerald-100 leading-relaxed">
                    Pendaftaran mahasiswa baru jenjang Sarjana (S1) dan Magister (S2) dibuka setiap semester.
                </p>
                <a href="{{ \App\Models\Setting::get('pmb_url', 'https://pmb.uinssc.ac.id') }}" target="_blank" class="w-full py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-xs uppercase tracking-wider text-center block transition shadow">
                    Daftar PMB Sekarang →
                </a>
            </div>

        </div>

    </div>

    <!-- Related Articles -->
    @if($relatedPosts->count() > 0)
        <div class="space-y-6 pt-4 border-t border-slate-200">
            <h3 class="text-xl font-bold text-slate-900 text-[#006837]">Berita & Informasi Terkait</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedPosts as $rel)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition overflow-hidden group flex flex-col justify-between">
                        <div class="relative h-44 overflow-hidden bg-slate-100">
                            <img src="{{ $rel->image_url }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <div class="p-5 space-y-2">
                            <span class="text-[10px] text-[#006837] font-bold uppercase bg-emerald-50 px-2 py-0.5 rounded">{{ $rel->category->name ?? 'Berita' }}</span>
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
