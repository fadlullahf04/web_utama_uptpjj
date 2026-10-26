@extends('layouts.app')

@section('title', 'Tanya Jawab (FAQs) - UPT Pendidikan Jarak Jauh UINSSC')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#006837] to-[#004d29] py-14 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold mb-3">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> <i class="fa-solid fa-chevron-right text-[10px]"></i> <span>FAQs</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Tanya Jawab Seputar Perkuliahan PJJ</h1>
        <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl">Jawaban resmi atas pertanyaan yang paling sering diajukan mengenai legalitas ijazah, alur PMB, tata cara kuliah di LMS Pillar, biaya, dan ujian daring.</p>

        <!-- Search Form -->
        <div class="mt-6 max-w-xl">
            <form action="{{ route('faqs') }}" method="GET">
                <div class="relative">
                    <input type="text" name="cari" value="{{ $search }}" placeholder="Ketik pertanyaan atau kata kunci..." class="w-full pl-11 pr-24 py-3 bg-white border border-emerald-200 rounded-full text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-amber-400 shadow-md">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                    <button type="submit" class="absolute right-1.5 top-1.5 px-4 py-1.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs rounded-full transition">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10" x-data="{ openFaq: null }">
    @forelse($faqs as $catName => $items)
        <div class="space-y-4">
            <h2 class="text-base font-extrabold text-slate-900 uppercase tracking-wider text-[#006837] pb-2 border-b border-slate-200 flex items-center gap-2">
                <i class="fa-solid fa-folder-open text-xs"></i> Kategori: {{ $catName }}
            </h2>

            <div class="space-y-3">
                @foreach($items as $faq)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden transition">
                        <button @click="openFaq = (openFaq === {{ $faq->id }} ? null : {{ $faq->id }})" class="w-full p-5 text-left flex items-center justify-between gap-4">
                            <span class="text-xs sm:text-sm font-bold text-slate-800" :class="openFaq === {{ $faq->id }} ? 'text-[#006837]' : ''">
                                {{ $faq->question }}
                            </span>
                            <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center shrink-0 text-slate-600 transition-transform duration-300" :class="openFaq === {{ $faq->id }} ? 'rotate-180 text-[#006837] bg-emerald-50' : ''">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </button>
                        <div x-show="openFaq === {{ $faq->id }}" x-cloak x-transition:enter="transition ease-out duration-200" class="px-5 pb-5 pt-1 text-xs text-slate-600 leading-relaxed border-t border-slate-100 space-y-2">
                            <p>{!! nl2br(e($faq->answer)) !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="text-center py-12 bg-white rounded-2xl border border-slate-200">
            <p class="text-slate-500 text-sm">Tidak ada FAQ yang ditemukan.</p>
        </div>
    @endforelse

    <!-- Still have questions? Helpdesk Box -->
    <div class="p-8 rounded-3xl bg-gradient-to-r from-[#006837] to-[#004d29] text-white text-center space-y-4 shadow-xl">
        <h3 class="text-lg font-bold text-white">Pertanyaan Anda Belum Terjawab?</h3>
        <p class="text-xs text-emerald-100 max-w-md mx-auto">Tim helpdesk kami siap membantu menjelaskan setiap pertanyaan Anda terkait pendaftaran dan perkuliahan.</p>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '628112345678')) }}" target="_blank" class="px-5 py-2.5 rounded-full bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition flex items-center gap-2 shadow">
                <i class="fa-brands fa-whatsapp text-sm"></i> Chat WhatsApp
            </a>
            <a href="{{ route('contact.index') }}" class="px-5 py-2.5 rounded-full bg-white/20 hover:bg-white/30 text-white font-bold text-xs uppercase tracking-wider transition flex items-center gap-2">
                <i class="fa-solid fa-envelope text-sm"></i> Kontak Helpdesk
            </a>
        </div>
    </div>
</div>
@endsection
