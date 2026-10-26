<!-- Contact Center & Live Virtual Assistant Floating Widget -->
<div x-data="contactCenterWidget()" x-init="initWidget()" class="relative z-50">
    
    <!-- Floating Trigger Launcher (Bottom-Right) -->
    <div class="fixed bottom-6 right-6 z-40 flex items-center gap-2 group">
        <button @click="toggleChat()" 
                type="button" 
                class="flex items-center gap-3 px-4 sm:px-5 py-3 rounded-full bg-gradient-to-r from-[#006837] to-[#004d29] hover:from-[#00522c] hover:to-[#00381d] text-white shadow-2xl shadow-emerald-950/40 border border-emerald-500/50 transition-all duration-300 transform hover:scale-105 cursor-pointer focus:outline-none focus:ring-4 focus:ring-emerald-500/50"
                aria-label="Buka Contact Center & Tanya Jawab Langsung"
                title="Contact Center & Tanya Jawab Langsung UPT PJJ">
            <!-- Pulsing Online Indicator -->
            <div class="relative flex items-center justify-center">
                <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-400"></span>
            </div>
            
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-headset text-sm text-emerald-200"></i>
                <div class="text-left leading-tight">
                    <span class="text-xs font-extrabold tracking-wide block">Contact Center</span>
                    <span class="text-[9px] text-emerald-200/90 font-medium hidden sm:block">Tanya Jawab Langsung 24/7</span>
                </div>
            </div>

            <span class="text-[9px] px-2 py-0.5 rounded-full bg-amber-400 text-slate-950 font-extrabold uppercase shrink-0">Live</span>
        </button>
    </div>

    <!-- Contact Center Interactive Drawer / Modal -->
    <div x-show="isOpen" 
         x-cloak 
         @click.away="isOpen = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-6 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-6 scale-95"
         class="fixed bottom-22 right-4 sm:right-6 z-50 w-[94vw] sm:w-[420px] h-[580px] max-h-[85vh] bg-white rounded-3xl border border-slate-200 shadow-2xl flex flex-col overflow-hidden text-slate-800">

        <!-- Header -->
        <div class="p-4 bg-gradient-to-r from-[#006837] via-[#005c31] to-[#004d29] text-white flex items-center justify-between shrink-0 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 rounded-2xl bg-white/15 border border-white/20 flex items-center justify-center text-amber-300 text-lg shadow-inner">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 border-2 border-slate-900 rounded-full"></span>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-bold text-white flex items-center gap-1.5">
                        Careline & Asisten Virtual
                        <span class="text-[9px] px-1.5 py-0.2 rounded-full bg-amber-400 text-slate-950 font-extrabold">Online</span>
                    </h3>
                    <p class="text-[11px] text-emerald-100/80">UPT PJJ UIN Siber Syekh Nurjati Cirebon</p>
                </div>
            </div>
            <button @click="isOpen = false" type="button" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-xs transition cursor-pointer" aria-label="Tutup jendela chat">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex items-center border-b border-slate-200 bg-slate-50/80 shrink-0 text-xs">
            <button @click="activeTab = 'chat'" 
                    class="flex-1 py-2.5 font-bold transition flex items-center justify-center gap-2 border-b-2 cursor-pointer"
                    :class="activeTab === 'chat' ? 'border-[#006837] text-[#006837] bg-white' : 'border-transparent text-slate-500 hover:text-slate-800'">
                <i class="fa-solid fa-robot"></i> Tanya Langsung
            </button>
            <button @click="activeTab = 'channels'" 
                    class="flex-1 py-2.5 font-bold transition flex items-center justify-center gap-2 border-b-2 cursor-pointer"
                    :class="activeTab === 'channels' ? 'border-[#006837] text-[#006837] bg-white' : 'border-transparent text-slate-500 hover:text-slate-800'">
                <i class="fa-solid fa-phone-volume"></i> Saluran Kontak
            </button>
        </div>

        <!-- Tab 1: Live Interactive Q&A (Virtual Assistant) -->
        <div x-show="activeTab === 'chat'" class="flex-1 flex flex-col min-h-0 bg-slate-50/50">
            
            <!-- Message Stream Area -->
            <div id="contact-chat-messages" class="flex-1 p-4 overflow-y-auto space-y-3.5 text-xs">
                
                <template x-for="(msg, index) in messages" :key="index">
                    <div class="flex gap-2.5" :class="msg.sender === 'user' ? 'justify-end' : 'justify-start'">
                        
                        <!-- Bot Avatar -->
                        <template x-if="msg.sender === 'bot'">
                            <div class="w-7 h-7 rounded-full bg-emerald-100 border border-emerald-300 flex items-center justify-center text-[#006837] text-xs shrink-0 mt-0.5">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                        </template>

                        <!-- Bubble -->
                        <div class="max-w-[85%] rounded-2xl p-3 shadow-xs space-y-1.5"
                             :class="msg.sender === 'user' ? 'bg-[#006837] text-white rounded-tr-none' : 'bg-white text-slate-800 border border-slate-200 rounded-tl-none'">
                            
                            <p class="leading-relaxed whitespace-pre-line" x-html="msg.text"></p>
                            
                            <!-- Action button if present -->
                            <template x-if="msg.action">
                                <div class="pt-1.5 border-t border-slate-100/80">
                                    <a :href="msg.action.url" :target="msg.action.target || '_self'" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-bold shadow-xs transition"
                                       :class="msg.sender === 'user' ? 'bg-amber-400 text-slate-950 hover:bg-amber-300' : 'bg-[#006837] text-white hover:bg-[#004d29]'">
                                        <span x-text="msg.action.label"></span>
                                        <i class="fa-solid fa-arrow-right text-[9px]"></i>
                                    </a>
                                </div>
                            </template>

                            <span class="text-[9px] block text-right opacity-70" x-text="msg.time"></span>
                        </div>
                    </div>
                </template>

                <!-- Typing indicator -->
                <div x-show="isTyping" class="flex items-center gap-2 text-slate-400 text-[11px] pl-9">
                    <i class="fa-solid fa-ellipsis animate-pulse text-base text-emerald-600"></i>
                    <span>Asisten sedang mengetik...</span>
                </div>

            </div>

            <!-- Quick Suggestion Chips (Tanya Cepat Sekali Klik) -->
            <div class="p-3 bg-white border-t border-slate-200/80 shrink-0 space-y-1.5">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Pilihan Pertanyaan Populer:</span>
                <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1">
                    <button @click="askQuick('Bagaimana legalitas ijazah PJJ?')" class="whitespace-nowrap px-2.5 py-1 rounded-full bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-[#006837] border border-slate-200 text-[11px] font-semibold transition cursor-pointer">
                        🎓 Legalitas Ijazah
                    </button>
                    <button @click="askQuick('Berapa biaya kuliah per semester?')" class="whitespace-nowrap px-2.5 py-1 rounded-full bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-[#006837] border border-slate-200 text-[11px] font-semibold transition cursor-pointer">
                        💰 Biaya Kuliah
                    </button>
                    <button @click="askQuick('Bagaimana cara mendaftar PMB online?')" class="whitespace-nowrap px-2.5 py-1 rounded-full bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-[#006837] border border-slate-200 text-[11px] font-semibold transition cursor-pointer">
                        📝 Alur PMB
                    </button>
                    <button @click="askQuick('Bagaimana cara belajar di LMS Pillar?')" class="whitespace-nowrap px-2.5 py-1 rounded-full bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-[#006837] border border-slate-200 text-[11px] font-semibold transition cursor-pointer">
                        💻 Sistem LMS
                    </button>
                    <button @click="askQuick('Program studi apa saja yang tersedia?')" class="whitespace-nowrap px-2.5 py-1 rounded-full bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-[#006837] border border-slate-200 text-[11px] font-semibold transition cursor-pointer">
                        🏛️ Pilihan Prodi
                    </button>
                    <button @click="askQuick('Apakah ada beasiswa Kemenag atau LPDP?')" class="whitespace-nowrap px-2.5 py-1 rounded-full bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-[#006837] border border-slate-200 text-[11px] font-semibold transition cursor-pointer">
                        🤝 Info Beasiswa
                    </button>
                </div>
            </div>

            <!-- Chat Input Box -->
            <form @submit.prevent="sendMessage()" class="p-3 bg-white border-t border-slate-100 flex items-center gap-2 shrink-0">
                <input type="text" 
                       x-model="userInput" 
                       placeholder="Ketik pertanyaan Anda di sini..." 
                       class="flex-1 px-4 py-2.5 rounded-xl bg-slate-100 border border-slate-200 focus:bg-white focus:border-[#006837] focus:ring-2 focus:ring-emerald-500/20 text-xs text-slate-800 transition outline-none">
                <button type="submit" 
                        class="w-10 h-10 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white flex items-center justify-center shrink-0 transition cursor-pointer shadow-sm">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </form>

        </div>

        <!-- Tab 2: Official Contact Channels (WA, Phone, Email, Office) -->
        <div x-show="activeTab === 'channels'" class="flex-1 p-5 overflow-y-auto space-y-4 text-xs bg-slate-50/50">
            
            <div class="text-center space-y-1 pb-2 border-b border-slate-200">
                <h4 class="font-bold text-slate-900 text-sm">Saluran Layanan Terpadu UPT PJJ</h4>
                <p class="text-[11px] text-slate-500">Hubungi petugas resmi kami melalui saluran komunikasi terverifikasi.</p>
            </div>

            <!-- WhatsApp Direct Button -->
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '628112345678')) }}?text=Halo%20Admin%20UPT%20PJJ%20UINSSC,%20saya%20ingin%20berkonsultasi%20terkait%20perkuliahan%20PJJ" target="_blank" class="p-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white shadow-md flex items-center justify-between gap-3 transition group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-brands fa-whatsapp text-white"></i>
                    </div>
                    <div>
                        <div class="font-bold text-white text-xs">WhatsApp Helpdesk Resmi</div>
                        <div class="text-[11px] text-emerald-100">+62 811-2345-678 (Fast Response)</div>
                    </div>
                </div>
                <i class="fa-solid fa-arrow-up-right-from-square text-xs group-hover:translate-x-0.5 transition-transform"></i>
            </a>

            <!-- Phone Direct -->
            <a href="tel:{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('phone', '0231481264')) }}" class="p-3.5 rounded-2xl bg-white hover:bg-slate-100 text-slate-800 border border-slate-200 shadow-xs flex items-center justify-between gap-3 transition group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg shrink-0">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 text-xs">Telepon Kantor UPT PJJ</div>
                        <div class="text-[11px] text-slate-500">{{ \App\Models\Setting::get('phone', '(0231) 481264') }}</div>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-blue-600">Panggil ↗</span>
            </a>

            <!-- Email Direct -->
            <a href="mailto:{{ \App\Models\Setting::get('email', 'pjj@uinssc.ac.id') }}" class="p-3.5 rounded-2xl bg-white hover:bg-slate-100 text-slate-800 border border-slate-200 shadow-xs flex items-center justify-between gap-3 transition group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg shrink-0">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 text-xs">Email Korespondensi Resmi</div>
                        <div class="text-[11px] text-slate-500">{{ \App\Models\Setting::get('email', 'pjj@uinssc.ac.id') }}</div>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-amber-600">Kirim ↗</span>
            </a>

            <!-- Physical Office & Operational Hours -->
            <div class="p-3.5 rounded-2xl bg-white border border-slate-200 shadow-xs space-y-2">
                <div class="flex items-center gap-2 font-bold text-slate-900 text-xs text-[#006837]">
                    <i class="fa-solid fa-building-columns"></i> Sentra Layanan Terpadu (Luring)
                </div>
                <p class="text-[11px] text-slate-600 leading-relaxed">
                    {{ \App\Models\Setting::get('address', 'Gedung Siber Lt. 3, Kampus UIN Siber Syekh Nurjati Cirebon, Jl. Perjuangan By Pass Sunyaragi, Kota Cirebon') }}
                </p>
                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                    <span><i class="fa-solid fa-clock text-amber-500 mr-1"></i> Jam Layanan:</span>
                    <span class="font-bold text-slate-700">Senin - Jumat, 08.00 - 16.00 WIB</span>
                </div>
            </div>

            <!-- Form Kontak Web -->
            <div class="pt-1">
                <a href="{{ route('contact.index') }}" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-[#006837] text-white font-bold text-xs text-center block transition shadow">
                    Buka Formulir Tiket Pengaduan Web →
                </a>
            </div>

        </div>

    </div>

</div>

<script>
function contactCenterWidget() {
    return {
        isOpen: false,
        activeTab: 'chat',
        userInput: '',
        isTyping: false,
        messages: [],

        initWidget() {
            // Initial greeting
            this.messages = [
                {
                    sender: 'bot',
                    text: 'Assalamu\'alaikum wr. wb. 👋\n\nSelamat datang di **Contact Center & Asisten Virtual UPT PJJ UIN Siber Syekh Nurjati Cirebon**.\n\nAda yang dapat kami bantu seputar pendaftaran mahasiswa baru (PMB), biaya kuliah, sistem LMS Pillar, atau legalitas ijazah?',
                    time: this.getTime()
                }
            ];
        },

        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.$nextTick(() => { this.scrollToBottom(); });
            }
        },

        getTime() {
            const now = new Date();
            return now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
        },

        scrollToBottom() {
            const el = document.getElementById('contact-chat-messages');
            if (el) {
                el.scrollTop = el.scrollHeight;
            }
        },

        askQuick(question) {
            this.userInput = question;
            this.sendMessage();
        },

        sendMessage() {
            const query = this.userInput.trim();
            if (!query) return;

            // Push User Message
            this.messages.push({
                sender: 'user',
                text: query,
                time: this.getTime()
            });

            this.userInput = '';
            this.isTyping = true;
            this.$nextTick(() => { this.scrollToBottom(); });

            // Generate Smart Automated Response
            setTimeout(() => {
                const answerObj = this.generateResponse(query);
                this.messages.push({
                    sender: 'bot',
                    text: answerObj.text,
                    action: answerObj.action || null,
                    time: this.getTime()
                });
                this.isTyping = false;
                this.$nextTick(() => { this.scrollToBottom(); });
            }, 600);
        },

        generateResponse(input) {
            const q = input.toLowerCase();

            // 1. Legalitas Ijazah
            if (q.includes('ijazah') || q.includes('legalitas') || q.includes('pddikti') || q.includes('akui') || q.includes('sama')) {
                return {
                    text: '✅ **Legalitas Ijazah PJJ 100% Setara dan Sah:**\n\nIjazah yang diterbitkan oleh UIN Siber Syekh Nurjati Cirebon untuk lulusan PJJ memiliki status hukum, hak akademik, dan pengakuan resmi yang sama persis dengan program reguler tatap muka. Ijazah terdaftar resmi di PDDikti Kemendikbudristek dan Kemenag RI, serta berhak digunakan melamar CPNS, PPPK, kenaikan pangkat, maupun lanjut S2/S3.',
                    action: { label: 'Lihat Dasar Hukum & Profil', url: '/profil/selayang-pandang' }
                };
            }

            // 2. Biaya Kuliah / UKT
            if (q.includes('biaya') || q.includes('ukt') || q.includes('bayar') || q.includes('harga') || q.includes('cicil') || q.includes('uang')) {
                return {
                    text: '💰 **Biaya Kuliah (UKT) Sangat Terjangkau:**\n\nBiaya pendidikan di UPT PJJ UINSSC disubsidi oleh pemerintah (Kemenag & skema BLU). Tidak ada uang pangkal atau sumbangan gedung yang membebani. Pembayaran dilakukan per semester secara online melalui Virtual Account bank nasional (BSI, Mandiri, BRI, BNI).',
                    action: { label: 'Info Biaya & Pendaftaran PMB', url: 'https://pmb.uinssc.ac.id', target: '_blank' }
                };
            }

            // 3. Pendaftaran / PMB / Syarat
            if (q.includes('daftar') || q.includes('pmb') || q.includes('syarat') || q.includes('registrasi') || q.includes('masuk') || q.includes('cara daftar')) {
                return {
                    text: '📝 **Pendaftaran Mahasiswa Baru (PMB) PJJ:**\n\n1. Dilakukan 100% online di portal resmi pmb.uinssc.ac.id\n2. Terbuka bagi lulusan SMA/SMK/MA/Pesantren sederajat tanpa batasan usia maupun tahun kelulusan.\n3. Syarat berkas: Scan Ijazah/SKL, KTP/KK, dan pasfoto terbaru.\n4. Kuliah 100% online dari rumah tanpa perlu datang ke kampus.',
                    action: { label: 'Buka Portal PMB Online', url: 'https://pmb.uinssc.ac.id', target: '_blank' }
                };
            }

            // 4. Sistem Belajar / LMS Pillar / Ujian
            if (q.includes('lms') || q.includes('pillar') || q.includes('kuliah') || q.includes('ujian') || q.includes('belajar') || q.includes('absen') || q.includes('hadir')) {
                return {
                    text: '💻 **Sistem Belajar Mandiri LMS Pillar:**\n\nPerkuliahan dilakukan secara asinkron (fleksibel 24/7) melalui platform LMS Pillar. Mahasiswa mengakses modul digital, video kuliah interaktif, forum diskusi dosen, kuis, dan ujian online. Kehadiran tercatat otomatis saat Anda berinteraksi dengan bahan ajar.',
                    action: { label: 'Buka Panduan Tutorial LMS', url: '/panduan-lms' }
                };
            }

            // 5. Program Studi / Jurusan
            if (q.includes('prodi') || q.includes('jurusan') || q.includes('program studi') || q.includes('s1') || q.includes('s2') || q.includes('magister')) {
                return {
                    text: '🏛️ **Program Studi Pendidikan Jarak Jauh UINSSC:**\n\n• **S1 PAI** (Pendidikan Agama Islam) - Akreditasi Unggul\n• **S1 PGMI** (Pendidikan Guru Madrasah Ibtidaiyah) - Akreditasi Baik Sekali\n• **S1 PBA** (Pendidikan Bahasa Arab) - Akreditasi Baik Sekali\n• **S1 HKI** (Hukum Keluarga Islam) - Akreditasi Baik Sekali\n• **S1 SPI** (Sejarah Peradaban Islam) - Akreditasi Baik\n• **S2 Magister PAI** (Pendidikan Agama Islam) - Akreditasi Unggul',
                    action: { label: 'Lihat Seluruh Prodi PJJ', url: '/prodi' }
                };
            }

            // 6. Beasiswa
            if (q.includes('beasiswa') || q.includes('lpdp') || q.includes('kemenag') || q.includes('keringanan') || q.includes('bib')) {
                return {
                    text: '🤝 **Program Beasiswa & Bantuan Pendidikan:**\n\nTersedia beasiswa Kementerian Agama RI untuk guru madrasah dan pondok pesantren, Beasiswa Indonesia Bangkit (BIB) LPDP, serta kemitraan beasiswa pemda di berbagai sentra layanan daerah (UPBJJ).',
                    action: { label: 'Pelajari Sentra UPBJJ', url: '/halaman/upbjj' }
                };
            }

            // 7. Kontak / WhatsApp / Alamat
            if (q.includes('wa') || q.includes('whatsapp') || q.includes('nomor') || q.includes('telepon') || q.includes('alamat') || q.includes('kantor') || q.includes('lokasi')) {
                return {
                    text: '📞 **Kontak & Lokasi Kantor Resmi:**\n\n• WhatsApp Helpdesk: +62 811-2345-678\n• Telepon: (0231) 481264\n• Email: pjj@uinssc.ac.id\n• Alamat: Gedung Siber Lt. 3, Kampus UIN Siber Syekh Nurjati Cirebon, Jl. Perjuangan By Pass Sunyaragi, Kota Cirebon.',
                    action: { label: 'Chat Langsung WhatsApp', url: 'https://wa.me/628112345678', target: '_blank' }
                };
            }

            // Fallback general response
            return {
                text: 'Terima kasih atas pertanyaannya. Terkait hal tersebut, Anda dapat membaca informasi lengkap di portal panduan kami, atau berkonsultasi langsung dengan petugas Helpdesk melalui WhatsApp.',
                action: { label: 'Chat Helpdesk via WhatsApp', url: 'https://wa.me/628112345678', target: '_blank' }
            };
        }
    };
}
</script>
