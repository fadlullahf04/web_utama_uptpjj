@extends('layouts.admin')

@section('title', 'Manajemen Dokumen Unduhan')
@section('header_title', 'Dokumen Unduhan')
@section('header_subtitle', 'Kelola file pedoman akademik, modul panduan, dan brosur PMB')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div></div>
        <a href="{{ route('admin.downloads.create') }}" class="px-4 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition flex items-center gap-2 shadow-md shadow-[#006837]/20">
            <i class="fa-solid fa-upload"></i> Tambah Dokumen Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs text-slate-700">
            <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200">
                <tr>
                    <th class="py-3.5 px-4 font-bold">Judul Dokumen</th>
                    <th class="py-3.5 px-4 font-bold">Kategori</th>
                    <th class="py-3.5 px-4 font-bold">Format / Ukuran</th>
                    <th class="py-3.5 px-4 font-bold">Downloads</th>
                    <th class="py-3.5 px-4 font-bold">Status</th>
                    <th class="py-3.5 px-4 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($documents as $doc)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-red-100 text-red-600 flex items-center justify-center font-bold">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900">{{ $doc->title }}</div>
                                    <div class="text-[10px] text-slate-500 line-clamp-1">{{ $doc->description }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 border border-emerald-200 font-bold text-[10px]">{{ $doc->category }}</span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 font-mono">{{ $doc->file_type }} ({{ $doc->file_size }})</td>
                        <td class="py-3.5 px-4 text-[#006837] font-semibold">{{ number_format($doc->downloads_count) }}x</td>
                        <td class="py-3.5 px-4">
                            @if($doc->is_active)
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-[#006837] text-[10px] font-bold">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold">Non-aktif</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ $doc->download_url }}" target="_blank" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-emerald-700 hover:bg-slate-200 transition" title="Unduh Langsung">
                                    <i class="fa-solid fa-download text-xs"></i>
                                </a>
                                <a href="{{ route('admin.downloads.edit', $doc->id) }}" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-amber-600 hover:bg-slate-200 transition" title="Edit">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('admin.downloads.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');" class="inline">
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
        <div class="p-4 border-t border-slate-100">
            {{ $documents->links() }}
        </div>
    </div>
</div>
@endsection
