<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kontak - Kirana Tongkonan Transport</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen">

    <nav class="bg-gradient-to-r from-blue-800 to-indigo-900 w-full z-20 shadow-lg relative border-b border-indigo-900/50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 bg-white text-slate-900 rounded-xl flex items-center justify-center shadow-lg group-hover:bg-blue-100 transition">
                    <i class="fa-solid fa-bus text-xl"></i>
                </div>
                <div class="text-lg font-extrabold tracking-tight text-white uppercase">
                    K2T
                </div>
            </a>

            @guest
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-base font-bold text-slate-200 hover:text-white transition tracking-wide">
                        Masuk
                    </a>
                    <span class="text-slate-400 font-light mx-1">/</span>
                    <a href="{{ route('register') }}" class="text-base font-bold text-slate-200 hover:text-white transition tracking-wide">
                        Daftar
                    </a>
                </div>
            @endguest

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
            @endauth
        </div>
    </nav>

    <main class="flex-grow pt-12 pb-24 px-6">
        <div class="max-w-5xl mx-auto bg-white p-10 md:p-14 rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 border-b-4 border-blue-600 pb-4 inline-block">Hubungi Kami</h1>
            
            <p class="mb-8 text-slate-600">Ada pertanyaan? Silakan hubungi agen perwakilan kami di kota Anda melalui WhatsApp.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
                
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-300 transition shadow-sm group">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 uppercase tracking-widest text-sm">Kantor Perwakilan Manado</h3>
                    <p class="text-slate-600 mb-3 flex items-start">
                        <i class="fa-solid fa-map-pin text-red-500 mr-3 mt-1"></i> 
                        <span>Perum  Citra  Land,  Eden  Bridge  7  No  7,  Kota  Manado</span>
                    </p>
                    <a href="https://wa.me/6281330349900" target="_blank" class="inline-flex items-center text-slate-600 hover:text-green-600 font-bold transition group-hover:underline">
                        <i class="fa-brands fa-whatsapp text-green-500 text-xl mr-2"></i> 0813-3034-9900
                    </a>
                </div>
                
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-300 transition shadow-sm group">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 uppercase tracking-widest text-sm">Kantor Perwakilan Tondano</h3>
                    <p class="text-slate-600 mb-3 flex items-start">
                        <i class="fa-solid fa-map-pin text-red-500 mr-3 mt-1"></i> 
                        <span>Perum UNIMA, Tondano, Sulawesi Utara</span>
                    </p>
                    <a href="https://wa.me/6285340957541" target="_blank" class="inline-flex items-center text-slate-600 hover:text-green-600 font-bold transition group-hover:underline">
                        <i class="fa-brands fa-whatsapp text-green-500 text-xl mr-2"></i> 0853-4095-7541
                    </a>
                </div>

                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-300 transition shadow-sm group">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 uppercase tracking-widest text-sm">Kantor Perwakilan Makale</h3>
                    <p class="text-slate-600 mb-3 flex items-start">
                        <i class="fa-solid fa-map-pin text-red-500 mr-3 mt-1"></i> 
                        <span>Terminal Makale loket PO. Kirana Tongkonan Transport, Tana Toraja</span>
                    </p>
                    <a href="https://wa.me/6285240816332" target="_blank" class="inline-flex items-center text-slate-600 hover:text-green-600 font-bold transition group-hover:underline">
                        <i class="fa-brands fa-whatsapp text-green-500 text-xl mr-2"></i> 0852-4081-6332
                    </a>
                </div>

                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-300 transition shadow-sm group">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 uppercase tracking-widest text-sm">Kantor Perwakilan Rantepao</h3>
                    <p class="text-slate-600 mb-3 flex items-start">
                        <i class="fa-solid fa-map-pin text-red-500 mr-3 mt-1"></i> 
                        <span>Jl. Andi Mappanyukki, Rantepao, Toraja Utara</span>
                    </p>
                    <a href="https://wa.me/6285255279166" target="_blank" class="inline-flex items-center text-slate-600 hover:text-green-600 font-bold transition group-hover:underline">
                        <i class="fa-brands fa-whatsapp text-green-500 text-xl mr-2"></i> 0852-5527-9166
                    </a>
                </div>

            </div>
            
            <div class="mt-12 pt-8 border-t border-slate-100 text-center">
                <p class="text-slate-600 mb-4 font-medium">Layanan Pengaduan Konsumen (Email):</p>
                <a href="mailto:cs@kiranatransport.com" class="text-blue-600 font-extrabold text-2xl hover:underline">cs@kiranatransport.com</a>
            </div>
        </div>
    </main>

    <footer class="bg-gradient-to-r from-blue-800 to-indigo-900 py-12 text-center border-t border-blue-900/50">
        <div class="max-w-4xl mx-auto px-6 flex flex-col items-center">
            
            <div class="mb-4">
                <span class="text-2xl font-extrabold text-white uppercase tracking-wider">KIRANA TONGKONAN TRANSPORT</span>
            </div>

            <p class="text-sm text-blue-100/80 mb-8 max-w-2xl leading-relaxed font-medium">
                PO Kirana Tongkonan Transport melayani rute perjalanan Anda dengan mengutamakan kenyamanan dan keamanan. Sahabat perjalanan terpercaya di Sulawesi.
            </p>

            <div class="flex flex-wrap justify-center gap-6 mb-8 text-sm font-bold text-white">
                <a href="{{ route('tentang-kami') }}" class="hover:text-blue-300 transition-colors">Tentang Kami</a>
                <a href="{{ route('informasi-bus') }}" class="hover:text-blue-300 transition-colors">Informasi Bus</a>
                <a href="{{ route('kontak') }}" class="hover:text-blue-300 transition-colors">Kontak</a>
                <a href="{{ route('syarat-ketentuan') }}" class="hover:text-blue-300 transition-colors">Syarat & Ketentuan</a>
            </div>

            <div class="flex space-x-6 justify-center mb-8">
                <a href="#" class="text-blue-200 hover:text-white transition-colors text-xl"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="text-blue-200 hover:text-white transition-colors text-xl"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="text-blue-200 hover:text-white transition-colors text-xl"><i class="fa-brands fa-whatsapp"></i></a>
            </div>

            <div class="text-blue-200/60 text-sm font-semibold tracking-wide">
                &copy; {{ date('Y') }} Kirana Tongkonan Transport
            </div>
        </div>
    </footer>

</body>
</html>