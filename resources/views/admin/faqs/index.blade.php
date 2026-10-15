@extends('layouts.admin')

@section('title', 'Manajemen Tanya Jawab (FAQs)')
@section('header_title', 'Tanya Jawab (FAQs)')
@section('header_subtitle', 'Kelola daftar pertanyaan dan jawaban seputar perkuliahan PJJ')

@section('content')
<div x-data="{ 
    editModal: false, 
    editFaq: { id: null, question: '', answer: '', category: 'Umum', order: 1, is_active: true } 
}" class="space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Form Tambah FAQ (4 cols) -->
        <div class="lg:col-span-4">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-circle-question text-[#006837]"></i> Tambah FAQ Baru
                </h3>
                
                <form action="{{ route('admin.faqs.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori *</label>
                        <select name="category" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            <option value="Umum">Umum & Legalitas Ijazah</option>
                            <option value="PMB & Registrasi">PMB & Pendaftaran</option>
                            <option value="LMS & Perkuliahan">LMS Pillar & Perkuliahan</option>
                            <option value="Biaya & Pembayaran">Biaya & Beasiswa</option>
                            <option value="Ujian & Kelulusan">Ujian Daring & Wisuda</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pertanyaan *</label>
                        <input type="text" name="question" required placeholder="Contoh: Apakah ijazah PJJ sah dan terakreditasi?" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div x-data="{
                        insertTag(before, after) {
                            const el = this.$refs.answerInput;
                            const start = el.selectionStart || 0;
                            const end = el.selectionEnd || 0;
                            const selected = el.value.substring(start, end);
                            el.value = el.value.substring(0, start) + before + selected + after + el.value.substring(end);
                            el.focus();
                            el.setSelectionRange(start + before.length, end + before.length);
                        }
                    }" class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Jawaban Lengkap *</label>
                            <div class="flex items-center gap-0.5 bg-slate-100 p-0.5 rounded-lg border border-slate-200 text-xs">
                                <button type="button" @click="insertTag('<strong>', '</strong>')" title="Tebal" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center font-bold text-[11px]">B</button>
                                <button type="button" @click="insertTag('<em>', '</em>')" title="Miring" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center italic font-serif text-[11px]">I</button>
                                <button type="button" @click="insertTag('<u>', '</u>')" title="Garis Bawah" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center underline text-[11px]">U</button>
                                <button type="button" @click="insertTag('<ul>\n  <li>', '</li>\n</ul>')" title="Daftar Poin" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center"><i class="fa-solid fa-list-ul text-[9px]"></i></button>
                                <button type="button" @click="insertTag('<a href=\'https://...\' target=\'_blank\'>', '</a>')" title="Tautan Link" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center"><i class="fa-solid fa-link text-[9px]"></i></button>
                            </div>
                        </div>
                        <textarea name="answer" x-ref="answerInput" rows="5" required placeholder="Tuliskan jawaban yang jelas dan ramah..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Urutan</label>
                        <input type="number" name="order" value="1" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/20">
                        Simpan FAQ
                    </button>
                </form>
            </div>
        </div>

        <!-- Table Daftar FAQs (8 cols) -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-900">Daftar Pertanyaan & Jawaban</h3>
                </div>
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4 font-bold">Pertanyaan</th>
                            <th class="py-3 px-4 font-bold">Kategori</th>
                            <th class="py-3 px-4 font-bold">Urutan</th>
                            <th class="py-3 px-4 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($faqs as $faq)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-900">{{ $faq->question }}</div>
                                    <div class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $faq->answer }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-800 border border-amber-200 text-[10px] font-bold">{{ $faq->category }}</span>
                                </td>
                                <td class="py-3 px-4 text-slate-500">#{{ $faq->order }}</td>
                                <td class="py-3 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button" 
                                            @click="editFaq = { id: {{ $faq->id }}, question: @js($faq->question), answer: @js($faq->answer), category: @js($faq->category), order: {{ $faq->order ?? 1 }}, is_active: {{ $faq->is_active ? 'true' : 'false' }} }; editModal = true" 
                                            class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-amber-600 hover:bg-slate-200 transition" 
                                            title="Edit FAQ">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </button>
                                        <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Hapus FAQ ini?');" class="inline">
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

    <!-- Modal Edit FAQ -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="editModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="editModal = false"></div>

        <div x-show="editModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative z-10 w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden my-8">
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-[#006837]"></i> Edit Tanya Jawab (FAQ)
                    </h3>
                    <button type="button" @click="editModal = false" class="text-slate-400 hover:text-slate-700 text-base">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form :action="'{{ url('/admin/faqs') }}/' + editFaq.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori *</label>
                        <select name="category" x-model="editFaq.category" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            <option value="Umum">Umum & Legalitas Ijazah</option>
                            <option value="PMB & Registrasi">PMB & Pendaftaran</option>
                            <option value="LMS & Perkuliahan">LMS Pillar & Perkuliahan</option>
                            <option value="Biaya & Pembayaran">Biaya & Beasiswa</option>
                            <option value="Ujian & Kelulusan">Ujian Daring & Wisuda</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pertanyaan *</label>
                        <input type="text" name="question" x-model="editFaq.question" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div x-data="{
                        insertEditTag(before, after) {
                            const el = this.$refs.editAnswerInput;
                            const start = el.selectionStart || 0;
                            const end = el.selectionEnd || 0;
                            const selected = el.value.substring(start, end);
                            el.value = el.value.substring(0, start) + before + selected + after + el.value.substring(end);
                            editFaq.answer = el.value;
                            el.focus();
                            el.setSelectionRange(start + before.length, end + before.length);
                        }
                    }" class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Jawaban Lengkap *</label>
                            <div class="flex items-center gap-0.5 bg-slate-100 p-0.5 rounded-lg border border-slate-200 text-xs">
                                <button type="button" @click="insertEditTag('<strong>', '</strong>')" title="Tebal" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center font-bold text-[11px]">B</button>
                                <button type="button" @click="insertEditTag('<em>', '</em>')" title="Miring" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center italic font-serif text-[11px]">I</button>
                                <button type="button" @click="insertEditTag('<u>', '</u>')" title="Garis Bawah" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center underline text-[11px]">U</button>
                                <button type="button" @click="insertEditTag('<ul>\n  <li>', '</li>\n</ul>')" title="Daftar Poin" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center"><i class="fa-solid fa-list-ul text-[9px]"></i></button>
                                <button type="button" @click="insertEditTag('<a href=\'https://...\' target=\'_blank\'>', '</a>')" title="Tautan Link" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center"><i class="fa-solid fa-link text-[9px]"></i></button>
                            </div>
                        </div>
                        <textarea name="answer" x-ref="editAnswerInput" x-model="editFaq.answer" rows="5" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Urutan</label>
                            <input type="number" name="order" x-model="editFaq.order" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>

                        <div class="flex items-center pt-6">
                            <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                                <input type="checkbox" name="is_active" value="1" :checked="editFaq.is_active" class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-[#006837] focus:ring-[#006837]">
                                <span>Aktif Ditampilkan</span>
                            </label>
                        </div>
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
