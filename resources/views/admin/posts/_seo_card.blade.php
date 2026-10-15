<!-- Card: Optimasi Mesin Pencari (SEO & Metadata) -->
<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5" x-data="{
    seoTitle: @js(old('meta_title', $post->meta_title ?? '')),
    seoDesc: @js(old('meta_description', $post->meta_description ?? '')),
    get displayTitle() {
        if (this.seoTitle && this.seoTitle.trim() !== '') return this.seoTitle.trim();
        const mainTitle = document.querySelector('input[name=\'title\']');
        return (mainTitle && mainTitle.value.trim() !== '') ? mainTitle.value.trim() : 'Judul Artikel Berita UPT PJJ UINSSC';
    },
    get displayDesc() {
        if (this.seoDesc && this.seoDesc.trim() !== '') return this.seoDesc.trim();
        const excerpt = document.querySelector('textarea[name=\'excerpt\']');
        if (excerpt && excerpt.value.trim() !== '') return excerpt.value.trim();
        return 'Pelajari informasi terbaru dan pembaruan kegiatan akademik dari UPT Pendidikan Jarak Jauh Universitas Islam Negeri Siber Syekh Nurjati Cirebon.';
    },
    copyFromTitle() {
        const mainTitle = document.querySelector('input[name=\'title\']');
        if (mainTitle && mainTitle.value) {
            this.seoTitle = mainTitle.value.trim();
        }
    },
    copyFromExcerpt() {
        const excerpt = document.querySelector('textarea[name=\'excerpt\']');
        if (excerpt && excerpt.value) {
            this.seoDesc = excerpt.value.trim();
        }
    }
}">
    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
            <i class="fa-solid fa-magnifying-glass-chart text-[#006837]"></i> Optimasi SEO & SERP
        </h4>
        <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-800 font-bold border border-emerald-200">Google Ready</span>
    </div>

    <!-- Google SERP Snippet Preview -->
    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-1.5 font-sans">
        <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider flex items-center gap-1.5">
            <i class="fa-brands fa-google text-blue-500"></i> Pratinjau Tampilan Google Search
        </div>
        
        <div class="pt-1">
            <div class="text-[11px] text-emerald-800 truncate flex items-center gap-1">
                <span>https://pjj.uinssc.ac.id</span>
                <span class="text-slate-400">›</span>
                <span>berita</span>
                <span class="text-slate-400">›</span>
                <span class="text-slate-500 truncate" x-text="(seoTitle ? seoTitle.toLowerCase().replace(/[^a-z0-9]+/g, '-').slice(0, 30) : 'artikel-berita')">artikel-berita</span>
            </div>
            
            <h5 class="text-sm font-semibold text-blue-700 hover:underline leading-snug cursor-pointer line-clamp-1 mt-0.5" 
                x-text="displayTitle + ' | UPT PJJ UINSSC'">
                Judul Artikel Berita | UPT PJJ UINSSC
            </h5>
            
            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed mt-1" 
               x-text="displayDesc">
                Deskripsi ringkas cuplikan artikel di mesin pencari Google...
            </p>
        </div>
    </div>

    <!-- Input Meta Title -->
    <div>
        <div class="flex items-center justify-between mb-1.5">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                Meta Title (Judul SEO)
            </label>
            <div class="flex items-center gap-2">
                <button type="button" x-on:click="copyFromTitle" class="text-[10px] text-[#006837] hover:underline font-semibold">
                    Salin dari Judul
                </button>
                <span class="text-[10px] text-slate-400" :class="seoTitle.length > 60 ? 'text-amber-600 font-bold' : ''">
                    <span x-text="seoTitle.length">0</span>/60 karakter
                </span>
            </div>
        </div>
        <input type="text" 
               name="meta_title" 
               x-model="seoTitle" 
               value="{{ old('meta_title', $post->meta_title ?? '') }}" 
               placeholder="Judul khusus untuk Google (opsional, jika beda dengan judul artikel)..." 
               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
        <span class="text-[11px] text-slate-400 mt-1 block">Rekomendasi 50 - 60 karakter agar tidak terpotong di Google</span>
    </div>

    <!-- Input Meta Description -->
    <div>
        <div class="flex items-center justify-between mb-1.5">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                Meta Description (Cuplikan Snippet)
            </label>
            <div class="flex items-center gap-2">
                <button type="button" x-on:click="copyFromExcerpt" class="text-[10px] text-[#006837] hover:underline font-semibold">
                    Salin dari Ringkasan
                </button>
                <span class="text-[10px] text-slate-400" :class="seoDesc.length > 160 ? 'text-amber-600 font-bold' : ''">
                    <span x-text="seoDesc.length">0</span>/160 karakter
                </span>
            </div>
        </div>
        <textarea name="meta_description" 
                  x-model="seoDesc" 
                  rows="3" 
                  placeholder="Deskripsi rangkuman 1-2 kalimat untuk snippet hasil pencarian Google..." 
                  class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
        <span class="text-[11px] text-slate-400 mt-1 block">Rekomendasi 120 - 160 karakter yang memikat pembaca untuk mengklik</span>
    </div>

</div>
