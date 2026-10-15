@extends('layouts.admin')

@section('title', 'Edit Banner Slider: ' . $slide->title)
@section('header_title', 'Edit Banner Slider')
@section('header_subtitle', 'Perbarui slide banner hero landing page')

@section('content')
<div class="w-full space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.slides.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold transition flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Slider
        </a>

        <a href="{{ route('home') }}" target="_blank" class="text-xs text-[#006837] hover:underline font-semibold flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat di Beranda
        </a>
    </div>

    <form action="{{ route('admin.slides.update', $slide->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Main Column (8 cols): Banner Content & CTAs -->
            <div class="lg:col-span-8 space-y-6">
                
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Utama Slider *</label>
                            <input type="text" name="title" value="{{ old('title', $slide->title) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Sorotan (Highlight)</label>
                            <input type="text" name="highlight_text" value="{{ old('highlight_text', $slide->highlight_text) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge Header (Tagline Kecil di Atas Judul)</label>
                        <input type="text" name="badge" value="{{ old('badge', $slide->badge) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Subtitle Hero *</label>
                        <textarea name="subtitle" rows="3" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed">{{ old('subtitle', $slide->subtitle) }}</textarea>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="pt-4 border-t border-slate-100 space-y-4">
                        <span class="text-xs font-bold text-slate-900 uppercase tracking-wider block">Tombol Aksi Hero (Call to Action)</span>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Teks Tombol Utama</label>
                                <input type="text" name="primary_btn_text" value="{{ old('primary_btn_text', $slide->primary_btn_text) }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Link URL Tombol Utama</label>
                                <input type="text" name="primary_btn_url" value="{{ old('primary_btn_url', $slide->primary_btn_url) }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Teks Tombol Sekunder (Opsional)</label>
                                <input type="text" name="secondary_btn_text" value="{{ old('secondary_btn_text', $slide->secondary_btn_text) }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Link URL Tombol Sekunder</label>
                                <input type="text" name="secondary_btn_url" value="{{ old('secondary_btn_url', $slide->secondary_btn_url) }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Right Sidebar Column (4 cols): Status, Order, Media -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Card 1: Publikasi & Urutan -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-paper-plane text-[#006837]"></i> Pengaturan Slide
                    </h4>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor Urutan Tampil</label>
                        <input type="number" name="order" value="{{ old('order', $slide->order) }}" min="1" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <label class="flex items-center gap-2.5 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $slide->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-[#006837] focus:ring-[#006837]">
                            <span>Aktifkan Slide di Beranda</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100 space-y-2">
                        <button type="submit" class="w-full py-3 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/25 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.slides.index') }}" class="block text-center w-full py-2.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition">
                            Batal
                        </a>
                    </div>
                </div>

                <!-- Card 2: Gambar Banner -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-image text-[#006837]"></i> Gambar Hero Slide
                    </h4>

                    @if($slide->image)
                        <div class="space-y-1.5">
                            <span class="text-[11px] font-semibold text-slate-500">Banner Saat Ini:</span>
                            <div class="relative rounded-xl overflow-hidden border border-slate-200 aspect-video bg-slate-100">
                                <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">URL Gambar Banner</label>
                        <input type="url" name="image_url" value="{{ old('image_url', $slide->image) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atau Unggah Berkas Baru</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-100 file:text-[#006837]">
                    </div>
                </div>

            </div>

        </div>

    </form>
</div>
@endsection
