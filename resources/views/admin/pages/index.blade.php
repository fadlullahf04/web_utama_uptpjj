@extends('layouts.admin')

@section('title', 'Manajemen Halaman Dinamis')
@section('header_title', 'Halaman Dinamis')
@section('header_subtitle', 'Buat dan kelola halaman informasi kustom untuk dipanggil pada Menu Navigasi')

@section('content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        
        <!-- Search & Filter Form -->
        <form action="{{ route('admin.pages.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <div class="relative">
                <input type="text" name="cari" value="{{ $search }}" placeholder="Cari judul atau slug..." class="pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:border-[#006837] shadow-sm">
                <i class="fa-solid fa-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
            </div>
            
            <select name="status" onchange="this.form.submit()" class="px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-[#006837] shadow-sm">
                <option value="">Semua Status</option>
                <option value="published" {{ $status == 'published' ? 'selected' : '' }}>Terpublikasi</option>
                <option value="draft" {{ $status == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>

            @if($search || $status)
                <a href="{{ route('admin.pages.index') }}" class="text-xs text-red-500 hover:underline font-semibold">Reset</a>
            @endif
        </form>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.menus.index') }}" class="px-3.5 py-2.5 rounded-xl bg-white hover:bg-emerald-50 text-[#006837] border border-[#006837]/30 hover:border-[#006837] font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2 shadow-sm" title="Buka Menu Builder">
                <i class="fa-solid fa-bars-staggered"></i> Menu Builder
            </a>
            <a href="{{ route('admin.pages.create') }}" class="px-4 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2 shadow-md shadow-[#006837]/20">
                <i class="fa-solid fa-plus"></i> Tambah Halaman Baru
            </a>
        </div>
    </div>

    <!-- Quick Info Banner -->
    <div class="p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200 flex items-start gap-3.5 text-xs text-emerald-950">
        <i class="fa-solid fa-circle-info text-emerald-600 text-base mt-0.5 shrink-0"></i>
        <div class="space-y-1">
            <p class="font-bold">Modul Pembuat Halaman Web Dinamis</p>
            <p class="text-emerald-800 leading-relaxed">
                Halaman yang Anda buat di sini memiliki URL khusus (contoh: <code class="bg-white/80 px-1.5 py-0.5 rounded border border-emerald-300">/halaman/nama-slug</code>) dan langsung dapat Anda pilih serta tautkan ke <strong>Menu Builder</strong> (Navbar atau Footer).
            </p>
        </div>
    </div>

    <!-- Pages Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4">Judul Halaman</th>
                        <th class="py-3.5 px-4">Slug / URL</th>
                        <th class="py-3.5 px-4">Template</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Views</th>
                        <th class="py-3.5 px-4">Diperbarui</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pages as $page)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 line-clamp-1 text-sm">{{ $page->title }}</div>
                                @if($page->excerpt)
                                    <div class="text-[11px] text-slate-400 line-clamp-1 mt-0.5">{{ $page->excerpt }}</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <code class="px-2 py-1 rounded bg-slate-100 text-slate-700 font-mono text-[11px] border border-slate-200 select-all">
                                    /halaman/{{ $page->slug }}
                                </code>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="capitalize px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 font-semibold text-[10px]">
                                    {{ $page->template }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($page->is_published)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Terpublikasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Draft
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 font-medium">
                                <i class="fa-regular fa-eye mr-1 text-slate-400"></i> {{ number_format($page->views_count) }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-400">
                                {{ $page->updated_at->format('d M Y, H:i') }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <!-- Preview Link -->
                                    <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="p-2 rounded-lg bg-slate-100 hover:bg-emerald-50 text-slate-600 hover:text-[#006837] transition" title="Lihat Halaman">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    </a>

                                    <!-- Edit Link -->
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="p-2 rounded-lg bg-slate-100 hover:bg-amber-50 text-slate-600 hover:text-amber-600 transition" title="Edit Halaman">
                                        <i class="fa-solid fa-pencil text-xs"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman &quot;{{ $page->title }}&quot;?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 transition" title="Hapus Halaman">
                                            <i class="fa-regular fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-file-circle-plus text-3xl mb-3 text-slate-300 block"></i>
                                Belum ada halaman dinamis yang dibuat.<br>
                                <a href="{{ route('admin.pages.create') }}" class="text-[#006837] font-bold hover:underline mt-2 inline-block">
                                    + Buat Halaman Dinamis Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pages->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $pages->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
