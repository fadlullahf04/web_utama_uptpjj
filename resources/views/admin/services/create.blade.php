@extends('layouts.admin')

@section('title', 'Tambah Layanan PJJ')
@section('header_title', 'Tambah Layanan')
@section('header_subtitle', 'Tambahkan fasilitas atau portal layanan digital baru')

@section('content')
<div class="max-w-4xl space-y-6">
    <a href="{{ route('admin.services.index') }}" class="text-xs text-slate-500 hover:text-[#006837] font-semibold transition flex items-center gap-1.5">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Layanan
    </a>

    <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Layanan / Fasilitas *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: LMS Pillar" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Layanan *</label>
                    <select name="category" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        <option value="LMS & Cyber Platform">LMS & Cyber Platform</option>
                        <option value="Studio Multimedia">Studio Multimedia & Penyiaran</option>
                        <option value="Akademik">Akademik & Kurikulum Modular</option>
                        <option value="Helpdesk & Training">Helpdesk & Pelatihan Dosen</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Icon ID *</label>
                    <input type="text" name="icon" value="{{ old('icon', 'laptop') }}" required placeholder="Contoh: laptop, video, headphones" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Tombol Aksi</label>
                    <input type="text" name="button_text" value="{{ old('button_text', 'Akses Layanan') }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">URL Portal Eksternal</label>
                    <input type="url" name="portal_url" value="{{ old('portal_url') }}" placeholder="https://..." class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">URL Gambar Cover</label>
                <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Singkat *</label>
                <textarea name="short_description" rows="2" required class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">{{ old('short_description') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Lengkap</label>
                <textarea name="content" rows="6" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">{{ old('content') }}</textarea>
            </div>

            <div class="flex items-center gap-6 pt-4 border-t border-slate-100">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-[#006837] focus:ring-[#006837]">
                    <span>Tampilkan di Beranda (Featured)</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-[#006837] focus:ring-[#006837]">
                    <span>Status Aktif</span>
                </label>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.services.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/20">
                    Simpan Layanan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
