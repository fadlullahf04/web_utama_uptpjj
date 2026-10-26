<!-- Accessibility Tools Floating Widget (Aksesibilitas Disabilitas) -->
<div x-data="accessibilityWidget()" x-init="initAccessibility()" class="relative z-50">
    
    <!-- Floating Trigger Button (Bottom-Left) -->
    <div class="fixed bottom-6 left-6 z-40 flex items-center gap-2 group">
        <button @click="toggleModal()" 
                type="button" 
                class="flex items-center gap-2.5 px-4 py-3 rounded-full bg-slate-900 hover:bg-[#006837] text-white shadow-2xl shadow-slate-950/40 border border-slate-700/80 hover:border-emerald-500 transition-all duration-300 transform hover:scale-105 cursor-pointer focus:outline-none focus:ring-4 focus:ring-emerald-500/50"
                aria-label="Buka Menu Aksesibilitas Disabilitas"
                title="Pusat Aksesibilitas & Ramah Disabilitas">
            <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 text-sm">
                <i class="fa-solid fa-universal-access"></i>
            </div>
            <span class="text-xs font-bold tracking-wide hidden sm:inline">Aksesibilitas</span>
            <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-emerald-500 text-slate-950 font-extrabold uppercase">Ramah Difabel</span>
        </button>
    </div>

    <!-- Accessibility Panel Modal / Slide-out Drawer -->
    <div x-show="isOpen" 
         x-cloak 
         @click.away="isOpen = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:-translate-x-6"
         x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:translate-x-0"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:-translate-x-6"
         class="fixed bottom-20 left-4 sm:left-6 z-50 w-[94vw] sm:w-[420px] max-h-[85vh] bg-white rounded-3xl border border-slate-200 shadow-2xl flex flex-col overflow-hidden text-slate-800">

        <!-- Panel Header -->
        <div class="p-5 bg-gradient-to-r from-slate-900 via-slate-800 to-[#004d29] text-white flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-emerald-300 text-lg shadow-inner">
                    <i class="fa-solid fa-universal-access"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                        Pusat Aksesibilitas
                        <span class="text-[9px] px-2 py-0.5 rounded-full bg-emerald-500 text-slate-950 font-extrabold uppercase">Inklusif</span>
                    </h3>
                    <p class="text-[11px] text-emerald-100/80">Kenyamanan membaca, visual, dan audio pembelajar</p>
                </div>
            </div>
            <button @click="isOpen = false" type="button" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-xs transition cursor-pointer" aria-label="Tutup panel aksesibilitas">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Panel Body (Scrollable Features) -->
        <div class="p-5 overflow-y-auto space-y-5 text-xs">

            <!-- 1. Text Sizing -->
            <div class="space-y-2">
                <label class="font-bold text-slate-800 flex items-center justify-between">
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-text-height text-[#006837]"></i> Ukuran Teks Halaman:</span>
                    <span class="text-emerald-700 font-extrabold" x-text="fontSize + '%'"></span>
                </label>
                <div class="grid grid-cols-4 gap-2">
                    <button @click="setFontSize(90)" :class="fontSize === 90 ? 'bg-[#006837] text-white font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="py-2 rounded-xl transition text-center cursor-pointer">
                        <span class="text-xs">A-</span> (90%)
                    </button>
                    <button @click="setFontSize(100)" :class="fontSize === 100 ? 'bg-[#006837] text-white font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="py-2 rounded-xl transition text-center cursor-pointer">
                        <span class="text-xs font-semibold">Normal</span>
                    </button>
                    <button @click="setFontSize(115)" :class="fontSize === 115 ? 'bg-[#006837] text-white font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="py-2 rounded-xl transition text-center cursor-pointer">
                        <span class="text-sm font-bold">A+</span> (115%)
                    </button>
                    <button @click="setFontSize(130)" :class="fontSize === 130 ? 'bg-[#006837] text-white font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="py-2 rounded-xl transition text-center cursor-pointer">
                        <span class="text-base font-extrabold">A++</span> (130%)
                    </button>
                </div>
            </div>

            <!-- 2. Visual Contrast & Color Modes -->
            <div class="space-y-2">
                <label class="font-bold text-slate-800 flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-half-stroke text-[#006837]"></i> Mode Kontras & Tampilan Visual:
                </label>
                <div class="grid grid-cols-2 gap-2">
                    <button @click="setVisualMode('normal')" :class="visualMode === 'normal' ? 'border-[#006837] bg-emerald-50 text-[#006837] font-bold' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'" class="p-2.5 rounded-xl border flex items-center gap-2 transition cursor-pointer">
                        <i class="fa-solid fa-sun text-amber-500"></i>
                        <span>Warna Standar</span>
                    </button>
                    <button @click="setVisualMode('contrast')" :class="visualMode === 'contrast' ? 'border-[#006837] bg-slate-900 text-amber-300 font-bold' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'" class="p-2.5 rounded-xl border flex items-center gap-2 transition cursor-pointer">
                        <i class="fa-solid fa-circle-half-stroke text-amber-400"></i>
                        <span>Kontras Tinggi</span>
                    </button>
                    <button @click="setVisualMode('grayscale')" :class="visualMode === 'grayscale' ? 'border-[#006837] bg-slate-200 text-slate-900 font-bold' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'" class="p-2.5 rounded-xl border flex items-center gap-2 transition cursor-pointer">
                        <i class="fa-solid fa-eye-slash text-slate-500"></i>
                        <span>Skala Abu-abu</span>
                    </button>
                    <button @click="setVisualMode('invert')" :class="visualMode === 'invert' ? 'border-[#006837] bg-slate-950 text-emerald-400 font-bold' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'" class="p-2.5 rounded-xl border flex items-center gap-2 transition cursor-pointer">
                        <i class="fa-solid fa-shuffle text-teal-500"></i>
                        <span>Balik Warna</span>
                    </button>
                </div>
            </div>

            <!-- 3. Readability & Typography Aids -->
            <div class="space-y-2">
                <label class="font-bold text-slate-800 flex items-center gap-1.5">
                    <i class="fa-solid fa-font text-[#006837]"></i> Bantuan Keterbacaan Huruf:
                </label>
                <div class="space-y-2">
                    <button @click="toggleDyslexicFont()" class="w-full p-2.5 rounded-xl border flex items-center justify-between transition cursor-pointer" :class="isDyslexic ? 'border-[#006837] bg-emerald-50 text-[#006837] font-bold' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-book-open-reader text-[#006837]"></i> Huruf Ramah Disleksia (Spasi Lebih Renggang)</span>
                        <i class="fa-solid" :class="isDyslexic ? 'fa-toggle-on text-emerald-600 text-lg' : 'fa-toggle-off text-slate-400 text-lg'"></i>
                    </button>
                    <button @click="toggleUnderlineLinks()" class="w-full p-2.5 rounded-xl border flex items-center justify-between transition cursor-pointer" :class="isUnderlineLinks ? 'border-[#006837] bg-emerald-50 text-[#006837] font-bold' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-link text-blue-600"></i> Garis Bawahi Semua Tautan</span>
                        <i class="fa-solid" :class="isUnderlineLinks ? 'fa-toggle-on text-emerald-600 text-lg' : 'fa-toggle-off text-slate-400 text-lg'"></i>
                    </button>
                    <button @click="toggleLargeCursor()" class="w-full p-2.5 rounded-xl border flex items-center justify-between transition cursor-pointer" :class="isLargeCursor ? 'border-[#006837] bg-emerald-50 text-[#006837] font-bold' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-arrow-pointer text-amber-600"></i> Kursor Mouse Ukuran Besar</span>
                        <i class="fa-solid" :class="isLargeCursor ? 'fa-toggle-on text-emerald-600 text-lg' : 'fa-toggle-off text-slate-400 text-lg'"></i>
                    </button>
                </div>
            </div>

            <!-- 4. Text-To-Speech (Pembaca Layar Audio) -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-slate-900 flex items-center gap-1.5">
                        <i class="fa-solid fa-volume-high text-emerald-600"></i> Pembaca Suara Layar (TTS):
                    </span>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold uppercase">Bahasa Indonesia</span>
                </div>
                <p class="text-[11px] text-slate-600 leading-relaxed">
                    Dengarkan isi ringkasan teks halaman ini atau blok teks tertentu dengan kursor untuk dibacakan secara otomatis.
                </p>
                <div class="flex items-center gap-2">
                    <button @click="speakPageContent()" type="button" class="flex-1 py-2 px-3 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold transition flex items-center justify-center gap-2 cursor-pointer shadow-sm">
                        <i class="fa-solid" :class="isSpeaking ? 'fa-stop text-amber-300' : 'fa-play'"></i>
                        <span x-text="isSpeaking ? 'Hentikan Pembacaan' : 'Bacakan Halaman Ini'"></span>
                    </button>
                    <button @click="speakSelectedText()" type="button" class="py-2 px-3 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold transition cursor-pointer" title="Bacakan teks yang diblok">
                        <i class="fa-solid fa-headphones mr-1"></i> Baca Seleksi
                    </button>
                </div>
            </div>

        </div>

        <!-- Panel Footer -->
        <div class="p-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between shrink-0">
            <button @click="resetAccessibility()" type="button" class="text-slate-600 hover:text-red-600 font-semibold text-xs flex items-center gap-1.5 transition cursor-pointer">
                <i class="fa-solid fa-rotate-left"></i> Reset ke Standar
            </button>
            <button @click="isOpen = false" type="button" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition cursor-pointer">
                Selesai
            </button>
        </div>

    </div>

</div>

<script>
function accessibilityWidget() {
    return {
        isOpen: false,
        fontSize: 100,
        visualMode: 'normal',
        isDyslexic: false,
        isUnderlineLinks: false,
        isLargeCursor: false,
        isSpeaking: false,

        initAccessibility() {
            try {
                const saved = localStorage.getItem('uptpjj_accessibility');
                if (saved) {
                    const data = JSON.parse(saved);
                    this.fontSize = data.fontSize || 100;
                    this.visualMode = data.visualMode || 'normal';
                    this.isDyslexic = !!data.isDyslexic;
                    this.isUnderlineLinks = !!data.isUnderlineLinks;
                    this.isLargeCursor = !!data.isLargeCursor;
                    this.applyAll();
                }
            } catch (e) {
                console.error('Error loading accessibility settings:', e);
            }
        },

        toggleModal() {
            this.isOpen = !this.isOpen;
        },

        setFontSize(size) {
            this.fontSize = size;
            this.applyAll();
            this.save();
        },

        setVisualMode(mode) {
            this.visualMode = mode;
            this.applyAll();
            this.save();
        },

        toggleDyslexicFont() {
            this.isDyslexic = !this.isDyslexic;
            this.applyAll();
            this.save();
        },

        toggleUnderlineLinks() {
            this.isUnderlineLinks = !this.isUnderlineLinks;
            this.applyAll();
            this.save();
        },

        toggleLargeCursor() {
            this.isLargeCursor = !this.isLargeCursor;
            this.applyAll();
            this.save();
        },

        applyAll() {
            const doc = document.documentElement;
            // Font Size
            doc.style.fontSize = this.fontSize === 100 ? '' : (this.fontSize + '%');

            // Visual Modes
            doc.classList.remove('accessibility-high-contrast', 'accessibility-grayscale', 'accessibility-invert');
            if (this.visualMode === 'contrast') doc.classList.add('accessibility-high-contrast');
            if (this.visualMode === 'grayscale') doc.classList.add('accessibility-grayscale');
            if (this.visualMode === 'invert') doc.classList.add('accessibility-invert');

            // Readability classes
            doc.classList.toggle('accessibility-dyslexic', this.isDyslexic);
            doc.classList.toggle('accessibility-underline-links', this.isUnderlineLinks);
            doc.classList.toggle('accessibility-large-cursor', this.isLargeCursor);
        },

        save() {
            localStorage.setItem('uptpjj_accessibility', JSON.stringify({
                fontSize: this.fontSize,
                visualMode: this.visualMode,
                isDyslexic: this.isDyslexic,
                isUnderlineLinks: this.isUnderlineLinks,
                isLargeCursor: this.isLargeCursor
            }));
        },

        resetAccessibility() {
            this.fontSize = 100;
            this.visualMode = 'normal';
            this.isDyslexic = false;
            this.isUnderlineLinks = false;
            this.isLargeCursor = false;
            this.applyAll();
            localStorage.removeItem('uptpjj_accessibility');
            if (window.speechSynthesis) window.speechSynthesis.cancel();
            this.isSpeaking = false;
        },

        speakPageContent() {
            if (!('speechSynthesis' in window)) {
                alert('Browser Anda tidak mendukung Web Speech API Text-to-Speech.');
                return;
            }

            if (this.isSpeaking) {
                window.speechSynthesis.cancel();
                this.isSpeaking = false;
                return;
            }

            // Extract main content
            const mainEl = document.querySelector('main') || document.querySelector('#main-content') || document.querySelector('article') || document.body;
            let text = mainEl ? mainEl.innerText.substring(0, 1500) : document.title;
            // Clean up text
            text = text.replace(/\s+/g, ' ').trim();

            this.runSpeech(text);
        },

        speakSelectedText() {
            if (!('speechSynthesis' in window)) {
                alert('Browser Anda tidak mendukung Web Speech API Text-to-Speech.');
                return;
            }

            const selection = window.getSelection().toString().trim();
            if (!selection) {
                alert('Silakan blok teks pada halaman terlebih dahulu untuk dibacakan.');
                return;
            }

            this.runSpeech(selection);
        },

        runSpeech(text) {
            window.speechSynthesis.cancel();
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 0.95;
            utterance.pitch = 1.0;

            utterance.onstart = () => { this.isSpeaking = true; };
            utterance.onend = () => { this.isSpeaking = false; };
            utterance.onerror = () => { this.isSpeaking = false; };

            window.speechSynthesis.speak(utterance);
        }
    };
}
</script>
