@extends('layouts.app')

@section('title', 'Profil Lulusan - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Profil</span> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Profil Lulusan</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">{{ $title }}</h1>
        @if(!empty($subtitle))
            <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">{{ $subtitle }}</p>
        @endif
    </div>
</div>

@php
    $compBorders = [
        'emerald' => 'border-t-[#006837]',
        'teal' => 'border-t-teal-600',
        'amber' => 'border-t-amber-500',
        'blue' => 'border-t-blue-600',
        'purple' => 'border-t-purple-600',
    ];
    $compIconBg = [
        'emerald' => 'bg-emerald-100 text-[#006837]',
        'teal' => 'bg-teal-100 text-teal-800',
        'amber' => 'bg-amber-100 text-amber-800',
        'blue' => 'bg-blue-100 text-blue-800',
        'purple' => 'bg-purple-100 text-purple-800',
    ];
    $careerIconColor = [
        'emerald' => 'text-[#006837]',
        'teal' => 'text-teal-600',
        'amber' => 'text-amber-600',
        'blue' => 'text-blue-600',
        'purple' => 'text-purple-600',
    ];
@endphp

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($competencies as $comp)
            @php $c = $comp['color'] ?? 'emerald'; @endphp
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3 border-t-4 {{ $compBorders[$c] ?? $compBorders['emerald'] }}">
                <div class="w-10 h-10 rounded-xl {{ $compIconBg[$c] ?? $compIconBg['emerald'] }} flex items-center justify-center text-lg">
                    <i class="{{ $comp['icon'] ?? 'fa-solid fa-award' }}"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">{{ $comp['title'] ?? '' }}</h3>
                <p class="text-xs text-slate-600 leading-relaxed">{{ $comp['description'] ?? '' }}</p>
            </div>
        @endforeach
    </div>

    <!-- Career Pathways -->
    <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
        <h2 class="text-xl font-bold text-[#006837]">{{ $careersTitle }}</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
            @foreach($careers as $car)
                @php $cc = $car['color'] ?? 'emerald'; @endphp
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <h4 class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                        <i class="{{ $car['icon'] ?? 'fa-solid fa-briefcase' }} {{ $careerIconColor[$cc] ?? $careerIconColor['emerald'] }}"></i>
                        <span>{{ $car['title'] ?? '' }}</span>
                    </h4>
                    <p class="text-slate-600">{{ $car['description'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
