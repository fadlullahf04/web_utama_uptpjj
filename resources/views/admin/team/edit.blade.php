@extends('layouts.admin')

@section('title', 'Edit Anggota Tim: ' . $member->name)
@section('header_title', 'Edit Anggota Tim')
@section('header_subtitle', 'Perbarui data pimpinan atau pengelola')

@section('content')
<div class="w-full space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.team.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold transition flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Tim
        </a>

        <a href="{{ route('profile.team') }}" target="_blank" class="text-xs text-[#006837] hover:underline font-semibold flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat di Profil Tim
        </a>
    </div>

    <form action="{{ route('admin.team.update', $member->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Main Column (8 cols): Personal & Professional Info -->
            <div class="lg:col-span-8 space-y-6">
                
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap & Gelar *</label>
                            <input type="text" name="name" value="{{ old('name', $member->name) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jabatan / Posisi *</label>
                            <input type="text" name="title" value="{{ old('title', $member->title) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Divisi Organisasi *</label>
                            <select name="division" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                                <option value="Pimpinan" {{ old('division', $member->division) === 'Pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                                <option value="Divisi Kurikulum & Bahan Ajar" {{ old('division', $member->division) === 'Divisi Kurikulum & Bahan Ajar' ? 'selected' : '' }}>Divisi Kurikulum & Bahan Ajar</option>
                                <option value="Divisi IT & LMS" {{ old('division', $member->division) === 'Divisi IT & LMS' ? 'selected' : '' }}>Divisi IT & LMS</option>
                                <option value="Divisi Multimedia & Penyiaran" {{ old('division', $member->division) === 'Divisi Multimedia & Penyiaran' ? 'selected' : '' }}>Divisi Multimedia & Penyiaran</option>
                                <option value="Administrasi & Layanan" {{ old('division', $member->division) === 'Administrasi & Layanan' ? 'selected' : '' }}>Administrasi & Layanan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIP / NIDN</label>
                            <input type="text" name="nip" value="{{ old('nip', $member->nip) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Kampus</label>
                            <input type="email" name="email" value="{{ old('email', $member->email) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                    </div>

                    <div>
                        @include('admin.posts._editor', [
                            'content' => old('bio', $member->bio),
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
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-[#006837] focus:ring-[#006837]">
                            <span>Aktif & Tampilkan di Profil Tim</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100 space-y-2">
                        <button type="submit" class="w-full py-3 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/25 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
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

                    @if($member->photo)
                        <div class="flex items-center gap-4 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="w-16 h-16 rounded-xl object-cover border border-slate-300 shadow-sm">
                            <div class="text-xs">
                                <span class="font-bold text-slate-800 block">Foto Saat Ini</span>
                                <span class="text-slate-400 text-[11px]">Unggah foto baru jika ingin mengganti</span>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ganti Berkas Foto</label>
                        <input type="file" name="photo" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#006837] file:text-white">
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atau Masukkan URL Foto Online</label>
                        <input type="url" name="photo_url" value="{{ old('photo_url', $member->photo) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>
                </div>

            </div>

        </div>

    </form>
</div>
@endsection
