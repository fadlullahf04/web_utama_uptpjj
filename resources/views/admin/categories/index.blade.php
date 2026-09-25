@extends('layouts.admin')

@section('title', 'Kategori Artikel & Berita')
@section('header_title', 'Kategori Konten')
@section('header_subtitle', 'Kelola kategori artikel berita, pengumuman, dan materi')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- Form Tambah Kategori (4 cols) -->
    <div class="lg:col-span-4">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Tambah Kategori Baru</h3>
            
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kategori *</label>
                    <input type="text" name="name" required placeholder="Contoh: Riset Siber" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tipe Kategori *</label>
                    <select name="type" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        <option value="berita">Berita & Informasi</option>
                        <option value="pengumuman">Pengumuman Akademik</option>
                        <option value="panduan">Panduan & Modul</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Warna Label</label>
                    <select name="color" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        <option value="emerald">Emerald / Hijau UPT PJJ</option>
                        <option value="amber">Amber / Emas</option>
                        <option value="blue">Biru Siber</option>
                        <option value="purple">Ungu</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" placeholder="Keterangan kategori..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]"></textarea>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/20">
                    Simpan Kategori
                </button>
            </form>
        </div>
    </div>

    <!-- Table Daftar Kategori (8 cols) -->
    <div class="lg:col-span-8">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-900">Daftar Kategori Tersedia</h3>
            </div>
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Slug</th>
                        <th class="py-3 px-4">Tipe</th>
                        <th class="py-3 px-4">Jumlah Artikel</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($categories as $cat)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $cat->name }}</td>
                            <td class="py-3 px-4 text-slate-500 font-mono text-[11px]">{{ $cat->slug }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded bg-emerald-50 text-[#006837] border border-emerald-200 text-[10px] font-bold uppercase">{{ $cat->type }}</span>
                            </td>
                            <td class="py-3 px-4 font-semibold text-[#006837]">{{ $cat->posts_count }} artikel</td>
                            <td class="py-3 px-4 text-right">
                                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-red-600 hover:bg-slate-200 transition" title="Hapus">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
