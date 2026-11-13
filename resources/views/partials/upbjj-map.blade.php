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
    <div class="relative w-full bg-[#e0f2fe] overflow-x-auto">
        <div class="relative min-w-[620px] max-w-4xl mx-auto w-full aspect-[1000/450] select-none overflow-hidden">
            
            <!-- Base Map SVG of Indonesia (Modern Bright Topographic Atlas Style) -->
            <img src="{{ asset('images/peta-indonesia.svg') }}?v=3" alt="Peta Sebaran Wilayah UPBJJ Indonesia" class="w-full h-full object-cover block pointer-events-none">

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
                        $count >= 2500 => 'w-11 h-11 sm:w-12 sm:h-12 text-[11px] sm:text-xs',
                        $count >= 1500 => 'w-10 h-10 sm:w-11 sm:h-11 text-[10px] sm:text-[11px]',
                        $count >= 800 => 'w-9 h-9 sm:w-10 sm:h-10 text-[10px]',
                        default => 'w-8 h-8 sm:w-9 sm:h-9 text-[9px] sm:text-[10px]',
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

</div>
