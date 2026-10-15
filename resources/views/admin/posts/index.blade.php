@extends('layouts.admin')

@section('title', 'Manajemen Berita & Artikel')
@section('header_title', 'Berita & Publikasi')
@section('header_subtitle', 'Kelola artikel, dokumentasi berita, dan rilis pers UPT PJJ UINSSC')

@section('content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        
        <!-- Search & Filter Form -->
        <form action="{{ route('admin.posts.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <div class="relative">
                <input type="text" name="cari" value="{{ $search }}" placeholder="Cari judul artikel..." class="pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:border-[#006837] shadow-sm">
                <i class="fa-solid fa-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
            </div>
            
            <select name="kategori" onchange="this.form.submit()" class="px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-[#006837] shadow-sm">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            @if($search || $categoryId)
                <a href="{{ route('admin.posts.index') }}" class="text-xs text-red-500 hover:underline font-semibold">Reset</a>
            @endif
        </form>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.posts.import') }}" class="px-3.5 py-2.5 rounded-xl bg-white hover:bg-emerald-50 text-[#006837] border border-[#006837]/30 hover:border-[#006837] font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2 shadow-sm">
                <i class="fa-solid fa-file-import text-sm"></i> Import XML
            </a>
            <a href="{{ route('admin.posts.create') }}" class="px-4 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2 shadow-md shadow-[#006837]/20">
                <i class="fa-solid fa-plus"></i> Tambah Berita Baru
            </a>
        </div>
    </div>

    <!-- Posts Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4">Artikel / Berita</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Penulis</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Views</th>
                        <th class="py-3.5 px-4">Tanggal</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($posts as $post)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-12 h-12 rounded-lg object-cover shrink-0">
                                    <div>
                                        <div class="font-bold text-slate-900 line-clamp-1">{{ $post->title }}</div>
                                        @if($post->is_featured)
                                            <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 border border-amber-300">Utama (Featured)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded bg-emerald-50 text-[#006837] border border-emerald-200 text-[10px] font-bold">
                                    {{ $post->category->name ?? '-' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">{{ $post->author->name ?? '-' }}</td>
                            <td class="py-3.5 px-4">
                                @if($post->is_published)
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">Published</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold">Draft</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-[#006837] font-semibold">{{ number_format($post->views_count) }}</td>
                            <td class="py-3.5 px-4 text-slate-500">{{ $post->published_at ? $post->published_at->format('d/m/Y') : '-' }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-[#006837] hover:bg-slate-200 transition" title="Lihat Publik">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-amber-600 hover:bg-slate-200 transition" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-red-600 hover:bg-slate-200 transition" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">Tidak ada data berita.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-200 bg-slate-50">
            {{ $posts->links() }}
        </div>
    </div>

</div>
@endsection
