@extends('layouts.admin')

@section('title', 'Detail Pesan: ' . $message->subject)
@section('header_title', 'Detail Pesan Helpdesk')
@section('header_subtitle', 'Tinjau rincian pesan masuk dan catat respon balasan')

@section('content')
<div class="w-full space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.contacts.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold transition flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Kotak Masuk
        </a>
        
        <span class="text-xs text-slate-500">
            Diterima: <span class="font-bold text-slate-700">{{ $message->created_at->format('d M Y, H:i') }} WIB</span>
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Main Column (8 cols): Message Content & Reply Studio -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Message Card -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-[#006837] border border-emerald-200 font-bold text-[10px] uppercase tracking-wider">
                                {{ $message->category }}
                            </span>
                            @if($message->replied_at)
                                <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-200 font-bold text-[10px] uppercase tracking-wider flex items-center gap-1">
                                    <i class="fa-solid fa-check"></i> Sudah Dibalas
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 border border-amber-200 font-bold text-[10px] uppercase tracking-wider flex items-center gap-1">
                                    <i class="fa-solid fa-clock"></i> Menunggu Respon
                                </span>
                            @endif
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">{{ $message->subject }}</h2>
                    </div>
                </div>

                <!-- Body Message -->
                <div class="space-y-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Uraian Pertanyaan / Masalah:</span>
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-slate-800 text-sm leading-relaxed whitespace-pre-line font-sans">
                        {{ $message->message }}
                    </div>
                </div>

            </div>

            <!-- Admin Reply Box -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-reply text-[#006837]"></i> Catatan Tindak Lanjut & Respon Solusi
                    </h3>

                    @if($message->replied_at)
                        <span class="text-xs text-emerald-700 font-semibold flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check"></i> Respons disimpan {{ $message->replied_at->format('d/m/Y H:i') }} WIB
                        </span>
                    @endif
                </div>

                <form action="{{ route('admin.contacts.reply', $message->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Catatan Balasan Tim Helpdesk
                        </label>
                        <textarea name="admin_reply" rows="6" placeholder="Tuliskan jawaban solusi yang telah disampaikan kepada mahasiswa (melalui WhatsApp atau Email) sebagai arsip tiket..." required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed">{{ old('admin_reply', $message->admin_reply) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="px-6 py-3 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/25 flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Catatan Balasan
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Right Sidebar Column (4 cols): Sender Profile & Quick Channels -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Card 1: Data Pengirim -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-user-circle text-[#006837]"></i> Data Mahasiswa / Pengirim
                </h4>

                <div class="space-y-3.5 text-xs">
                    <div>
                        <span class="text-slate-400 text-[11px] block mb-0.5">Nama Lengkap</span>
                        <span class="font-bold text-slate-900 text-sm">{{ $message->name }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 text-[11px] block mb-0.5">Alamat Email</span>
                        <a href="mailto:{{ $message->email }}" class="text-[#006837] font-semibold hover:underline flex items-center gap-1.5 break-all">
                            <i class="fa-solid fa-envelope"></i> {{ $message->email }}
                        </a>
                    </div>

                    <div>
                        <span class="text-slate-400 text-[11px] block mb-0.5">Nomor WhatsApp / HP</span>
                        @if($message->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->phone) }}" target="_blank" class="text-emerald-700 font-bold hover:underline flex items-center gap-1.5">
                                <i class="fa-brands fa-whatsapp text-emerald-600 text-sm"></i> {{ $message->phone }}
                            </a>
                        @else
                            <span class="text-slate-400 italic">Tidak dicantumkan</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card 2: Saluran Cepat Respon -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-bolt text-amber-500"></i> Respon Cepat Mahasiswa
                </h4>

                <div class="space-y-2.5">
                    @if($message->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->phone) }}?text={{ urlencode('Halo ' . $message->name . ', kami dari Helpdesk UPT PJJ UINSSC menindaklanjuti pesan Anda terkait: ' . $message->subject) }}" target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm">
                            <i class="fa-brands fa-whatsapp text-sm"></i> Chat Langsung via WhatsApp
                        </a>
                    @endif

                    <a href="mailto:{{ $message->email }}?subject={{ urlencode('Re: ' . $message->subject . ' [Helpdesk UPT PJJ UINSSC]') }}" class="w-full py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm">
                        <i class="fa-solid fa-envelope text-sm"></i> Balas Lewat Email
                    </a>
                </div>
            </div>

            <!-- Card 3: SOP Penanganan Pesan -->
            <div class="bg-emerald-50/50 p-6 rounded-2xl border border-emerald-200/60 space-y-3">
                <h4 class="text-xs font-bold text-[#006837] uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-circle-info"></i> Petunjuk Helpdesk
                </h4>
                <ul class="text-[11px] text-slate-600 space-y-1.5 list-disc list-inside leading-relaxed">
                    <li>Gunakan salam dan bahasa yang santun serta ramah.</li>
                    <li>Sertakan tautan panduan jika menyangkut kendala teknis LMS.</li>
                    <li>Pastikan menyimpan ringkasan respon agar rekan admin lain mengetahui status penyelesaiannya.</li>
                </ul>
            </div>

        </div>

    </div>

</div>
@endsection
