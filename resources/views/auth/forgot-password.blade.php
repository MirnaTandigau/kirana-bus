<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Sandi - Kirana Tongkonan Transport</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-gradient-to-br from-blue-900 via-indigo-900 to-slate-900 antialiased min-h-screen flex flex-col relative overflow-hidden">

    <!-- Latar Belakang Doodle -->
    <div class="fixed inset-0 z-0 pointer-events-none select-none overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-500 rounded-full mix-blend-overlay filter blur-[128px] opacity-50"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-indigo-500 rounded-full mix-blend-overlay filter blur-[128px] opacity-50"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 py-8">
        <a href="{{ route('login') }}" class="inline-flex items-center text-white/70 hover:text-white font-semibold text-sm transition-all group">
            <div class="w-8 h-8 rounded-full bg-white/10 border border-white/20 flex items-center justify-center mr-3 group-hover:bg-white/20 group-hover:scale-110 transition-all">
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </div>
            Kembali ke Login
        </a>
    </div>

    <div class="relative z-10 flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 pb-16">
        <div class="max-w-lg w-full bg-white/95 backdrop-blur-2xl rounded-[2rem] shadow-[0_20px_50px_rgba(0,_0,_0,_0.3)] p-10 md:p-12 border border-white/40">
            
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-tr from-blue-50 to-indigo-50 text-blue-600 rounded-2xl mb-6 shadow-sm border border-blue-100/50">
                    <i class="fa-solid fa-key text-2xl"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-3">Lupa Kata Sandi?</h2>
                <p class="text-slate-500 text-sm leading-relaxed px-2">
                    Tidak masalah. Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
                </p>
            </div>

            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-extrabold text-slate-700 uppercase tracking-widest mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                               class="w-full pl-11 pr-4 py-3.5 bg-slate-50/50 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all text-sm font-medium text-slate-800 placeholder-slate-400" 
                               placeholder="nama@email.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs font-bold" />
                </div>

                <button type="submit" class="w-full group flex justify-center items-center py-4 px-4 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 transition-all shadow-lg shadow-indigo-600/25 hover:shadow-indigo-600/40 hover:-translate-y-0.5">
                    Kirim Tautan Reset
                    <i class="fa-regular fa-paper-plane ml-2 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>
        </div>
    </div>
</body>
</html>