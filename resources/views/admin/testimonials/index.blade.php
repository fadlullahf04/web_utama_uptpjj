@extends('layouts.admin')

@section('title', 'Manajemen Testimoni Mahasiswa & Alumni')
@section('header_title', 'Testimoni Mahasiswa & Alumni')
@section('header_subtitle', 'Kelola ulasan dan kutipan pengalaman kuliah di UPT PJJ UINSSC')

@section('content')
<div x-data="{ 
    editModal: false, 
    editTestimonial: { id: null, name: '', role_status: '', rating: 5, quote: '', avatar_url: '', order: 0, is_active: true } 
}" class="space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Form Tambah Testimoni (4 cols) -->
        <div class="lg:col-span-4">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-comment-dots text-[#006837]"></i> Tambah Testimoni
                </h3>
                
                <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
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

                    <div x-data="{
                        insertQuoteTag(before, after) {
                            const el = this.$refs.quoteInput;
                            const start = el.selectionStart || 0;
                            const end = el.selectionEnd || 0;
                            const selected = el.value.substring(start, end);
                            el.value = el.value.substring(0, start) + before + selected + after + el.value.substring(end);
                            el.focus();
                            el.setSelectionRange(start + before.length, end + before.length);
                        }
                    }" class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kutipan Testimoni *</label>
                            <div class="flex items-center gap-0.5 bg-slate-100 p-0.5 rounded-lg border border-slate-200 text-xs">
                                <button type="button" @click="insertQuoteTag('<strong>', '</strong>')" title="Tebal" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center font-bold text-[11px]">B</button>
                                <button type="button" @click="insertQuoteTag('<em>', '</em>')" title="Miring" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center italic font-serif text-[11px]">I</button>
                                <button type="button" @click="insertQuoteTag('«', '»')" title="Tanda Kutip" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center text-[10px] font-bold">""</button>
                            </div>
                        </div>
                        <textarea name="quote" x-ref="quoteInput" rows="4" required placeholder="Ceritakan pengalaman belajar di LMS Pillar..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Unggah Foto Profil (Opsional)</label>
                        <input type="file" name="avatar_file" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-100 file:text-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atau URL Foto Profil</label>
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
                                    <div class="flex items-center gap-2">
                                        <button type="button" 
                                            @click="editTestimonial = { id: {{ $t->id }}, name: @js($t->name), role_status: @js($t->role_status), rating: {{ $t->rating }}, quote: @js($t->quote), avatar_url: @js($t->avatar ?? ''), order: {{ $t->order ?? 0 }}, is_active: {{ $t->is_active ? 'true' : 'false' }} }; editModal = true" 
                                            class="text-slate-400 hover:text-amber-600 transition" 
                                            title="Edit Testimoni">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </button>
                                        <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus testimoni ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-red-600 transition" title="Hapus">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <p class="text-xs text-slate-700 italic line-clamp-3">"{{ $t->quote }}"</p>
                            </div>

                            <div class="flex items-center gap-3 pt-3 border-t border-slate-200">
                                <img src="{{ $t->avatar_url }}" alt="{{ $t->name }}" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                                <div class="min-w-0">
                                    <h5 class="text-xs font-bold text-slate-900 truncate">{{ $t->name }}</h5>
                                    <p class="text-[10px] text-amber-700 font-medium truncate">{{ $t->role_status }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Edit Testimoni -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="editModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="editModal = false"></div>

        <div x-show="editModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative z-10 w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden my-8">
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-[#006837]"></i> Edit Testimoni
                    </h3>
                    <button type="button" @click="editModal = false" class="text-slate-400 hover:text-slate-700 text-base">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form :action="'{{ url('/admin/testimonials') }}/' + editTestimonial.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Mahasiswa / Alumni *</label>
                        <input type="text" name="name" x-model="editTestimonial.name" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status / Peran *</label>
                        <input type="text" name="role_status" x-model="editTestimonial.role_status" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Rating Bintang</label>
                        <select name="rating" x-model="editTestimonial.rating" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            <option value="5">★★★★★ (5 Bintang)</option>
                            <option value="4">★★★★☆ (4 Bintang)</option>
                            <option value="3">★★★☆☆ (3 Bintang)</option>
                        </select>
                    </div>

                    <div x-data="{
                        insertEditQuoteTag(before, after) {
                            const el = this.$refs.editQuoteInput;
                            const start = el.selectionStart || 0;
                            const end = el.selectionEnd || 0;
                            const selected = el.value.substring(start, end);
                            el.value = el.value.substring(0, start) + before + selected + after + el.value.substring(end);
                            editTestimonial.quote = el.value;
                            el.focus();
                            el.setSelectionRange(start + before.length, end + before.length);
                        }
                    }" class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kutipan Testimoni *</label>
                            <div class="flex items-center gap-0.5 bg-slate-100 p-0.5 rounded-lg border border-slate-200 text-xs">
                                <button type="button" @click="insertEditQuoteTag('<strong>', '</strong>')" title="Tebal" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center font-bold text-[11px]">B</button>
                                <button type="button" @click="insertEditQuoteTag('<em>', '</em>')" title="Miring" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center italic font-serif text-[11px]">I</button>
                                <button type="button" @click="insertEditQuoteTag('«', '»')" title="Tanda Kutip" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center text-[10px] font-bold">""</button>
                            </div>
                        </div>
                        <textarea name="quote" x-ref="editQuoteInput" x-model="editTestimonial.quote" rows="4" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ganti Berkas Foto (Opsional)</label>
                        <input type="file" name="avatar_file" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-100 file:text-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atau URL Foto Profil</label>
                        <input type="url" name="avatar_url" x-model="editTestimonial.avatar_url" placeholder="https://..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div class="flex items-center pt-2">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" name="is_active" value="1" :checked="editTestimonial.is_active" class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-[#006837] focus:ring-[#006837]">
                            <span>Aktif Ditampilkan</span>
                        </label>
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
