@php
    $locales = [
        'id' => [
            'name' => 'Indonesia',
            'code' => 'ID',
            'flag_url' => 'https://flagcdn.com/28x21/id.png',
            'flag' => '🇮🇩',
            'native' => 'Bahasa Indonesia'
        ],
        'en' => [
            'name' => 'English',
            'code' => 'EN',
            'flag_url' => 'https://flagcdn.com/28x21/gb.png',
            'flag' => '🇬🇧',
            'native' => 'English'
        ],
        'ar' => [
            'name' => 'العربية',
            'code' => 'AR',
            'flag_url' => 'https://flagcdn.com/28x21/sa.png',
            'flag' => '🇸🇦',
            'native' => 'العربية'
        ],
    ];
    $activeLocale = app()->getLocale();
    $current = $locales[$activeLocale] ?? $locales['id'];
    $theme = $variant ?? 'dark'; // 'dark', 'light', 'mobile'
    $alignClass = $activeLocale === 'ar' ? 'left-0' : 'right-0';
@endphp

@if($theme === 'mobile')
    <!-- Mobile Segmented Selector -->
    <div class="p-1.5 bg-slate-100 rounded-xl flex items-center gap-1 border border-slate-200" dir="ltr">
        @foreach($locales as $code => $lang)
            <a href="{{ route('locale.switch', $code) }}" 
               class="flex-1 py-1.5 px-2 rounded-lg text-xs font-bold text-center transition flex items-center justify-center gap-2 {{ $activeLocale === $code ? 'bg-[#006837] text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-white' }}"
               title="{{ $lang['native'] }} ({{ $lang['name'] }})">
                <img src="{{ $lang['flag_url'] }}" width="16" height="12" alt="{{ $lang['code'] }}" class="rounded-xs shrink-0 object-cover shadow-2xs">
                <span>{{ $lang['code'] }}</span>
            </a>
        @endforeach
    </div>
@elseif($theme === 'light')
    <!-- Admin / Main Header Light Navbar Dropdown -->
    <div class="relative inline-block text-left" dir="ltr" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
        <button @click.stop="open = !open" 
                type="button" 
                class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold border border-slate-200 shadow-2xs transition cursor-pointer select-none" 
                aria-label="{{ __('Pilih Bahasa') }}"
                :aria-expanded="open.toString()"
                title="{{ __('Pilih Bahasa') }} / Select Language">
            <i class="fa-solid fa-globe text-emerald-600 text-xs"></i>
            <img src="{{ $current['flag_url'] }}" width="18" height="13" alt="{{ $current['code'] }}" class="rounded-xs shrink-0 object-cover shadow-2xs border border-slate-200">
            <span class="font-bold tracking-wide">{{ $current['code'] }}</span>
            <i class="fa-solid fa-chevron-down text-[9px] text-slate-400 transition-transform duration-200" :class="{'rotate-180': open}"></i>
        </button>

        <div x-show="open" 
             x-cloak 
             @click.stop
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
             class="absolute {{ $alignClass }} mt-2 w-56 bg-white border border-slate-200 rounded-xl shadow-2xl py-1.5 z-[100] text-slate-700 divide-y divide-slate-100">
            <div class="px-3.5 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400 flex items-center justify-between">
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-language text-emerald-600 text-xs"></i> {{ __('Pilih Bahasa') }}
                </span>
                <span class="text-[9px] text-slate-400 font-mono">3 BAHASA</span>
            </div>
            <div class="py-1">
                @foreach($locales as $code => $lang)
                    <a href="{{ route('locale.switch', $code) }}" 
                       class="flex items-center justify-between px-3.5 py-2.5 text-xs font-medium hover:bg-emerald-50 hover:text-[#006837] transition {{ $activeLocale === $code ? 'bg-emerald-50/80 text-[#006837] font-bold' : '' }}">
                        <div class="flex items-center gap-3">
                            <img src="{{ $lang['flag_url'] }}" width="20" height="15" alt="{{ $lang['code'] }}" class="rounded-xs shrink-0 object-cover shadow-2xs border border-slate-200">
                            <div class="flex flex-col text-left">
                                <span class="text-xs {{ $activeLocale === $code ? 'font-bold' : '' }}">{{ $lang['native'] }}</span>
                                <span class="text-[10px] text-slate-400 font-normal">{{ $lang['name'] }}</span>
                            </div>
                        </div>
                        @if($activeLocale === $code)
                            <span class="flex items-center justify-center w-5 h-5 rounded-full bg-emerald-100 text-[#006837] text-xs">
                                <i class="fa-solid fa-check"></i>
                            </span>
                        @else
                            <span class="text-[10px] text-slate-400 font-mono font-semibold">{{ $lang['code'] }}</span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@else
    <!-- Public Header / Dark Topbar Dropdown -->
    <div class="relative inline-block text-left" dir="ltr" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
        <button @click.stop="open = !open" 
                type="button" 
                id="language-switcher-dropdown-btn"
                class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-800/90 hover:bg-slate-700 text-[11px] text-white font-semibold border border-slate-700/80 shadow-xs transition cursor-pointer select-none" 
                aria-label="{{ __('Pilih Bahasa') }}"
                :aria-expanded="open.toString()"
                title="{{ __('Pilih Bahasa') }} / Select Language">
            <i class="fa-solid fa-globe text-emerald-400 text-xs"></i>
            <img src="{{ $current['flag_url'] }}" width="18" height="13" alt="{{ $current['code'] }}" class="rounded-xs shrink-0 object-cover shadow-2xs border border-white/20">
            <span class="font-bold tracking-wide">{{ $current['code'] }}</span>
            <i class="fa-solid fa-chevron-down text-[8px] text-slate-400 transition-transform duration-200" :class="{'rotate-180': open}"></i>
        </button>

        <div x-show="open" 
             x-cloak 
             @click.stop
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
             class="absolute {{ $alignClass }} mt-2 w-56 bg-[#0f172a] border border-slate-700/90 rounded-xl shadow-2xl py-1.5 z-[100] text-slate-200 divide-y divide-slate-800">
            <div class="px-3.5 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400 flex items-center justify-between">
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-globe text-emerald-400 text-xs"></i> {{ __('Pilih Bahasa') }}
                </span>
                <span class="text-[9px] text-slate-500 font-mono">3 BAHASA</span>
            </div>
            <div class="py-1">
                @foreach($locales as $code => $lang)
                    <a href="{{ route('locale.switch', $code) }}" 
                       class="flex items-center justify-between px-3.5 py-2.5 text-xs font-medium hover:bg-slate-800 hover:text-emerald-400 transition {{ $activeLocale === $code ? 'bg-slate-800/90 text-emerald-300 font-bold' : 'text-slate-300' }}">
                        <div class="flex items-center gap-3">
                            <img src="{{ $lang['flag_url'] }}" width="20" height="15" alt="{{ $lang['code'] }}" class="rounded-xs shrink-0 object-cover shadow-2xs border border-slate-700">
                            <div class="flex flex-col text-left">
                                <span class="text-xs {{ $activeLocale === $code ? 'font-bold text-white' : '' }}">{{ $lang['native'] }}</span>
                                <span class="text-[10px] text-slate-400 font-normal">{{ $lang['name'] }}</span>
                            </div>
                        </div>
                        @if($activeLocale === $code)
                            <span class="flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 text-xs">
                                <i class="fa-solid fa-check"></i>
                            </span>
                        @else
                            <span class="text-[10px] text-slate-500 font-mono">{{ $lang['code'] }}</span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif
