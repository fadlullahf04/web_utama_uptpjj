@extends('layouts.admin')

@section('title', 'Tambah Anggota Tim')
@section('header_title', 'Tambah Anggota Tim')
@section('header_subtitle', 'Tambahkan data pimpinan atau pengelola baru')

@section('content')
<div class="w-full space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.team.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold transition flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Tim
        </a>
    </div>

    <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Main Column (8 cols): Personal & Professional Info -->
            <div class="lg:col-span-8 space-y-6">
                
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap & Gelar *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Dr. Nama Lengkap, M.Pd" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jabatan / Posisi *</label>
                            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Koordinator Divisi IT & LMS" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Divisi Organisasi *</label>
                            <select name="division" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                                <option value="Pimpinan">Pimpinan</option>
                                <option value="Divisi Kurikulum & Bahan Ajar">Divisi Kurikulum & Bahan Ajar</option>
                                <option value="Divisi IT & LMS">Divisi IT & LMS</option>
                                <option value="Divisi Multimedia & Penyiaran">Divisi Multimedia & Penyiaran</option>
                                <option value="Administrasi & Layanan">Administrasi & Layanan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIP / NIDN</label>
                            <input type="text" name="nip" value="{{ old('nip') }}" placeholder="19800101..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Kampus</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@uinssc.ac.id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                    </div>

                    <div>
                        @include('admin.posts._editor', [
                            'content' => old('bio', ''),
                            'name' => 'bio',
                            'label' => 'Bio & Riwayat Singkat',
                            'required' => false,
                            'minHeight' => '220px',
                        ])
                    </div>

                </div>

            </div>

            <!-- Right Sidebar Column (4 cols): Status & Photo Media -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Card 1: Publikasi & Status -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-paper-plane text-[#006837]"></i> Status Keanggotaan
                    </h4>

                    <div class="space-y-3">
                        <label class="flex items-center gap-2.5 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-[#006837] focus:ring-[#006837]">
                            <span>Aktif & Tampilkan di Profil Tim</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100 space-y-2">
                        <button type="submit" class="w-full py-3 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/25 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Anggota Tim
                        </button>
                        <a href="{{ route('admin.team.index') }}" class="block text-center w-full py-2.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition">
                            Batal
                        </a>
                    </div>
                </div>

                <!-- Card 2: Foto Profil -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-user-tie text-[#006837]"></i> Foto Profil
                    </h4>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Unggah Foto Berkas</label>
                        <input type="file" name="photo" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#006837] file:text-white">
                        <span class="text-[11px] text-slate-400 mt-1 block">Format JPG/PNG/WebP, rasio 1:1 atau 3:4</span>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atau Masukkan URL Foto Online</label>
                        <input type="url" name="photo_url" value="{{ old('photo_url') }}" placeholder="https://..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>
                </div>

            </div>

        </div>

    </form>
</div>
@endsection
