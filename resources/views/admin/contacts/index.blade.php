@extends('layouts.admin')

@section('title', 'Pesan Masuk & Helpdesk')
@section('header_title', 'Pesan & Helpdesk Mahasiswa')
@section('header_subtitle', 'Kotak masuk pesan, pertanyaan pendaftaran, dan kendala LMS')

@section('content')
<div class="space-y-6">
    
    <!-- Filter Tabs -->
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !$status ? 'bg-[#006837] text-white shadow-md shadow-[#006837]/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200' }}">
            Semua Pesan
        </a>
        <a href="{{ route('admin.contacts.index', ['status' => 'unread']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'unread' ? 'bg-red-600 text-white shadow-md shadow-red-600/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200' }}">
            Belum Dibaca ({{ $unreadCount }})
        </a>
        <a href="{{ route('admin.contacts.index', ['status' => 'read']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'read' ? 'bg-[#006837] text-white' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200' }}">
            Sudah Dibaca
        </a>
    </div>

    <!-- Messages List Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs text-slate-700">
            <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200">
                <tr>
                    <th class="py-3.5 px-4 font-bold">Pengirim</th>
                    <th class="py-3.5 px-4 font-bold">Subjek / Kategori</th>
                    <th class="py-3.5 px-4 font-bold">Pesan</th>
                    <th class="py-3.5 px-4 font-bold">Status</th>
                    <th class="py-3.5 px-4 font-bold">Waktu</th>
                    <th class="py-3.5 px-4 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($messages as $msg)
                    <tr class="hover:bg-slate-50 transition {{ !$msg->is_read ? 'bg-emerald-50/50 font-semibold' : '' }}">
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-slate-900">{{ $msg->name }}</div>
                            <div class="text-[11px] text-slate-500">{{ $msg->email }}</div>
                            @if($msg->phone)
                                <div class="text-[10px] text-[#006837] font-semibold">{{ $msg->phone }}</div>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="text-slate-900 font-bold">{{ $msg->subject }}</div>
                            <span class="text-[10px] text-amber-700 uppercase font-bold">{{ $msg->category }}</span>
                        </td>
                        <td class="py-3.5 px-4 max-w-xs text-slate-600">
                            <p class="line-clamp-2 text-[11px]">{{ $msg->message }}</p>
                        </td>
                        <td class="py-3.5 px-4">
                            @if(!$msg->is_read)
                                <span class="px-2 py-0.5 rounded-full bg-red-100 text-red-700 text-[10px] font-bold">Unread</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px]">Dibaca</span>
                            @endif
                            @if($msg->replied_at)
                                <span class="block mt-1 text-[9px] text-[#006837] font-bold"><i class="fa-solid fa-check"></i> Sudah Dibalas</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 text-[11px]">{{ $msg->created_at->diffForHumans() }}</td>
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.contacts.show', $msg->id) }}" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-emerald-700 hover:bg-slate-200 transition" title="Baca & Balas">
                                    <i class="fa-solid fa-reply text-xs"></i>
                                </a>
                                <form action="{{ route('admin.contacts.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');" class="inline">
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
                        <td colspan="6" class="py-8 text-center text-slate-500">Tidak ada pesan di kotak masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-slate-100">
            {{ $messages->links() }}
        </div>
    </div>

</div>
@endsection
