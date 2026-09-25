@extends('layouts.admin')

@section('title', 'Edit Anggota Tim')
@section('header_title', 'Edit Anggota Tim')
@section('header_subtitle', 'Perbarui data pimpinan atau pengelola')

@section('content')
<div class="max-w-4xl space-y-6">
    <a href="{{ route('admin.team.index') }}" class="text-xs text-slate-500 hover:text-[#006837] font-semibold transition flex items-center gap-1.5">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Tim
    </a>

    <form action="{{ route('admin.team.update', $member->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap & Gelar *</label>
                    <input type="text" name="name" value="{{ old('name', $member->name) }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jabatan / Posisi *</label>
                    <input type="text" name="title" value="{{ old('title', $member->title) }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Divisi *</label>
                    <select name="division" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        <option value="Pimpinan" {{ old('division', $member->division) === 'Pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                        <option value="Divisi Kurikulum & Bahan Ajar" {{ old('division', $member->division) === 'Divisi Kurikulum & Bahan Ajar' ? 'selected' : '' }}>Divisi Kurikulum & Bahan Ajar</option>
                        <option value="Divisi IT & LMS" {{ old('division', $member->division) === 'Divisi IT & LMS' ? 'selected' : '' }}>Divisi IT & LMS</option>
                        <option value="Divisi Multimedia & Penyiaran" {{ old('division', $member->division) === 'Divisi Multimedia & Penyiaran' ? 'selected' : '' }}>Divisi Multimedia & Penyiaran</option>
                        <option value="Administrasi & Layanan" {{ old('division', $member->division) === 'Administrasi & Layanan' ? 'selected' : '' }}>Administrasi & Layanan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIP</label>
                    <input type="text" name="nip" value="{{ old('nip', $member->nip) }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Kampus</label>
                    <input type="email" name="email" value="{{ old('email', $member->email) }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">URL Foto Online</label>
                    <input type="url" name="photo_url" value="{{ old('photo_url', $member->photo) }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Atau Ganti Foto</label>
                    <input type="file" name="photo" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-100 file:text-[#006837]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bio / Profil Singkat</label>
                <textarea name="bio" rows="3" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">{{ old('bio', $member->bio) }}</textarea>
            </div>

            <div class="flex items-center gap-6 pt-4 border-t border-slate-100">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-[#006837] focus:ring-[#006837]">
                    <span>Status Aktif</span>
                </label>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.team.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/20">
                    Perbarui Anggota
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
