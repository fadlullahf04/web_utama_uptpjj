@extends('layouts.admin')

@section('title', 'Tambah Dokumen Unduhan')
@section('header_title', 'Tambah Dokumen')
@section('header_subtitle', 'Unggah file atau masukkan tautan dokumen pedoman/regulasi')

@section('content')
<div class="max-w-4xl space-y-6">
    <a href="{{ route('admin.downloads.index') }}" class="text-xs text-slate-500 hover:text-[#006837] font-semibold transition flex items-center gap-1.5">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Dokumen
    </a>

    <form action="{{ route('admin.downloads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Dokumen *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Buku Pedoman Akademik PJJ 2026/2027" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Dokumen *</label>
                    <select name="category" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        <option value="Pedoman Akademik">Pedoman Akademik</option>
                        <option value="Panduan LMS">Panduan LMS Pillar</option>
                        <option value="SK & Regulasi">SK Rektor & Regulasi</option>
                        <option value="Template & Format">Template & Format Tugas</option>
                        <option value="Brosur PMB">Brosur PMB</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Keterangan / Deskripsi Dokumen</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">{{ old('description') }}</textarea>
            </div>

            <!-- File Options -->
            <div class="space-y-3">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">File Dokumen</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="text-[11px] text-slate-500 font-medium block mb-1">Unggah Berkas File:</span>
                        <input type="file" name="file" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-100 file:text-[#006837]">
                    </div>
                    <div>
                        <span class="text-[11px] text-slate-500 font-medium block mb-1">Atau Gunakan Tautan Eksternal (Google Drive/Cloud):</span>
                        <input type="url" name="external_url" value="{{ old('external_url') }}" placeholder="https://..." class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-6 pt-4 border-t border-slate-100">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-[#006837] focus:ring-[#006837]">
                    <span>Tampilkan ke Publik</span>
                </label>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.downloads.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/20">
                    Simpan Dokumen
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
