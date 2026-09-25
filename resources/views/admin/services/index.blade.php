@extends('layouts.admin')

@section('title', 'Manajemen Layanan & Fasilitas PJJ')
@section('header_title', 'Layanan & Fasilitas PJJ')
@section('header_subtitle', 'Kelola portal LMS Pillar, studio produksi, cyber lab, dan helpdesk')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div></div>
        <a href="{{ route('admin.services.create') }}" class="px-4 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition flex items-center gap-2 shadow-md shadow-[#006837]/20">
            <i class="fa-solid fa-plus"></i> Tambah Layanan Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs text-slate-700">
            <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200">
                <tr>
                    <th class="py-3.5 px-4 font-bold">Nama Layanan</th>
                    <th class="py-3.5 px-4 font-bold">Kategori</th>
                    <th class="py-3.5 px-4 font-bold">Portal Link</th>
                    <th class="py-3.5 px-4 font-bold">Status</th>
                    <th class="py-3.5 px-4 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($services as $srv)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $srv->image_url }}" alt="{{ $srv->title }}" class="w-10 h-10 rounded-lg object-cover shrink-0 border border-slate-200">
                                <div>
                                    <div class="font-bold text-slate-900">{{ $srv->title }}</div>
                                    <div class="text-[10px] text-slate-500 line-clamp-1">{{ $srv->short_description }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 border border-emerald-200 font-bold text-[10px]">{{ $srv->category }}</span>
                        </td>
                        <td class="py-3.5 px-4">
                            @if($srv->portal_url)
                                <a href="{{ $srv->portal_url }}" target="_blank" class="text-[#006837] font-semibold hover:underline flex items-center gap-1">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> {{ $srv->button_text ?? 'Akses' }}
                                </a>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            @if($srv->is_active)
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-[#006837] text-[10px] font-bold">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold">Non-aktif</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.services.edit', $srv->id) }}" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-amber-600 hover:bg-slate-200 transition" title="Edit">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('admin.services.destroy', $srv->id) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-red-600 hover:bg-slate-200 transition" title="Hapus">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
