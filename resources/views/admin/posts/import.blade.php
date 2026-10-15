@extends('layouts.admin')

@section('title', 'Import Berita & Artikel dari XML')
@section('header_title', 'Import Berita dari XML')
@section('header_subtitle', 'Impor banyak berita dan artikel sekaligus dari berkas XML WordPress WXR, RSS 2.0, atau XML Kustom')

@section('content')
<div class="w-full space-y-6" x-data="{ 
    inputMethod: 'file', 
    fileName: '', 
    fileSize: '',
    copied: false,
    copyTemplate() {
        const text = document.getElementById('sample-xml-content').innerText;
        navigator.clipboard.writeText(text).then(() => {
            this.copied = true;
            setTimeout(() => this.copied = false, 2500);
        });
    },
    handleFile(e) {
        const file = e.target.files[0];
        if (file) {
            this.fileName = file.name;
            this.fileSize = (file.size / 1024).toFixed(1) + ' KB';
        } else {
            this.fileName = '';
            this.fileSize = '';
        }
    }
}">

    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-[#006837] transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Berita
        </a>

        <a href="{{ route('admin.posts.template.xml') }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-[#006837] border border-emerald-200 text-xs font-bold transition">
            <i class="fa-solid fa-download"></i> Unduh File Template XML
        </a>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Form Column (Left 2 cols) -->
        <div class="lg:col-span-2 space-y-6">
            <form action="{{ route('admin.posts.import.process') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
                @csrf

                <!-- Header in Card -->
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-emerald-100 text-[#006837] flex items-center justify-center text-sm">
                            <i class="fa-solid fa-file-code"></i>
                        </span>
                        Sumber Data XML
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Pilih metode pemasukan data XML: unggah file berkas <code>.xml</code> atau tempel langsung sintaks XML.
                    </p>
                </div>

                <!-- Input Method Tabs -->
                <div class="flex items-center gap-2 p-1 bg-slate-100 rounded-xl max-w-sm">
                    <button type="button" @click="inputMethod = 'file'" :class="inputMethod === 'file' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900'" class="flex-1 py-2 px-3 rounded-lg text-xs transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Unggah File XML
                    </button>
                    <button type="button" @click="inputMethod = 'text'" :class="inputMethod === 'text' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900'" class="flex-1 py-2 px-3 rounded-lg text-xs transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-code"></i> Tempel Teks XML
                    </button>
                </div>

                <!-- 1. File Upload Mode -->
                <div x-show="inputMethod === 'file'" class="space-y-3">
                    <label class="block text-xs font-bold text-slate-700">Berkas XML (.xml)</label>
                    <div class="relative border-2 border-dashed border-slate-300 hover:border-[#006837] rounded-2xl p-6 text-center transition bg-slate-50/50 hover:bg-emerald-50/20">
                        <input type="file" name="xml_file" id="xml_file" accept=".xml,text/xml,application/xml" @change="handleFile($event)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        
                        <div x-show="!fileName" class="space-y-2 pointer-events-none">
                            <div class="w-12 h-12 mx-auto rounded-full bg-emerald-100 text-[#006837] flex items-center justify-center text-xl">
                                <i class="fa-solid fa-file-import"></i>
                            </div>
                            <div class="text-xs font-bold text-slate-800">
                                Klik untuk memilih berkas atau seret file XML ke sini
                            </div>
                            <div class="text-[11px] text-slate-500">
                                Mendukung berkas XML WordPress (.xml), RSS feed, atau XML Kustom (maks. 20MB)
                            </div>
                        </div>

                        <div x-show="fileName" x-cloak class="flex items-center justify-center gap-3 py-2 pointer-events-none">
                            <i class="fa-solid fa-file-lines text-2xl text-emerald-600"></i>
                            <div class="text-left">
                                <div class="text-xs font-bold text-slate-900" x-text="fileName"></div>
                                <div class="text-[11px] text-emerald-700 font-semibold" x-text="'Ukuran: ' + fileSize"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Raw Text Mode -->
                <div x-show="inputMethod === 'text'" x-cloak class="space-y-3">
                    <div class="flex items-center justify-between">
                        <label for="xml_content" class="block text-xs font-bold text-slate-700">Kode / Isi Dokumen XML</label>
                        <span class="text-[10px] text-slate-500">Tempelkan seluruh kode XML secara lengkap</span>
                    </div>
                    <textarea name="xml_content" id="xml_content" rows="12" placeholder="<?xml version=&quot;1.0&quot; encoding=&quot;UTF-8&quot;?>&#10;<posts>&#10;    <post>&#10;        <title>Judul Berita...</title>&#10;        ...&#10;    </post>&#10;</posts>" class="w-full font-mono text-xs p-3.5 bg-slate-900 text-emerald-400 rounded-xl border border-slate-700 focus:outline-none focus:border-[#006837] focus:ring-1 focus:ring-[#006837] leading-relaxed">{{ old('xml_content') }}</textarea>
                </div>

                <!-- Configuration Options -->
                <div class="border-t border-slate-100 pt-5 space-y-5">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                        <i class="fa-solid fa-sliders text-[#006837]"></i> Pengaturan Impor
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Default Category -->
                        <div>
                            <label for="default_category_id" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Kategori Default / Cadangan
                            </label>
                            <select name="default_category_id" id="default_category_id" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-[#006837] shadow-sm">
                                <option value="">-- Pilih Kategori Cadangan --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('default_category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-[10px] text-slate-500 mt-1">Digunakan jika berita di XML tidak mencantumkan nama kategori.</p>
                        </div>

                        <!-- Auto create category checkbox -->
                        <div class="flex items-start gap-2.5 pt-2 sm:pt-6">
                            <input type="checkbox" name="auto_create_category" id="auto_create_category" value="1" {{ old('auto_create_category', '1') ? 'checked' : '' }} class="mt-0.5 w-4 h-4 text-[#006837] border-slate-300 rounded focus:ring-[#006837]">
                            <label for="auto_create_category" class="text-xs text-slate-700 cursor-pointer">
                                <span class="font-bold">Buat Kategori Baru Otomatis</span>
                                <span class="block text-[11px] text-slate-500">Jika nama kategori dari XML belum ada di database, sistem akan langsung menambahkannya.</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <!-- Publication Status -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">Status Publikasi</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="status_mode" value="keep" {{ old('status_mode', 'keep') === 'keep' ? 'checked' : '' }} class="text-[#006837] focus:ring-[#006837]">
                                    <span>Ikuti Status di XML (Publish / Draft)</span>
                                </label>
                                <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="status_mode" value="publish" {{ old('status_mode') === 'publish' ? 'checked' : '' }} class="text-[#006837] focus:ring-[#006837]">
                                    <span>Terbitkan Semua Langsung (Published)</span>
                                </label>
                                <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="status_mode" value="draft" {{ old('status_mode') === 'draft' ? 'checked' : '' }} class="text-[#006837] focus:ring-[#006837]">
                                    <span>Simpan Semua Sebagai Draf (Draft)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Duplicate Handling -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">Penanganan Duplikasi Judul</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="duplicate_handling" value="allow" {{ old('duplicate_handling', 'allow') === 'allow' ? 'checked' : '' }} class="text-[#006837] focus:ring-[#006837]">
                                    <span>Izinkan & Buat Slug Unik Baru</span>
                                </label>
                                <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="duplicate_handling" value="skip" {{ old('duplicate_handling') === 'skip' ? 'checked' : '' }} class="text-[#006837] focus:ring-[#006837]">
                                    <span>Lewati Artikel Jika Judul Sudah Ada</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="border-t border-slate-100 pt-5 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.posts.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100 text-xs font-bold transition">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition flex items-center gap-2 shadow-md shadow-[#006837]/20">
                        <i class="fa-solid fa-file-import"></i> Mulai Impor Berita
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar / Guidance Column (Right 1 col) -->
        <div class="space-y-6">
            
            <!-- Supported Formats Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-[#006837]"></i> Format XML Didukung
                </h3>
                
                <div class="space-y-3 text-xs text-slate-600">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                        <div class="font-bold text-slate-900 flex items-center gap-1.5 mb-1">
                            <i class="fa-brands fa-wordpress text-blue-600"></i> WordPress WXR Export
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Ekspor langsung dari <em>WordPress Dashboard &rarr; Tools &rarr; Export</em>. Semua tag judul, <code>content:encoded</code>, kategori, tanggal, dan status akan diproses secara otomatis.
                        </p>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                        <div class="font-bold text-slate-900 flex items-center gap-1.5 mb-1">
                            <i class="fa-solid fa-rss text-amber-500"></i> Standar RSS 2.0 Feed
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Dokumen RSS 2.0 dengan elemen <code>&lt;item&gt;</code>, <code>&lt;title&gt;</code>, <code>&lt;description&gt;</code>, dan <code>&lt;category&gt;</code>.
                        </p>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                        <div class="font-bold text-slate-900 flex items-center gap-1.5 mb-1">
                            <i class="fa-solid fa-code text-[#006837]"></i> XML Kustom UPT PJJ
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Struktur XML sederhana dengan root <code>&lt;posts&gt;</code> dan item <code>&lt;post&gt;</code>.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sample Template Code Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-file-code text-amber-600"></i> Contoh XML
                    </h3>
                    <button type="button" @click="copyTemplate()" class="text-[11px] font-bold text-[#006837] hover:underline flex items-center gap-1">
                        <i class="fa-solid" :class="copied ? 'fa-check text-emerald-600' : 'fa-copy'"></i>
                        <span x-text="copied ? 'Tersalin!' : 'Salin Contoh'"></span>
                    </button>
                </div>

                <div class="relative bg-slate-900 text-slate-300 rounded-xl p-3 text-[11px] font-mono overflow-x-auto max-h-60 border border-slate-800">
                    <pre id="sample-xml-content">&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;posts&gt;
  &lt;post&gt;
    &lt;title&gt;Judul Berita Baru&lt;/title&gt;
    &lt;category&gt;Berita &amp;amp; Informasi&lt;/category&gt;
    &lt;excerpt&gt;Ringkasan berita...&lt;/excerpt&gt;
    &lt;content&gt;&lt;![CDATA[&lt;p&gt;Isi berita...&lt;/p&gt;]]&gt;&lt;/content&gt;
    &lt;featured_image&gt;https://images.unsplash.com/...&lt;/featured_image&gt;
    &lt;tags&gt;pjj, siber, uinssc&lt;/tags&gt;
    &lt;published_at&gt;2026-10-14 10:00:00&lt;/published_at&gt;
    &lt;is_featured&gt;1&lt;/is_featured&gt;
    &lt;is_published&gt;1&lt;/is_published&gt;
  &lt;/post&gt;
&lt;/posts&gt;</pre>
                </div>

                <a href="{{ route('admin.posts.template.xml') }}" class="w-full py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center justify-center gap-2 border border-slate-200">
                    <i class="fa-solid fa-download text-emerald-600"></i> Unduh File Template (.xml)
                </a>
            </div>

            <!-- Tips & Notes Card -->
            <div class="bg-emerald-50/50 rounded-2xl border border-emerald-200/80 p-5 space-y-2 text-xs text-slate-700">
                <div class="font-bold text-[#006837] flex items-center gap-2">
                    <i class="fa-solid fa-lightbulb"></i> Tips Ekstraksi Gambar
                </div>
                <p class="text-[11px] text-slate-600 leading-relaxed">
                    Jika item XML tidak memiliki tag <code>&lt;featured_image&gt;</code>, sistem akan otomatis mendeteksi dan mengambil gambar pertama (<code>&lt;img src="..."&gt;</code>) yang ada di dalam badan teks artikel sebagai gambar sampul.
                </p>
            </div>

        </div>

    </div>

</div>
@endsection
