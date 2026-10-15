@extends('layouts.app')

@section('title', 'Kontak & Helpdesk - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>Kontak Kami</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Hubungi Kami & Layanan Helpdesk</h1>
        <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">Kami siap mendengarkan pertanyaan, kendala teknis LMS, konsultasi pendaftaran PMB, maupun usulan kerjasama akademik.</p>
    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Left 7 Cols: Contact Form -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 text-[#006837]">Kirim Pesan atau Pengaduan</h2>
                    <p class="text-xs text-slate-500 mt-1">Isi formulir di bawah ini, tim customer support kami akan segera merespons via email atau WhatsApp.</p>
                </div>

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Anti-spam honeypot (hidden from human visitors) --}}
                    <div class="hidden" style="display: none;" aria-hidden="true">
                        <label for="_hp_company">Do not fill this field</label>
                        <input type="text" name="_hp_company" id="_hp_company" tabindex="-1" autocomplete="off" value="">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Ahmad Fauzi" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:border-[#006837] focus:ring-2 focus:ring-[#006837]/20">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:border-[#006837] focus:ring-2 focus:ring-[#006837]/20">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">No. WhatsApp / HP</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 08123456789" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:border-[#006837] focus:ring-2 focus:ring-[#006837]/20">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Pesan *</label>
                            <select name="category" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-[#006837] focus:ring-2 focus:ring-[#006837]/20">
                                <option value="Pertanyaan Umum">Pertanyaan Umum</option>
                                <option value="Pendaftaran & PMB Online">Pendaftaran & PMB Online</option>
                                <option value="Kendala Teknis LMS Pillar">Kendala Teknis LMS Pillar</option>
                                <option value="Layanan Mahasiswa & KRS">Layanan Mahasiswa & KRS</option>
                                <option value="Kerjasama Akademik / Kelembagaan">Kerjasama Akademik / Kelembagaan</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Subjek Pesan *</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required placeholder="Contoh: Konfirmasi Alur Pendaftaran Jalur RPL" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:border-[#006837] focus:ring-2 focus:ring-[#006837]/20">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Isi Pesan / Pertanyaan *</label>
                        <textarea name="message" rows="5" required placeholder="Tuliskan secara jelas rincian pertanyaan atau kendala yang Anda alami..." class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:border-[#006837] focus:ring-2 focus:ring-[#006837]/20 leading-relaxed">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-full bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider shadow-md transition">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>

        <!-- Right 5 Cols: Contact Info & Maps -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Quick Contacts Card -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-[#006837] pb-2 border-b border-slate-100">
                    Informasi Kontak Kantor
                </h3>

                <div class="space-y-4 text-xs">
                    <div class="flex items-start gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-[#006837] flex items-center justify-center shrink-0 text-sm border border-emerald-200">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Alamat Kampus:</span>
                            <span class="text-slate-600 leading-relaxed">{{ \App\Models\Setting::get('address') }}</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-[#006837] flex items-center justify-center shrink-0 text-sm border border-emerald-200">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">WhatsApp Helpdesk:</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '628112345678')) }}" target="_blank" class="text-[#006837] hover:underline font-semibold">{{ \App\Models\Setting::get('whatsapp', '+62 811-2345-678') }}</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-[#006837] flex items-center justify-center shrink-0 text-sm border border-emerald-200">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Email Resmi:</span>
                            <a href="mailto:{{ \App\Models\Setting::get('email', 'pjj@uinssc.ac.id') }}" class="text-[#006837] hover:underline font-semibold">{{ \App\Models\Setting::get('email', 'pjj@uinssc.ac.id') }}</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-[#006837] flex items-center justify-center shrink-0 text-sm border border-emerald-200">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Jam Operasional:</span>
                            <span class="text-slate-600">{{ \App\Models\Setting::get('work_hours', 'Senin - Jumat: 07.30 - 16.00 WIB') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Google Maps Embed Card -->
            <div class="bg-white p-3 rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="w-full h-64 rounded-2xl overflow-hidden">
                    {!! \App\Models\Setting::get('google_maps_iframe') !!}
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
