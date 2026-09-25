@extends('layouts.admin')

@section('title', 'Manajemen Tanya Jawab (FAQs)')
@section('header_title', 'Tanya Jawab (FAQs)')
@section('header_subtitle', 'Kelola daftar pertanyaan dan jawaban seputar perkuliahan PJJ')

@section('content')
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

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jawaban Lengkap *</label>
                    <textarea name="answer" rows="5" required placeholder="Tuliskan jawaban yang jelas dan ramah..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]"></textarea>
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
                                <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Hapus FAQ ini?');" class="inline">
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
