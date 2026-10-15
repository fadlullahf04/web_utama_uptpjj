@extends('layouts.admin')

@section('title', 'Edit Dokumen: ' . $document->title)
@section('header_title', 'Edit Dokumen')
@section('header_subtitle', 'Perbarui berkas atau data unduhan')

@section('content')
<div class="w-full space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.downloads.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold transition flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Dokumen
        </a>

        @if($document->file_url)
            <a href="{{ $document->file_url }}" target="_blank" class="text-xs text-[#006837] hover:underline font-semibold flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-down"></i> Unduh Berkas Saat Ini
            </a>
        @endif
    </div>

    <form action="{{ route('admin.downloads.update', $document->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Main Column (8 cols): Title & Description -->
            <div class="lg:col-span-8 space-y-6">
                
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Dokumen / Panduan *</label>
                        <input type="text" name="title" value="{{ old('title', $document->title) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        @include('admin.posts._editor', [
                            'content' => old('description', $document->description),
                            'name' => 'description',
                            'label' => 'Keterangan / Deskripsi Dokumen',
                            'required' => false,
                            'minHeight' => '240px',
                        ])
                    </div>

                </div>

            </div>

            <!-- Right Sidebar Column (4 cols): Meta, Category, File -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Card 1: Publikasi & Status -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-paper-plane text-[#006837]"></i> Status Dokumen
                    </h4>

                    <div class="space-y-3">
                        <label class="flex items-center gap-2.5 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $document->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-[#006837] focus:ring-[#006837]">
                            <span>Tampilkan Dokumen ke Publik</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100 space-y-2">
                        <button type="submit" class="w-full py-3 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/25 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.downloads.index') }}" class="block text-center w-full py-2.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition">
                            Batal
                        </a>
                    </div>
                </div>

                <!-- Card 2: Kategori Dokumen -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-folder-tree text-[#006837]"></i> Kategori Dokumen
                    </h4>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori *</label>
                        <select name="category" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            <option value="Pedoman Akademik" {{ old('category', $document->category) === 'Pedoman Akademik' ? 'selected' : '' }}>Pedoman Akademik</option>
                            <option value="Panduan LMS" {{ old('category', $document->category) === 'Panduan LMS' ? 'selected' : '' }}>Panduan LMS Pillar</option>
                            <option value="SK & Regulasi" {{ old('category', $document->category) === 'SK & Regulasi' ? 'selected' : '' }}>SK Rektor & Regulasi</option>
                            <option value="Template & Format" {{ old('category', $document->category) === 'Template & Format' ? 'selected' : '' }}>Template & Format Tugas</option>
                            <option value="Brosur PMB" {{ old('category', $document->category) === 'Brosur PMB' ? 'selected' : '' }}>Brosur PMB</option>
                        </select>
                    </div>
                </div>

                <!-- Card 3: Berkas File & Tautan Eksternal -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-file-arrow-up text-[#006837]"></i> Sumber Berkas Dokumen
                    </h4>

                    @if($document->file_path)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 space-y-1">
                            <span class="text-[11px] font-semibold text-slate-500 block">Berkas File Tersimpan:</span>
                            <div class="flex items-center gap-2 text-xs font-bold text-emerald-800">
                                <i class="fa-solid fa-file-circle-check text-emerald-600"></i>
                                <span class="break-all">{{ basename($document->file_path) }}</span>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ganti Berkas File</label>
                        <input type="file" name="file" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#006837] file:text-white">
                        <span class="text-[11px] text-slate-400 mt-1 block">Biarkan kosong jika tidak mengganti berkas</span>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atau Tautan Eksternal Cloud</label>
                        <input type="url" name="external_url" value="{{ old('external_url', $document->external_url) }}" placeholder="https://drive.google.com/..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>
                </div>

            </div>

        </div>

    </form>
</div>
@endsection
