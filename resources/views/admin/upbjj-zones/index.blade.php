@extends('layouts.admin')

@section('title', 'Manajemen Wilayah, Zona & Peta Sebaran UPBJJ')
@section('header_title', 'Wilayah, Zona & Peta Sebaran UPBJJ')
@section('header_subtitle', 'Kelola direktori zona wilayah layanan, pimpinan, rincian mahasiswa, dan titik sebaran di Peta Indonesia')

@section('content')
<div x-data="{ 
    createModal: false,
    detailModal: false,
    editModal: false,
    createGalleryModal: false,
    editGalleryModal: false,
    showMapPreview: true,
    newMale: 120,
    newFemale: 130,
    detailZone: {},
    editZone: { id: null, code: '', name: '', coverage: '', partner: '', head_name: '', vice_head_name: '', secretary_name: '', coordinator_name: '', phone: '', address: '', male_students_count: 0, female_students_count: 0, students_count: 0, bubble_color: 'emerald', map_x: 30.5, map_y: 70.0, order: 1, is_active: true },
    editGallery: { id: null, upbjj_zone_id: '', title: '', image_url: '', activity_date: '', description: '', order: 1 }
}" class="space-y-6">

    <!-- Info Banner & Quick Link to Public UPBJJ Page -->
    <div class="bg-gradient-to-r from-[#006837] to-[#004d29] p-5 rounded-2xl text-white shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center text-amber-300 text-lg shrink-0 mt-0.5">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <div>
                <h3 class="text-sm font-extrabold text-white">Direktori Zona Wilayah & Peta Sebaran Mahasiswa UPBJJ</h3>
                <p class="text-xs text-emerald-100/90 mt-0.5">Setiap perubahan data zona, pimpinan, jumlah mahasiswa, atau koordinat wilayah otomatis memperbarui Peta Indonesia & Tabel Direktori di halaman publik <strong>UPBJJ</strong>.</p>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-2 shrink-0">
            <button type="button" @click="showMapPreview = !showMapPreview" class="px-3.5 py-2 rounded-xl bg-white/15 hover:bg-white/25 text-white font-bold text-xs transition flex items-center gap-1.5 border border-white/20 cursor-pointer">
                <i class="fa-solid fa-earth-asia"></i> <span x-text="showMapPreview ? 'Sembunyikan Pratinjau Peta' : 'Tampilkan Pratinjau Peta'"></span>
            </button>
            <a href="{{ url('/halaman/upbjj') }}" target="_blank" class="px-4 py-2 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-xs transition flex items-center gap-1.5 shadow">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Halaman UPBJJ
            </a>
        </div>
    </div>

    <!-- Live Interactive Map Preview in Admin -->
    <div x-show="showMapPreview" x-transition>
        @include('partials.upbjj-map', ['zones' => $zones->where('is_active', true)])
    </div>

    <!-- Tabel Daftar Zona & Wilayah UPBJJ (Full Width) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Daftar Zona & Wilayah UPBJJ</h3>
                <p class="text-[11px] text-slate-500 mt-0.5">
                    Total {{ $zones->count() }} zona wilayah • Klik <strong>Detail</strong> pada baris zona untuk melihat rincian mahasiswa, pimpinan, dan informasi sentra.
                </p>
            </div>
            <button type="button" @click="createModal = true" class="px-4 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/20 flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-plus-circle"></i> Tambah Data UPBJJ
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4 font-bold">Kode & Bubble</th>
                        <th class="py-3 px-4 font-bold">Zona & Wilayah Layanan</th>
                        <th class="py-3 px-4 font-bold text-center">Total Mhs</th>
                        <th class="py-3 px-4 font-bold text-center">Status</th>
                        <th class="py-3 px-4 font-bold text-right">Menu & Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $badgeColors = [
                            'emerald' => 'bg-emerald-500',
                            'teal' => 'bg-teal-500',
                            'amber' => 'bg-amber-500',
                            'blue' => 'bg-blue-500',
                            'purple' => 'bg-purple-500',
                            'rose' => 'bg-rose-500',
                            'cyan' => 'bg-cyan-500',
                        ];
                    @endphp
                    @forelse($zones as $zone)
                        @php
                            $zonePayload = [
                                'id' => $zone->id,
                                'code' => $zone->code,
                                'name' => $zone->name,
                                'coverage' => $zone->coverage,
                                'partner' => $zone->partner ?? '',
                                'head_name' => $zone->head_name ?? '',
                                'vice_head_name' => $zone->vice_head_name ?? '',
                                'secretary_name' => $zone->secretary_name ?? '',
                                'coordinator_name' => $zone->coordinator_name ?? '',
                                'phone' => $zone->phone ?? '',
                                'address' => $zone->address ?? '',
                                'male_students_count' => (int) $zone->male_students_count,
                                'female_students_count' => (int) $zone->female_students_count,
                                'students_count' => (int) $zone->students_count,
                                'bubble_color' => $zone->bubble_color ?? 'emerald',
                                'map_x' => (float) ($zone->map_x ?? 30.5),
                                'map_y' => (float) ($zone->map_y ?? 70.0),
                                'order' => $zone->order ?? 1,
                                'is_active' => (bool) $zone->is_active,
                            ];
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 align-middle whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-900 border border-slate-200 text-[11px] font-extrabold">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $badgeColors[$zone->bubble_color] ?? 'bg-emerald-500' }}"></span>
                                    {{ $zone->code }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 align-middle">
                                <div class="font-bold text-slate-900">{{ $zone->name }}</div>
                                @if($zone->head_name)
                                    <div class="text-[11px] text-slate-500 mt-0.5">Ketua: <span class="font-semibold text-slate-700">{{ $zone->head_name }}</span></div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 align-middle text-center whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-[#006837] border border-emerald-200 font-extrabold text-xs">
                                    {{ number_format($zone->students_count, 0, ',', '.') }} Mhs
                                </span>
                            </td>
                            <td class="py-3.5 px-4 align-middle text-center">
                                @if($zone->is_active)
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">Aktif</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold">Nonaktif</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 align-middle text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button"
                                        @click="detailZone = {{ \Illuminate\Support\Js::from($zonePayload) }}; detailModal = true"
                                        class="px-2.5 py-1.5 rounded-lg bg-emerald-50 text-[#006837] hover:bg-[#006837] hover:text-white border border-emerald-200 font-bold text-[11px] transition cursor-pointer inline-flex items-center gap-1"
                                        title="Lihat Detail Zona & Rincian">
                                        <i class="fa-solid fa-eye text-[10px]"></i> Detail
                                    </button>
                                    <button type="button" 
                                        @click="editZone = {{ \Illuminate\Support\Js::from($zonePayload) }}; editModal = true" 
                                        class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-amber-600 hover:bg-slate-200 transition cursor-pointer" 
                                        title="Edit Zona & Rincian">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>
                                    <form action="{{ route('admin.upbjj-zones.destroy', $zone->id) }}" method="POST" onsubmit="return confirm('Hapus zona wilayah UPBJJ ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-red-600 hover:bg-slate-200 transition cursor-pointer" title="Hapus">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">Belum ada data zona wilayah UPBJJ.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Galeri Dokumentasi Kegiatan UPBJJ -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-images text-[#006837]"></i> Galeri Dokumentasi Kegiatan UPBJJ
                </h3>
                <p class="text-[11px] text-slate-500 mt-0.5">
                    Simpan foto dokumentasi kegiatan koordinasi, sosialisasi, dan layanan daerah UPBJJ ({{ $galleries->count() }} dokumentasi).
                </p>
            </div>
            <button type="button" @click="createGalleryModal = true" class="px-4 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/20 flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-camera"></i> Tambah Dokumentasi
            </button>
        </div>

        <div class="p-5">
            @if($galleries->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($galleries as $item)
                        @php
                            $galleryPayload = [
                                'id' => $item->id,
                                'upbjj_zone_id' => $item->upbjj_zone_id ? (string) $item->upbjj_zone_id : '',
                                'title' => $item->title,
                                'image_url' => str_starts_with($item->image, 'http') ? $item->image : '',
                                'activity_date' => $item->activity_date ? $item->activity_date->format('Y-m-d') : '',
                                'description' => $item->description ?? '',
                                'order' => $item->order ?? 1,
                            ];
                        @endphp
                        <div class="bg-slate-50/70 rounded-2xl border border-slate-200 overflow-hidden flex flex-col justify-between group">
                            <div>
                                <div class="relative h-44 bg-slate-200 overflow-hidden">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    @if($item->zone)
                                        <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded-lg bg-white/95 text-[#006837] border border-emerald-200 text-[10px] font-extrabold shadow-sm">
                                            {{ $item->zone->code }}
                                        </span>
                                    @endif
                                </div>
                                <div class="p-4 space-y-1.5">
                                    <h4 class="text-xs font-bold text-slate-900 line-clamp-2">{{ $item->title }}</h4>
                                    @if($item->activity_date)
                                        <div class="text-[10px] text-slate-500 flex items-center gap-1">
                                            <i class="fa-regular fa-calendar text-[#006837]"></i> {{ $item->activity_date->translatedFormat('d M Y') }}
                                        </div>
                                    @endif
                                    @if($item->description)
                                        <p class="text-[11px] text-slate-600 line-clamp-2 leading-relaxed">{{ $item->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="px-4 py-2.5 bg-white border-t border-slate-100 flex items-center justify-end gap-1.5">
                                <button type="button"
                                    @click="editGallery = {{ \Illuminate\Support\Js::from($galleryPayload) }}; editGalleryModal = true"
                                    class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 hover:bg-amber-50 hover:text-amber-700 text-[11px] font-bold transition cursor-pointer">
                                    <i class="fa-solid fa-pen mr-1"></i> Edit
                                </button>
                                <form action="{{ route('admin.upbjj-zones.galleries.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus dokumentasi kegiatan ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 hover:bg-red-50 hover:text-red-600 text-[11px] font-bold transition cursor-pointer">
                                        <i class="fa-solid fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-10 text-center text-xs text-slate-400">
                    Belum ada foto dokumentasi kegiatan UPBJJ. Klik tombol <strong>Tambah Dokumentasi</strong> di atas untuk mengunggah.
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Tambah Data UPBJJ -->
    <div x-show="createModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="createModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="createModal = false"></div>

        <div x-show="createModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative z-10 w-full max-w-2xl bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden my-8 max-h-[90vh] overflow-y-auto">
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-plus-circle text-[#006837]"></i> Tambah Zona Wilayah UPBJJ Baru
                    </h3>
                    <button type="button" @click="createModal = false" class="text-slate-400 hover:text-slate-700 text-base cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form action="{{ route('admin.upbjj-zones.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kode Zona *</label>
                            <input type="text" name="code" required placeholder="Contoh: ZONA 07" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-bold focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Urutan Tampil</label>
                            <input type="number" name="order" value="{{ $zones->count() + 1 }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Wilayah Layanan UPBJJ *</label>
                        <input type="text" name="name" required placeholder="Contoh: UPBJJ Wilayah Jawa Barat & Banten" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <!-- Struktur Pimpinan UPBJJ -->
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                        <span class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-600">
                            <i class="fa-solid fa-user-tie mr-1 text-[#006837]"></i> Pimpinan UPBJJ (Opsional)
                        </span>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Ketua</label>
                                <input type="text" name="head_name" placeholder="Nama Ketua UPBJJ" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Wakil Ketua</label>
                                <input type="text" name="vice_head_name" placeholder="Nama Wakil Ketua" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Sekretaris</label>
                                <input type="text" name="secretary_name" placeholder="Nama Sekretaris" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-[#006837]">
                            </div>
                        </div>
                    </div>

                    <!-- Rincian Mahasiswa Laki-Laki, Perempuan, Total & Warna Bubble Peta -->
                    <div class="p-3.5 rounded-xl bg-emerald-50/70 border border-emerald-200 space-y-3">
                        <span class="block text-[10px] font-extrabold uppercase tracking-wider text-[#006837]">
                            <i class="fa-solid fa-users mr-1"></i> Rincian Jumlah Mahasiswa & Peta Bubble
                        </span>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-sky-800 mb-1"><i class="fa-solid fa-mars mr-1"></i>Mhs Laki-Laki *</label>
                                <input type="number" name="male_students_count" x-model.number="newMale" min="0" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs font-extrabold focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-pink-800 mb-1"><i class="fa-solid fa-venus mr-1"></i>Mhs Perempuan *</label>
                                <input type="number" name="female_students_count" x-model.number="newFemale" min="0" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs font-extrabold focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-emerald-900 mb-1">Total Mahasiswa</label>
                                <div class="w-full px-3 py-2 bg-emerald-100/80 border border-emerald-300 rounded-xl text-[#006837] text-xs font-black" x-text="((parseInt(newMale) || 0) + (parseInt(newFemale) || 0)).toLocaleString('id-ID') + ' Mhs'"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Warna Bubble Peta *</label>
                                <select name="bubble_color" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs font-bold focus:outline-none focus:border-[#006837]">
                                    <option value="emerald">🟢 Hijau Emerald</option>
                                    <option value="teal">🟢 Hijau Teal</option>
                                    <option value="amber">🟡 Kuning Amber</option>
                                    <option value="blue">🔵 Biru</option>
                                    <option value="purple">🟣 Ungu</option>
                                    <option value="rose">🔴 Merah Rose</option>
                                    <option value="cyan">🔵 Biru Cyan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Posisi Peta X (%)</label>
                                <input type="number" step="0.5" min="5" max="95" name="map_x" value="50.0" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Posisi Peta Y (%)</label>
                                <input type="number" step="0.5" min="5" max="95" name="map_y" value="55.0" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-[#006837]">
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-500">Panduan X%: Sumatera (~17%), Jabar (~30%), Jateng/Jatim (~39%), Kalimantan (~43%), Sulawesi (~58%), Papua (~82%).</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cakupan Provinsi / Kota & Sentra Pokjar *</label>
                        <textarea name="coverage" rows="3" required placeholder="Contoh: Cirebon, Indramayu, Majalengka, Kuningan, Bandung, Bogor..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mitra Koordinasi Wilayah</label>
                        <input type="text" name="partner" placeholder="Contoh: Kanwil Kemenag, Madrasah & Pesantren Mitra" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Koordinator / PIC Wilayah</label>
                            <input type="text" name="coordinator_name" placeholder="Contoh: Koordinator Wilayah Jawa Barat" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">No. Telepon / WhatsApp Sentra</label>
                            <input type="text" name="phone" placeholder="Contoh: +62 811-2345-678" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Sekretariat / Sentra</label>
                            <input type="text" name="address" placeholder="Contoh: Gedung Siber Lt. 3 UINSSC Cirebon" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="createModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white text-xs font-bold uppercase tracking-wider transition shadow-md shadow-[#006837]/20 flex items-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Zona Wilayah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Zona & Wilayah UPBJJ -->
    <div x-show="detailModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="detailModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="detailModal = false"></div>

        <div x-show="detailModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative z-10 w-full max-w-2xl bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden my-8 max-h-[90vh] overflow-y-auto">
            <div class="p-6 space-y-5">
                <div class="flex items-start justify-between border-b border-slate-100 pb-3 gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2.5 py-0.5 rounded-lg bg-emerald-100 text-[#006837] text-[11px] font-extrabold" x-text="detailZone.code"></span>
                            <span x-show="detailZone.is_active" class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold">Aktif</span>
                            <span x-show="!detailZone.is_active" class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold">Nonaktif</span>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900" x-text="detailZone.name"></h3>
                    </div>
                    <button type="button" @click="detailModal = false" class="text-slate-400 hover:text-slate-700 text-base cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Rincian Jumlah Mahasiswa -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="p-3.5 rounded-xl bg-sky-50 border border-sky-200 text-center">
                        <div class="text-[10px] font-extrabold uppercase tracking-wider text-sky-700"><i class="fa-solid fa-mars mr-1"></i>Laki-Laki</div>
                        <div class="text-lg font-black text-sky-900 mt-1" x-text="(detailZone.male_students_count || 0).toLocaleString('id-ID')"></div>
                    </div>
                    <div class="p-3.5 rounded-xl bg-pink-50 border border-pink-200 text-center">
                        <div class="text-[10px] font-extrabold uppercase tracking-wider text-pink-700"><i class="fa-solid fa-venus mr-1"></i>Perempuan</div>
                        <div class="text-lg font-black text-pink-900 mt-1" x-text="(detailZone.female_students_count || 0).toLocaleString('id-ID')"></div>
                    </div>
                    <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-center">
                        <div class="text-[10px] font-extrabold uppercase tracking-wider text-[#006837]"><i class="fa-solid fa-users mr-1"></i>Total Mahasiswa</div>
                        <div class="text-lg font-black text-[#006837] mt-1" x-text="(detailZone.students_count || 0).toLocaleString('id-ID')"></div>
                    </div>
                </div>

                <!-- Struktur Pimpinan UPBJJ -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2.5">
                    <h4 class="text-[11px] font-extrabold uppercase tracking-wider text-slate-600 flex items-center gap-1.5">
                        <i class="fa-solid fa-user-tie text-[#006837]"></i> Pimpinan UPBJJ
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                        <div>
                            <span class="text-[10px] text-slate-500 block">Nama Ketua</span>
                            <span class="font-bold text-slate-900" x-text="detailZone.head_name || '-'"></span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-500 block">Wakil Ketua</span>
                            <span class="font-bold text-slate-900" x-text="detailZone.vice_head_name || '-'"></span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-500 block">Sekretaris</span>
                            <span class="font-bold text-slate-900" x-text="detailZone.secretary_name || '-'"></span>
                        </div>
                    </div>
                </div>

                <!-- Cakupan, Mitra & Kontak -->
                <div class="space-y-3 text-xs">
                    <div>
                        <span class="font-bold text-slate-700 block mb-0.5">Cakupan Provinsi / Kota & Sentra Pokjar:</span>
                        <p class="text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100" x-text="detailZone.coverage || '-'"></p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <span class="font-bold text-slate-700 block mb-0.5">Mitra Koordinasi Wilayah:</span>
                            <p class="text-slate-600" x-text="detailZone.partner || '-'"></p>
                        </div>
                        <div>
                            <span class="font-bold text-slate-700 block mb-0.5">Koordinator / PIC Wilayah:</span>
                            <p class="text-slate-600" x-text="detailZone.coordinator_name || '-'"></p>
                        </div>
                        <div>
                            <span class="font-bold text-slate-700 block mb-0.5">No. Telepon / WhatsApp Sentra:</span>
                            <p class="text-slate-600" x-text="detailZone.phone || '-'"></p>
                        </div>
                        <div>
                            <span class="font-bold text-slate-700 block mb-0.5">Koordinat Peta & Bubble:</span>
                            <p class="text-slate-600">X=<span x-text="detailZone.map_x"></span>%, Y=<span x-text="detailZone.map_y"></span>% (<span class="capitalize" x-text="detailZone.bubble_color"></span>)</p>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="font-bold text-slate-700 block mb-0.5">Alamat Sekretariat / Sentra:</span>
                            <p class="text-slate-600" x-text="detailZone.address || '-'"></p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="editZone = { ...detailZone }; detailModal = false; editModal = true" class="px-4 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-xs font-bold transition cursor-pointer flex items-center gap-1.5">
                        <i class="fa-solid fa-pen"></i> Edit Data Zona
                    </button>
                    <button type="button" @click="detailModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-bold transition cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Zona Wilayah UPBJJ -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="editModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="editModal = false"></div>

        <div x-show="editModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative z-10 w-full max-w-2xl bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden my-8 max-h-[90vh] overflow-y-auto">
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-[#006837]"></i> Edit Zona, Pimpinan, Mahasiswa L/P & Titik Peta UPBJJ
                    </h3>
                    <button type="button" @click="editModal = false" class="text-slate-400 hover:text-slate-700 text-base cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form :action="'{{ url('/admin/upbjj-zones') }}/' + editZone.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kode Zona *</label>
                            <input type="text" name="code" x-model="editZone.code" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-bold focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Urutan</label>
                            <input type="number" name="order" x-model="editZone.order" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                        <div class="flex items-center pt-6">
                            <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                                <input type="checkbox" name="is_active" value="1" :checked="editZone.is_active" class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-[#006837] focus:ring-[#006837]">
                                <span>Aktif Ditampilkan</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Wilayah Layanan UPBJJ *</label>
                        <input type="text" name="name" x-model="editZone.name" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <!-- Struktur Pimpinan UPBJJ -->
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                        <span class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-600">
                            <i class="fa-solid fa-user-tie mr-1 text-[#006837]"></i> Pimpinan UPBJJ (Opsional)
                        </span>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Ketua</label>
                                <input type="text" name="head_name" x-model="editZone.head_name" placeholder="Nama Ketua UPBJJ" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Wakil Ketua</label>
                                <input type="text" name="vice_head_name" x-model="editZone.vice_head_name" placeholder="Nama Wakil Ketua" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Sekretaris</label>
                                <input type="text" name="secretary_name" x-model="editZone.secretary_name" placeholder="Nama Sekretaris" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-[#006837]">
                            </div>
                        </div>
                    </div>

                    <!-- Edit Jumlah Mahasiswa Laki-Laki, Perempuan, Total & Bubble Peta -->
                    <div class="p-3.5 rounded-xl bg-emerald-50/70 border border-emerald-200 space-y-3">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-sky-800 mb-1"><i class="fa-solid fa-mars mr-1"></i>Mhs Laki-Laki *</label>
                                <input type="number" name="male_students_count" x-model.number="editZone.male_students_count" min="0" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs font-extrabold focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-pink-800 mb-1"><i class="fa-solid fa-venus mr-1"></i>Mhs Perempuan *</label>
                                <input type="number" name="female_students_count" x-model.number="editZone.female_students_count" min="0" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs font-extrabold focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-emerald-900 mb-1">Total Mahasiswa (Otomatis)</label>
                                <div class="w-full px-3 py-2 bg-emerald-100/80 border border-emerald-300 rounded-xl text-[#006837] text-xs font-black" x-text="((parseInt(editZone.male_students_count) || 0) + (parseInt(editZone.female_students_count) || 0)).toLocaleString('id-ID') + ' Mhs'"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Warna Bubble *</label>
                                <select name="bubble_color" x-model="editZone.bubble_color" required class="w-full px-2.5 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs font-bold focus:outline-none focus:border-[#006837]">
                                    <option value="emerald">🟢 Emerald</option>
                                    <option value="teal">🟢 Teal</option>
                                    <option value="amber">🟡 Amber</option>
                                    <option value="blue">🔵 Biru</option>
                                    <option value="purple">🟣 Ungu</option>
                                    <option value="rose">🔴 Rose</option>
                                    <option value="cyan">🔵 Cyan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Posisi X (%)</label>
                                <input type="number" step="0.5" min="5" max="95" name="map_x" x-model="editZone.map_x" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Posisi Y (%)</label>
                                <input type="number" step="0.5" min="5" max="95" name="map_y" x-model="editZone.map_y" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-[#006837]">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cakupan Provinsi / Kota & Sentra Pokjar *</label>
                        <textarea name="coverage" x-model="editZone.coverage" rows="3" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mitra Koordinasi Wilayah</label>
                        <input type="text" name="partner" x-model="editZone.partner" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Koordinator / PIC Wilayah</label>
                            <input type="text" name="coordinator_name" x-model="editZone.coordinator_name" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">No. Telepon / WhatsApp Sentra</label>
                            <input type="text" name="phone" x-model="editZone.phone" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Sekretariat / Sentra</label>
                            <input type="text" name="address" x-model="editZone.address" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="editModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white text-xs font-bold uppercase tracking-wider transition shadow-md shadow-[#006837]/20 cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Dokumentasi Galeri UPBJJ -->
    <div x-show="createGalleryModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="createGalleryModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="createGalleryModal = false"></div>

        <div x-show="createGalleryModal" x-transition class="relative z-10 w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden my-8">
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-camera text-[#006837]"></i> Tambah Dokumentasi Kegiatan UPBJJ
                    </h3>
                    <button type="button" @click="createGalleryModal = false" class="text-slate-400 hover:text-slate-700 text-base cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form action="{{ route('admin.upbjj-zones.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul / Nama Kegiatan *</label>
                        <input type="text" name="title" required placeholder="Contoh: Rapat Koordinasi Pokjar Wilayah Jawa Barat" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Zona UPBJJ (Opsional)</label>
                            <select name="upbjj_zone_id" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                                <option value="">Kegiatan Umum UPBJJ</option>
                                @foreach($zones as $z)
                                    <option value="{{ $z->id }}">{{ $z->code }} — {{ $z->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Kegiatan</label>
                            <input type="date" name="activity_date" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Unggah Foto Dokumentasi *</label>
                        <input type="file" name="image_file" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#006837] file:text-white hover:file:bg-[#004d29]">
                        <span class="text-[10px] text-slate-400 mt-1 block">JPG, PNG, WEBP maks 5 MB</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atau URL Foto</label>
                        <input type="url" name="image_url" placeholder="https://..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Keterangan Singkat</label>
                        <textarea name="description" rows="2" placeholder="Deskripsi singkat kegiatan..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="createGalleryModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white text-xs font-bold uppercase tracking-wider transition shadow-md shadow-[#006837]/20 cursor-pointer">
                            Simpan Dokumentasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Dokumentasi Galeri UPBJJ -->
    <div x-show="editGalleryModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="editGalleryModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="editGalleryModal = false"></div>

        <div x-show="editGalleryModal" x-transition class="relative z-10 w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden my-8">
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-[#006837]"></i> Edit Dokumentasi Kegiatan UPBJJ
                    </h3>
                    <button type="button" @click="editGalleryModal = false" class="text-slate-400 hover:text-slate-700 text-base cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form :action="'{{ url('/admin/upbjj-zones/galleries') }}/' + editGallery.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul / Nama Kegiatan *</label>
                        <input type="text" name="title" x-model="editGallery.title" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Zona UPBJJ (Opsional)</label>
                            <select name="upbjj_zone_id" x-model="editGallery.upbjj_zone_id" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                                <option value="">Kegiatan Umum UPBJJ</option>
                                @foreach($zones as $z)
                                    <option value="{{ $z->id }}">{{ $z->code }} — {{ $z->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Kegiatan</label>
                            <input type="date" name="activity_date" x-model="editGallery.activity_date" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ganti Foto Dokumentasi</label>
                        <input type="file" name="image_file" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#006837] file:text-white hover:file:bg-[#004d29]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atau URL Foto</label>
                        <input type="url" name="image_url" x-model="editGallery.image_url" placeholder="https://..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Keterangan Singkat</label>
                        <textarea name="description" x-model="editGallery.description" rows="2" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="editGalleryModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white text-xs font-bold uppercase tracking-wider transition shadow-md shadow-[#006837]/20 cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
