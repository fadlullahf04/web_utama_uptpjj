@extends('layouts.admin')

@section('title', 'Tambah Berita Baru')
@section('header_title', 'Tambah Berita')
@section('header_subtitle', 'Publikasikan berita, rilis kegiatan, atau opini baru')

@section('content')
<div class="w-full space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.posts.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold transition flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Berita
        </a>
    </div>

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Main Column (8 cols): Title & Body Content -->
            <div class="lg:col-span-8 space-y-6">
                
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                    
                    <!-- Title -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Berita / Artikel *</label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Ketik judul berita secara jelas..." class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ringkasan Singkat (Excerpt)</label>
                        <textarea name="excerpt" rows="3" placeholder="Ringkasan 1-2 kalimat untuk preview di kartu berita..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed">{{ old('excerpt') }}</textarea>
                    </div>

                    <!-- Content with Rich Text Editor & Image Upload -->
                    <div>
                        @include('admin.posts._editor', ['content' => old('content', '')])
                    </div>

                </div>

                <!-- Optimasi SEO & Metadata Google -->
                @include('admin.posts._seo_card')

            </div>

            <!-- Right Sidebar Column (4 cols): Publish, Category, Media -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Card 1: Publish & Status -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-paper-plane text-[#006837]"></i> Publikasi & Status
                    </h4>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jadwal Publikasi</label>
                        <input type="datetime-local" name="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div class="space-y-3 pt-2 border-t border-slate-100">
                        <label class="flex items-center gap-2.5 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }} class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-[#006837] focus:ring-[#006837]">
                            <span>Publikasikan Langsung</span>
                        </label>

                        <label class="flex items-center gap-2.5 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-[#006837] focus:ring-[#006837]">
                            <span>Jadikan Berita Utama (Featured)</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100 space-y-2">
                        <button type="submit" class="w-full py-3 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/25 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan & Publikasikan
                        </button>
                        <a href="{{ route('admin.posts.index') }}" class="block text-center w-full py-2.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition">
                            Batal
                        </a>
                    </div>
                </div>

                <!-- Card 2: Category & Tags -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-folder-tree text-[#006837]"></i> Kategori & Tags
                    </h4>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Berita *</label>
                        <select name="category_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tags (Pisahkan koma)</label>
                        <input type="text" name="tags" value="{{ old('tags', 'PJJ, UINSSC, LMS Pillar') }}" placeholder="Contoh: Kuliah Online, Seminar, Beasiswa" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>
                </div>

                <!-- Card 3: Featured Image -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-image text-[#006837]"></i> Gambar Sampul (Cover)
                    </h4>

                    <div>
                        <span class="text-[11px] text-slate-500 block mb-1 font-semibold">Unggah dari Komputer:</span>
                        <input type="file" name="featured_image" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#006837] file:text-white">
                        <span class="text-[10px] text-slate-400 mt-1 block">JPG, PNG, WEBP maks 5 MB.</span>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-[11px] text-slate-500 block mb-1 font-semibold">Atau Gunakan URL Gambar:</span>
                        <input type="url" name="featured_image_url" value="{{ old('featured_image_url') }}" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-[11px] text-slate-500 leading-relaxed">
                        <i class="fa-solid fa-circle-info text-[#006837] mr-1"></i> Rekomendasi gambar berasio landscape (16:9) dengan resolusi minimal 1200 &times; 675 px.
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection
