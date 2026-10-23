@extends('layouts.admin')

@section('title', 'Menu Builder & Manajemen Navigasi')
@section('header_title', 'Menu Builder')
@section('header_subtitle', 'Susun dan atur hierarki menu navigasi utama (Header) dan link footer website secara dinamis')

@section('content')
<div class="space-y-6" x-data="{ 
    editModalOpen: false,
    menuType: 'page',
    newTitle: '',
    newIcon: '',
    itemsMap: {{ \Illuminate\Support\Js::from($allItems) }},
    editingItem: {
        id: '',
        title: '',
        type: 'page',
        page_id: '',
        route_name: '',
        url: '',
        parent_id: '',
        target: '_self',
        icon: '',
        badge: '',
        badge_color: 'emerald',
        order: 1,
        is_active: true
    },
    openEditModal(id) {
        if (this.itemsMap && this.itemsMap[id]) {
            const item = JSON.parse(JSON.stringify(this.itemsMap[id]));
            this.editingItem = {
                id: item.id,
                title: item.title || '',
                type: item.type || 'page',
                page_id: item.page_id !== null && item.page_id !== undefined ? String(item.page_id) : '',
                route_name: item.route_name || '',
                url: item.url || '',
                parent_id: item.parent_id !== null && item.parent_id !== undefined ? String(item.parent_id) : '',
                target: item.target || '_self',
                icon: item.icon || '',
                badge: item.badge || '',
                badge_color: item.badge_color || 'emerald',
                order: item.order !== undefined ? item.order : 1,
                is_active: item.is_active === true || item.is_active === 1 || item.is_active === '1'
            };
            this.editModalOpen = true;
        }
    }
}" @keydown.escape.window="editModalOpen = false">

    <!-- Location Tab Switcher & Quick Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        
        <!-- Tab Switcher -->
        <div class="flex items-center gap-2 bg-slate-200/80 p-1 rounded-2xl w-fit">
            <a href="{{ route('admin.menus.index', ['location' => 'header']) }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition {{ $location === 'header' ? 'bg-white text-[#006837] shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                <i class="fa-solid fa-compass text-sm"></i>
                <span>Menu Navigasi Utama (Header)</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $location === 'header' ? 'bg-emerald-100 text-[#006837]' : 'bg-slate-300 text-slate-700' }}">
                    {{ \App\Models\MenuItem::where('location', 'header')->count() }}
                </span>
            </a>
            <a href="{{ route('admin.menus.index', ['location' => 'footer']) }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition {{ $location === 'footer' ? 'bg-white text-[#006837] shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                <i class="fa-solid fa-shoe-prints text-sm"></i>
                <span>Menu Footer (Link Bawah)</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $location === 'footer' ? 'bg-emerald-100 text-[#006837]' : 'bg-slate-300 text-slate-700' }}">
                    {{ \App\Models\MenuItem::where('location', 'footer')->count() }}
                </span>
            </a>
        </div>

        <!-- Action: Seed Defaults & Manage Pages -->
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.pages.create') }}" class="px-3.5 py-2 rounded-xl bg-white hover:bg-emerald-50 text-[#006837] border border-[#006837]/30 hover:border-[#006837] text-xs font-bold transition flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-file-circle-plus"></i>
                <span>Buat Halaman Baru</span>
            </a>

            <form action="{{ route('admin.menus.seed_defaults') }}" method="POST" onsubmit="return confirm('Apakah Anda ingin memuat ulang menu bawaan untuk bagian [{{ strtoupper($location) }}]? Perubahan kustom saat ini akan di-reset ke standar bawaan.');">
                @csrf
                <input type="hidden" name="location" value="{{ $location }}">
                <button type="submit" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-2 border border-slate-300 shadow-sm" title="Kembalikan struktur menu ke default portal">
                    <i class="fa-solid fa-rotate-left text-amber-600"></i>
                    <span>Muat Menu Bawaan</span>
                </button>
            </form>
        </div>

    </div>

    <!-- Main Grid: Left (Add Menu Item Form) & Right (Interactive Menu Tree) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Form Tambah Item Menu (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-plus-circle text-[#006837]"></i> Tambah Item Menu
                    </h3>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-50 text-[#006837] font-bold uppercase">
                        {{ $location }}
                    </span>
                </div>

                <form action="{{ route('admin.menus.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="location" value="{{ $location }}">

                    <!-- Step 1: Pilih Tipe Menu -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Pilih Sumber Tautan *
                        </label>
                        <div class="grid grid-cols-3 gap-1.5 p-1 bg-slate-100 rounded-xl">
                            <button type="button" @click="menuType = 'page'" :class="menuType === 'page' ? 'bg-white text-[#006837] shadow-sm font-bold' : 'text-slate-600 font-medium'" class="py-2 text-[11px] rounded-lg transition text-center">
                                <i class="fa-solid fa-file-lines block mb-1 text-xs"></i> Halaman
                            </button>
                            <button type="button" @click="menuType = 'route'" :class="menuType === 'route' ? 'bg-white text-[#006837] shadow-sm font-bold' : 'text-slate-600 font-medium'" class="py-2 text-[11px] rounded-lg transition text-center">
                                <i class="fa-solid fa-route block mb-1 text-xs"></i> Sistem
                            </button>
                            <button type="button" @click="menuType = 'custom'" :class="menuType === 'custom' ? 'bg-white text-[#006837] shadow-sm font-bold' : 'text-slate-600 font-medium'" class="py-2 text-[11px] rounded-lg transition text-center">
                                <i class="fa-solid fa-link block mb-1 text-xs"></i> Kustom
                            </button>
                        </div>
                        <input type="hidden" name="type" :value="menuType">
                    </div>

                    <!-- Option A: Pilih Halaman Dinamis -->
                    <div x-show="menuType === 'page'" x-cloak class="space-y-2 p-3 bg-emerald-50/50 rounded-xl border border-emerald-200">
                        <label class="block text-[11px] font-bold text-emerald-900 uppercase tracking-wider">
                            Pilih Halaman Dinamis *
                        </label>
                        @if($pages->count() > 0)
                            <select name="page_id" :disabled="menuType !== 'page'" @change="if (!newTitle) { const opt = $event.target.selectedOptions[0]; if (opt && opt.dataset.title) newTitle = opt.dataset.title; }" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-[#006837]">
                                <option value="">-- Pilih Halaman --</option>
                                @foreach($pages as $p)
                                    <option value="{{ $p->id }}" data-title="{{ $p->title }}">
                                        {{ $p->title }} ({{ $p->is_published ? 'Publik' : 'Draft' }})
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <p class="text-xs text-amber-700">
                                Belum ada halaman dinamis. <a href="{{ route('admin.pages.create') }}" class="underline font-bold text-[#006837]">Buat Halaman</a> terlebih dahulu.
                            </p>
                        @endif
                    </div>

                    <!-- Option B: Pilih Route Sistem -->
                    <div x-show="menuType === 'route'" x-cloak class="space-y-2 p-3 bg-blue-50/50 rounded-xl border border-blue-200">
                        <label class="block text-[11px] font-bold text-blue-900 uppercase tracking-wider">
                            Pilih Halaman / Fitur Sistem *
                        </label>
                        <select name="route_name" :disabled="menuType !== 'route'" @change="if (!newTitle) { const opt = $event.target.selectedOptions[0]; if (opt && opt.dataset.title) newTitle = opt.dataset.title; }" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-[#006837]">
                            <option value="">-- Pilih Route Portal --</option>
                            @foreach($availableRoutes as $routeName => $routeLabel)
                                <option value="{{ $routeName }}" data-title="{{ $routeLabel }}">{{ $routeLabel }} ({{ $routeName }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Option C: Link Kustom -->
                    <div x-show="menuType === 'custom'" x-cloak class="space-y-2 p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">
                            URL / Tautan Bebas
                        </label>
                        <input type="text" name="url" :disabled="menuType !== 'custom'" placeholder="https://... atau # untuk dropdown" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-[#006837]">
                        <p class="text-[10px] text-slate-400">Gunakan tanda <code>#</code> jika menu ini hanya menjadi induk pembuka dropdown.</p>
                    </div>

                    <!-- Label / Teks Menu -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Label / Teks Menu
                        </label>
                        <input type="text" name="title" x-model="newTitle" placeholder="Contoh: Tentang Kami, Pedoman..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        <p class="text-[10px] text-slate-400 mt-1">Kosongkan untuk menggunakan judul asli dari Halaman / Route yang dipilih.</p>
                    </div>

                    <!-- Induk Menu / Parent Item -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Posisi / Induk Menu
                        </label>
                        <select name="parent_id" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            <option value="">Tingkat Teratas (Menu Utama)</option>
                            @foreach($parentItems as $parent)
                                <option value="{{ $parent->id }}">
                                    ↳ Sub-menu dari: {{ $parent->title }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1">Pilih induk menu untuk membuat dropdown sub-navigasi.</p>
                    </div>

                    <!-- Target Link -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Target Tautan</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 text-xs font-medium cursor-pointer has-[:checked]:border-[#006837] has-[:checked]:bg-emerald-50/50">
                                <input type="radio" name="target" value="_self" checked class="text-[#006837] focus:ring-[#006837]">
                                <span>Tab Sama (_self)</span>
                            </label>
                            <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 text-xs font-medium cursor-pointer has-[:checked]:border-[#006837] has-[:checked]:bg-emerald-50/50">
                                <input type="radio" name="target" value="_blank" class="text-[#006837] focus:ring-[#006837]">
                                <span>Tab Baru (_blank)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Icon Class (FontAwesome) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Icon FontAwesome (Opsional)
                        </label>
                        <div class="relative">
                            <input type="text" name="icon" x-model="newIcon" placeholder="fa-solid fa-file" class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            <span class="absolute left-3 top-2.5 text-xs text-slate-400 w-4 text-center">
                                <i :class="newIcon || 'fa-solid fa-icons'"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Badge Tambahan (Opsional) -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Badge Teks</label>
                            <input type="text" name="badge" placeholder="Baru, Hot, dll" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Warna Badge</label>
                            <select name="badge_color" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                                <option value="emerald">Hijau (Emerald)</option>
                                <option value="amber">Kuning (Amber)</option>
                                <option value="blue">Biru (Blue)</option>
                                <option value="purple">Ungu (Purple)</option>
                                <option value="teal">Tosca (Teal)</option>
                                <option value="red">Merah (Red)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Active Toggle -->
                    <div class="pt-2">
                        <label class="flex items-center gap-2.5 cursor-pointer text-xs font-semibold text-slate-700 select-none">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded text-[#006837] focus:ring-[#006837]">
                            <span>Aktifkan Menu Ini Langsung</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full py-3 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/25 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Item ke Menu
                    </button>
                </form>
            </div>

        </div>

        <!-- Right: Interactive Menu Structure (8 cols) -->
        <div class="lg:col-span-8 space-y-4">
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-bars-staggered text-[#006837]"></i>
                            <span>Susunan Menu Navigasi {{ $location === 'header' ? 'Header / Navbar' : 'Footer' }}</span>
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Urutan tampilan menu pada website dapat diubah melalui tombol panah atas/bawah.
                        </p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-100 text-slate-700">
                        {{ $menuItems->count() }} Menu Utama
                    </span>
                </div>

                <!-- Tree List -->
                @if($menuItems->count() > 0)
                    <div class="space-y-3">
                        @foreach($menuItems as $index => $item)
                            @php
                                $badgeClass = match($item->badge_color) {
                                    'amber' => 'bg-amber-100 text-amber-800',
                                    'blue' => 'bg-blue-100 text-blue-800',
                                    'purple' => 'bg-purple-100 text-purple-800',
                                    'teal' => 'bg-teal-100 text-teal-800',
                                    'red' => 'bg-red-100 text-red-800',
                                    default => 'bg-emerald-100 text-emerald-800',
                                };
                            @endphp
                            <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm hover:border-slate-300 transition">
                                
                                <!-- Level 1 Header Item Bar -->
                                <div class="p-3.5 sm:p-4 flex items-center justify-between gap-3 bg-slate-50/80">
                                    
                                    <!-- Left: Drag / Order Buttons & Title -->
                                    <div class="flex items-center gap-3 min-w-0">
                                        <!-- Reorder Buttons -->
                                        <div class="flex flex-col gap-0.5 shrink-0">
                                            @if(! $loop->first)
                                                <form action="{{ route('admin.menus.move', [$item, 'up']) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="w-6 h-5 rounded bg-white hover:bg-slate-200 border border-slate-200 text-slate-600 flex items-center justify-center text-[10px]" title="Pindahkan Ke Atas">
                                                        <i class="fa-solid fa-chevron-up"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <div class="w-6 h-5"></div>
                                            @endif

                                            @if(! $loop->last)
                                                <form action="{{ route('admin.menus.move', [$item, 'down']) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="w-6 h-5 rounded bg-white hover:bg-slate-200 border border-slate-200 text-slate-600 flex items-center justify-center text-[10px]" title="Pindahkan Ke Bawah">
                                                        <i class="fa-solid fa-chevron-down"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <div class="w-6 h-5"></div>
                                            @endif
                                        </div>

                                        <!-- Icon & Title -->
                                        <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-[#006837] flex items-center justify-center text-xs shrink-0 shadow-sm">
                                            <i class="{{ $item->icon ?: 'fa-solid fa-circle-dot' }}"></i>
                                        </div>

                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs sm:text-sm font-bold text-slate-900 truncate">
                                                    {{ $item->title }}
                                                </span>
                                                @if($item->badge)
                                                    <span class="text-[9px] px-2 py-0.5 rounded-full font-bold {{ $badgeClass }}">
                                                        {{ $item->badge }}
                                                    </span>
                                                @endif
                                                @if(! $item->is_active)
                                                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-200 text-slate-600 font-bold uppercase">Non-Aktif</span>
                                                @endif
                                            </div>

                                            <!-- Source Label -->
                                            <div class="text-[11px] text-slate-500 flex items-center gap-2 mt-0.5">
                                                @if($item->type === 'page')
                                                    <span class="inline-flex items-center gap-1 text-emerald-700 font-semibold">
                                                        <i class="fa-solid fa-file-lines text-[10px]"></i> Halaman: {{ $item->page?->title ?? 'Halaman Terhapus' }}
                                                    </span>
                                                @elseif($item->type === 'route')
                                                    <span class="inline-flex items-center gap-1 text-blue-700 font-semibold">
                                                        <i class="fa-solid fa-route text-[10px]"></i> Route: {{ $availableRoutes[$item->route_name] ?? $item->route_name }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-slate-600">
                                                        <i class="fa-solid fa-link text-[10px]"></i> URL: <code class="bg-white px-1 rounded border border-slate-200">{{ $item->url ?: '#' }}</code>
                                                    </span>
                                                @endif
                                                <span class="text-slate-300">•</span>
                                                <span class="text-[10px] text-slate-400">Target: {{ $item->target }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right: Action Buttons -->
                                    <div class="flex items-center gap-1.5 shrink-0">
                                        <a href="{{ $item->getUrl() }}" target="_blank" class="p-2 rounded-xl bg-white hover:bg-emerald-50 text-slate-600 hover:text-[#006837] border border-slate-200 transition text-xs shadow-sm" title="Buka Tautan">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>

                                        <button type="button" @click="openEditModal({{ $item->id }})" class="p-2 rounded-xl bg-white hover:bg-amber-50 text-slate-600 hover:text-amber-600 border border-slate-200 transition text-xs shadow-sm" title="Edit Menu">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>

                                        <form action="{{ route('admin.menus.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item menu &quot;{{ $item->title }}&quot; beserta seluruh sub-menunya?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-xl bg-white hover:bg-red-50 text-slate-600 hover:text-red-600 border border-slate-200 transition text-xs shadow-sm" title="Hapus Menu">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>

                                </div>

                                <!-- Level 2 Children (Sub-menu Dropdown) -->
                                @if($item->children->count() > 0)
                                    <div class="bg-white px-4 py-3 border-t border-slate-100 space-y-2">
                                        <div class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 flex items-center gap-1.5 pl-4">
                                            <i class="fa-solid fa-turn-down text-slate-300"></i>
                                            <span>Sub-Menu Dropdown ({{ $item->children->count() }})</span>
                                        </div>

                                        <div class="space-y-1.5 pl-6 border-l-2 border-emerald-300/80 ml-4">
                                            @foreach($item->children as $cIndex => $child)
                                                @php
                                                    $childBadgeClass = match($child->badge_color) {
                                                        'amber' => 'bg-amber-100 text-amber-800',
                                                        'blue' => 'bg-blue-100 text-blue-800',
                                                        'purple' => 'bg-purple-100 text-purple-800',
                                                        'teal' => 'bg-teal-100 text-teal-800',
                                                        'red' => 'bg-red-100 text-red-800',
                                                        default => 'bg-emerald-100 text-emerald-800',
                                                    };
                                                @endphp
                                                <div class="p-2.5 rounded-xl bg-slate-50 hover:bg-slate-100/80 border border-slate-200/80 flex items-center justify-between gap-3 transition">
                                                    
                                                    <div class="flex items-center gap-2.5 min-w-0">
                                                        <!-- Child Move Buttons -->
                                                        <div class="flex flex-col gap-0.5 shrink-0">
                                                            @if(! $loop->first)
                                                                <form action="{{ route('admin.menus.move', [$child, 'up']) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" class="w-5 h-4 rounded bg-white hover:bg-slate-200 border border-slate-200 text-slate-500 flex items-center justify-center text-[8px]" title="Pindah Atas">
                                                                        <i class="fa-solid fa-chevron-up"></i>
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <div class="w-5 h-4"></div>
                                                            @endif

                                                            @if(! $loop->last)
                                                                <form action="{{ route('admin.menus.move', [$child, 'down']) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" class="w-5 h-4 rounded bg-white hover:bg-slate-200 border border-slate-200 text-slate-500 flex items-center justify-center text-[8px]" title="Pindah Bawah">
                                                                        <i class="fa-solid fa-chevron-down"></i>
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <div class="w-5 h-4"></div>
                                                            @endif
                                                        </div>

                                                        <div class="w-6 h-6 rounded-lg bg-white text-emerald-700 flex items-center justify-center text-[10px] shrink-0 border border-slate-200">
                                                            <i class="{{ $child->icon ?: 'fa-solid fa-circle' }}"></i>
                                                        </div>

                                                        <div class="min-w-0">
                                                            <div class="flex items-center gap-1.5">
                                                                <span class="text-xs font-semibold text-slate-800 truncate">{{ $child->title }}</span>
                                                                @if($child->badge)
                                                                    <span class="text-[8px] px-1.5 py-0.2 rounded-full font-bold {{ $childBadgeClass }}">{{ $child->badge }}</span>
                                                                @endif
                                                                @if(! $child->is_active)
                                                                    <span class="text-[8px] px-1 rounded bg-slate-200 text-slate-600 font-semibold uppercase">Non-Aktif</span>
                                                                @endif
                                                            </div>
                                                            <div class="text-[10px] text-slate-400 truncate">
                                                                @if($child->type === 'page')
                                                                    <span class="text-emerald-700 font-medium">Halaman: {{ $child->page?->title }}</span>
                                                                @elseif($child->type === 'route')
                                                                    <span class="text-blue-700 font-medium">Route: {{ $child->route_name }}</span>
                                                                @else
                                                                    <span>{{ $child->url }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center gap-1 shrink-0">
                                                        <a href="{{ $child->getUrl() }}" target="_blank" class="p-1.5 rounded-lg bg-white hover:bg-emerald-50 text-slate-500 hover:text-[#006837] border border-slate-200 transition text-[11px]" title="Buka Tautan">
                                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                        </a>

                                                        <button type="button" @click="openEditModal({{ $child->id }})" class="p-1.5 rounded-lg bg-white hover:bg-amber-50 text-slate-500 hover:text-amber-600 border border-slate-200 transition text-[11px]" title="Edit Sub-menu">
                                                            <i class="fa-solid fa-pencil"></i>
                                                        </button>

                                                        <form action="{{ route('admin.menus.destroy', $child) }}" method="POST" onsubmit="return confirm('Hapus sub-menu &quot;{{ $child->title }}&quot;?');" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="p-1.5 rounded-lg bg-white hover:bg-red-50 text-slate-500 hover:text-red-600 border border-slate-200 transition text-[11px]" title="Hapus Sub-menu">
                                                                <i class="fa-regular fa-trash-can"></i>
                                                            </button>
                                                        </form>
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="p-12 text-center text-slate-400 bg-slate-50 rounded-2xl border border-dashed border-slate-300 space-y-3">
                        <i class="fa-solid fa-bars-staggered text-3xl text-slate-300 block"></i>
                        <p class="text-xs text-slate-600 font-semibold">
                            Belum ada item navigasi yang tersimpan untuk <strong>{{ strtoupper($location) }}</strong>.
                        </p>
                        <p class="text-[11px] text-slate-400 max-w-md mx-auto">
                            Gunakan form di samping kiri untuk menambahkan item baru, atau klik tombol di bawah ini untuk memuat susunan menu default UPT PJJ secara otomatis.
                        </p>
                        <form action="{{ route('admin.menus.seed_defaults') }}" method="POST" class="pt-2">
                            @csrf
                            <input type="hidden" name="location" value="{{ $location }}">
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs transition shadow-md shadow-[#006837]/20">
                                <i class="fa-solid fa-wand-magic-sparkles mr-1.5"></i> Muat Menu Bawaan Sistem
                            </button>
                        </form>
                    </div>
                @endif

            </div>

        </div>

    </div>

    <!-- Edit Item Modal -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <!-- Backdrop -->
        <div x-show="editModalOpen" 
             x-transition.opacity.duration.200ms
             @click="editModalOpen = false" 
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <!-- Modal Dialog Box -->
        <div x-show="editModalOpen" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 scale-95" 
             x-transition:enter-end="opacity-100 scale-100" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100 scale-100" 
             x-transition:leave-end="opacity-0 scale-95" 
             class="relative z-10 w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden my-auto max-h-[90vh] flex flex-col">
            
            <form :action="'{{ url('/admin/menus') }}/' + editingItem.id" method="POST" class="flex flex-col max-h-[90vh]">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-4 overflow-y-auto flex-1">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h4 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-pen-to-square text-[#006837]"></i>
                            <span>Edit Item Menu</span>
                        </h4>
                        <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-xmark text-base"></i>
                        </button>
                    </div>

                    <!-- Label / Title -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Label / Teks Menu *</label>
                        <input type="text" name="title" x-model="editingItem.title" required class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tipe Tautan</label>
                        <select name="type" x-model="editingItem.type" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-[#006837]">
                            <option value="page">Halaman Dinamis</option>
                            <option value="route">Route Sistem</option>
                            <option value="custom">URL Kustom</option>
                        </select>
                    </div>

                    <!-- Target Type Inputs -->
                    <div x-show="editingItem.type === 'page'">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Halaman Dinamis</label>
                        <select name="page_id" x-model="editingItem.page_id" :disabled="editingItem.type !== 'page'" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs">
                            <option value="">-- Pilih Halaman --</option>
                            @foreach($pages as $p)
                                <option value="{{ $p->id }}">{{ $p->title }} ({{ $p->is_published ? 'Publik' : 'Draft' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div x-show="editingItem.type === 'route'">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Route Sistem</label>
                        <select name="route_name" x-model="editingItem.route_name" :disabled="editingItem.type !== 'route'" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs">
                            <option value="">-- Pilih Route --</option>
                            @foreach($availableRoutes as $routeName => $routeLabel)
                                <option value="{{ $routeName }}">{{ $routeLabel }} ({{ $routeName }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div x-show="editingItem.type === 'custom'">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">URL Tautan</label>
                        <input type="text" name="url" x-model="editingItem.url" :disabled="editingItem.type !== 'custom'" placeholder="https://... atau # untuk dropdown" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs">
                        <p class="text-[10px] text-slate-400 mt-1">Gunakan tanda <code>#</code> jika menu ini menjadi induk dropdown.</p>
                    </div>

                    <!-- Parent Menu -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Induk Menu</label>
                        <select name="parent_id" x-model="editingItem.parent_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs">
                            <option value="">Tingkat Teratas (Menu Utama)</option>
                            @foreach($parentItems as $parent)
                                <option value="{{ $parent->id }}" x-show="editingItem.id != {{ $parent->id }}" :disabled="editingItem.id == {{ $parent->id }}">↳ Sub-menu dari: {{ $parent->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Icon & Target -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Icon FontAwesome</label>
                            <div class="relative">
                                <input type="text" name="icon" x-model="editingItem.icon" placeholder="fa-solid fa-file" class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs">
                                <span class="absolute left-2.5 top-2.5 text-xs text-slate-400 w-4 text-center">
                                    <i :class="editingItem.icon || 'fa-solid fa-icons'"></i>
                                </span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Target</label>
                            <select name="target" x-model="editingItem.target" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs">
                                <option value="_self">Tab Sama (_self)</option>
                                <option value="_blank">Tab Baru (_blank)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Badge & Order -->
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Badge Teks</label>
                            <input type="text" name="badge" x-model="editingItem.badge" placeholder="Baru, Hot, dll" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Warna Badge</label>
                            <select name="badge_color" x-model="editingItem.badge_color" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs">
                                <option value="emerald">Hijau</option>
                                <option value="amber">Kuning</option>
                                <option value="blue">Biru</option>
                                <option value="purple">Ungu</option>
                                <option value="teal">Tosca</option>
                                <option value="red">Merah</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Urut</label>
                            <input type="number" name="order" x-model="editingItem.order" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs">
                        </div>
                    </div>

                    <!-- Status Aktif -->
                    <div class="pt-2">
                        <label class="flex items-center gap-2.5 cursor-pointer text-xs font-semibold text-slate-700 select-none">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" x-model="editingItem.is_active" class="w-4 h-4 rounded text-[#006837] focus:ring-[#006837]">
                            <span>Menu Ini Aktif</span>
                        </label>
                    </div>

                </div>

                <!-- Modal Actions (Sticky Footer) -->
                <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-2 border-t border-slate-100 shrink-0">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl bg-white border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-100 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white text-xs font-bold transition shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
