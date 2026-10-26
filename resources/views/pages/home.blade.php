@extends('layouts.app')

@section('title', 'UPT Pendidikan Jarak Jauh - UIN Siber Syekh Nurjati Cirebon')

@section('content')

<!-- 1. Hero Banner Slider Section -->
<section class="relative bg-slate-900 overflow-hidden" x-data="{ 
    activeSlide: 0, 
    slidesCount: {{ $heroSlides->count() > 0 ? $heroSlides->count() : 1 }},
    timer: null,
    startTimer() {
        this.timer = setInterval(() => {
            this.activeSlide = (this.activeSlide + 1) % this.slidesCount;
        }, 6000);
    },
    stopTimer() {
        if (this.timer) clearInterval(this.timer);
    }
}" x-init="startTimer()" @mouseenter="stopTimer()" @mouseleave="startTimer()">
    
    <div class="relative min-h-[520px] md:min-h-[600px] flex items-center">
        
        @foreach($heroSlides as $index => $slide)
            <div x-show="activeSlide === {{ $index }}" x-cloak
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute inset-0 w-full h-full">
                
                <!-- Slide Background Image with Soft University Overlay -->
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $slide->image_url }}');">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-950/75 to-slate-900/40"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-black/30"></div>
                </div>

                <!-- Slide Content -->
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center py-16">
                    <div class="max-w-3xl space-y-5">
                        
                        @if($slide->badge)
                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#006837]/30 border border-emerald-400/40 text-emerald-300 text-xs font-extrabold tracking-wide backdrop-blur-sm">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                {{ $slide->badge }}
                            </div>
                        @endif

                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight tracking-tight drop-shadow-md">
                            {{ $slide->title }}
                            @if($slide->highlight_text)
                                <span class="block text-amber-400 mt-1 drop-shadow">{{ $slide->highlight_text }}</span>
                            @endif
                        </h1>

                        <p class="text-sm sm:text-base text-slate-200 max-w-2xl leading-relaxed">
                            {{ $slide->subtitle }}
                        </p>

                        <!-- CTA Buttons -->
                        <div class="pt-4 flex flex-wrap items-center gap-4">
                            @if($slide->primary_btn_text)
                                <a href="{{ $slide->primary_btn_url }}" target="{{ str_starts_with($slide->primary_btn_url, 'http') ? '_blank' : '_self' }}" class="px-6 py-3.5 rounded-full bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider shadow-lg shadow-emerald-950/40 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                                    <span>{{ $slide->primary_btn_text }}</span>
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            @endif

                            @if($slide->secondary_btn_text)
                                <a href="{{ $slide->secondary_btn_url }}" class="px-6 py-3.5 rounded-full bg-white/15 hover:bg-white/25 border border-white/30 text-white font-bold text-xs uppercase tracking-wider backdrop-blur transition flex items-center gap-2">
                                    <span>{{ $slide->secondary_btn_text }}</span>
                                    <i class="fa-solid fa-circle-chevron-right text-emerald-400 text-xs"></i>
                                </a>
                            @endif
                        </div>

                    </div>
                </div>

            </div>
        @endforeach

    </div>

    <!-- Carousel Controls (Indicators & Arrows) -->
    <div class="absolute bottom-6 right-4 sm:right-12 z-20 flex items-center gap-3">
        <button @click="activeSlide = (activeSlide - 1 + slidesCount) % slidesCount" class="w-9 h-9 rounded-full bg-black/50 hover:bg-[#006837] border border-white/20 text-white flex items-center justify-center transition">
            <i class="fa-solid fa-chevron-left text-xs"></i>
        </button>
        <div class="flex items-center gap-1.5">
            @for($i = 0; $i < $heroSlides->count(); $i++)
                <button @click="activeSlide = {{ $i }}" class="h-2 rounded-full transition-all duration-300" :class="activeSlide === {{ $i }} ? 'w-7 bg-[#006837]' : 'w-2 bg-white/40'"></button>
            @endfor
        </div>
        <button @click="activeSlide = (activeSlide + 1) % slidesCount" class="w-9 h-9 rounded-full bg-black/50 hover:bg-[#006837] border border-white/20 text-white flex items-center justify-center transition">
            <i class="fa-solid fa-chevron-right text-xs"></i>
        </button>
    </div>

</section>

<!-- 2. University Stats Counter (Clean Elevated White Card) -->
<section class="relative z-20 -mt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-xl border border-slate-200/80 grid grid-cols-2 lg:grid-cols-4 gap-6 text-center">
        
        <div class="p-2 border-r border-slate-100 last:border-0">
            <div class="text-2xl sm:text-4xl font-black text-[#006837] mb-1">
                {{ \App\Models\Setting::get('stats_students', '8,500+') }}
            </div>
            <div class="text-xs font-bold text-slate-800">Mahasiswa PJJ Aktif</div>
            <p class="text-[11px] text-slate-500 mt-0.5">38 Provinsi & Luar Negeri</p>
        </div>

        <div class="p-2 border-r border-slate-100 last:border-0">
            <div class="text-2xl sm:text-4xl font-black text-amber-600 mb-1">
                {{ \App\Models\Setting::get('stats_programs', '6') }}
            </div>
            <div class="text-xs font-bold text-slate-800">Program Studi PJJ</div>
            <p class="text-[11px] text-slate-500 mt-0.5">Sarjana (S1) & Magister (S2)</p>
        </div>

        <div class="p-2 border-r border-slate-100 last:border-0">
            <div class="text-2xl sm:text-4xl font-black text-teal-700 mb-1">
                {{ \App\Models\Setting::get('stats_lecturers', '180+') }}
            </div>
            <div class="text-xs font-bold text-slate-800">Dosen & Tutor Siber</div>
            <p class="text-[11px] text-slate-500 mt-0.5">Tersertifikasi Pedagogi Daring</p>
        </div>

        <div class="p-2">
            <div class="text-2xl sm:text-4xl font-black text-blue-700 mb-1">
                {{ \App\Models\Setting::get('stats_modules', '1,250+') }}
            </div>
            <div class="text-xs font-bold text-slate-800">Modul & Video LMS</div>
            <p class="text-[11px] text-slate-500 mt-0.5">Materi Digital Interaktif</p>
        </div>

    </div>
</section>

<!-- 3. Sambutan & Visi Kepala UPT PJJ (Matches uptpjj.uinssc.ac.id middle section) -->
<section class="py-20 bg-slate-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Foto & Nama Kepala UPT PJJ -->
            <div class="lg:col-span-5 text-center">
                <div class="relative mx-auto max-w-sm rounded-2xl overflow-hidden shadow-xl border-4 border-white group">
                    <img src="{{ \App\Models\Setting::get('head_photo', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=600&auto=format&fit=crop') }}" alt="Kepala UPT PJJ" class="w-full h-[380px] object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white text-left">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider bg-[#006837] px-2 py-0.5 rounded text-white">Kepala UPT</span>
                        <h4 class="text-base font-extrabold text-white mt-1">{{ \App\Models\Setting::get('head_name', 'Dr. Moh. Ali, M.Pd.I') }}</h4>
                    </div>
                </div>
                <div class="mt-3">
                    <h5 class="text-sm font-bold text-slate-800">{{ \App\Models\Setting::get('head_name', 'Dr. Moh. Ali, M.Pd.I') }}</h5>
                    <p class="text-xs text-slate-500">{{ \App\Models\Setting::get('head_title', 'Kepala UPT Pendidikan Jarak Jauh') }}</p>
                </div>
            </div>

            <!-- Teks Sambutan & Visi Misi -->
            <div class="lg:col-span-7 space-y-6">
                
                <div class="border-l-4 border-[#006837] pl-4 space-y-2">
                    <p class="text-sm sm:text-base text-slate-700 font-medium italic leading-relaxed">
                        "Visi kami adalah menjadi Unit Pelaksana Teknis Pendidikan Jarak Jauh (UPT-PJJ) yang inovatif dan inklusif, menghasilkan lulusan berkualitas global dalam bingkai nilai-nilai Islam, serta mendukung terwujudnya Universitas Islam Siber berkelas dunia untuk semua pada Tahun 2030."
                    </p>
                </div>

                <div class="text-slate-600 text-xs sm:text-sm leading-relaxed space-y-3">
                    <p>
                        Untuk mewujudkan visi tersebut, kami akan terus meningkatkan kualitas sistem pembelajaran, mengembangkan konten-konten edukatif yang relevan, serta memperkuat kolaborasi dengan berbagai pihak, baik internal maupun eksternal universitas.
                    </p>
                    <p>
                        UPT PJJ UIN SSC merupakan Unit Pelaksana Teknis Pendidikan Jarak Jauh Universitas Islam Negeri Siber Syekh Nurjati Cirebon yang bertanggung jawab atas penyelenggaraan pendidikan daring di UIN Cirebon dengan standar mutu nasional dan internasional.
                    </p>
                </div>

                <!-- Action Button (Emerald Pill matching live site) -->
                <div class="pt-2">
                    <a href="{{ route('profile.overview') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider shadow-md transition transform hover:-translate-y-0.5">
                        <span>Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- 4. Berita dan Informasi (Matches uptpjj.uinssc.ac.id news section) -->
<section class="py-20 bg-white border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <div class="flex items-center justify-center gap-2 text-xs font-bold uppercase tracking-wider text-amber-600 mb-1">
                <span class="w-6 h-0.5 bg-amber-500 inline-block"></span>
                <span>Terbaru</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                Berita dan Informasi
            </h2>
        </div>

        <!-- News Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredPosts as $post)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden group">
                    
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-[#006837] text-white text-[10px] font-bold uppercase tracking-wider">
                            {{ $post->category->name ?? 'Berita' }}
                        </span>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-slate-500">
                                <i class="fa-regular fa-calendar text-[#006837]"></i>
                                <span>{{ $post->published_at ? $post->published_at->format('d F Y') : $post->created_at->format('d F Y') }}</span>
                            </div>
                            <h3 class="text-sm sm:text-base font-bold text-slate-900 group-hover:text-[#006837] transition leading-snug line-clamp-2">
                                <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                {{ $post->excerpt }}
                            </p>
                        </div>

                        <div class="pt-2">
                            <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition shadow-sm">
                                <span>Selengkapnya</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Lihat Lebih Banyak Button -->
        <div class="mt-12 text-center">
            <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 px-7 py-3 rounded-full bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider shadow-md transition transform hover:-translate-y-0.5">
                <span>Lihat Lebih Banyak</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

    </div>
</section>

<!-- 5. Program Studi PJJ Showcase (Matches uptpjj.uinssc.ac.id photo grid style) -->
<section class="py-20 relative bg-slate-900 text-white overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1600&auto=format&fit=crop');"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-slate-950 via-slate-900/90 to-slate-950"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10">
        
        <div class="text-center mb-14">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                Program Studi PJJ
            </h2>
            <p class="text-xs sm:text-sm text-slate-300 mt-2 max-w-2xl mx-auto">
                Program studi berbasis siber terakreditasi resmi di UIN Siber Syekh Nurjati Cirebon.
            </p>
        </div>

        <!-- Prodi Grid with Dark Translucent Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($studyPrograms as $prodi)
                <div class="bg-black/60 backdrop-blur-md rounded-2xl border border-white/10 p-6 flex flex-col justify-between space-y-4 hover:border-emerald-400/50 hover:bg-black/80 transition-all duration-300 group">
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-full {{ $prodi->degree === 'S2' ? 'bg-amber-500 text-black' : 'bg-[#006837] text-white' }} text-[11px] font-extrabold uppercase">
                                {{ $prodi->degree }}
                            </span>
                            <span class="text-[11px] font-bold text-emerald-400 bg-emerald-950/60 px-2.5 py-0.5 rounded-full border border-emerald-500/30">
                                Akreditasi {{ $prodi->accreditation }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-white group-hover:text-emerald-300 transition">
                            {{ $prodi->name }}
                        </h3>

                        <p class="text-xs text-slate-300 line-clamp-2 leading-relaxed">
                            {{ $prodi->short_description }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-white/10 flex items-center justify-between text-xs">
                        <a href="{{ route('programs.show', $prodi->slug) }}" class="font-bold text-emerald-400 hover:text-emerald-300 flex items-center gap-1 transition">
                            Detail Kurikulum <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                        <a href="{{ $prodi->registration_url ?? \App\Models\Setting::get('pmb_url', 'https://pmb.uinssc.ac.id') }}" target="_blank" class="px-3.5 py-1.5 rounded-lg bg-[#006837] hover:bg-[#004d29] text-white font-bold text-[11px] transition">
                            Daftar PMB
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- 6. Sarana & Gedung Kampus Siber (Matches uptpjj.uinssc.ac.id building grid) -->
<section class="py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                Sarana dan Prasarana Kampus
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Fasilitas gedung perkuliahan, pusat teknologi, studio pembelajaran siber, dan laboratorium modern.
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
            @php
                $campusBuildings = [
                    ['title' => 'Gedung Siber', 'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=600&auto=format&fit=crop'],
                    ['title' => 'Gedung Rektorat', 'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=600&auto=format&fit=crop'],
                    ['title' => 'Gedung UPT dan Pusat', 'image' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop'],
                    ['title' => 'Gedung FDKI', 'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=600&auto=format&fit=crop'],
                    ['title' => 'Gedung FEBI', 'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=600&auto=format&fit=crop'],
                    ['title' => 'Gedung FITK', 'image' => 'https://images.unsplash.com/photo-1519452635265-7b1fbfd1e4e0?q=80&w=600&auto=format&fit=crop'],
                    ['title' => 'Gedung FUA', 'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop'],
                    ['title' => 'Gedung FASYA', 'image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=600&auto=format&fit=crop'],
                    ['title' => 'Gedung Pascasarjana', 'image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=600&auto=format&fit=crop'],
                ];
            @endphp

            @foreach($campusBuildings as $bld)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden group hover:shadow-lg transition">
                    <div class="h-40 overflow-hidden relative">
                        <img src="{{ $bld['image'] }}" alt="{{ $bld['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4 text-center">
                        <h4 class="text-sm font-bold text-[#006837] group-hover:text-[#004d29]">
                            {{ $bld['title'] }}
                        </h4>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- 7. Layanan & Fasilitas PJJ -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-2">
            <span class="text-xs font-bold uppercase tracking-wider text-[#006837] bg-emerald-50 px-3 py-1 rounded-full">
                Layanan Unggulan
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                Ekosistem Layanan & Pembelajaran Siber
            </h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Fasilitas pembelajaran daring modern untuk kemudahan perkuliahan seluruh sivitas akademika.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $srv)
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 hover:border-[#006837] hover:bg-white hover:shadow-lg transition flex flex-col justify-between space-y-4 group">
                    <div class="space-y-3">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-[#006837] flex items-center justify-center text-xl shadow-sm group-hover:bg-[#006837] group-hover:text-white transition">
                            <i class="fa-solid fa-laptop-code"></i>
                        </div>
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                            {{ $srv->category }}
                        </span>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-[#006837] transition">
                            {{ $srv->title }}
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $srv->short_description }}
                        </p>
                    </div>

                    <div class="pt-2 border-t border-slate-200">
                        @if($srv->portal_url)
                            <a href="{{ $srv->portal_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#006837] hover:underline">
                                <span>{{ $srv->button_text ?? 'Akses Portal' }}</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            </a>
                        @else
                            <a href="{{ route('services.show', $srv->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-700 hover:text-[#006837]">
                                <span>{{ $srv->button_text ?? 'Detail Layanan' }}</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- 8. Tanya Jawab (FAQ) Accordion Section -->
<section class="py-20 bg-slate-50 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            
            <div class="text-center mb-12 space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-[#006837] bg-emerald-50 px-3 py-1 rounded-full">
                    Frequently Asked Questions
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                    Pertanyaan yang Sering Diajukan (FAQs)
                </h2>
                <p class="text-xs text-slate-500">
                    Informasi penting seputar perkuliahan jarak jauh, legalitas ijazah, dan pendaftaran.
                </p>
            </div>

            <div class="space-y-3" x-data="{ openFaq: 0 }">
                @foreach($faqs as $fIndex => $faq)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden transition">
                        <button @click="openFaq = (openFaq === {{ $fIndex }} ? null : {{ $fIndex }})" class="w-full p-5 text-left flex items-center justify-between gap-4">
                            <span class="text-xs sm:text-sm font-bold text-slate-800" :class="openFaq === {{ $fIndex }} ? 'text-[#006837]' : ''">
                                {{ $faq->question }}
                            </span>
                            <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center shrink-0 text-slate-600 transition-transform duration-300" :class="openFaq === {{ $fIndex }} ? 'rotate-180 text-[#006837] bg-emerald-50' : ''">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </button>
                        <div x-show="openFaq === {{ $fIndex }}" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="px-5 pb-5 pt-1 text-xs text-slate-600 leading-relaxed border-t border-slate-100">
                            {{ $faq->answer }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('faqs') }}" class="text-xs font-bold text-[#006837] hover:underline">
                    Lihat Semua Pertanyaan & Jawaban (FAQ) →
                </a>
            </div>

        </div>
    </div>
</section>

<!-- 9. Call to Action PMB Banner -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-gradient-to-r from-[#006837] to-[#004d29] p-8 sm:p-12 lg:p-14 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-8">
            
            <div class="max-w-2xl space-y-4">
                <span class="px-3.5 py-1 rounded-full bg-amber-400 text-slate-950 text-xs font-extrabold uppercase tracking-wider">
                    Penerimaan Mahasiswa Baru
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                    Kuliah Fleksibel, Berkualitas, dan Berakreditasi Resmi
                </h2>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                    Daftar sekarang di program studi pilihan Anda dan nikmati kemudahan belajar daring dari mana saja bersama UPT PJJ UIN Siber Syekh Nurjati Cirebon.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 shrink-0">
                <a href="{{ \App\Models\Setting::get('pmb_url', 'https://pmb.uinssc.ac.id') }}" target="_blank" class="px-7 py-3.5 rounded-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs uppercase tracking-wider shadow-lg transition transform hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus"></i> Daftar PMB Online
                </a>
                <a href="{{ route('contact.index') }}" class="px-6 py-3.5 rounded-full bg-white/20 hover:bg-white/30 text-white font-bold text-xs uppercase tracking-wider backdrop-blur transition">
                    Kontak Kami
                </a>
            </div>

        </div>
    </div>
</section>

@endsection
