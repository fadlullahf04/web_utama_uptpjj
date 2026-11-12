@php
    $totalMale = (int) $zones->sum('male_students_count');
    $totalFemale = (int) $zones->sum('female_students_count');
    $totalStudentsSum = (int) $zones->sum('students_count');
    $totalStudents = max($totalStudentsSum, 1);
    $malePct = round(($totalMale / $totalStudents) * 100, 1);
    $femalePct = round(($totalFemale / $totalStudents) * 100, 1);

    $colorPalette = [
        'emerald' => [
            'grad' => 'from-emerald-500 to-emerald-700',
            'bg' => 'bg-emerald-600',
            'ring' => 'ring-emerald-400/50',
            'sonar' => 'border-emerald-500 bg-emerald-400/25',
            'badge' => 'bg-white/95 text-emerald-800 border-emerald-300',
            'card_border' => 'border-emerald-500 bg-emerald-50/40',
            'text' => 'text-emerald-700',
            'bar' => 'bg-emerald-500',
            'hex' => '#059669',
        ],
        'teal' => [
            'grad' => 'from-teal-500 to-teal-700',
            'bg' => 'bg-teal-600',
            'ring' => 'ring-teal-400/50',
            'sonar' => 'border-teal-500 bg-teal-400/25',
            'badge' => 'bg-white/95 text-teal-800 border-teal-300',
            'card_border' => 'border-teal-500 bg-teal-50/40',
            'text' => 'text-teal-700',
            'bar' => 'bg-teal-500',
            'hex' => '#0d9488',
        ],
        'amber' => [
            'grad' => 'from-amber-500 to-orange-600',
            'bg' => 'bg-amber-500',
            'ring' => 'ring-amber-400/50',
            'sonar' => 'border-amber-500 bg-amber-400/25',
            'badge' => 'bg-white/95 text-amber-800 border-amber-300',
            'card_border' => 'border-amber-500 bg-amber-50/40',
            'text' => 'text-amber-700',
            'bar' => 'bg-amber-500',
            'hex' => '#d97706',
        ],
        'blue' => [
            'grad' => 'from-blue-500 to-indigo-600',
            'bg' => 'bg-blue-600',
            'ring' => 'ring-blue-400/50',
            'sonar' => 'border-blue-500 bg-blue-400/25',
            'badge' => 'bg-white/95 text-blue-800 border-blue-300',
            'card_border' => 'border-blue-500 bg-blue-50/40',
            'text' => 'text-blue-700',
            'bar' => 'bg-blue-500',
            'hex' => '#2563eb',
        ],
        'purple' => [
            'grad' => 'from-purple-500 to-fuchsia-700',
            'bg' => 'bg-purple-600',
            'ring' => 'ring-purple-400/50',
            'sonar' => 'border-purple-500 bg-purple-400/25',
            'badge' => 'bg-white/95 text-purple-800 border-purple-300',
            'card_border' => 'border-purple-500 bg-purple-50/40',
            'text' => 'text-purple-700',
            'bar' => 'bg-purple-500',
            'hex' => '#9333ea',
        ],
        'rose' => [
            'grad' => 'from-rose-500 to-pink-700',
            'bg' => 'bg-rose-600',
            'ring' => 'ring-rose-400/50',
            'sonar' => 'border-rose-500 bg-rose-400/25',
            'badge' => 'bg-white/95 text-rose-800 border-rose-300',
            'card_border' => 'border-rose-500 bg-rose-50/40',
            'text' => 'text-rose-700',
            'bar' => 'bg-rose-500',
            'hex' => '#e11d48',
        ],
        'cyan' => [
            'grad' => 'from-cyan-500 to-sky-700',
            'bg' => 'bg-cyan-600',
            'ring' => 'ring-cyan-400/50',
            'sonar' => 'border-cyan-500 bg-cyan-400/25',
            'badge' => 'bg-white/95 text-cyan-800 border-cyan-300',
            'card_border' => 'border-cyan-500 bg-cyan-50/40',
            'text' => 'text-cyan-700',
            'bar' => 'bg-cyan-500',
            'hex' => '#0891b2',
        ],
    ];
@endphp

<div class="my-8 rounded-3xl border border-slate-200 bg-white shadow-md overflow-hidden" x-data="{ selectedZoneId: {{ $zones->first()->id ?? 'null' }}, hoveredZoneId: null }">
    
    <!-- Map Header Bar -->
    <div class="p-5 sm:p-6 bg-gradient-to-r from-[#006837] via-[#045c33] to-[#004d29] text-white space-y-4 border-b border-emerald-500/20">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/15 border border-white/20 text-amber-300 text-[10px] font-extrabold uppercase tracking-wider mb-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-300 animate-pulse"></span> Peta Interaktif Sebaran Nasional & Internasional
            </div>
            <h4 class="text-base sm:text-lg font-extrabold text-white tracking-tight">
                Peta Sebaran Wilayah & Jumlah Mahasiswa UPBJJ UINSSC
            </h4>
            <p class="text-xs text-emerald-100/90 mt-0.5">
                Sebaran jumlah mahasiswa aktif pada masing-masing zona wilayah layanan UPBJJ di seluruh Indonesia dan Luar Negeri.
            </p>
        </div>

        <!-- Proportional 3-Column Summary Counters in Header -->
        <div class="grid grid-cols-3 gap-2.5 sm:gap-3 pt-1">
            <div class="bg-white/10 backdrop-blur-sm px-3.5 py-2.5 rounded-2xl border border-white/15 flex items-center gap-2.5">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-sky-400/25 text-sky-200 border border-sky-300/30 flex items-center justify-center text-xs sm:text-sm font-extrabold shrink-0">
                    <i class="fa-solid fa-mars"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-sm sm:text-base font-black text-white leading-none truncate">
                        {{ number_format($totalMale, 0, ',', '.') }}
                    </div>
                    <div class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-sky-200 mt-1 truncate">
                        Mhs Laki-Laki
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-sm px-3.5 py-2.5 rounded-2xl border border-white/15 flex items-center gap-2.5">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-pink-400/25 text-pink-200 border border-pink-300/30 flex items-center justify-center text-xs sm:text-sm font-extrabold shrink-0">
                    <i class="fa-solid fa-venus"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-sm sm:text-base font-black text-white leading-none truncate">
                        {{ number_format($totalFemale, 0, ',', '.') }}
                    </div>
                    <div class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-pink-200 mt-1 truncate">
                        Mhs Perempuan
                    </div>
                </div>
            </div>

            <div class="bg-amber-400 text-slate-950 px-3.5 py-2.5 rounded-2xl border border-amber-300 flex items-center gap-2.5 shadow-sm">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-slate-950/10 text-slate-950 flex items-center justify-center text-xs sm:text-sm font-extrabold shrink-0">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-sm sm:text-base font-black text-slate-950 leading-none truncate">
                        {{ number_format($totalStudentsSum, 0, ',', '.') }}
                    </div>
                    <div class="text-[9px] sm:text-[10px] font-extrabold uppercase tracking-wider text-slate-800 mt-1 truncate">
                        Total Mahasiswa
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Indonesia Atlas Map Container with Curved Animated Signal Arcs & Sonar Bubbles -->
    <div class="relative w-full bg-[#e0f2fe] overflow-x-auto border-b border-slate-200">
        <div class="relative min-w-[680px] w-full aspect-[1000/450] select-none overflow-hidden">
            
            <!-- Base Map SVG of Indonesia (Modern Bright Topographic Atlas Style) -->
            <img src="{{ asset('images/peta-indonesia.svg') }}?v=2" alt="Peta Sebaran Wilayah UPBJJ Indonesia" class="w-full h-full object-cover block pointer-events-none">

            <!-- Curved Bezier Network Arcs from Cirebon Hub (x: 30.5%, y: 72%) to Each UPBJJ Zone -->
            <svg class="absolute inset-0 w-full h-full pointer-events-none" viewBox="0 0 100 100" preserveAspectRatio="none">
                @foreach($zones as $zone)
                    @php
                        $hx = 30.5;
                        $hy = 72.0;
                        $zx = (float) ($zone->map_x ?? 30.5);
                        $zy = (float) ($zone->map_y ?? 70.0);
                        $palette = $colorPalette[$zone->bubble_color] ?? $colorPalette['emerald'];

                        // Calculate quadratic Bezier control point for a graceful arch
                        $midX = ($hx + $zx) / 2;
                        $dist = sqrt(pow($zx - $hx, 2) + pow($zy - $hy, 2));
                        $archLift = min(max($dist * 0.32, 4), 22);
                        $ctrlY = min($hy, $zy) - $archLift;
                        $pathD = "M {$hx} {$hy} Q {$midX} {$ctrlY} {$zx} {$zy}";
                    @endphp
                    @if(abs($zx - $hx) > 1 || abs($zy - $hy) > 1)
                        <!-- Soft Background Track Arc -->
                        <path d="{{ $pathD }}" fill="none" stroke="{{ $palette['hex'] }}" stroke-width="0.3" stroke-opacity="0.22" />
                        <!-- Animated Flowing Data Signal Arc -->
                        <path d="{{ $pathD }}" fill="none" stroke="{{ $palette['hex'] }}" stroke-width="0.55" stroke-linecap="round" stroke-opacity="0.8" class="upbjj-arc-animated" />
                    @endif
                @endforeach
            </svg>

            <!-- Colored Bubbles Overlay with Dual Sonar Ripples & Gentle Floating Animation -->
            @foreach($zones as $index => $zone)
                @php
                    $zx = $zone->map_x ?? 30.5;
                    $zy = $zone->map_y ?? 70.0;
                    $palette = $colorPalette[$zone->bubble_color] ?? $colorPalette['emerald'];
                    $count = (int) $zone->students_count;
                    $sizeClass = match (true) {
                        $count >= 2500 => 'w-14 h-14 sm:w-16 sm:h-16 text-xs sm:text-sm',
                        $count >= 1500 => 'w-12 h-12 sm:w-14 sm:h-14 text-xs',
                        $count >= 800 => 'w-11 h-11 sm:w-12 sm:h-12 text-[11px]',
                        default => 'w-10 h-10 sm:w-11 sm:h-11 text-[10px] sm:text-[11px]',
                    };
                    $floatDelay = number_format(($index % 5) * 0.45, 2) . 's';
                @endphp

                <div class="absolute -translate-x-1/2 -translate-y-1/2 group cursor-pointer transition-all duration-300"
                     style="left: {{ $zx }}%; top: {{ $zy }}%;"
                     :class="(selectedZoneId === {{ $zone->id }} || hoveredZoneId === {{ $zone->id }}) ? 'z-30 scale-110' : 'z-20 hover:z-30'"
                     @mouseenter="hoveredZoneId = {{ $zone->id }}"
                     @mouseleave="hoveredZoneId = null"
                     @click="selectedZoneId = {{ $zone->id }}">
                    
                    <div class="relative flex flex-col items-center upbjj-bubble-float" style="animation-delay: {{ $floatDelay }};">
                        <!-- Dual Staggered Concentric Sonar Ripples -->
                        <div class="relative flex items-center justify-center">
                            <span class="upbjj-sonar-ring absolute inset-0 rounded-full border-2 {{ $palette['sonar'] }} pointer-events-none"></span>
                            <span class="upbjj-sonar-ring-delay absolute inset-0 rounded-full border {{ $palette['sonar'] }} pointer-events-none"></span>

                            <!-- 3D Glossy Gradient Bubble Circle with Student Count Inside -->
                            <div class="relative {{ $sizeClass }} rounded-full bg-gradient-to-br {{ $palette['grad'] }} text-white ring-4 {{ $palette['ring'] }} shadow-lg flex flex-col items-center justify-center font-extrabold leading-none border-2 border-white transition-all duration-300 overflow-hidden"
                                 :class="selectedZoneId === {{ $zone->id }} ? 'ring-8 ring-emerald-500/30 shadow-xl scale-105' : ''">
                                <!-- Subtle Top Glass Highlight -->
                                <span class="absolute inset-x-1 top-0.5 h-1/3 rounded-t-full bg-gradient-to-b from-white/35 to-transparent pointer-events-none"></span>
                                <span class="relative drop-shadow-xs">{{ number_format($zone->students_count, 0, ',', '.') }}</span>
                                <span class="relative text-[8px] font-bold uppercase tracking-tighter opacity-95 mt-0.5">Mhs</span>
                            </div>
                        </div>

                        <!-- Sleek Pill Tag Below Bubble -->
                        <div class="mt-1.5 px-2.5 py-0.5 rounded-full border text-[9px] sm:text-[10px] font-black whitespace-nowrap shadow-sm text-center backdrop-blur-md transition-transform duration-300 {{ $palette['badge'] }}"
                             :class="selectedZoneId === {{ $zone->id }} ? 'scale-105 ring-2 ring-emerald-500/30' : ''">
                            {{ $zone->code }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Proportional Rincian Sebaran Mahasiswa per Zona UPBJJ -->
    <div class="p-5 sm:p-6 bg-slate-50 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1.5 border-b border-slate-200/80 pb-3">
            <h5 class="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-chart-pie text-[#006837]"></i> Rincian Sebaran Mahasiswa per Zona UPBJJ
            </h5>
            <span class="text-[11px] font-medium text-slate-500">Klik kartu wilayah untuk menyorot titik di peta</span>
        </div>

        <!-- Symmetrical 2-Column Grid (Last item spans full width if count is odd so layout stays balanced) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($zones as $zone)
                @php
                    $palette = $colorPalette[$zone->bubble_color] ?? $colorPalette['emerald'];
                    $pct = round(($zone->students_count / $totalStudents) * 100, 1);
                    $isFullSpan = $loop->last && ($zones->count() % 2 === 1);
                @endphp
                <div @click="selectedZoneId = {{ $zone->id }}"
                     class="p-4 sm:p-5 rounded-2xl border transition-all duration-300 cursor-pointer flex flex-col justify-between gap-3.5 bg-white hover:shadow-md {{ $isFullSpan ? 'md:col-span-2' : '' }}"
                     :class="selectedZoneId === {{ $zone->id }} ? '{{ $palette['card_border'] }} ring-2 ring-emerald-500/30 shadow-sm' : 'border-slate-200/90'">
                    
                    <!-- Top Row: Zone Badge + Title + National Percentage -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between gap-2">
                            <div class="inline-flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full {{ $palette['bg'] }} shrink-0 ring-2 {{ $palette['ring'] }}"></span>
                                <span class="text-xs font-black {{ $palette['text'] }} uppercase tracking-wider">{{ $zone->code }}</span>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 font-bold text-[11px] shrink-0">
                                {{ $pct }}% dari Total
                            </span>
                        </div>

                        <div class="text-xs sm:text-sm font-extrabold text-slate-900 leading-snug">
                            {{ $zone->name }}
                        </div>

                        <div class="text-[11px] text-slate-500 leading-relaxed line-clamp-2">
                            <span class="font-semibold text-slate-700">Cakupan:</span> {{ $zone->coverage }}
                        </div>
                    </div>

                    <!-- Proportional 3-Column Breakdown: Laki-Laki, Perempuan, Total -->
                    <div class="grid grid-cols-3 gap-2.5 pt-1">
                        <div class="p-2.5 rounded-xl bg-sky-50/80 border border-sky-200/70 text-center">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-sky-700 flex items-center justify-center gap-1">
                                <i class="fa-solid fa-mars"></i> Laki-Laki
                            </div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900 mt-1">
                                {{ number_format($zone->male_students_count, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-pink-50/80 border border-pink-200/70 text-center">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-pink-700 flex items-center justify-center gap-1">
                                <i class="fa-solid fa-venus"></i> Perempuan
                            </div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900 mt-1">
                                {{ number_format($zone->female_students_count, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-emerald-50/90 border border-emerald-200 text-center">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-[#006837] flex items-center justify-center gap-1">
                                <i class="fa-solid fa-users"></i> Total Mhs
                            </div>
                            <div class="text-xs sm:text-sm font-black text-[#006837] mt-1">
                                {{ number_format($zone->students_count, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    <!-- Proportional Progress Bar -->
                    <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full {{ $palette['bar'] }} rounded-full transition-all duration-500" style="width: {{ max($pct, 4) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Proportional Grand Total Summary Card (3 Equal Columns) -->
        <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-[#006837] to-[#004d29] text-white space-y-3.5 shadow-sm">
            <div class="flex items-center justify-between gap-3 border-b border-white/15 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center text-amber-300 text-sm shrink-0">
                        <i class="fa-solid fa-users-viewfinder"></i>
                    </div>
                    <div>
                        <div class="text-xs sm:text-sm font-extrabold text-white uppercase tracking-wide">
                            Rekapitulasi Total Keseluruhan Mahasiswa UPBJJ
                        </div>
                        <div class="text-[11px] text-emerald-100/90">
                            Akumulasi mahasiswa aktif pada {{ $zones->count() }} Zona Wilayah (Nasional & Luar Negeri)
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 sm:gap-3">
                <div class="px-4 py-3 rounded-xl bg-white/10 border border-white/15 flex items-center justify-between">
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-sky-200">
                            <i class="fa-solid fa-mars mr-1"></i> Total Laki-Laki
                        </div>
                        <div class="text-sm sm:text-base font-black text-white mt-0.5">
                            {{ number_format($totalMale, 0, ',', '.') }} <span class="text-[11px] font-semibold text-emerald-100">Mhs</span>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded-lg bg-sky-500/25 text-sky-200 text-[10px] font-bold">
                        {{ $malePct }}%
                    </span>
                </div>

                <div class="px-4 py-3 rounded-xl bg-white/10 border border-white/15 flex items-center justify-between">
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-pink-200">
                            <i class="fa-solid fa-venus mr-1"></i> Total Perempuan
                        </div>
                        <div class="text-sm sm:text-base font-black text-white mt-0.5">
                            {{ number_format($totalFemale, 0, ',', '.') }} <span class="text-[11px] font-semibold text-emerald-100">Mhs</span>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded-lg bg-pink-500/25 text-pink-200 text-[10px] font-bold">
                        {{ $femalePct }}%
                    </span>
                </div>

                <div class="px-4 py-3 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-between shadow">
                    <div>
                        <div class="text-[10px] font-extrabold uppercase tracking-wider text-slate-800">
                            <i class="fa-solid fa-users mr-1"></i> Total Keseluruhan
                        </div>
                        <div class="text-sm sm:text-base font-black text-slate-950 mt-0.5">
                            {{ number_format($totalStudentsSum, 0, ',', '.') }} <span class="text-[11px] font-bold">Mhs</span>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded-lg bg-slate-950/15 text-slate-950 text-[10px] font-extrabold">
                        100%
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>
