@extends('layouts.admin')

@section('title', 'Manajemen Pengumuman Akademik')
@section('header_title', 'Pengumuman Akademik')
@section('header_subtitle', 'Kelola surat edaran, kalender akademik, dan pemberitahuan penting')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div></div>
        <a href="{{ route('admin.announcements.create') }}" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Buat Pengumuman Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs text-slate-700">
            <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200">
                <tr>
                    <th class="py-3.5 px-4">Judul Pengumuman</th>
                    <th class="py-3.5 px-4">Kategori</th>
                    <th class="py-3.5 px-4">Lampiran File</th>
                    <th class="py-3.5 px-4">Pin</th>
                    <th class="py-3.5 px-4">Tanggal</th>
                    <th class="py-3.5 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($announcements as $ann)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-slate-900 line-clamp-1">{{ $ann->title }}</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-bold">{{ $ann->category }}</span>
                        </td>
                        <td class="py-3.5 px-4">
                            @if($ann->attachment_file)
                                <a href="{{ $ann->attachment_url }}" target="_blank" class="text-[#006837] font-semibold hover:underline flex items-center gap-1">
                                    <i class="fa-solid fa-file-pdf"></i> Ada Lampiran
                                </a>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            @if($ann->is_pinned)
                                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">Pinned</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-slate-500">{{ $ann->published_at ? $ann->published_at->format('d/m/Y') : '-' }}</td>
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.announcements.edit', $ann->id) }}" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-amber-600 hover:bg-slate-200 transition" title="Edit">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('admin.announcements.destroy', $ann->id) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-red-600 hover:bg-slate-200 transition" title="Hapus">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">Belum ada pengumuman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-200 bg-slate-50">
            {{ $announcements->links() }}
        </div>
    </div>
</div>
@endsection
