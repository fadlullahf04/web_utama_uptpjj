@extends('layouts.admin')

@section('title', 'Manajemen Wilayah, Zona & Peta Sebaran UPBJJ')
@section('header_title', 'Wilayah, Zona & Peta Sebaran UPBJJ')
@section('header_subtitle', 'Kelola direktori zona wilayah layanan, rincian mahasiswa laki-laki & perempuan, warna bubble, dan titik sebaran di Peta Indonesia')

@section('content')
<div x-data="{ 
    editModal: false,
    showMapPreview: true,
    newMale: 120,
    newFemale: 130,
    editZone: { id: null, code: '', name: '', coverage: '', partner: '', coordinator_name: '', phone: '', address: '', male_students_count: 0, female_students_count: 0, students_count: 0, bubble_color: 'emerald', map_x: 30.5, map_y: 70.0, order: 1, is_active: true } 
}" class="space-y-6">

    <!-- Info Banner & Quick Link to Public UPBJJ Page -->
    <div class="bg-gradient-to-r from-[#006837] to-[#004d29] p-5 rounded-2xl text-white shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center text-amber-300 text-lg shrink-0 mt-0.5">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <div>
                <h3 class="text-sm font-extrabold text-white">Direktori Zona Wilayah & Peta Sebaran Mahasiswa UPBJJ</h3>
                <p class="text-xs text-emerald-100/90 mt-0.5">Setiap perubahan jumlah mahasiswa laki-laki/perempuan, warna <em>bubble</em>, atau koordinat wilayah otomatis memperbarui Peta Indonesia & Tabel Direktori di halaman publik <strong>UPBJJ</strong>.</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Form Tambah Zona & Wilayah UPBJJ (4 cols) -->
        <div class="lg:col-span-4">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-plus-circle text-[#006837]"></i> Tambah Zona Wilayah Baru
                </h3>
                
                <form action="{{ route('admin.upbjj-zones.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
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

                    <!-- Rincian Mahasiswa Laki-Laki, Perempuan, Total & Warna Bubble Peta -->
                    <div class="p-3.5 rounded-xl bg-emerald-50/70 border border-emerald-200 space-y-3">
                        <span class="block text-[10px] font-extrabold uppercase tracking-wider text-[#006837]">
                            <i class="fa-solid fa-users mr-1"></i> Rincian Jumlah Mahasiswa & Peta Bubble
                        </span>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-sky-800 mb-1"><i class="fa-solid fa-mars mr-1"></i>Mhs Laki-Laki *</label>
                                <input type="number" name="male_students_count" x-model.number="newMale" min="0" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs font-extrabold focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-pink-800 mb-1"><i class="fa-solid fa-venus mr-1"></i>Mhs Perempuan *</label>
                                <input type="number" name="female_students_count" x-model.number="newFemale" min="0" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs font-extrabold focus:outline-none focus:border-[#006837]">
                            </div>
                        </div>

                        <div class="px-3 py-2 rounded-xl bg-white border border-emerald-200 flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-600">Total Mahasiswa Zona:</span>
                            <span class="font-black text-[#006837]" x-text="((parseInt(newMale) || 0) + (parseInt(newFemale) || 0)).toLocaleString('id-ID') + ' Mahasiswa'"></span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Warna Bubble Peta *</label>
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

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Posisi Peta X (Barat-Timur %)</label>
                                <input type="number" step="0.5" min="5" max="95" name="map_x" value="50.0" class="w-full px-3 py-1.5 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-[#006837]">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Posisi Peta Y (Utara-Selatan %)</label>
                                <input type="number" step="0.5" min="5" max="95" name="map_y" value="55.0" class="w-full px-3 py-1.5 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:border-[#006837]">
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

                    <div class="pt-2 border-t border-slate-100 space-y-3">
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Informasi Kontak Sentra (Opsional)</span>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Koordinator / PIC Wilayah</label>
                            <input type="text" name="coordinator_name" placeholder="Contoh: Koordinator Wilayah Jawa Barat" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">No. Telepon / WhatsApp Sentra</label>
                            <input type="text" name="phone" placeholder="Contoh: +62 811-2345-678" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Sekretariat / Sentra</label>
                            <input type="text" name="address" placeholder="Contoh: Gedung Siber Lt. 3 UINSSC Cirebon" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/20 flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Zona Wilayah
                    </button>
                </form>
            </div>
        </div>

        <!-- Tabel Daftar Zona & Wilayah UPBJJ (8 cols) -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Daftar Zona, Wilayah & Rincian Mahasiswa UPBJJ</h3>
                        <p class="text-[11px] text-slate-500">
                            Total {{ $zones->count() }} zona • Laki-Laki: <strong>{{ number_format($zones->sum('male_students_count'), 0, ',', '.') }}</strong> • Perempuan: <strong>{{ number_format($zones->sum('female_students_count'), 0, ',', '.') }}</strong> • Total Keseluruhan: <strong>{{ number_format($zones->sum('students_count'), 0, ',', '.') }} Mahasiswa</strong>
                        </p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="py-3 px-4 font-bold">Kode & Bubble</th>
                                <th class="py-3 px-4 font-bold">Wilayah Layanan & Kontak</th>
                                <th class="py-3 px-3 font-bold text-center">Laki-Laki</th>
                                <th class="py-3 px-3 font-bold text-center">Perempuan</th>
                                <th class="py-3 px-3 font-bold text-center">Total Mhs</th>
                                <th class="py-3 px-4 font-bold text-center">Status</th>
                                <th class="py-3 px-4 font-bold text-right">Aksi</th>
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
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-900 border border-slate-200 text-[11px] font-extrabold">
                                            <span class="w-2.5 h-2.5 rounded-full {{ $badgeColors[$zone->bubble_color] ?? 'bg-emerald-500' }}"></span>
                                            {{ $zone->code }}
                                        </span>
                                        <div class="text-[10px] text-slate-400 mt-1">X={{ $zone->map_x }}%, Y={{ $zone->map_y }}%</div>
                                    </td>
                                    <td class="py-3.5 px-4 align-top">
                                        <div class="font-bold text-slate-900">{{ $zone->name }}</div>
                                        <div class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $zone->coverage }}</div>
                                        @if($zone->partner)
                                            <div class="text-[10px] text-emerald-700 font-medium mt-0.5">{{ $zone->partner }}</div>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-3 align-top text-center whitespace-nowrap font-bold text-sky-700">
                                        {{ number_format($zone->male_students_count, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-3 align-top text-center whitespace-nowrap font-bold text-pink-700">
                                        {{ number_format($zone->female_students_count, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-3 align-top text-center whitespace-nowrap">
                                        <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-[#006837] border border-emerald-200 font-extrabold text-xs">
                                            {{ number_format($zone->students_count, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 align-top text-center">
                                        @if($zone->is_active)
                                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">Aktif</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 align-top text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <button type="button" 
                                                @click="editZone = { 
                                                    id: {{ $zone->id }}, 
                                                    code: @js($zone->code), 
                                                    name: @js($zone->name), 
                                                    coverage: @js($zone->coverage), 
                                                    partner: @js($zone->partner ?? ''), 
                                                    coordinator_name: @js($zone->coordinator_name ?? ''), 
                                                    phone: @js($zone->phone ?? ''), 
                                                    address: @js($zone->address ?? ''),
                                                    male_students_count: {{ (int) $zone->male_students_count }},
                                                    female_students_count: {{ (int) $zone->female_students_count }},
                                                    students_count: {{ (int) $zone->students_count }},
                                                    bubble_color: @js($zone->bubble_color ?? 'emerald'),
                                                    map_x: {{ (float) ($zone->map_x ?? 30.5) }},
                                                    map_y: {{ (float) ($zone->map_y ?? 70.0) }},
                                                    order: {{ $zone->order ?? 1 }}, 
                                                    is_active: {{ $zone->is_active ? 'true' : 'false' }} 
                                                }; editModal = true" 
                                                class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-amber-600 hover:bg-slate-200 transition cursor-pointer" 
                                                title="Edit Zona & Rincian Mahasiswa">
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
                                    <td colspan="7" class="py-8 text-center text-slate-400">Belum ada data zona wilayah UPBJJ.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($zones->isNotEmpty())
                            <tfoot class="bg-slate-100 border-t-2 border-slate-200 font-extrabold text-slate-900">
                                <tr>
                                    <td colspan="2" class="py-3 px-4 text-right uppercase text-[10px] tracking-wider text-slate-600">Total Keseluruhan Mahasiswa:</td>
                                    <td class="py-3 px-3 text-center text-sky-700">{{ number_format($zones->sum('male_students_count'), 0, ',', '.') }}</td>
                                    <td class="py-3 px-3 text-center text-pink-700">{{ number_format($zones->sum('female_students_count'), 0, ',', '.') }}</td>
                                    <td class="py-3 px-3 text-center text-[#006837]">{{ number_format($zones->sum('students_count'), 0, ',', '.') }}</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Edit Zona Wilayah UPBJJ -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="editModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="editModal = false"></div>

        <div x-show="editModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative z-10 w-full max-w-xl bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden my-8">
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-[#006837]"></i> Edit Zona, Mahasiswa L/P & Titik Peta UPBJJ
                    </h3>
                    <button type="button" @click="editModal = false" class="text-slate-400 hover:text-slate-700 text-base">
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
                        <button type="button" @click="editModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white text-xs font-bold uppercase tracking-wider transition shadow-md shadow-[#006837]/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
