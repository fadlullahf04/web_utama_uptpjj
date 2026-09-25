@extends('layouts.admin')

@section('title', 'Detail Pesan: ' . $message->subject)
@section('header_title', 'Detail Pesan Helpdesk')
@section('header_subtitle', 'Tinjau rincian pesan masuk dan catat respon balasan')

@section('content')
<div class="max-w-4xl space-y-6">
    <a href="{{ route('admin.contacts.index') }}" class="text-xs text-slate-500 hover:text-[#006837] font-semibold transition flex items-center gap-1.5">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Kotak Masuk
    </a>

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        
        <!-- Header Info -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-100 gap-4">
            <div>
                <span class="px-2.5 py-0.5 rounded bg-amber-50 text-amber-800 border border-amber-200 font-bold text-[10px] uppercase">{{ $message->category }}</span>
                <h2 class="text-xl font-bold text-slate-900 mt-1">{{ $message->subject }}</h2>
                <div class="flex items-center gap-3 text-xs text-slate-500 mt-2">
                    <span class="text-slate-800 font-bold"><i class="fa-solid fa-user text-[#006837] mr-1"></i> {{ $message->name }}</span>
                    <span>•</span>
                    <a href="mailto:{{ $message->email }}" class="text-[#006837] font-semibold hover:underline"><i class="fa-solid fa-envelope mr-1"></i> {{ $message->email }}</a>
                    @if($message->phone)
                        <span>•</span>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->phone) }}" target="_blank" class="text-emerald-700 font-semibold hover:underline"><i class="fa-brands fa-whatsapp mr-1"></i> {{ $message->phone }}</a>
                    @endif
                </div>
            </div>

            <div class="text-xs text-slate-500 text-left sm:text-right">
                <div>Diterima pada:</div>
                <div class="font-bold text-slate-800">{{ $message->created_at->format('d F Y, H:i') }} WIB</div>
            </div>
        </div>

        <!-- Body Message -->
        <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
            <span class="text-[10px] font-bold uppercase text-slate-500 tracking-wider">Isi Pesan Masuk:</span>
            <p class="text-xs sm:text-sm text-slate-800 leading-relaxed whitespace-pre-line">{{ $message->message }}</p>
        </div>

        <!-- Admin Response Area -->
        <div class="pt-4 space-y-4">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider text-[#006837] flex items-center gap-2">
                <i class="fa-solid fa-reply"></i> Catatan Balasan & Solusi Helpdesk
            </h3>

            <form action="{{ route('admin.contacts.reply', $message->id) }}" method="POST" class="space-y-4">
                @csrf
                <textarea name="admin_reply" rows="4" placeholder="Tuliskan respon balasan yang telah disampaikan ke email/whatsapp mahasiswa..." required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">{{ old('admin_reply', $message->admin_reply) }}</textarea>

                <div class="flex items-center justify-between">
                    <div class="text-[11px] text-slate-500 font-medium">
                        @if($message->replied_at)
                            <span class="text-[#006837] font-semibold"><i class="fa-solid fa-check-double"></i> Terakhir direspons pada: {{ $message->replied_at->format('d/m/Y H:i') }}</span>
                        @endif
                    </div>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/20">
                        Simpan Catatan Balasan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
