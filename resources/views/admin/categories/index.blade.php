@extends('layouts.admin')

@section('title', 'Kategori Artikel & Berita')
@section('header_title', 'Kategori Konten')
@section('header_subtitle', 'Kelola kategori artikel berita, pengumuman, dan materi')

@section('content')
<div x-data="{ 
    editModal: false, 
    editCat: { id: null, name: '', type: 'berita', color: 'emerald', description: '' } 
}" class="space-y-8">
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

                    <div x-data="{
                        insertCatTag(before, after) {
                            const el = this.$refs.catDescInput;
                            const start = el.selectionStart || 0;
                            const end = el.selectionEnd || 0;
                            const selected = el.value.substring(start, end);
                            el.value = el.value.substring(0, start) + before + selected + after + el.value.substring(end);
                            el.focus();
                            el.setSelectionRange(start + before.length, end + before.length);
                        }
                    }" class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi Singkat</label>
                            <div class="flex items-center gap-0.5 bg-slate-100 p-0.5 rounded-lg border border-slate-200 text-xs">
                                <button type="button" @click="insertCatTag('<strong>', '</strong>')" title="Tebal" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center font-bold text-[11px]">B</button>
                                <button type="button" @click="insertCatTag('<em>', '</em>')" title="Miring" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center italic font-serif text-[11px]">I</button>
                            </div>
                        </div>
                        <textarea name="description" x-ref="catDescInput" rows="3" placeholder="Keterangan kategori..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed"></textarea>
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
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button" 
                                            @click="editCat = { id: {{ $cat->id }}, name: @js($cat->name), type: @js($cat->type), color: @js($cat->color ?? 'emerald'), description: @js($cat->description ?? '') }; editModal = true" 
                                            class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-amber-600 hover:bg-slate-200 transition" 
                                            title="Edit Kategori">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-red-600 hover:bg-slate-200 transition" title="Hapus">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Edit Kategori -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="editModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="editModal = false"></div>

        <div x-show="editModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative z-10 w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden my-8">
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-[#006837]"></i> Edit Kategori
                    </h3>
                    <button type="button" @click="editModal = false" class="text-slate-400 hover:text-slate-700 text-base">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form :action="'{{ url('/admin/categories') }}/' + editCat.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kategori *</label>
                        <input type="text" name="name" x-model="editCat.name" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tipe Kategori *</label>
                        <select name="type" x-model="editCat.type" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            <option value="berita">Berita & Informasi</option>
                            <option value="pengumuman">Pengumuman Akademik</option>
                            <option value="panduan">Panduan & Modul</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Warna Label</label>
                        <select name="color" x-model="editCat.color" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            <option value="emerald">Emerald / Hijau UPT PJJ</option>
                            <option value="amber">Amber / Emas</option>
                            <option value="blue">Biru Siber</option>
                            <option value="purple">Ungu</option>
                        </select>
                    </div>

                    <div x-data="{
                        insertEditCatTag(before, after) {
                            const el = this.$refs.editCatDescInput;
                            const start = el.selectionStart || 0;
                            const end = el.selectionEnd || 0;
                            const selected = el.value.substring(start, end);
                            el.value = el.value.substring(0, start) + before + selected + after + el.value.substring(end);
                            editCat.description = el.value;
                            el.focus();
                            el.setSelectionRange(start + before.length, end + before.length);
                        }
                    }" class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi Singkat</label>
                            <div class="flex items-center gap-0.5 bg-slate-100 p-0.5 rounded-lg border border-slate-200 text-xs">
                                <button type="button" @click="insertEditCatTag('<strong>', '</strong>')" title="Tebal" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center font-bold text-[11px]">B</button>
                                <button type="button" @click="insertEditCatTag('<em>', '</em>')" title="Miring" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center italic font-serif text-[11px]">I</button>
                            </div>
                        </div>
                        <textarea name="description" x-ref="editCatDescInput" x-model="editCat.description" rows="3" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed"></textarea>
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
