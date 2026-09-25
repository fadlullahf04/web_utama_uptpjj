@extends('layouts.admin')

@section('title', 'Manajemen Tim & Struktur Organisasi')
@section('header_title', 'Tim & Struktur UPT PJJ')
@section('header_subtitle', 'Kelola data pimpinan, koordinator divisi, dan tim tutor siber')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div></div>
        <a href="{{ route('admin.team.create') }}" class="px-4 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition flex items-center gap-2 shadow-md shadow-[#006837]/20">
            <i class="fa-solid fa-plus"></i> Tambah Anggota Tim
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs text-slate-700">
            <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200">
                <tr>
                    <th class="py-3.5 px-4 font-bold">Nama & Foto</th>
                    <th class="py-3.5 px-4 font-bold">Jabatan</th>
                    <th class="py-3.5 px-4 font-bold">Divisi</th>
                    <th class="py-3.5 px-4 font-bold">Kontak</th>
                    <th class="py-3.5 px-4 font-bold">Status</th>
                    <th class="py-3.5 px-4 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($members as $m)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $m->photo_url }}" alt="{{ $m->name }}" class="w-10 h-10 rounded-xl object-cover border border-slate-200">
                                <div>
                                    <div class="font-bold text-slate-900">{{ $m->name }}</div>
                                    <div class="text-[10px] text-slate-500">NIP: {{ $m->nip ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-[#006837] font-semibold">{{ $m->title }}</td>
                        <td class="py-3.5 px-4">
                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[10px] font-medium">{{ $m->division }}</span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 text-[11px]">{{ $m->email ?? '-' }}</td>
                        <td class="py-3.5 px-4">
                            @if($m->is_active)
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-[#006837] text-[10px] font-bold">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold">Non-aktif</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.team.edit', $m->id) }}" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-amber-600 hover:bg-slate-200 transition">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('admin.team.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus data tim ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-red-600 hover:bg-slate-200 transition">
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
