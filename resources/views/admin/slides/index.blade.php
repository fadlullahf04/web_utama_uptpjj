@extends('layouts.admin')

@section('title', 'Manajemen Hero Banner Slider')
@section('header_title', 'Hero Slider')
@section('header_subtitle', 'Kelola banner interaktif dan tombol aksi utama di beranda')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div></div>
        <a href="{{ route('admin.slides.create') }}" class="px-4 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition flex items-center gap-2 shadow-md shadow-[#006837]/20">
            <i class="fa-solid fa-plus"></i> Tambah Banner Slider Baru
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($slides as $slide)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="relative h-44 overflow-hidden">
                        <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        <span class="absolute top-3 left-3 px-2 py-0.5 rounded bg-white/90 backdrop-blur-sm text-[#006837] text-[10px] font-bold shadow-sm">
                            Urutan #{{ $slide->order }}
                        </span>
                    </div>

                    <div class="p-5 space-y-2">
                        @if($slide->badge)
                            <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">{{ $slide->badge }}</span>
                        @endif
                        <h4 class="text-sm font-bold text-slate-900">{{ $slide->title }}</h4>
                        <p class="text-xs text-slate-500 line-clamp-2">{{ $slide->subtitle }}</p>
                    </div>
                </div>

                <div class="p-5 pt-0 flex items-center justify-between border-t border-slate-100 mt-2">
                    <span class="text-[10px] {{ $slide->is_active ? 'text-[#006837] font-bold' : 'text-slate-400' }}">
                        {{ $slide->is_active ? '● Aktif' : '○ Non-aktif' }}
                    </span>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.slides.edit', $slide->id) }}" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-amber-600 hover:bg-slate-200 transition">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>
                        <form action="{{ route('admin.slides.destroy', $slide->id) }}" method="POST" onsubmit="return confirm('Hapus banner ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-red-600 hover:bg-slate-200 transition">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
