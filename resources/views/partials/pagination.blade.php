@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white px-5 py-3.5 rounded-2xl border border-slate-200 shadow-sm">
        <div class="text-xs text-slate-500">
            Menampilkan
            <span class="font-bold text-slate-800">{{ $paginator->firstItem() }}</span>
            –
            <span class="font-bold text-slate-800">{{ $paginator->lastItem() }}</span>
            dari
            <span class="font-bold text-slate-800">{{ $paginator->total() }}</span>
            data
        </div>

        <div class="flex flex-wrap items-center justify-center gap-1.5">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center gap-1.5 px-3 h-9 rounded-xl bg-slate-100 text-slate-400 text-xs font-semibold cursor-not-allowed select-none">
                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    <span class="hidden sm:inline">Sebelumnya</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center gap-1.5 px-3 h-9 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-emerald-50 hover:text-[#006837] hover:border-emerald-300 text-xs font-semibold transition">
                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    <span class="hidden sm:inline">Sebelumnya</span>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="inline-flex items-center justify-center w-9 h-9 text-xs font-bold text-slate-400 select-none">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-[#006837] text-white text-xs font-extrabold shadow-sm shadow-[#006837]/25">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-emerald-50 hover:text-[#006837] hover:border-emerald-300 text-xs font-semibold transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center gap-1.5 px-3 h-9 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-emerald-50 hover:text-[#006837] hover:border-emerald-300 text-xs font-semibold transition">
                    <span class="hidden sm:inline">Berikutnya</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 h-9 rounded-xl bg-slate-100 text-slate-400 text-xs font-semibold cursor-not-allowed select-none">
                    <span class="hidden sm:inline">Berikutnya</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </span>
            @endif
        </div>
    </nav>
@endif

