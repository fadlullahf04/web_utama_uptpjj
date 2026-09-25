@extends('layouts.admin')

@section('title', 'Manajemen Testimoni Mahasiswa & Alumni')
@section('header_title', 'Testimoni Mahasiswa & Alumni')
@section('header_subtitle', 'Kelola ulasan dan kutipan pengalaman kuliah di UPT PJJ UINSSC')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- Form Tambah Testimoni (4 cols) -->
    <div class="lg:col-span-4">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-comment-dots text-[#006837]"></i> Tambah Testimoni
            </h3>
            
            <form action="{{ route('admin.testimonials.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Mahasiswa / Alumni *</label>
                    <input type="text" name="name" required placeholder="Contoh: Ust. Ahmad Fauzi, S.Pd" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status / Peran *</label>
                    <input type="text" name="role_status" required placeholder="Contoh: Alumni PJJ PAI S1 - Guru di Papua" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Rating Bintang</label>
                    <select name="rating" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        <option value="5">★★★★★ (5 Bintang)</option>
                        <option value="4">★★★★☆ (4 Bintang)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kutipan Testimoni *</label>
                    <textarea name="quote" rows="4" required placeholder="Ceritakan pengalaman belajar di LMS Pillar..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">URL Foto Profil</label>
                    <input type="url" name="avatar_url" placeholder="https://..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/20">
                    Simpan Testimoni
                </button>
            </form>
        </div>
    </div>

    <!-- Daftar Testimoni Cards (8 cols) -->
    <div class="lg:col-span-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-slate-900">Daftar Testimoni Aktif</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($testimonials as $t)
                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 flex flex-col justify-between space-y-3">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1 text-amber-500 text-xs">
                                    @for($i = 0; $i < $t->rating; $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                </div>
                                <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus testimoni ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-red-600 transition" title="Hapus">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                            <p class="text-xs text-slate-700 italic line-clamp-3">"{{ $t->quote }}"</p>
                        </div>

                        <div class="flex items-center gap-3 pt-3 border-t border-slate-200">
                            <img src="{{ $t->avatar_url }}" alt="{{ $t->name }}" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                            <div>
                                <h5 class="text-xs font-bold text-slate-900">{{ $t->name }}</h5>
                                <p class="text-[10px] text-amber-700 font-medium">{{ $t->role_status }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
