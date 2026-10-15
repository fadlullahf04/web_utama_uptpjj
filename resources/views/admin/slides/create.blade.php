@extends('layouts.admin')

@section('title', 'Tambah Banner Slider')
@section('header_title', 'Tambah Banner Slider')
@section('header_subtitle', 'Tambahkan slider hero baru untuk landing page')

@section('content')
<div class="w-full space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.slides.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold transition flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Slider
        </a>
    </div>

    <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Main Column (8 cols): Banner Content & CTAs -->
            <div class="lg:col-span-8 space-y-6">
                
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Utama Slider *</label>
                            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Kuliah Fleksibel Berkualitas Dunia" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Sorotan (Highlight)</label>
                            <input type="text" name="highlight_text" value="{{ old('highlight_text') }}" placeholder="Contoh: Bersama UPT PJJ UINSSC" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge Header (Tagline Kecil di Atas Judul)</label>
                        <input type="text" name="badge" value="{{ old('badge') }}" placeholder="Contoh: Cyber Islamic University Terdepan" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Subtitle Hero *</label>
                        <textarea name="subtitle" rows="3" required placeholder="Jelaskan pesan utama atau nilai tambah yang ingin disampaikan kepada calon mahasiswa..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed">{{ old('subtitle') }}</textarea>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="pt-4 border-t border-slate-100 space-y-4">
                        <span class="text-xs font-bold text-slate-900 uppercase tracking-wider block">Tombol Aksi Hero (Call to Action)</span>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Teks Tombol Utama</label>
                                <input type="text" name="primary_btn_text" value="{{ old('primary_btn_text', 'Daftar PMB PJJ') }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Link URL Tombol Utama</label>
                                <input type="text" name="primary_btn_url" value="{{ old('primary_btn_url', 'https://pmb.uinssc.ac.id') }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Teks Tombol Sekunder (Opsional)</label>
                                <input type="text" name="secondary_btn_text" value="{{ old('secondary_btn_text', 'Pelajari Program Studi') }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Link URL Tombol Sekunder</label>
                                <input type="text" name="secondary_btn_url" value="{{ old('secondary_btn_url', '/prodi') }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
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
                        <input type="number" name="order" value="{{ old('order', 1) }}" min="1" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <label class="flex items-center gap-2.5 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-[#006837] focus:ring-[#006837]">
                            <span>Aktifkan Slide di Beranda</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100 space-y-2">
                        <button type="submit" class="w-full py-3 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/25 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Banner
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

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Unggah Gambar Banner (Komputer)</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#006837] file:text-white hover:file:bg-[#004d29]">
                        <span class="text-[10px] text-slate-400 mt-1 block">Rekomendasi resolusi 1920x800px (JPG/PNG/WEBP)</span>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atau URL Gambar Banner</label>
                        <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        <span class="text-[11px] text-slate-400 mt-1 block">Tautan gambar eksternal</span>
                    </div>
                </div>

            </div>

        </div>

    </form>
</div>
@endsection
