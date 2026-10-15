@extends('layouts.admin')

@section('title', 'Pengaturan Website UPT PJJ')
@section('header_title', 'Pengaturan Situs Web')
@section('header_subtitle', 'Konfigurasi identitas kampus, sambutan pimpinan, kontak, dan tautan sistem')

@section('content')
<div class="w-full space-y-6" x-data="{ activeTab: 'general' }">
    
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Settings Tabs & Forms (8 cols) -->
            <div class="xl:col-span-8 space-y-6">
                
                <!-- Tab Navigation Buttons -->
                <div class="flex flex-wrap items-center gap-2 bg-white p-2.5 rounded-2xl border border-slate-200 shadow-sm">
                    <button type="button" @click="activeTab = 'general'" :class="activeTab === 'general' ? 'bg-[#006837] text-white font-bold shadow-md shadow-[#006837]/25' : 'bg-slate-50 text-slate-700 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-xs transition flex items-center gap-2">
                        <i class="fa-solid fa-university"></i>
                        <span>Identitas Unit</span>
                    </button>
                    <button type="button" @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'bg-[#006837] text-white font-bold shadow-md shadow-[#006837]/25' : 'bg-slate-50 text-slate-700 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-xs transition flex items-center gap-2">
                        <i class="fa-solid fa-user-tie"></i>
                        <span>Pimpinan & Sambutan</span>
                    </button>
                    <button type="button" @click="activeTab = 'contact'" :class="activeTab === 'contact' ? 'bg-[#006837] text-white font-bold shadow-md shadow-[#006837]/25' : 'bg-slate-50 text-slate-700 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-xs transition flex items-center gap-2">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Kontak & Alamat</span>
                    </button>
                    <button type="button" @click="activeTab = 'links'" :class="activeTab === 'links' ? 'bg-[#006837] text-white font-bold shadow-md shadow-[#006837]/25' : 'bg-slate-50 text-slate-700 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-xs transition flex items-center gap-2">
                        <i class="fa-solid fa-link"></i>
                        <span>Tautan Portal & LMS</span>
                    </button>
                    <button type="button" @click="activeTab = 'social'" :class="activeTab === 'social' ? 'bg-[#006837] text-white font-bold shadow-md shadow-[#006837]/25' : 'bg-slate-50 text-slate-700 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-xs transition flex items-center gap-2">
                        <i class="fa-brands fa-instagram"></i>
                        <span>Sosial Media</span>
                    </button>
                </div>

                <!-- 1. Tab General -->
                <div x-show="activeTab === 'general'" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-4">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-university text-[#006837]"></i> Identitas & Branding Unit
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Nama resmi, institusi, dan tagline yang tampil di header dan footer portal.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
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
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Meta Portal (SEO)</label>
                        <textarea name="site_description" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">{{ \App\Models\Setting::get('site_description') }}</textarea>
                        <span class="text-[11px] text-slate-400 mt-1 block">Tampil pada hasil pencarian Google saat pengguna mencari informasi UPT PJJ.</span>
                    </div>
                </div>

                <!-- 2. Tab Profile & Sambutan -->
                <div x-show="activeTab === 'profile'" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6" x-cloak>
                    <div class="border-b border-slate-100 pb-4">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-user-tie text-[#006837]"></i> Pimpinan & Sambutan Resmi
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Profil Kepala Unit, sambutan resmi pimpinan, serta visi dan misi strategis UPT PJJ.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
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
                <div x-show="activeTab === 'contact'" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6" x-cloak>
                    <div class="border-b border-slate-100 pb-4">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-[#006837]"></i> Alamat & Kontak Resmi
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Informasi helpdesk, telepon, jam operasional, dan peta lokasi kampus.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Kantor Kampus</label>
                        <textarea name="address" rows="2" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">{{ \App\Models\Setting::get('address') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Helpdesk</label>
                            <input type="email" name="email" value="{{ \App\Models\Setting::get('email') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">No. WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ \App\Models\Setting::get('whatsapp') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Telepon Kantor</label>
                            <input type="text" name="phone" value="{{ \App\Models\Setting::get('phone') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jam Layanan</label>
                        <input type="text" name="work_hours" value="{{ \App\Models\Setting::get('work_hours') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Embed Iframe Google Maps</label>
                        <textarea name="google_maps_iframe" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-mono focus:bg-white focus:outline-none focus:border-[#006837]">{{ \App\Models\Setting::get('google_maps_iframe') }}</textarea>
                    </div>
                </div>

                <!-- 4. Tab Links -->
                <div x-show="activeTab === 'links'" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6" x-cloak>
                    <div class="border-b border-slate-100 pb-4">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-link text-[#006837]"></i> Tautan Sistem & Portal Terkait
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Integrasi URL ekosistem pembelajaran digital, PMB, dan aplikasi siber.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
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
                <div x-show="activeTab === 'social'" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6" x-cloak>
                    <div class="border-b border-slate-100 pb-4">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-brands fa-instagram text-pink-600"></i> Akun Sosial Media Resmi
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Tautan sosial media resmi yang tampil di bilah atas (*top bar*) dan *footer*.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2"><i class="fa-brands fa-instagram text-pink-600 mr-1"></i> Instagram</label>
                            <input type="url" name="instagram_url" value="{{ \App\Models\Setting::get('instagram_url') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2"><i class="fa-brands fa-youtube text-red-600 mr-1"></i> YouTube Channel</label>
                            <input type="url" name="youtube_url" value="{{ \App\Models\Setting::get('youtube_url') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2"><i class="fa-brands fa-facebook text-blue-600 mr-1"></i> Facebook Page</label>
                            <input type="url" name="facebook_url" value="{{ \App\Models\Setting::get('facebook_url') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2"><i class="fa-brands fa-tiktok text-slate-800 mr-1"></i> TikTok</label>
                            <input type="url" name="tiktok_url" value="{{ \App\Models\Setting::get('tiktok_url') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                        </div>
                    </div>
                </div>

                <!-- Bottom Save Button -->
                <div class="flex items-center justify-between bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                    <span class="text-xs text-slate-500 font-medium">
                        <i class="fa-solid fa-circle-check text-emerald-600 mr-1"></i> Perubahan tersimpan aman dan ter-refresh di seluruh halaman.
                    </span>
                    <button type="submit" class="px-7 py-3 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-[#006837]/25 transition">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Semua Pengaturan
                    </button>
                </div>

            </div>

            <!-- Right Column: Sidebar Panels & Live Verification (4 cols) -->
            <div class="xl:col-span-4 space-y-6">
                
                <!-- Quick Save Card -->
                <div class="bg-gradient-to-br from-[#006837] to-[#004d29] p-6 rounded-2xl text-white shadow-lg space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-1 rounded-lg bg-white/20 text-white font-bold text-[10px] uppercase tracking-wider">Aksi Cepat</span>
                        <i class="fa-solid fa-sliders text-emerald-300 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-white">Simpan Konfigurasi</h4>
                        <p class="text-xs text-emerald-100/90 mt-1 leading-relaxed">Pastikan semua data pada setiap tab sudah terisi dengan benar sebelum menekan tombol simpan.</p>
                    </div>
                    <button type="submit" class="w-full py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold text-xs uppercase tracking-wider shadow-md transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Semua Pengaturan
                    </button>
                </div>

                <!-- System Info Card -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-server text-[#006837]"></i> Status Lingkungan & Sistem
                    </h4>
                    
                    <div class="divide-y divide-slate-100 text-xs">
                        <div class="py-2.5 flex items-center justify-between">
                            <span class="text-slate-500">Lingkungan (Env):</span>
                            <span class="font-bold px-2 py-0.5 rounded text-[10px] uppercase {{ app()->environment('production') ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ app()->environment() }}
                            </span>
                        </div>
                        <div class="py-2.5 flex items-center justify-between">
                            <span class="text-slate-500">Versi Framework:</span>
                            <span class="font-bold text-slate-800">Laravel {{ app()->version() }}</span>
                        </div>
                        <div class="py-2.5 flex items-center justify-between">
                            <span class="text-slate-500">Versi PHP:</span>
                            <span class="font-bold text-slate-800">PHP {{ PHP_VERSION }}</span>
                        </div>
                        <div class="py-2.5 flex items-center justify-between">
                            <span class="text-slate-500">Database Driver:</span>
                            <span class="font-bold text-slate-800 capitalize">{{ config('database.default') }}</span>
                        </div>
                        <div class="py-2.5 flex items-center justify-between">
                            <span class="text-slate-500">Session Driver:</span>
                            <span class="font-bold text-slate-800">{{ config('session.driver') }}</span>
                        </div>
                        <div class="py-2.5 flex items-center justify-between">
                            <span class="text-slate-500">Sistem Cache:</span>
                            <span class="text-emerald-700 font-semibold flex items-center gap-1.5">
                                <i class="fa-solid fa-circle text-[8px]"></i> Auto Flush on Save
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Live Frontend Verification Links -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-up-right-from-square text-[#006837]"></i> Tinjau Tampilan Website
                    </h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Periksa langsung hasil pengaturan di halaman publik setelah menyimpan perubahan:</p>

                    <div class="space-y-2">
                        <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 transition group">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-house text-[#006837]"></i> Halaman Beranda
                            </span>
                            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 group-hover:translate-x-0.5 transition-transform"></i>
                        </a>
                        <a href="{{ route('profile.overview') }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 transition group">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-user-tie text-[#006837]"></i> Sambutan Kepala UPT
                            </span>
                            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 group-hover:translate-x-0.5 transition-transform"></i>
                        </a>
                        <a href="{{ route('contact.index') }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 transition group">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-location-dot text-[#006837]"></i> Kontak & Peta Kampus
                            </span>
                            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 group-hover:translate-x-0.5 transition-transform"></i>
                        </a>
                    </div>
                </div>

                <!-- Helpful Tips Card -->
                <div class="bg-emerald-50 p-6 rounded-2xl border border-emerald-200 text-emerald-950 space-y-3">
                    <div class="flex items-center gap-2 font-bold text-xs text-emerald-900 uppercase tracking-wider">
                        <i class="fa-solid fa-lightbulb text-amber-500"></i> Petunjuk Praktis
                    </div>
                    <ul class="text-xs text-emerald-900/80 space-y-2 leading-relaxed list-disc list-inside">
                        <li><strong>Iframe Maps:</strong> Buka Google Maps, klik <em>Bagikan &rarr; Sematkan Peta</em>, lalu salin kodenya ke kolom yang disediakan.</li>
                        <li><strong>Foto Pimpinan:</strong> Disarankan menggunakan foto formal beresolusi tinggi dengan rasio persegi (1:1).</li>
                        <li><strong>Cache:</strong> Sistem otomatis merefresh memori cache setiap kali tombol simpan ditekan.</li>
                    </ul>
                </div>

            </div>

        </div>
    </form>

</div>
@endsection
