@extends('layouts.admin')

@section('title', 'Manajemen Profil Lulusan')
@section('header_title', 'CMS Profil Lulusan')
@section('header_subtitle', 'Kelola capaian pembelajaran, kompetensi utama, dan prospek karir lulusan PJJ')

@section('content')
<div class="space-y-6" x-data="{
    competencies: @js($competencies),
    careers: @js($careers),
    addCompetency() {
        this.competencies.push({ title: '', description: '', icon: 'fa-solid fa-award', color: 'emerald' });
    },
    removeCompetency(idx) {
        this.competencies.splice(idx, 1);
    },
    addCareer() {
        this.careers.push({ title: '', description: '', icon: 'fa-solid fa-briefcase', color: 'emerald' });
    },
    removeCareer(idx) {
        this.careers.splice(idx, 1);
    }
}">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <p class="text-xs text-slate-500">Sesuaikan informasi Profil Lulusan yang tampil pada halaman publik.</p>
        <a href="{{ route('profile.graduate-profile') }}" target="_blank" class="px-4 py-2 rounded-xl bg-white border border-slate-300 hover:bg-slate-50 text-[#006837] font-bold text-xs transition flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Halaman Profil Lulusan
        </a>
    </div>

    <form action="{{ route('admin.graduate-profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Header Halaman -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-heading text-[#006837]"></i> Judul &amp; Pengantar Halaman
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Halaman *</label>
                    <input type="text" name="graduate_profile_title" value="{{ old('graduate_profile_title', $title) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Bagian Prospek Karir *</label>
                    <input type="text" name="graduate_careers_title" value="{{ old('graduate_careers_title', $careersTitle) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Subjudul / Pengantar</label>
                <textarea name="graduate_profile_subtitle" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">{{ old('graduate_profile_subtitle', $subtitle) }}</textarea>
            </div>
        </div>

        <!-- Kartu Kompetensi Utama -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap text-[#006837]"></i> Kartu Kompetensi &amp; Capaian Pembelajaran
                </h3>
                <button type="button" @click="addCompetency()" class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-[#006837] font-bold text-[11px] border border-emerald-200 transition">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah Kompetensi
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <template x-for="(item, idx) in competencies" :key="idx">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3 relative">
                        <button type="button" @click="removeCompetency(idx)" class="absolute top-3 right-3 text-slate-400 hover:text-red-600" title="Hapus">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Judul Kompetensi *</label>
                            <input type="text" :name="`competencies[${idx}][title]`" x-model="item.title" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs">
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Ikon (FontAwesome)</label>
                                <input type="text" :name="`competencies[${idx}][icon]`" x-model="item.icon" placeholder="fa-solid fa-laptop-code" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Warna Aksen</label>
                                <select :name="`competencies[${idx}][color]`" x-model="item.color" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs">
                                    <option value="emerald">Emerald</option>
                                    <option value="teal">Teal</option>
                                    <option value="amber">Amber</option>
                                    <option value="blue">Blue</option>
                                    <option value="purple">Purple</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Deskripsi *</label>
                            <textarea :name="`competencies[${idx}][description]`" x-model="item.description" rows="3" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs leading-relaxed"></textarea>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Peluang & Prospek Karir -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-briefcase text-[#006837]"></i> Peluang &amp; Prospek Karir Lulusan
                </h3>
                <button type="button" @click="addCareer()" class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-[#006837] font-bold text-[11px] border border-emerald-200 transition">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah Prospek Karir
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <template x-for="(car, idx) in careers" :key="idx">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3 relative">
                        <button type="button" @click="removeCareer(idx)" class="absolute top-3 right-3 text-slate-400 hover:text-red-600" title="Hapus">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Judul Karir *</label>
                            <input type="text" :name="`careers[${idx}][title]`" x-model="car.title" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs">
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Ikon</label>
                                <input type="text" :name="`careers[${idx}][icon]`" x-model="car.icon" placeholder="fa-solid fa-user-tie" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Warna</label>
                                <select :name="`careers[${idx}][color]`" x-model="car.color" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs">
                                    <option value="emerald">Emerald</option>
                                    <option value="purple">Purple</option>
                                    <option value="teal">Teal</option>
                                    <option value="amber">Amber</option>
                                    <option value="blue">Blue</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Deskripsi *</label>
                            <textarea :name="`careers[${idx}][description]`" x-model="car.description" rows="3" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-xs leading-relaxed"></textarea>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/20 flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Profil Lulusan
            </button>
        </div>
    </form>
</div>
@endsection
