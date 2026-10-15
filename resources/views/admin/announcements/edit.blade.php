@extends('layouts.admin')

@section('title', 'Edit Pengumuman: ' . $announcement->title)
@section('header_title', 'Edit Pengumuman')
@section('header_subtitle', 'Perbarui pengumuman akademik atau informasi operasional')

@section('content')
<div class="w-full space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.announcements.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold transition flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pengumuman
        </a>

        @if($announcement->is_published)
            <a href="{{ route('announcements.show', $announcement->slug) }}" target="_blank" class="text-xs text-[#006837] hover:underline font-semibold flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat di Portal
            </a>
        @endif
    </div>

    <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Main Column (8 cols): Title & Content -->
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Pengumuman *</label>
                        <input type="text" name="title" value="{{ old('title', $announcement->title) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <!-- Content with Rich Text Editor & Image Upload -->
                    <div>
                        @include('admin.posts._editor', [
                            'content' => old('content', $announcement->content),
                            'label' => 'Isi Pengumuman Lengkap *',
                            'name' => 'content',
                        ])
                    </div>

                </div>
            </div>

            <!-- Right Sidebar Column (4 cols): Meta, Settings, Attachments -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Card 1: Publikasi & Status -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-paper-plane text-[#006837]"></i> Publikasi & Status
                    </h4>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Waktu Publikasi</label>
                        <input type="datetime-local" name="published_at" value="{{ old('published_at', $announcement->published_at ? $announcement->published_at->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div class="space-y-3 pt-2 border-t border-slate-100">
                        <label class="flex items-center gap-2.5 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $announcement->is_published) ? 'checked' : '' }} class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-[#006837] focus:ring-[#006837]">
                            <span>Status Terbit (Published)</span>
                        </label>

                        <label class="flex items-center gap-2.5 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned', $announcement->is_pinned) ? 'checked' : '' }} class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-amber-500 focus:ring-amber-400">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-thumbtack text-amber-500"></i> Sematkan di Atas (Pinned)</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100 space-y-2">
                        <button type="submit" class="w-full py-3 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/25 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.announcements.index') }}" class="block text-center w-full py-2.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition">
                            Batal
                        </a>
                    </div>
                </div>

                <!-- Card 2: Kategori -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-tag text-[#006837]"></i> Kategori Pengumuman
                    </h4>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Sasaran *</label>
                        <select name="category" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            <option value="Akademik" {{ old('category', $announcement->category) === 'Akademik' ? 'selected' : '' }}>Akademik</option>
                            <option value="Layanan LMS" {{ old('category', $announcement->category) === 'Layanan LMS' ? 'selected' : '' }}>Layanan LMS</option>
                            <option value="Kemahasiswaan" {{ old('category', $announcement->category) === 'Kemahasiswaan' ? 'selected' : '' }}>Kemahasiswaan</option>
                            <option value="Beasiswa" {{ old('category', $announcement->category) === 'Beasiswa' ? 'selected' : '' }}>Beasiswa & Subsidi</option>
                            <option value="Umum" {{ old('category', $announcement->category) === 'Umum' ? 'selected' : '' }}>Umum</option>
                        </select>
                    </div>
                </div>

                <!-- Card 3: Lampiran Dokumen -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-paperclip text-[#006837]"></i> Lampiran Surat / Dokumen
                    </h4>

                    @if($announcement->attachment_file)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 space-y-1">
                            <span class="text-[11px] font-semibold text-slate-500 block">Berkas Terlampir:</span>
                            <a href="{{ $announcement->attachment_url }}" target="_blank" class="text-xs text-[#006837] font-bold hover:underline flex items-center gap-1.5 break-all">
                                <i class="fa-solid fa-file-pdf text-red-500 text-sm"></i>
                                <span>{{ $announcement->attachment_name ?: basename($announcement->attachment_file) }}</span>
                            </a>
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Tampilan Lampiran</label>
                        <input type="text" name="attachment_name" value="{{ old('attachment_name', $announcement->attachment_name) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ganti Berkas Lampiran / Poster Gambar dari Komputer</label>
                        <input type="file" name="attachment_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#006837] file:text-white hover:file:bg-[#004d29]">
                        <span class="text-[11px] text-slate-400 mt-1 block">Dokumen PDF, Word, atau Gambar Surat/Poster. Biarkan kosong jika tidak mengubah berkas.</span>
                    </div>
                </div>

            </div>

        </div>

    </form>
</div>
@endsection
