@extends('layouts.app')

@section('title', 'Login CMS - UPT PJJ UINSSC')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-14 px-4 sm:px-6 lg:px-8 relative bg-slate-50">
    
    <div class="max-w-md w-full relative z-10" x-data="{ showPassword: false, fillDemo(email, pass) { $refs.emailInput.value = email; $refs.passInput.value = pass; } }">
        
        <!-- Card Container -->
        <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-xl border border-slate-200">
            
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <img src="{{ asset('images/logo_uptpjj.png') }}" alt="Logo UPT PJJ UINSSC" class="h-12 w-auto mx-auto object-contain mb-3">
                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">CMS UPT PJJ</h2>
                <p class="text-xs text-slate-500 mt-0.5">Sistem Manajemen Konten UIN Siber Syekh Nurjati Cirebon</p>
            </div>

            <!-- Error Alerts -->
            @if ($errors->any())
                <div class="mb-6 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 text-base"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email Input -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Administrator</label>
                    <div class="relative">
                        <input type="email" name="email" x-ref="emailInput" value="{{ old('email', 'admin@uinssc.ac.id') }}" required autofocus class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:border-[#006837] focus:ring-2 focus:ring-[#006837]/20">
                        <i class="fa-solid fa-envelope absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" x-ref="passInput" value="admin123" required class="w-full pl-11 pr-11 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:border-[#006837] focus:ring-2 focus:ring-[#006837]/20">
                        <i class="fa-solid fa-key absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-3.5 top-3.5 text-slate-400 hover:text-slate-700">
                            <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-[#006837] focus:ring-[#006837]">
                        <span class="text-slate-600">Ingat sesi saya</span>
                    </label>
                    <span class="text-slate-400">Security SSL 256-bit</span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3.5 rounded-full bg-[#006837] hover:bg-[#004d29] text-white font-extrabold text-sm uppercase tracking-wider shadow-md transition-all">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i> Masuk ke CMS
                </button>
            </form>

            <!-- Quick Demo Credentials Box -->
            <div class="mt-8 pt-6 border-t border-slate-100 text-xs text-slate-600">
                <div class="font-bold text-slate-800 mb-2 flex items-center gap-1.5">
                    <i class="fa-solid fa-key text-amber-600"></i> Akun Pengujian Demo:
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" @click="fillDemo('admin@uinssc.ac.id', 'admin123')" class="p-2.5 rounded-xl bg-slate-50 hover:bg-emerald-50 hover:border-[#006837] border border-slate-200 text-left transition">
                        <span class="block font-bold text-[#006837]">Super Admin</span>
                        <span class="text-[10px] text-slate-500">admin@uinssc.ac.id</span>
                    </button>
                    <button type="button" @click="fillDemo('editor@uinssc.ac.id', 'editor123')" class="p-2.5 rounded-xl bg-slate-50 hover:bg-emerald-50 hover:border-[#006837] border border-slate-200 text-left transition">
                        <span class="block font-bold text-teal-800">Humas / Editor</span>
                        <span class="text-[10px] text-slate-500">editor@uinssc.ac.id</span>
                    </button>
                </div>
            </div>

            <!-- Back to website link -->
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-xs font-semibold text-slate-500 hover:text-[#006837] transition flex items-center justify-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
