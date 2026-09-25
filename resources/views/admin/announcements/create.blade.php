@extends('layouts.admin')

@section('title', 'Buat Pengumuman Baru')
@section('header_title', 'Buat Pengumuman')
@section('header_subtitle', 'Terbitkan pengumuman akademik atau informasi operasional')

@section('content')
<div class="max-w-4xl space-y-6">
    <a href="{{ route('admin.announcements.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold transition flex items-center gap-1.5">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pengumuman
    </a>

    <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Pengumuman *</label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Jadwal Pengisian KRS Online Semester Ganjil" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:bg-white focus:outline-none focus:border-[#006837]">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Pengumuman *</label>
                    <select name="category" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        <option value="Akademik">Akademik</option>
                        <option value="Layanan LMS">Layanan LMS</option>
                        <option value="Kemahasiswaan">Kemahasiswaan</option>
                        <option value="Beasiswa">Beasiswa & Subsidi</option>
                        <option value="Umum">Umum</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Publikasi</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>
            </div>

            <!-- Content -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Isi Pengumuman *</label>
                <textarea name="content" rows="8" required placeholder="Tuliskan detail pengumuman di sini..." class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed">{{ old('content') }}</textarea>
            </div>

            <!-- Attachment File -->
            <div class="space-y-3">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Lampiran Dokumen (Opsional PDF/DOCX)</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="text-[11px] text-slate-500 block mb-1">Nama Tampilan Lampiran:</span>
                        <input type="text" name="attachment_name" value="{{ old('attachment_name') }}" placeholder="Contoh: Surat_Edaran_KRS.pdf" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>
                    <div>
                        <span class="text-[11px] text-slate-500 block mb-1">Unggah File:</span>
                        <input type="file" name="attachment_file" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#006837] file:text-white">
                    </div>
                </div>
            </div>

            <!-- Options -->
            <div class="flex items-center gap-6 pt-4 border-t border-slate-100">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                    <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }} class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-amber-500 focus:ring-amber-400">
                    <span>Sematkan di Atas (Pin Pengumuman)</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }} class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-[#006837] focus:ring-[#006837]">
                    <span>Publikasikan Langsung</span>
                </label>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.announcements.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/20">
                    Simpan Pengumuman
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
