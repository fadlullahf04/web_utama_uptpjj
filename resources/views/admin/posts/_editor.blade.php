<script>
(function() {
    if (window.richTextEditor) return;
    function createRichTextEditor(config) {
        return {
            mode: 'visual',
            content: config.initialContent || '',
            uploadUrl: config.uploadUrl,
            csrfToken: config.csrfToken,
            isUploading: false,
            uploadProgressText: '',
            wordCount: 0,
            charCount: 0,

            // Image Modal state
            imageModalOpen: false,
            imageTab: 'upload',
            uploadFile: null,
            uploadFileName: '',
            uploadPreview: null,
            urlImageSrc: '',
            urlImageError: false,
            imageCaption: '',
            imageAlt: '',
            modalError: '',

            init() {
                this.$refs.canvas.innerHTML = this.content;
                this.$refs.htmlTextarea.value = this.content;
                this.$refs.contentInput.value = this.content;
                this.updateStats();

                const form = this.$el.closest('form');
                if (form) {
                    form.addEventListener('submit', () => {
                        this.syncToInput();
                    });
                }
            },

            setMode(newMode) {
                if (newMode === this.mode) return;
                if (newMode === 'html') {
                    this.syncToInput();
                    this.$refs.htmlTextarea.value = this.content;
                    this.mode = 'html';
                } else {
                    this.syncFromHtml();
                    this.$refs.canvas.innerHTML = this.content;
                    this.mode = 'visual';
                }
            },

            exec(command, value = null) {
                this.$refs.canvas.focus();
                document.execCommand(command, false, value);
                this.syncToInput();
            },

            execFormatBlock(tag) {
                this.$refs.canvas.focus();
                document.execCommand('formatBlock', false, tag);
                this.syncToInput();
            },

            insertHorizontalRule() {
                this.$refs.canvas.focus();
                document.execCommand('insertHorizontalRule', false, null);
                this.syncToInput();
            },

            openLinkPrompt() {
                const url = prompt('Masukkan URL tautan:', 'https://');
                if (url && url.trim() !== '') {
                    this.$refs.canvas.focus();
                    document.execCommand('createLink', false, url.trim());
                    this.syncToInput();
                }
            },

            syncToInput() {
                this.content = this.$refs.canvas.innerHTML;
                this.$refs.contentInput.value = this.content;
                this.updateStats();
            },

            syncFromHtml() {
                this.content = this.$refs.htmlTextarea.value;
                this.$refs.canvas.innerHTML = this.content;
                this.$refs.contentInput.value = this.content;
                this.updateStats();
            },

            updateStats() {
                const text = this.$refs.canvas.innerText || '';
                const words = text.trim() ? text.trim().split(/\s+/).length : 0;
                this.wordCount = words;
                this.charCount = text.length;
            },

            openImageModal() {
                this.modalError = '';
                this.uploadFile = null;
                this.uploadFileName = '';
                this.uploadPreview = null;
                this.urlImageSrc = '';
                this.urlImageError = false;
                this.imageCaption = '';
                this.imageAlt = '';
                this.imageModalOpen = true;
            },

            previewUploadFile(event) {
                const file = event.target.files[0];
                if (!file) return;

                if (file.size > 5 * 1024 * 1024) {
                    this.modalError = 'Ukuran berkas melebihi batas 5MB';
                    return;
                }

                this.modalError = '';
                this.uploadFile = file;
                this.uploadFileName = file.name;

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.uploadPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            async insertImageAction() {
                this.modalError = '';

                if (this.imageTab === 'upload') {
                    if (!this.uploadFile) {
                        this.modalError = 'Pilih berkas gambar terlebih dahulu';
                        return;
                    }

                    try {
                        this.isUploading = true;
                        this.uploadProgressText = 'Mengunggah gambar ke server...';

                        const formData = new FormData();
                        formData.append('image', this.uploadFile);

                        const response = await fetch(this.uploadUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        if (!response.ok) {
                            const errData = await response.json().catch(() => ({}));
                            throw new Error(errData.message || 'Gagal mengunggah gambar. Pastikan format JPG, PNG, atau WebP.');
                        }

                        const data = await response.json();
                        if (data.success && data.url) {
                            this.insertImageNode(data.url, this.imageCaption, this.imageAlt || this.imageCaption || this.uploadFileName);
                            this.imageModalOpen = false;
                        } else {
                            throw new Error('Respon tidak valid dari server');
                        }
                    } catch (err) {
                        this.modalError = err.message || 'Terjadi kesalahan saat mengunggah.';
                    } finally {
                        this.isUploading = false;
                    }

                } else {
                    const url = this.urlImageSrc ? this.urlImageSrc.trim() : '';
                    if (!url) {
                        this.modalError = 'Masukkan tautan URL gambar terlebih dahulu';
                        return;
                    }

                    this.insertImageNode(url, this.imageCaption, this.imageAlt || this.imageCaption || 'Gambar Berita');
                    this.imageModalOpen = false;
                }
            },

            insertImageNode(src, caption = '', alt = '') {
                this.$refs.canvas.focus();

                let figureHtml = '';
                const safeAlt = (alt || '').replace(/"/g, '&quot;');
                const safeSrc = src.replace(/"/g, '&quot;');

                if (caption && caption.trim() !== '') {
                    figureHtml = `<figure class="my-6 text-center"><img src="${safeSrc}" alt="${safeAlt}" class="rounded-2xl max-w-full h-auto mx-auto shadow-md"><figcaption class="text-xs text-slate-500 mt-2 italic">${caption.trim()}</figcaption></figure><p><br></p>`;
                } else {
                    figureHtml = `<figure class="my-6 text-center"><img src="${safeSrc}" alt="${safeAlt}" class="rounded-2xl max-w-full h-auto mx-auto shadow-md"></figure><p><br></p>`;
                }

                document.execCommand('insertHTML', false, figureHtml);
                this.syncToInput();
            },

            async handlePaste(e) {
                const items = (e.clipboardData || e.originalEvent.clipboardData).items;
                for (let item of items) {
                    if (item.kind === 'file' && item.type.startsWith('image/')) {
                        e.preventDefault();
                        const file = item.getAsFile();
                        await this.uploadAndInsertDirect(file);
                        return;
                    }
                }
            },

            async handleDrop(e) {
                e.preventDefault();
                const files = e.dataTransfer.files;
                if (files && files.length > 0) {
                    for (let file of files) {
                        if (file.type.startsWith('image/')) {
                            await this.uploadAndInsertDirect(file);
                        }
                    }
                }
            },

            async uploadAndInsertDirect(file) {
                try {
                    this.isUploading = true;
                    this.uploadProgressText = `Mengunggah ${file.name || 'gambar'}...`;

                    const formData = new FormData();
                    formData.append('image', file);

                    const response = await fetch(this.uploadUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error('Gagal mengunggah file.');
                    }

                    const data = await response.json();
                    if (data.success && data.url) {
                        this.insertImageNode(data.url, '', file.name || 'Gambar');
                    }
                } catch (err) {
                    alert('Gagal mengunggah gambar: ' + err.message);
                } finally {
                    this.isUploading = false;
                }
            }
        };
    }

    window.richTextEditor = createRichTextEditor;

    if (window.Alpine) {
        window.Alpine.data('richTextEditor', createRichTextEditor);
    } else {
        document.addEventListener('alpine:init', () => {
            Alpine.data('richTextEditor', createRichTextEditor);
        });
    }
})();
</script>

<div x-data="richTextEditor({
    initialContent: @js($content ?? ''),
    uploadUrl: @js($uploadUrl ?? route('admin.posts.upload_image')),
    csrfToken: @js(csrf_token())
})" class="space-y-2">
    
    <div class="flex items-center justify-between mb-1.5">
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
            {{ $label ?? 'Konten Lengkap Berita & Artikel *' }}
        </label>
        
        <!-- Mode Switcher: Visual vs HTML -->
        <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl border border-slate-200">
            <button type="button" 
                    x-on:click="setMode('visual')" 
                    :class="mode === 'visual' ? 'bg-white text-[#006837] shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'" 
                    class="px-2.5 py-1 rounded-lg text-xs transition flex items-center gap-1.5">
                <i class="fa-solid fa-eye text-xs"></i> Visual Editor
            </button>
            <button type="button" 
                    x-on:click="setMode('html')" 
                    :class="mode === 'html' ? 'bg-white text-[#006837] shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'" 
                    class="px-2.5 py-1 rounded-lg text-xs transition flex items-center gap-1.5 font-mono">
                <i class="fa-solid fa-code text-xs"></i> Kode HTML
            </button>
        </div>
    </div>

    <!-- Main Editor Box -->
    <div class="border border-slate-300 rounded-2xl overflow-hidden bg-white shadow-sm focus-within:border-[#006837] focus-within:ring-2 focus-within:ring-[#006837]/20 transition flex flex-col">
        
        <!-- Toolbar (Visible in Visual Mode) -->
        <div x-show="mode === 'visual'" class="bg-slate-50 border-b border-slate-200 p-2 sm:p-2.5 flex flex-wrap items-center gap-1.5 select-none text-slate-700">
            
            <!-- Format Block Dropdown (Heading / Paragraph) -->
            <select x-on:change="execFormatBlock($event.target.value); $event.target.value=''" class="h-8 px-2.5 text-xs bg-white border border-slate-300 rounded-lg text-slate-700 focus:outline-none focus:border-[#006837] font-semibold cursor-pointer">
                <option value="" disabled selected>Format Teks</option>
                <option value="p">Paragraf Normal</option>
                <option value="h2">Judul Bagian (H2)</option>
                <option value="h3">Sub-Judul (H3)</option>
                <option value="h4">Judul Kecil (H4)</option>
                <option value="blockquote">Kutipan (Blockquote)</option>
            </select>

            <span class="w-px h-5 bg-slate-300 mx-1"></span>

            <!-- Inline Styles -->
            <div class="flex items-center gap-0.5">
                <button type="button" x-on:click="exec('bold')" title="Tebal (Ctrl+B)" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-bold"></i>
                </button>
                <button type="button" x-on:click="exec('italic')" title="Miring (Ctrl+I)" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-italic"></i>
                </button>
                <button type="button" x-on:click="exec('underline')" title="Garis Bawah (Ctrl+U)" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-underline"></i>
                </button>
                <button type="button" x-on:click="exec('strikeThrough')" title="Coret (Strikethrough)" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-strikethrough"></i>
                </button>
            </div>

            <span class="w-px h-5 bg-slate-300 mx-1"></span>

            <!-- Alignment -->
            <div class="flex items-center gap-0.5">
                <button type="button" x-on:click="exec('justifyLeft')" title="Rata Kiri" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-align-left"></i>
                </button>
                <button type="button" x-on:click="exec('justifyCenter')" title="Rata Tengah" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-align-center"></i>
                </button>
                <button type="button" x-on:click="exec('justifyRight')" title="Rata Kanan" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-align-right"></i>
                </button>
                <button type="button" x-on:click="exec('justifyFull')" title="Rata Kanan Kiri" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-align-justify"></i>
                </button>
            </div>

            <span class="w-px h-5 bg-slate-300 mx-1"></span>

            <!-- Lists & Blocks -->
            <div class="flex items-center gap-0.5">
                <button type="button" x-on:click="exec('insertUnorderedList')" title="Daftar Poin (Bullet List)" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-list-ul"></i>
                </button>
                <button type="button" x-on:click="exec('insertOrderedList')" title="Daftar Nomor (Numbered List)" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-list-ol"></i>
                </button>
                <button type="button" x-on:click="insertHorizontalRule" title="Garis Pemisah (Horizontal Rule)" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-minus"></i>
                </button>
            </div>

            <span class="w-px h-5 bg-slate-300 mx-1"></span>

            <!-- Links & Media -->
            <div class="flex items-center gap-1">
                <button type="button" x-on:click="openLinkPrompt" title="Sisipkan Tautan Link" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-link"></i>
                </button>
                <button type="button" x-on:click="exec('unlink')" title="Hapus Link" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-link-slash"></i>
                </button>
                
                <!-- Dedicated Add Image Button -->
                <button type="button" 
                        x-on:click="openImageModal" 
                        class="h-8 px-3 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-[#006837] font-bold text-xs flex items-center gap-1.5 border border-emerald-300 transition shadow-xs">
                    <i class="fa-solid fa-image"></i> Sisipkan Gambar
                </button>
            </div>

            <span class="w-px h-5 bg-slate-300 mx-1"></span>

            <!-- Undo / Redo & Clear -->
            <div class="flex items-center gap-0.5 ml-auto">
                <button type="button" x-on:click="exec('undo')" title="Undo (Ctrl+Z)" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-rotate-left"></i>
                </button>
                <button type="button" x-on:click="exec('redo')" title="Redo (Ctrl+Y)" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-rotate-right"></i>
                </button>
                <button type="button" x-on:click="exec('removeFormat')" title="Hapus Format" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-text-slash"></i>
                </button>
            </div>

        </div>

        <!-- HTML Mode Notice -->
        <div x-show="mode === 'html'" class="bg-slate-900 text-emerald-400 px-4 py-2 border-b border-slate-800 text-[11px] font-mono flex items-center justify-between">
            <span class="flex items-center gap-1.5">
                <i class="fa-solid fa-terminal text-xs"></i> Mode Penyuntingan Kode Sumber HTML Langsung
            </span>
            <span class="text-slate-400 text-[10px]">Perubahan tersinkronisasi otomatis saat beralih ke Visual</span>
        </div>

        <!-- Visual Canvas Area -->
        <div x-show="mode === 'visual'"
             x-ref="canvas"
             contenteditable="true"
             x-on:input="syncToInput"
             x-on:blur="syncToInput"
             x-on:paste="handlePaste($event)"
             x-on:drop="handleDrop($event)"
             x-on:dragover.prevent
             class="article-content p-6 sm:p-8 max-h-[750px] overflow-y-auto focus:outline-none text-slate-800 text-sm leading-relaxed"
             style="min-height: {{ $minHeight ?? '320px' }}; cursor: text;">
        </div>

        <!-- HTML Source Textarea -->
        <textarea x-show="mode === 'html'"
                  x-ref="htmlTextarea"
                  x-on:input="syncFromHtml"
                  class="w-full p-6 sm:p-8 max-h-[750px] font-mono text-xs text-emerald-300 bg-slate-900 focus:outline-none resize-y leading-relaxed border-0"
                  style="min-height: {{ $minHeight ?? '320px' }};"
                  rows="14"
                  placeholder="Ketikkan kode HTML di sini..."></textarea>

        <!-- Hidden Textarea for Standard Form Submit -->
        <textarea name="{{ $name ?? 'content' }}" x-ref="contentInput" class="hidden" {{ (!isset($required) || $required) ? 'required' : '' }}>{{ $content ?? '' }}</textarea>

        <!-- Editor Footer Info & Upload Notification -->
        <div class="bg-slate-50 border-t border-slate-200 px-4 py-2.5 flex flex-wrap items-center justify-between gap-3 text-[11px] text-slate-500">
            <div class="flex items-center gap-4">
                <span><strong class="text-slate-800 font-bold" x-text="wordCount">0</strong> kata</span>
                <span>•</span>
                <span><strong class="text-slate-800 font-bold" x-text="charCount">0</strong> karakter</span>
            </div>

            <!-- Uploading Indicator -->
            <div x-show="isUploading" x-cloak class="flex items-center gap-2 text-emerald-700 font-semibold bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 animate-pulse">
                <i class="fa-solid fa-circle-notch fa-spin"></i>
                <span x-text="uploadProgressText">Mengunggah gambar...</span>
            </div>

            <div x-show="!isUploading" class="hidden sm:flex items-center gap-2 text-slate-400">
                <i class="fa-regular fa-lightbulb text-amber-500"></i>
                <span>Tips: Anda dapat menempelkan gambar (Ctrl+V) atau drag-and-drop file gambar langsung ke kanvas.</span>
            </div>
        </div>

    </div>

    <!-- Image Insert Modal -->
    <div x-show="imageModalOpen" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4"
         x-on:keydown.escape.window="imageModalOpen = false">
        
        <div x-on:click.outside="imageModalOpen = false" 
             class="bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-lg w-full overflow-hidden transform transition-all p-6 space-y-5">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-image text-[#006837]"></i> Sisipkan Gambar ke Konten
                </h3>
                <button type="button" x-on:click="imageModalOpen = false" class="text-slate-400 hover:text-slate-700 text-sm p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Tabs: Upload vs External URL -->
            <div class="flex rounded-xl bg-slate-100 p-1 text-xs font-semibold">
                <button type="button" 
                        x-on:click="imageTab = 'upload'" 
                        :class="imageTab === 'upload' ? 'bg-white text-[#006837] shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900'"
                        class="flex-1 py-2 rounded-lg text-center transition flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-cloud-arrow-up"></i> Unggah dari Komputer
                </button>
                <button type="button" 
                        x-on:click="imageTab = 'url'" 
                        :class="imageTab === 'url' ? 'bg-white text-[#006837] shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900'"
                        class="flex-1 py-2 rounded-lg text-center transition flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-link"></i> Tautan URL Gambar
                </button>
            </div>

            <!-- Tab 1: Upload from Local Machine -->
            <div x-show="imageTab === 'upload'" class="space-y-4">
                <div class="border-2 border-dashed border-slate-300 hover:border-[#006837] rounded-2xl p-6 text-center cursor-pointer transition bg-slate-50/50 hover:bg-emerald-50/30"
                     x-on:click="$refs.fileInput.click()">
                    
                    <input type="file" 
                           x-ref="fileInput" 
                           accept="image/jpeg,image/png,image/webp,image/gif" 
                           x-on:change="previewUploadFile($event)" 
                           class="hidden">

                    <template x-if="!uploadPreview">
                        <div class="space-y-2">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 text-[#006837] mx-auto flex items-center justify-center text-xl">
                                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            </div>
                            <div class="text-xs font-bold text-slate-700">Klik untuk memilih gambar atau seret file ke sini</div>
                            <div class="text-[11px] text-slate-400">JPG, PNG, WebP, GIF (Maksimal 5MB)</div>
                        </div>
                    </template>

                    <template x-if="uploadPreview">
                        <div class="space-y-2">
                            <img :src="uploadPreview" class="max-h-40 mx-auto rounded-xl shadow-sm object-contain border border-slate-200">
                            <div class="text-xs font-semibold text-emerald-700 flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-circle-check"></i> File dipilih: <span x-text="uploadFileName" class="truncate max-w-[200px]"></span>
                            </div>
                            <span class="text-[11px] text-slate-400 underline hover:text-slate-600 block">Klik untuk mengganti gambar</span>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Tab 2: Image URL -->
            <div x-show="imageTab === 'url'" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat URL Gambar *</label>
                    <input type="url" 
                           x-model="urlImageSrc" 
                           placeholder="https://images.unsplash.com/... atau URL gambar online" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <template x-if="urlImageSrc">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-center">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block mb-1.5">Preview Tautan:</span>
                        <img :src="urlImageSrc" x-on:error="urlImageError = true" x-on:load="urlImageError = false" class="max-h-36 mx-auto rounded-lg object-contain shadow-xs">
                        <div x-show="urlImageError" class="text-red-500 text-[11px] mt-1 font-medium">Gambar tidak dapat dimuat dari URL ini</div>
                    </div>
                </template>
            </div>

            <!-- Common Fields: Caption & Alt Text -->
            <div class="space-y-3 pt-2 border-t border-slate-100">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Keterangan Gambar / Caption (Opsional)
                    </label>
                    <input type="text" 
                           x-model="imageCaption" 
                           placeholder="Contoh: Suasana perkuliahan virtual mahasiswa PJJ UINSSC" 
                           class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Deskripsi Alt Text (SEO & Aksesibilitas)
                    </label>
                    <input type="text" 
                           x-model="imageAlt" 
                           placeholder="Deskripsi singkat isi gambar" 
                           class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                </div>
            </div>

            <!-- Error Notification in Modal -->
            <div x-show="modalError" x-cloak class="p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span x-text="modalError"></span>
            </div>

            <!-- Modal Action Buttons -->
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" 
                        x-on:click="imageModalOpen = false" 
                        class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    Batal
                </button>
                
                <button type="button" 
                        x-on:click="insertImageAction" 
                        :disabled="isUploading || (imageTab === 'upload' && !uploadFile) || (imageTab === 'url' && !urlImageSrc)"
                        class="px-5 py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] disabled:opacity-50 disabled:cursor-not-allowed text-white text-xs font-bold uppercase tracking-wider transition shadow-md shadow-[#006837]/20 flex items-center gap-2">
                    <template x-if="isUploading">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-notch fa-spin"></i> Mengunggah...
                        </span>
                    </template>
                    <template x-if="!isUploading">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-plus-circle"></i> Masukkan Gambar
                        </span>
                    </template>
                </button>
            </div>

        </div>
    </div>

</div>
