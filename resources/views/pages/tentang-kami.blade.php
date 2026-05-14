<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami - Kirana Tongkonan Transport</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen">

    <nav class="bg-gradient-to-r from-blue-800 to-indigo-900 w-full z-20 shadow-lg relative border-b border-indigo-900/50">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-3 md:py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="flex items-center space-x-2 md:space-x-3 group">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-white text-slate-900 rounded-lg md:rounded-xl flex items-center justify-center shadow-lg group-hover:bg-blue-100 transition">
                    <i class="fa-solid fa-bus text-sm md:text-xl"></i>
                </div>
                <div class="text-base md:text-xl font-extrabold tracking-tight text-white uppercase">
                    K2T
                </div>
            </a>
            @guest
                <div class="flex items-center gap-2 md:gap-3">
                    <a href="{{ route('login') }}" class="text-xs md:text-sm font-bold text-slate-300 hover:text-white transition">
                        Masuk
                    </a>
                    <span class="text-slate-500 mx-0.5 md:mx-1">/</span>
                    <a href="{{ route('register') }}" class="text-xs md:text-sm font-bold text-slate-300 hover:text-white transition">
                        Daftar
                    </a>
                </div>
            @endguest

            @auth
                @if(Auth::user()->is_admin)
                    <a href="{{ url('/admin/dashboard') }}" class="text-xs md:text-sm font-bold text-slate-300 hover:text-white transition flex items-center gap-1.5 md:gap-2">
                        Dashboard Admin <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="text-xs md:text-sm font-bold text-slate-300 hover:text-white transition flex items-center gap-1.5 md:gap-2">
                        Dashboard <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @endif
            @endauth
        </div>
    </nav>

    <main class="flex-grow pt-8 md:pt-12 pb-16 md:pb-24 px-4 md:px-6">
        <div class="max-w-4xl mx-auto bg-white p-6 md:p-10 lg:p-14 rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100">
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 mb-4 md:mb-6 border-b-4 border-blue-600 pb-3 md:pb-4 inline-block">Tentang Kami</h1>
            
            <div class="space-y-4 md:space-y-6 text-slate-600 leading-relaxed text-sm md:text-base">
                <p>
                    <strong class="text-slate-900">PO Kirana Tongkonan Transport</strong> adalah perusahaan penyedia jasa transportasi darat antarkota antarprovinsi (AKAP) yang berfokus melayani mobilitas masyarakat pada rute <strong>Manado – Toraja</strong> dan sebaliknya.
                </p>
                <p>
                    Berkomitmen untuk memberikan layanan transportasi darat yang profesional dan terstandarisasi, operasional PO. Kirana Tongkonan Transport secara resmi bernaung dan didukung penuh oleh <strong>PT. Juwindo Kikhato Abadi.</strong> Dukungan ini memastikan seluruh standar keselamatan, legalitas, dan manajemen kualitas layanan kami senantiasa terjaga di tingkat tertinggi. Demi menjamin kelancaran mobilitas Anda, saat ini Kirana Tongkonan Transport mengoperasikan 3 unit armada bus tangguh yang dirawat secara ketat dan berkala.
                </p>
                <p>
                    Sebagai wujud komitmen untuk terus berinovasi, Kirana Tongkonan Transport kini menghadirkan kemudahan transaksi di ujung jari Anda. Melalui platform website ini, pelanggan dapat melihat jadwal keberangkatan, memesan tiket (e-ticketing), hingga melacak status pengiriman kargo secara real-time tanpa perlu repot datang ke loket. 
                </p>   
                <p> 
                    <strong>Perjalanan Anda adalah prioritas kami. Bersama PO Kirana Tongkonan Transport mari ciptakan pengalaman perjalanan yang aman, nyaman, dan tak terlupakan.</strong>
                </p>
            </div>
        </div>
    </main>

    <footer class="bg-gradient-to-r from-blue-800 to-indigo-900 py-8 md:py-12 text-center border-t border-blue-900/50">
        <div class="max-w-4xl mx-auto px-4 md:px-6 flex flex-col items-center">
            
            <div class="mb-3 md:mb-4">
                <span class="text-lg md:text-2xl font-extrabold text-white uppercase tracking-wider">KIRANA TONGKONAN TRANSPORT</span>
            </div>

            <p class="text-xs md:text-sm text-blue-100/80 mb-6 md:mb-8 max-w-2xl leading-relaxed font-medium px-4">
                PO Kirana Tongkonan Transport merupakan salah satu perusahaan yang bergerak di bidang jasa transportasi umum darat, melayani rute perjalanan Anda dengan mengutamakan kenyamanan dan keamanan.
            </p>

            <div class="flex flex-wrap justify-center gap-4 md:gap-6 mb-6 md:mb-8 text-[10px] md:text-sm font-bold text-white uppercase tracking-wide">
                <a href="{{ route('tentang-kami') }}" class="hover:text-blue-300 transition-colors">Tentang Kami</a>
                <a href="{{ route('informasi-bus') }}" class="hover:text-blue-300 transition-colors">Informasi Bus</a>
                <a href="{{ route('kontak') }}" class="hover:text-blue-300 transition-colors">Kontak</a>
                <a href="{{ route('syarat-ketentuan') }}" class="hover:text-blue-300 transition-colors">Syarat & Ketentuan</a>
            </div>

            <div class="flex space-x-5 md:space-x-6 justify-center mb-6 md:mb-8">
                <a href="#" class="text-blue-200 hover:text-white transition-colors text-lg md:text-xl"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="text-blue-200 hover:text-white transition-colors text-lg md:text-xl"><i class="fa-brands fa-twitter"></i></a>
                <a href="#" class="text-blue-200 hover:text-white transition-colors text-lg md:text-xl"><i class="fa-brands fa-instagram"></i></a>
            </div>

            <div class="text-blue-200/60 text-[10px] md:text-sm font-semibold tracking-wide">
                &copy; {{ date('Y') }} Kirana Tongkonan Transport
            </div>
        </div>
    </footer>

</body>
</html>