@extends('layouts.app')

@section('title', $service->title . ' - UPT Pendidikan Jarak Jauh UINSSC')
@section('meta_description', $service->short_description ?: \Illuminate\Support\Str::limit(strip_tags($service->content), 155))

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-2">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <a href="{{ route('services.index') }}" class="hover:underline">Layanan</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>{{ $service->category }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            {{ $service->title }}
        </h1>
        <p class="text-xs sm:text-sm text-emerald-100 font-semibold">{{ $service->short_description }}</p>
    </div>
</div>

<div class="py-14 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
    <div class="bg-white p-3 rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="w-full h-80 object-cover rounded-2xl">
    </div>

    <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-6">
        <h2 class="text-xl font-bold text-slate-900 text-[#006837]">Tentang Layanan Ini</h2>
        <div class="text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
            <p>{{ $service->content ?? $service->short_description }}</p>
        </div>

        @if($service->portal_url)
            <div class="pt-6 border-t border-slate-100">
                <a href="{{ $service->portal_url }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-full bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider shadow-md transition">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>{{ $service->button_text ?? 'Akses Portal Layanan' }}</span>
                </a>
            </div>
        @endif
    </div>

    @if($otherServices->count() > 0)
        <div class="space-y-4 pt-6">
            <h3 class="text-base font-bold text-slate-900 text-[#006837]">Layanan & Fasilitas PJJ Lainnya</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($otherServices as $os)
                    <a href="{{ route('services.show', $os->slug) }}" class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-[#006837] hover:shadow-md transition block">
                        <span class="text-[10px] text-[#006837] bg-emerald-50 px-2 py-0.5 rounded font-bold uppercase">{{ $os->category }}</span>
                        <h5 class="text-xs font-bold text-slate-900 hover:text-[#006837] transition mt-1.5">{{ $os->title }}</h5>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
