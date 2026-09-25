@extends('layouts.app')

@section('title', 'Sarana dan Prasarana - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Profil</span> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Sarana & Prasarana</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Sarana & Prasarana Kampus Siber</h1>
        <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">Fasilitas fisik dan arsitektur digital mutakhir yang menopang keandalan perkuliahan jarak jauh UPT PJJ UINSSC.</p>
    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
    @foreach($galleries as $categoryName => $items)
        <div class="space-y-6">
            <h2 class="text-base font-extrabold text-slate-900 uppercase tracking-wider text-[#006837] flex items-center gap-2 pb-2 border-b border-slate-200">
                <i class="fa-solid fa-building-columns text-sm"></i> {{ $categoryName }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($items as $item)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden group hover:shadow-lg transition">
                        <div class="relative h-56 overflow-hidden bg-slate-100">
                            <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-[#006837] text-white text-[10px] font-bold uppercase tracking-wider">
                                {{ $item->category }}
                            </span>
                        </div>
                        <div class="p-5 space-y-2">
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-[#006837] transition">{{ $item->title }}</h3>
                            @if($item->description)
                                <p class="text-xs text-slate-600 leading-relaxed">{{ $item->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection
