@extends('layouts.app')

@section('title', 'Login CMS - UPT PJJ UINSSC')

@section('content')
<div class="min-h-[82vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative bg-gradient-to-br from-slate-50 via-emerald-50/20 to-slate-100 overflow-hidden">
    
    <!-- Decorative Ambient Glows -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-md w-full relative z-10" x-data="{ showPassword: false }">
        
        <!-- Card Container -->
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-900/5 border border-slate-200/80 overflow-hidden">
            
            <!-- Top Gradient Accent Bar -->
            <div class="h-1.5 bg-gradient-to-r from-[#006837] via-emerald-500 to-teal-400"></div>

            <div class="p-8 sm:p-10">
                <!-- Logo & Heading -->
                <div class="text-center mb-7">
                    <img src="{{ asset('images/logo_uptpjj.png') }}" alt="Logo UPT PJJ UINSSC" class="h-12 w-auto mx-auto object-contain mb-3.5">
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">CMS UPT PJJ</h1>
                    <p class="text-xs text-slate-500 mt-1">Sistem Manajemen Konten & Informasi Resmi UINSSC</p>
                    
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 mt-3.5 rounded-full bg-emerald-50 text-[#006837] border border-emerald-100 text-[11px] font-semibold">
                        <i class="fa-solid fa-shield-halved text-xs"></i>
                        <span>Portal Masuk Terenkripsi</span>
                    </div>
                </div>

                <!-- Error Alert -->
                @if ($errors->any())
                    <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs flex items-start gap-2.5">
                        <i class="fa-solid fa-triangle-exclamation text-red-500 text-sm mt-0.5 shrink-0"></i>
                        <span class="leading-relaxed">{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Session Status / Feedback -->
                @if (session('status'))
                    <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-[#006837] text-xs flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-sm mt-0.5 shrink-0"></i>
                        <span class="leading-relaxed">{{ session('status') }}</span>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Administrator</label>
                        <div class="relative">
                            <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="nama@uinssc.ac.id" 
                                   required 
                                   autofocus 
                                   class="w-full pl-11 pr-4 py-3 bg-slate-50/70 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:border-[#006837] focus:ring-4 focus:ring-[#006837]/10 focus:bg-white transition-all">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi</label>
                        </div>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                            <input id="password" 
                                   :type="showPassword ? 'text' : 'password'" 
                                   name="password" 
                                   placeholder="••••••••" 
                                   required 
                                   class="w-full pl-11 pr-11 py-3 bg-slate-50/70 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:border-[#006837] focus:ring-4 focus:ring-[#006837]/10 focus:bg-white transition-all">
                            <button type="button" 
                                    @click="showPassword = !showPassword" 
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-600 transition" 
                                    :title="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'">
                                <i class="fa-solid text-sm" :class="showPassword ? 'fa-eye-slash text-slate-700' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Security Badge -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-[#006837] focus:ring-[#006837]">
                            <span class="text-slate-600 font-medium">Ingat sesi saya</span>
                        </label>
                        <span class="inline-flex items-center gap-1 text-[11px] font-medium text-slate-400">
                            <i class="fa-solid fa-lock text-emerald-600 text-[10px]"></i> SSL 256-bit
                        </span>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-[#006837] to-[#00522c] hover:from-[#005c31] hover:to-[#004223] text-white font-bold text-sm tracking-wide shadow-md shadow-emerald-950/15 hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer transform active:scale-[0.99]">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            <span>Masuk ke CMS</span>
                        </button>
                    </div>
                </form>

                <!-- Back to Website Link -->
                <div class="mt-7 pt-5 border-t border-slate-100 text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-[#006837] transition-colors py-1.5 px-3 rounded-lg hover:bg-slate-50">
                        <i class="fa-solid fa-arrow-left text-[11px]"></i>
                        <span>Kembali ke Beranda Website</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Copyright -->
        <p class="text-center text-[11px] text-slate-400 mt-5">&copy; {{ date('Y') }} UPT Pembelajaran Jarak Jauh UIN Siber Syekh Nurjati Cirebon</p>

    </div>
</div>
@endsection
