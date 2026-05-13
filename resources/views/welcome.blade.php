<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kirana Tongkonan Transport</title>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased bg-slate-50 text-slate-900">
        <div class="relative min-h-screen flex flex-col">
            
            <!-- NAVBAR -->
            <nav class="bg-gradient-to-r from-blue-800 to-indigo-900 w-full z-20 shadow-lg relative border-b border-indigo-900/50">
                <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                    
                    <!-- Logo & Nama -->
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white text-slate-900 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-bus text-xl"></i>
                        </div>
                        <div class="text-lg md:text-xl font-extrabold tracking-tight text-white uppercase">
                            K2T
                        </div>
                    </div>

                    <!-- Tombol Auth -->
                    @if (Route::has('login'))
                        <div class="flex items-center gap-3">
                            @auth
                                @if(Auth::user()->is_admin)
                                    <a href="{{ url('/admin/dashboard') }}" class="text-base font-bold text-slate-200 hover:text-white transition tracking-wide flex items-center gap-2">
                                        Dashboard Admin <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="text-base font-bold text-slate-200 hover:text-white transition tracking-wide flex items-center gap-2">
                                        Dashboard <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="text-base font-bold text-slate-200 hover:text-white transition tracking-wide">
                                    Masuk
                                </a>
                                
                                @if (Route::has('register'))
                                    <span class="text-slate-400 font-light mx-1">/</span>
                                    <a href="{{ route('register') }}" class="text-base font-bold text-slate-200 hover:text-white transition tracking-wide">
                                        Daftar
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </nav>

            <!-- MAIN CONTENT -->
            <div class="relative pt-36 pb-20 px-6 flex-grow">
                <div class="max-w-7xl mx-auto text-center">
                    <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-slate-900 mb-6 leading-tight">
                        Welcome To <br>
                        Kirana Tongkonan Transport
                    </h1>
                    <p class="text-lg text-slate-500 max-w-2xl mx-auto leading-relaxed mb-16 italic">
                        "Nikmati perjalanan yang lebih nyaman dan menyenangkan bersama kami."
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        <a href="{{ route('explore.index') }}" class="group relative p-8 bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-300/50 transition-all hover:-translate-y-3">
                            <div class="w-20 h-20 bg-emerald-50 rounded-2xl flex items-center justify-center mb-8 mx-auto group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-map-location-dot text-3xl text-emerald-600"></i>
                            </div>
                            <h3 class="text-2xl font-extrabold text-slate-800 mb-3">Kirana Explore</h3>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Jelajahi keindahan budaya dan objek wisata yang ada di Manado - Toraja.
                            </p>
                            <div class="mt-8 text-emerald-600 font-bold text-sm opacity-0 group-hover:opacity-100 transition-all">
                                Jelajahi Sekarang <i class="fa-solid fa-arrow-right ml-2"></i>
                            </div>
                        </a>

                        <a href="{{ route('tickets.selection') }}" class="group relative p-8 bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-300/50 transition-all hover:-translate-y-3 ">
                            <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mb-8 mx-auto group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-ticket text-3xl text-blue-600"></i>
                            </div>
                            <h3 class="text-2xl font-extrabold text-slate-800 mb-3">Kirana Ticket</h3>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Booking tiket bus dengan pilihan kursi favorit secara cepat dan praktis.
                            </p>
                            <div class="mt-8 text-blue-600 font-bold text-sm opacity-0 group-hover:opacity-100 transition-all">
                                Pesan Tiket <i class="fa-solid fa-arrow-right ml-2"></i>
                            </div>
                        </a>

                        <a href="{{ route('cargos.index') }}" class="group relative p-8 bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-300/50 transition-all hover:-translate-y-3">
                            <div class="w-20 h-20 bg-orange-50 rounded-2xl flex items-center justify-center mb-8 mx-auto group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-boxes-stacked text-3xl text-orange-600"></i>
                            </div>
                            <h3 class="text-2xl font-extrabold text-slate-800 mb-3">Kirana Ekspedisi</h3>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Pengiriman paket aman dan terpercaya antar kantor perwakilan resmi.
                            </p>
                            <div class="mt-8 text-orange-600 font-bold text-sm opacity-0 group-hover:opacity-100 transition-all">
                                Kirim Barang <i class="fa-solid fa-arrow-right ml-2"></i>
                            </div>
                        </a>

                    </div>
                </div>
            </div>

            <footer class="bg-gradient-to-r from-blue-800 to-indigo-900 py-12 text-center border-t border-blue-900/50">
                <div class="max-w-4xl mx-auto px-6 flex flex-col items-center">
                    
                    <!-- Logo / Brand -->
                    <div class="flex items-center justify-center space-x-3 mb-4">
                        <span class="text-2xl font-extrabold text-white uppercase tracking-wider">KIRANA TONGKONAN TRANSPORT</span>
                    </div>

                    <!-- Deskripsi Singkat -->
                    <p class="text-sm text-blue-100/80 mb-8 max-w-2xl leading-relaxed font-medium">
                        PO Kirana Tongkonan Transport merupakan salah satu perusahaan yang bergerak di bidang jasa transportasi umum darat, melayani rute perjalanan Anda dengan mengutamakan kenyamanan dan keamanan.
                    </p>

                    <!-- Navigasi 4 Menu -->
                    <div class="flex flex-wrap justify-center gap-6 mb-8 text-sm font-bold text-white">
                        <a href="{{ route('tentang-kami') }}" class="hover:text-blue-300 transition-colors">Tentang Kami</a>
                        <a href="{{ route('informasi-bus') }}" class="hover:text-blue-300 transition-colors">Informasi Bus</a>
                        <a href="{{ route('kontak') }}" class="hover:text-blue-300 transition-colors">Kontak</a>
                        <a href="{{ route('syarat-ketentuan') }}" class="hover:text-blue-300 transition-colors">Syarat & Ketentuan</a>
                    </div>

                    <!-- Ikon Sosial Media -->
                    <div class="flex space-x-6 justify-center mb-8">
                        <a href="#" class="text-blue-200 hover:text-white transition-colors text-xl"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="text-blue-200 hover:text-white transition-colors text-xl"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="text-blue-200 hover:text-white transition-colors text-xl"><i class="fa-brands fa-instagram"></i></a>
                    </div>

                    <!-- Copyright -->
                    <div class="text-blue-200/60 text-sm font-semibold tracking-wide">
                        &copy; {{ date('Y') }} Kirana Tongkonan Transport
                    </div>
                </div>
            </footer>

        </div>
    </body>
</html>