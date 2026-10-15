@extends('layouts.admin')

@section('title', 'Manajemen Pengguna CMS')
@section('header_title', 'Manajemen Pengguna')
@section('header_subtitle', 'Kelola hak akses administrator dan editor konten')

@section('content')
<div x-data="{ 
    editModal: false, 
    editUser: { id: null, name: '', email: '', role: 'editor', phone: '', bio: '', is_active: true } 
}" class="space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Form Tambah User (4 cols) -->
        <div class="lg:col-span-4">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-user-plus text-[#006837]"></i> Tambah Akun CMS
                </h3>
                
                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap *</label>
                        <input type="text" name="name" required placeholder="Contoh: Budi Santoso" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email *</label>
                        <input type="email" name="email" required placeholder="nama@uinssc.ac.id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kata Sandi (Password) *</label>
                        <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Peran (Role) *</label>
                        <select name="role" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            <option value="admin">Super Admin (Akses Penuh)</option>
                            <option value="editor">Editor / Humas (Kelola Berita & Pengumuman)</option>
                            <option value="staf">Staf Helpdesk</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Foto Profil / Avatar (Komputer)</label>
                        <input type="file" name="avatar" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-100 file:text-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Telepon / WA</label>
                        <input type="text" name="phone" placeholder="081..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div x-data="{
                        insertUserTag(before, after) {
                            const el = this.$refs.userBioInput;
                            const start = el.selectionStart || 0;
                            const end = el.selectionEnd || 0;
                            const selected = el.value.substring(start, end);
                            el.value = el.value.substring(0, start) + before + selected + after + el.value.substring(end);
                            el.focus();
                            el.setSelectionRange(start + before.length, end + before.length);
                        }
                    }" class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Bio Singkat</label>
                            <div class="flex items-center gap-0.5 bg-slate-100 p-0.5 rounded-lg border border-slate-200 text-xs">
                                <button type="button" @click="insertUserTag('<strong>', '</strong>')" title="Tebal" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center font-bold text-[11px]">B</button>
                                <button type="button" @click="insertUserTag('<em>', '</em>')" title="Miring" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center italic font-serif text-[11px]">I</button>
                            </div>
                        </div>
                        <textarea name="bio" x-ref="userBioInput" rows="2" placeholder="Keterangan singkat staf/admin..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed"></textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white font-bold text-xs uppercase tracking-wider transition shadow-md shadow-[#006837]/20">
                        Daftarkan Akun
                    </button>
                </form>
            </div>
        </div>

        <!-- Table Daftar User (8 cols) -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-900">Daftar Pengguna Aktif</h3>
                </div>
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4 font-bold">Pengguna</th>
                            <th class="py-3 px-4 font-bold">Peran (Role)</th>
                            <th class="py-3 px-4 font-bold">Status</th>
                            <th class="py-3 px-4 font-bold">Terdaftar</th>
                            <th class="py-3 px-4 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($users as $u)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $u->avatar_url }}" alt="{{ $u->name }}" class="w-8 h-8 rounded-full object-cover border border-slate-200">
                                        <div>
                                            <div class="font-bold text-slate-900">{{ $u->name }}</div>
                                            <div class="text-[11px] text-slate-500">{{ $u->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded {{ $u->role === 'admin' ? 'bg-emerald-100 text-[#006837] border border-emerald-200' : 'bg-slate-100 text-slate-700' }} text-[10px] font-bold uppercase">
                                        {{ $u->role }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($u->is_active)
                                        <span class="text-[#006837] font-semibold text-[10px]">● Aktif</span>
                                    @else
                                        <span class="text-slate-400 text-[10px]">○ Non-aktif</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-slate-500 text-[11px]">{{ $u->created_at->format('d M Y') }}</td>
                                <td class="py-3 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button" 
                                            @click="editUser = { id: {{ $u->id }}, name: @js($u->name), email: @js($u->email), role: @js($u->role), phone: @js($u->phone ?? ''), bio: @js($u->bio ?? ''), is_active: {{ $u->is_active ? 'true' : 'false' }} }; editModal = true" 
                                            class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-amber-600 hover:bg-slate-200 transition" 
                                            title="Edit Pengguna">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </button>
                                        @if(auth()->id() !== $u->id)
                                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-red-600 hover:bg-slate-200 transition" title="Hapus">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[10px] text-slate-400 italic px-1">Anda</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Edit User -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="editModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="editModal = false"></div>

        <div x-show="editModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative z-10 w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden my-8">
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-user-pen text-[#006837]"></i> Edit Pengguna CMS
                    </h3>
                    <button type="button" @click="editModal = false" class="text-slate-400 hover:text-slate-700 text-base">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form :action="'{{ url('/admin/users') }}/' + editUser.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap *</label>
                        <input type="text" name="name" x-model="editUser.name" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email *</label>
                        <input type="email" name="email" x-model="editUser.email" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Peran (Role) *</label>
                        <select name="role" x-model="editUser.role" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                            <option value="admin">Super Admin (Akses Penuh)</option>
                            <option value="editor">Editor / Humas (Kelola Berita & Pengumuman)</option>
                            <option value="staf">Staf Helpdesk</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ganti Foto Profil / Avatar (Opsional)</label>
                        <input type="file" name="avatar" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-100 file:text-[#006837]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Telepon / WA</label>
                        <input type="text" name="phone" x-model="editUser.phone" placeholder="081..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div x-data="{
                        insertEditUserTag(before, after) {
                            const el = this.$refs.editUserBioInput;
                            const start = el.selectionStart || 0;
                            const end = el.selectionEnd || 0;
                            const selected = el.value.substring(start, end);
                            el.value = el.value.substring(0, start) + before + selected + after + el.value.substring(end);
                            editUser.bio = el.value;
                            el.focus();
                            el.setSelectionRange(start + before.length, end + before.length);
                        }
                    }" class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Bio Singkat</label>
                            <div class="flex items-center gap-0.5 bg-slate-100 p-0.5 rounded-lg border border-slate-200 text-xs">
                                <button type="button" @click="insertEditUserTag('<strong>', '</strong>')" title="Tebal" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center font-bold text-[11px]">B</button>
                                <button type="button" @click="insertEditUserTag('<em>', '</em>')" title="Miring" class="w-5 h-5 rounded hover:bg-white text-slate-700 flex items-center justify-center italic font-serif text-[11px]">I</button>
                            </div>
                        </div>
                        <textarea name="bio" x-ref="editUserBioInput" x-model="editUser.bio" rows="2" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837] leading-relaxed"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ganti Password (Opsional)</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:bg-white focus:outline-none focus:border-[#006837]">
                    </div>

                    <div class="flex items-center pt-2">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" name="is_active" value="1" :checked="editUser.is_active" class="w-4 h-4 rounded bg-slate-100 border-slate-300 text-[#006837] focus:ring-[#006837]">
                            <span>Akun Aktif</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="editModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-[#006837] hover:bg-[#004d29] text-white text-xs font-bold uppercase tracking-wider transition shadow-md shadow-[#006837]/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
