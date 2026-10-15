@extends('layouts.admin')

@section('title', 'Manajemen Galeri Sarana Prasarana')
@section('header_title', 'Galeri & Sarana Siber')
@section('header_subtitle', 'Kelola foto fasilitas kampus siber, studio multimedia, dan kegiatan')

@section('content')
<div x-data="{ 
    editModal: false, 
    editItem: { id: null, title: '', category: 'Gedung Siber', type: 'image', media_url: '', description: '', order: 0 } 
}" class="space-y-8">
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

                    <div x-data="{
                        insertGalleryTag(before, after) {
                            const el = this.$refs.galleryDescInput;
                            const start = el.selectionStart || 0;
                            const end = el.selectionEnd || 0;
                            const selected = el.value.substring(start, end);
                            el.value = el.value.substring(0, start) + before + selected + after + el.value.substring(end);
                            el.focus();
                            el.setSelectionRange(start + before.length, end + before.length);
                        }
                    }" class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Keterangan Singkat</label>
                            <div class="flex items-center gap-0.5 bg-slate-100 p-0.5 rounded-lg border border-slate-200 text-xs">
                                <button type="button" @click="insertGalleryTag('<strong>', '</strong>')" title="Tebal" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center font-bold text-[11px]">B</button>
                                <button type="button" @click="insertGalleryTag('<em>', '</em>')" title="Miring" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center italic font-serif text-[11px]">I</button>
                                <button type="button" @click="insertGalleryTag('<a href=\'https://...\' target=\'_blank\'>', '</a>')" title="Tautan Link" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center"><i class="fa-solid fa-link text-[9px]"></i></button>
                            </div>
                        </div>
                        <textarea name="description" x-ref="galleryDescInput" rows="3" placeholder="Deskripsi sarana / kegiatan..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed"></textarea>
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
                            <div class="absolute top-2 right-2 flex items-center gap-1.5">
                                <button type="button" 
                                    @click="editItem = { id: {{ $g->id }}, title: @js($g->title), category: @js($g->category), type: @js($g->type), media_url: @js($g->media_url ?? ''), description: @js($g->description ?? ''), order: {{ $g->order ?? 0 }} }; editModal = true" 
                                    class="p-1.5 rounded-lg bg-white/90 backdrop-blur-sm text-slate-700 hover:bg-amber-500 hover:text-white transition shadow-sm" 
                                    title="Edit">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </button>
                                <form action="{{ route('admin.gallery.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Hapus item galeri ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
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

    <!-- Modal Edit Galeri -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="editModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="editModal = false"></div>

        <div x-show="editModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative z-10 w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden my-8">
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-[#006837]"></i> Edit Sarana / Galeri
                    </h3>
                    <button type="button" @click="editModal = false" class="text-slate-400 hover:text-slate-700 text-base">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form :action="'{{ url('/admin/gallery') }}/' + editItem.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Fasilitas / Foto *</label>
                        <input type="text" name="title" x-model="editItem.title" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Sarana *</label>
                        <select name="category" x-model="editItem.category" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            <option value="Gedung Siber">Gedung Siber & Ruang UPT</option>
                            <option value="Studio Multimedia">Studio Rekaman MOOC</option>
                            <option value="Lab Komputer">Laboratorium Siber & CBT</option>
                            <option value="Bimtek & Workshop">Bimtek & Kegiatan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tipe Media *</label>
                        <select name="type" x-model="editItem.type" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            <option value="image">Foto / Gambar</option>
                            <option value="video">Video YouTube</option>
                            <option value="tour">Virtual Tour 360</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">URL Media (Opsional)</label>
                        <input type="url" name="media_url" x-model="editItem.media_url" placeholder="https://..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ganti Berkas Foto (Opsional)</label>
                        <input type="file" name="media_file" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-100 file:text-[#006837]">
                    </div>

                    <div x-data="{
                        insertEditGalleryTag(before, after) {
                            const el = this.$refs.editGalleryDescInput;
                            const start = el.selectionStart || 0;
                            const end = el.selectionEnd || 0;
                            const selected = el.value.substring(start, end);
                            el.value = el.value.substring(0, start) + before + selected + after + el.value.substring(end);
                            editItem.description = el.value;
                            el.focus();
                            el.setSelectionRange(start + before.length, end + before.length);
                        }
                    }" class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Keterangan Singkat</label>
                            <div class="flex items-center gap-0.5 bg-slate-100 p-0.5 rounded-lg border border-slate-200 text-xs">
                                <button type="button" @click="insertEditGalleryTag('<strong>', '</strong>')" title="Tebal" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center font-bold text-[11px]">B</button>
                                <button type="button" @click="insertEditGalleryTag('<em>', '</em>')" title="Miring" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center italic font-serif text-[11px]">I</button>
                                <button type="button" @click="insertEditGalleryTag('<a href=\'https://...\' target=\'_blank\'>', '</a>')" title="Tautan Link" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center"><i class="fa-solid fa-link text-[9px]"></i></button>
                            </div>
                        </div>
                        <textarea name="description" x-ref="editGalleryDescInput" x-model="editItem.description" rows="3" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="editModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white text-xs font-bold uppercase tracking-wider transition shadow-md shadow-[#006837]/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
