@extends('layouts.admin')

@section('title', 'Manajemen Galeri Sarana Prasarana')
@section('header_title', 'Galeri & Sarana Siber')
@section('header_subtitle', 'Kelola foto fasilitas kampus siber, studio multimedia, dan kegiatan')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- Form Tambah Galeri (4 cols) -->
    <div class="lg:col-span-4">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-cloud-arrow-up text-[#006837]"></i> Tambah Foto / Fasilitas
            </h3>
            
            <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Fasilitas / Foto *</label>
                    <input type="text" name="title" required placeholder="Contoh: Studio Podcast UPT PJJ" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Sarana *</label>
                    <select name="category" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        <option value="Gedung Siber">Gedung Siber & Ruang UPT</option>
                        <option value="Studio Multimedia">Studio Rekaman MOOC</option>
                        <option value="Lab Komputer">Laboratorium Siber & CBT</option>
                        <option value="Bimtek & Workshop">Bimtek & Kegiatan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tipe Media *</label>
                    <select name="type" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        <option value="image">Foto / Gambar</option>
                        <option value="video">Video YouTube</option>
                        <option value="tour">Virtual Tour 360</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">URL Gambar (Online)</label>
                    <input type="url" name="media_url" placeholder="https://images.unsplash.com/..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atau Unggah Berkas Gambar</label>
                    <input type="file" name="media_file" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-100 file:text-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Keterangan Singkat</label>
                    <textarea name="description" rows="3" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]"></textarea>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/20">
                    Unggah ke Galeri
                </button>
            </form>
        </div>
    </div>

    <!-- Grid Daftar Foto (8 cols) -->
    <div class="lg:col-span-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-slate-900">Daftar Foto & Fasilitas Terunggah</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($galleries as $g)
                    <div class="bg-slate-50 rounded-xl overflow-hidden border border-slate-200 group relative">
                        <img src="{{ $g->thumbnail_url }}" alt="{{ $g->title }}" class="w-full h-36 object-cover">
                        <div class="p-3 space-y-1">
                            <span class="text-[9px] font-bold uppercase text-amber-600">{{ $g->category }}</span>
                            <h5 class="text-xs font-bold text-slate-900 line-clamp-1">{{ $g->title }}</h5>
                        </div>
                        <div class="absolute top-2 right-2">
                            <form action="{{ route('admin.gallery.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Hapus item galeri ini?');">
                                <button type="submit" class="p-1.5 rounded-lg bg-white/90 backdrop-blur-sm text-red-600 hover:bg-red-500 hover:text-white transition shadow-sm" title="Hapus">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
