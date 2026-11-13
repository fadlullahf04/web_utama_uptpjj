@if($galleries->isNotEmpty())
    <div class="my-10 space-y-5" x-data="{ lightboxOpen: false, activeItem: {} }">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-3">
            <div>
                <h4 class="text-base sm:text-lg font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-images text-[#006837]"></i> Galeri Dokumentasi Kegiatan UPBJJ
                </h4>
                <p class="text-xs text-slate-500 mt-0.5">Dokumentasi kegiatan koordinasi, sosialisasi, dan layanan daerah UPBJJ UINSSC.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($galleries as $item)
                @php
                    $payload = [
                        'title' => $item->title,
                        'image_url' => $item->image_url,
                        'zone' => $item->zone ? ($item->zone->code . ' — ' . $item->zone->name) : 'Kegiatan Umum UPBJJ',
                        'date' => $item->activity_date ? $item->activity_date->translatedFormat('d F Y') : null,
                        'description' => $item->description,
                    ];
                @endphp
                <div @click="activeItem = {{ \Illuminate\Support\Js::from($payload) }}; lightboxOpen = true"
                     class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group cursor-pointer flex flex-col">
                    <div class="relative h-48 bg-slate-100 overflow-hidden">
                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @if($item->zone)
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg bg-white/95 backdrop-blur-sm text-[#006837] border border-emerald-200/80 shadow-sm text-[10px] font-extrabold">
                                {{ $item->zone->code }}
                            </span>
                        @endif
                        <div class="absolute inset-0 bg-slate-900/0 group-hover:bg-slate-900/20 transition flex items-center justify-center">
                            <span class="opacity-0 group-hover:opacity-100 transition px-3 py-1.5 rounded-full bg-white/90 text-slate-900 text-[11px] font-bold shadow">
                                <i class="fa-solid fa-magnifying-glass-plus mr-1"></i> Perbesar
                            </span>
                        </div>
                    </div>
                    <div class="p-4 space-y-1.5 flex-1 flex flex-col justify-between">
                        <div>
                            <h5 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#006837] transition line-clamp-2">{{ $item->title }}</h5>
                            @if($item->description)
                                <p class="text-[11px] text-slate-500 line-clamp-2 mt-1 leading-relaxed">{{ $item->description }}</p>
                            @endif
                        </div>
                        @if($item->activity_date)
                            <div class="text-[10px] text-slate-400 pt-2 border-t border-slate-100 flex items-center gap-1.5">
                                <i class="fa-regular fa-calendar text-[#006837]"></i> {{ $item->activity_date->translatedFormat('d M Y') }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Lightbox Modal -->
        <div x-show="lightboxOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true">
            <div x-show="lightboxOpen" x-transition.opacity class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm" @click="lightboxOpen = false"></div>
            <div x-show="lightboxOpen" x-transition class="relative z-10 max-w-3xl w-full bg-white rounded-3xl overflow-hidden shadow-2xl border border-slate-200">
                <button type="button" @click="lightboxOpen = false" class="absolute top-3 right-3 z-20 w-9 h-9 rounded-full bg-slate-900/70 hover:bg-slate-900 text-white flex items-center justify-center transition cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="bg-slate-950 max-h-[65vh] flex items-center justify-center overflow-hidden">
                    <img :src="activeItem.image_url" :alt="activeItem.title" class="max-h-[65vh] w-auto object-contain">
                </div>
                <div class="p-5 sm:p-6 space-y-2">
                    <div class="flex flex-wrap items-center gap-2 text-[11px]">
                        <span class="px-2.5 py-0.5 rounded-lg bg-emerald-50 text-[#006837] border border-emerald-200 font-bold" x-text="activeItem.zone"></span>
                        <span x-show="activeItem.date" class="text-slate-500 flex items-center gap-1"><i class="fa-regular fa-calendar text-[#006837]"></i> <span x-text="activeItem.date"></span></span>
                    </div>
                    <h4 class="text-base font-extrabold text-slate-900" x-text="activeItem.title"></h4>
                    <p x-show="activeItem.description" class="text-xs text-slate-600 leading-relaxed" x-text="activeItem.description"></p>
                </div>
            </div>
        </div>
    </div>
@endif

