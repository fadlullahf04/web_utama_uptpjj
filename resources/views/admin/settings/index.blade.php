@extends('layouts.admin')

@section('title', 'Pengaturan Website UPT PJJ')
@section('header_title', 'Pengaturan Situs Web')
@section('header_subtitle', 'Konfigurasi identitas kampus, sambutan pimpinan, kontak, dan tautan sistem')

@section('content')
<div class="max-w-5xl space-y-6" x-data="{ activeTab: 'general' }">
    
    <!-- Tab Navigation -->
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-3">
        <button @click="activeTab = 'general'" :class="activeTab === 'general' ? 'bg-[#006837] text-white font-bold shadow-md shadow-[#006837]/25' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs transition">
            <i class="fa-solid fa-university mr-1.5"></i> Identitas Unit
        </button>
        <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'bg-[#006837] text-white font-bold shadow-md shadow-[#006837]/25' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs transition">
            <i class="fa-solid fa-user-tie mr-1.5"></i> Pimpinan & Sambutan
        </button>
        <button @click="activeTab = 'contact'" :class="activeTab === 'contact' ? 'bg-[#006837] text-white font-bold shadow-md shadow-[#006837]/25' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs transition">
            <i class="fa-solid fa-location-dot mr-1.5"></i> Kontak & Alamat
        </button>
        <button @click="activeTab = 'links'" :class="activeTab === 'links' ? 'bg-[#006837] text-white font-bold shadow-md shadow-[#006837]/25' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs transition">
            <i class="fa-solid fa-link mr-1.5"></i> Tautan Portal & LMS
        </button>
        <button @click="activeTab = 'social'" :class="activeTab === 'social' ? 'bg-[#006837] text-white font-bold shadow-md shadow-[#006837]/25' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs transition">
            <i class="fa-brands fa-instagram mr-1.5"></i> Sosial Media
        </button>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- 1. Tab General -->
        <div x-show="activeTab === 'general'" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-5">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-university text-[#006837]"></i> Identitas & Branding Unit
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Unit Teknis</label>
                    <input type="text" name="site_name" value="{{ \App\Models\Setting::get('site_name') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Institusi / Universitas</label>
                    <input type="text" name="site_institution" value="{{ \App\Models\Setting::get('site_institution') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tagline Portal</label>
                <input type="text" name="site_tagline" value="{{ \App\Models\Setting::get('site_tagline') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Meta Portal</label>
                <textarea name="site_description" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">{{ \App\Models\Setting::get('site_description') }}</textarea>
            </div>
        </div>

        <!-- 2. Tab Profile & Sambutan -->
        <div x-show="activeTab === 'profile'" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-5" x-cloak>
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-user-tie text-[#006837]"></i> Pimpinan & Sambutan Resmi
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Kepala UPT</label>
                    <input type="text" name="head_name" value="{{ \App\Models\Setting::get('head_name') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jabatan Kepala UPT</label>
                    <input type="text" name="head_title" value="{{ \App\Models\Setting::get('head_title') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">URL Foto Pimpinan</label>
                <input type="url" name="head_photo" value="{{ \App\Models\Setting::get('head_photo') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Sambutan Kepala UPT</label>
                <textarea name="head_greeting" rows="8" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed">{{ \App\Models\Setting::get('head_greeting') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Visi 2030</label>
                <textarea name="vision" rows="3" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">{{ \App\Models\Setting::get('vision') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Misi Strategis</label>
                <textarea name="mission" rows="6" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">{{ \App\Models\Setting::get('mission') }}</textarea>
            </div>
        </div>

        <!-- 3. Tab Contact -->
        <div x-show="activeTab === 'contact'" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-5" x-cloak>
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-location-dot text-[#006837]"></i> Alamat & Kontak Resmi
            </h3>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Kantor Kampus</label>
                <textarea name="address" rows="2" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">{{ \App\Models\Setting::get('address') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Helpdesk</label>
                    <input type="email" name="email" value="{{ \App\Models\Setting::get('email') }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">No. WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ \App\Models\Setting::get('whatsapp') }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Telepon Kantor</label>
                    <input type="text" name="phone" value="{{ \App\Models\Setting::get('phone') }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jam Layanan</label>
                <input type="text" name="work_hours" value="{{ \App\Models\Setting::get('work_hours') }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Embed Iframe Google Maps</label>
                <textarea name="google_maps_iframe" rows="3" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-mono focus:bg-white focus:outline-none focus:border-[#006837]">{{ \App\Models\Setting::get('google_maps_iframe') }}</textarea>
            </div>
        </div>

        <!-- 4. Tab Links -->
        <div x-show="activeTab === 'links'" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-5" x-cloak>
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-link text-[#006837]"></i> Tautan Sistem & Portal Terkait
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">URL LMS Pillar *</label>
                    <input type="url" name="lms_url" value="{{ \App\Models\Setting::get('lms_url') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">URL PMB Online *</label>
                    <input type="url" name="pmb_url" value="{{ \App\Models\Setting::get('pmb_url') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">URL Website Utama UINSSC</label>
                    <input type="url" name="main_campus_url" value="{{ \App\Models\Setting::get('main_campus_url') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">URL Aplikasi Mobile SiberGo</label>
                    <input type="url" name="sibergo_url" value="{{ \App\Models\Setting::get('sibergo_url') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>
            </div>
        </div>

        <!-- 5. Tab Social -->
        <div x-show="activeTab === 'social'" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-5" x-cloak>
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-brands fa-instagram text-pink-600"></i> Akun Sosial Media Resmi
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2"><i class="fa-brands fa-instagram text-pink-600 mr-1"></i> Instagram</label>
                    <input type="url" name="instagram_url" value="{{ \App\Models\Setting::get('instagram_url') }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2"><i class="fa-brands fa-youtube text-red-600 mr-1"></i> YouTube Channel</label>
                    <input type="url" name="youtube_url" value="{{ \App\Models\Setting::get('youtube_url') }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2"><i class="fa-brands fa-facebook text-blue-600 mr-1"></i> Facebook Page</label>
                    <input type="url" name="facebook_url" value="{{ \App\Models\Setting::get('facebook_url') }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2"><i class="fa-brands fa-tiktok text-slate-800 mr-1"></i> TikTok</label>
                    <input type="url" name="tiktok_url" value="{{ \App\Models\Setting::get('tiktok_url') }}" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="px-8 py-3 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-[#006837]/25 transition">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Semua Pengaturan
            </button>
        </div>

    </form>

</div>
@endsection
