@extends('layouts.admin')

@section('title', 'Tambah Program Studi PJJ')
@section('header_title', 'Tambah Program Studi')
@section('header_subtitle', 'Tambahkan informasi prodi PJJ baru ke portal')

@section('content')
<div class="w-full space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.programs.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold transition flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Prodi
        </a>
    </div>

    <form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Main Column (8 cols): Main Program Information -->
            <div class="lg:col-span-8 space-y-6">
                
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Program Studi *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: PJJ Pendidikan Agama Islam" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenjang Pendidikan *</label>
                            <select name="degree" required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                                <option value="S1" {{ old('degree') === 'S1' ? 'selected' : '' }}>Sarjana (S1)</option>
                                <option value="S2" {{ old('degree') === 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Fakultas / Pascasarjana Penyelenggara *</label>
                        <input type="text" name="faculty" value="{{ old('faculty', 'Fakultas Ilmu Tarbiyah dan Keguruan') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Singkat (Ringkasan) *</label>
                        <textarea name="short_description" rows="3" required placeholder="Ringkasan 1-2 kalimat untuk preview di kartu beranda..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed">{{ old('short_description') }}</textarea>
                    </div>

                    <div>
                        @include('admin.posts._editor', [
                            'content' => old('description', ''),
                            'name' => 'description',
                            'label' => 'Deskripsi Lengkap & Profil Lulusan',
                            'required' => false,
                            'minHeight' => '320px',
                        ])
                    </div>

                </div>

            </div>

            <!-- Right Sidebar Column (4 cols): Meta, Academic Metrics, Actions -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Card 1: Tombol Aksi Simpan -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-floppy-disk text-[#006837]"></i> Tindakan
                    </h4>

                    <button type="submit" class="w-full py-3 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/25 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus-circle"></i> Simpan Program Studi
                    </button>
                    <a href="{{ route('admin.programs.index') }}" class="block text-center w-full py-2.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition">
                        Batal
                    </a>
                </div>

                <!-- Card 2: Metrik & Profil Akademik -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-graduation-cap text-[#006837]"></i> Spesifikasi Akademik
                    </h4>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Akreditasi *</label>
                        <input type="text" name="accreditation" value="{{ old('accreditation', 'Unggul') }}" required placeholder="Unggul / Baik Sekali / A" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Gelar Lulusan *</label>
                        <input type="text" name="graduate_title" value="{{ old('graduate_title', 'S.Pd.') }}" required placeholder="Contoh: S.Pd." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ketua Prodi (Kaprodi)</label>
                        <input type="text" name="head_of_program" value="{{ old('head_of_program') }}" placeholder="Dr. H. Nama, M.Ag" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-2 border-t border-slate-100">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Beban SKS</label>
                            <input type="number" name="total_credits" value="{{ old('total_credits', 144) }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Masa Studi</label>
                            <input type="text" name="study_duration" value="{{ old('study_duration', '8 Semester') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                    </div>
                </div>

                <!-- Card 3: Media & Tautan PMB -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-link text-[#006837]"></i> Tautan & Gambar Cover
                    </h4>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Unggah Gambar Cover (Komputer)</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#006837] file:text-white hover:file:bg-[#004d29]">
                        <span class="text-[10px] text-slate-400 mt-1 block">JPG, PNG, WEBP maks 5 MB</span>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atau URL Gambar Cover</label>
                        <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">URL Pendaftaran PMB</label>
                        <input type="url" name="registration_url" value="{{ old('registration_url', 'https://pmb.uinssc.ac.id') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>
                </div>

            </div>

        </div>

    </form>
</div>
@endsection
