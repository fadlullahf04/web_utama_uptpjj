@extends('layouts.admin')

@section('title', 'Tambah Halaman Dinamis Baru')
@section('header_title', 'Tambah Halaman Dinamis')
@section('header_subtitle', 'Buat halaman informasi baru untuk portal UPT PJJ UINSSC')

@section('content')
<div class="w-full space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pages.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold transition flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Halaman
        </a>
    </div>

    <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Main Column (8 cols): Title, Slug, Excerpt, Content -->
            <div class="lg:col-span-8 space-y-6">
                
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                    
                    <!-- Title -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Halaman *</label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Maklumat Pelayanan, Panduan Skripsi Online, dll..." class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:bg-white focus:outline-none focus:border-[#006837]">
                        @error('title')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug (Optional / Custom) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Slug Kustom (Opsional)
                        </label>
                        <div class="flex items-center rounded-xl bg-slate-50 border border-slate-300 overflow-hidden focus-within:border-[#006837] focus-within:bg-white">
                            <span class="px-3.5 py-2.5 bg-slate-100 text-slate-500 text-xs font-mono border-r border-slate-200">
                                /halaman/
                            </span>
                            <input type="text" name="slug" value="{{ old('slug') }}" placeholder="kosongkan untuk otomatis dari judul..." class="w-full px-3 py-2 bg-transparent text-slate-800 text-xs font-mono focus:outline-none">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Jika dikosongkan, tautan slug akan dibuat secara otomatis dari judul halaman.</p>
                        @error('slug')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Ringkas / Sub-judul</label>
                        <textarea name="excerpt" rows="2" placeholder="Ringkasan atau pengantar 1-2 kalimat untuk preview..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed">{{ old('excerpt') }}</textarea>
                        @error('excerpt')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content with Rich Text Editor -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Konten / Isi Lengkap Halaman *</label>
                        @include('admin.posts._editor', ['content' => old('content', '')])
                        @error('content')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- SEO Card -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5" x-data="{
                    seoTitle: @js(old('meta_title', '')),
                    seoDesc: @js(old('meta_description', '')),
                    get displayTitle() {
                        if (this.seoTitle && this.seoTitle.trim() !== '') return this.seoTitle.trim();
                        const mainTitle = document.querySelector('input[name=\'title\']');
                        return (mainTitle && mainTitle.value.trim() !== '') ? mainTitle.value.trim() : 'Judul Halaman Dinamis UPT PJJ UINSSC';
                    },
                    get displayDesc() {
                        if (this.seoDesc && this.seoDesc.trim() !== '') return this.seoDesc.trim();
                        const excerpt = document.querySelector('textarea[name=\'excerpt\']');
                        if (excerpt && excerpt.value.trim() !== '') return excerpt.value.trim();
                        return 'Pelajari informasi selengkapnya pada halaman resmi UPT Pendidikan Jarak Jauh Universitas Islam Negeri Siber Syekh Nurjati Cirebon.';
                    }
                }">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass-chart text-[#006837]"></i> Optimasi SEO & Metadata Google
                        </h4>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-800 font-bold border border-emerald-200">SEO Ready</span>
                    </div>

                    <!-- Google Snippet Preview -->
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-1.5 font-sans">
                        <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider flex items-center gap-1.5">
                            <i class="fa-brands fa-google text-blue-500"></i> Pratinjau Tampilan Google Search
                        </div>
                        <div class="text-xs text-slate-500 truncate">
                            {{ config('app.url') }} &rsaquo; halaman &rsaquo; ...
                        </div>
                        <div class="text-sm font-semibold text-blue-700 hover:underline cursor-pointer truncate" x-text="displayTitle + ' - UPT PJJ UINSSC'"></div>
                        <div class="text-xs text-slate-600 line-clamp-2 leading-relaxed" x-text="displayDesc"></div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 pt-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Meta Title</label>
                            <input type="text" name="meta_title" x-model="seoTitle" placeholder="Ketik meta title (opsional)..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Meta Description</label>
                            <textarea name="meta_description" x-model="seoDesc" rows="2" placeholder="Deskripsi meta 140-160 karakter untuk mesin pencari..." class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed"></textarea>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Sidebar Column (4 cols): Publish, Template, Featured Image -->
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
                            <span>Publikasikan Halaman Langsung</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100 space-y-2">
                        <button type="submit" class="w-full py-3 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/25 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Halaman
                        </button>
                        <a href="{{ route('admin.pages.index') }}" class="block text-center w-full py-2.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition">
                            Batal
                        </a>
                    </div>
                </div>

                <!-- Card 2: Layout Template -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-table-columns text-emerald-600"></i> Pilihan Layout Template
                    </h4>

                    <div class="space-y-2.5">
                        <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 hover:border-[#006837] cursor-pointer transition has-[:checked]:border-[#006837] has-[:checked]:bg-emerald-50/50">
                            <input type="radio" name="template" value="default" {{ old('template', 'default') === 'default' ? 'checked' : '' }} class="mt-0.5 text-[#006837] focus:ring-[#006837]">
                            <div>
                                <span class="block text-xs font-bold text-slate-800">Standar (Dengan Sidebar)</span>
                                <span class="text-[11px] text-slate-500">Artikel di kiri dan widget informasi/kontak di kanan.</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 hover:border-[#006837] cursor-pointer transition has-[:checked]:border-[#006837] has-[:checked]:bg-emerald-50/50">
                            <input type="radio" name="template" value="full-width" {{ old('template') === 'full-width' ? 'checked' : '' }} class="mt-0.5 text-[#006837] focus:ring-[#006837]">
                            <div>
                                <span class="block text-xs font-bold text-slate-800">Lebar Penuh (Full-Width)</span>
                                <span class="text-[11px] text-slate-500">Konten memanjang penuh tanpa sidebar samping.</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 hover:border-[#006837] cursor-pointer transition has-[:checked]:border-[#006837] has-[:checked]:bg-emerald-50/50">
                            <input type="radio" name="template" value="blank" {{ old('template') === 'blank' ? 'checked' : '' }} class="mt-0.5 text-[#006837] focus:ring-[#006837]">
                            <div>
                                <span class="block text-xs font-bold text-slate-800">Minimalis (Clean Box)</span>
                                <span class="text-[11px] text-slate-500">Layout terpusat bersih tanpa banner samping.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Card 3: Featured Image / Banner (Optional) -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4" x-data="{ imagePreview: null }">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-image text-amber-600"></i> Gambar Sampul / Banner
                    </h4>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Upload Berkas Gambar</label>
                        <input type="file" name="featured_image" accept="image/*" @change="imagePreview = URL.createObjectURL($event.target.files[0])" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-[#006837] hover:file:bg-emerald-100 cursor-pointer">
                    </div>

                    <div class="relative flex py-1 items-center">
                        <div class="flex-grow border-t border-slate-200"></div>
                        <span class="flex-shrink mx-2 text-[10px] text-slate-400 uppercase font-bold">atau</span>
                        <div class="flex-grow border-t border-slate-200"></div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">URL Gambar Online</label>
                        <input type="url" name="featured_image_url" value="{{ old('featured_image_url') }}" placeholder="https://..." class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <template x-if="imagePreview">
                        <div class="mt-3 rounded-xl overflow-hidden border border-slate-200 shadow-inner">
                            <img :src="imagePreview" alt="Preview Gambar" class="w-full h-36 object-cover">
                        </div>
                    </template>
                </div>

            </div>

        </div>
    </form>

</div>
@endsection
