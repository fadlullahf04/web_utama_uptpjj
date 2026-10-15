@extends('layouts.admin')

@section('title', 'Manajemen Program Studi PJJ')
@section('header_title', 'Program Studi PJJ')
@section('header_subtitle', 'Kelola informasi program studi S1 & S2 siber, kurikulum, dan pendaftaran')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div></div>
        <a href="{{ route('admin.programs.create') }}" class="px-4 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition flex items-center gap-2 shadow-md shadow-[#006837]/20">
            <i class="fa-solid fa-plus"></i> Tambah Program Studi Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs text-slate-700">
            <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200">
                <tr>
                    <th class="py-3.5 px-4 font-bold">Program Studi</th>
                    <th class="py-3.5 px-4 font-bold">Jenjang</th>
                    <th class="py-3.5 px-4 font-bold">Akreditasi</th>
                    <th class="py-3.5 px-4 font-bold">Kaprodi</th>
                    <th class="py-3.5 px-4 font-bold">SKS / Durasi</th>
                    <th class="py-3.5 px-4 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($programs as $prodi)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $prodi->image_url }}" alt="{{ $prodi->name }}" class="w-12 h-12 rounded-lg object-cover shrink-0 border border-slate-200">
                                <div>
                                    <div class="font-bold text-slate-900">{{ $prodi->name }}</div>
                                    <div class="text-[10px] text-[#006837] font-semibold">{{ $prodi->faculty }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2 py-0.5 rounded {{ $prodi->degree === 'S2' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-[#006837]' }} text-[10px] font-extrabold">
                                {{ $prodi->degree }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 border border-emerald-200 font-bold text-[10px]">
                                {{ $prodi->accreditation }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-800 font-medium">{{ $prodi->head_of_program ?? '-' }}</td>
                        <td class="py-3.5 px-4 text-slate-500">{{ $prodi->total_credits }} SKS ({{ $prodi->study_duration }})</td>
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('programs.show', $prodi->slug) }}" target="_blank" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-emerald-700 hover:bg-slate-200 transition" title="Lihat Publik">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('admin.programs.edit', $prodi->id) }}" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-amber-600 hover:bg-slate-200 transition" title="Edit">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('admin.programs.destroy', $prodi->id) }}" method="POST" onsubmit="return confirm('Hapus program studi ini?');" class="inline">
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
