<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Informasi Bus - Kirana Tongkonan Transport</title>
    
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
                    <a href="{{ route('login') }}" class="text-xs md:text-base font-bold text-slate-200 hover:text-white transition tracking-wide">
                        Masuk
                    </a>
                    <span class="text-slate-400 font-light mx-0.5 md:mx-1">/</span>
                    <a href="{{ route('register') }}" class="text-xs md:text-base font-bold text-slate-200 hover:text-white transition tracking-wide">
                        Daftar
                    </a>
                </div>
            @endguest

            @auth
                @if(Auth::user()->is_admin)
                    <a href="{{ url('/admin/dashboard') }}" class="text-xs md:text-base font-bold text-slate-200 hover:text-white transition tracking-wide flex items-center gap-1.5 md:gap-2">
                        Dashboard Admin <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="text-xs md:text-base font-bold text-slate-200 hover:text-white transition tracking-wide flex items-center gap-1.5 md:gap-2">
                        Dashboard <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @endif
            @endauth
        </div>
    </nav>

    <main class="flex-grow pt-8 md:pt-12 pb-16 md:pb-24 px-4 md:px-6">
        <div class="max-w-6xl mx-auto bg-white p-6 md:p-10 lg:p-14 rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100">
            
            <div class="text-center mb-8 md:mb-12">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 mb-3 md:mb-4 inline-block">Armada Pilihan Kami</h1>
                <p class="text-sm md:text-base text-slate-600 max-w-2xl mx-auto">Armada Kirana Tongkonan Transport dirancang khusus untuk rute perjalanan panjang Trans Sulawesi dengan tetap menjaga kenyamanan ekstra bagi para penumpang.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-8 mb-8 md:mb-12">
                
                <div class="bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition-all group">
                    <div class="h-48 md:h-56 bg-slate-200 relative overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('images/bus-1.jpeg') }}" alt="Bus Executive" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 z-10 relative">
                        <span class="absolute text-slate-400 text-xs md:text-sm font-bold z-0"><i class="fa-solid fa-image mr-2"></i>Foto Bus 1</span>
                    </div>
                    <div class="p-5 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-slate-900 mb-1.5 md:mb-2">Bus 1 - Batuda'a (St. Mikael)</h3>
                        <p class="text-xs md:text-sm text-slate-600 mb-3 md:mb-4">Kapasitas 33 Kursi. Cocok untuk perjalanan jauh yang nyaman.</p>
                        <div class="flex flex-wrap gap-1.5 md:gap-2">
                            <span class="bg-indigo-100 text-indigo-700 text-[9px] md:text-[10px] px-2 py-1 rounded font-bold uppercase">Reguler</span>
                            <span class="bg-indigo-100 text-indigo-700 text-[9px] md:text-[10px] px-2 py-1 rounded font-bold uppercase">Charter</span>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition-all group">
                    <div class="h-48 md:h-56 bg-slate-200 relative overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('images/bus-2.jpeg') }}" alt="Bus VIP" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 z-10 relative">
                        <span class="absolute text-slate-400 text-xs md:text-sm font-bold z-0"><i class="fa-solid fa-image mr-2"></i>Foto Bus 2</span>
                    </div>
                    <div class="p-5 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-slate-900 mb-1.5 md:mb-2">Bus 2 - Rumengkor (Sta. Theresa)</h3>
                        <p class="text-xs md:text-sm text-slate-600 mb-3 md:mb-4">Kapasitas 33 Kursi. Cocok untuk perjalanan jauh yang nyaman.</p>
                        <div class="flex flex-wrap gap-1.5 md:gap-2">
                            <span class="bg-blue-100 text-blue-700 text-[9px] md:text-[10px] px-2 py-1 rounded font-bold uppercase">Reguler</span>
                            <span class="bg-blue-100 text-blue-700 text-[9px] md:text-[10px] px-2 py-1 rounded font-bold uppercase">Charter</span>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition-all group">
                    <div class="h-48 md:h-56 bg-slate-200 relative overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('images/bus-3.jpeg') }}" alt="Mini Bus" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 z-10 relative">
                        <span class="absolute text-slate-400 text-xs md:text-sm font-bold z-0"><i class="fa-solid fa-image mr-2"></i>Foto Bus 3</span>
                    </div>
                    <div class="p-5 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-slate-900 mb-1.5 md:mb-2">Bus 3 - Nanggala (Sta. Verena)</h3>
                        <p class="text-xs md:text-sm text-slate-600 mb-3 md:mb-4">Kapasitas 33 Kursi. Cocok untuk perjalanan jauh yang nyaman.</p>
                        <div class="flex flex-wrap gap-1.5 md:gap-2">
                            <span class="bg-indigo-100 text-indigo-700 text-[9px] md:text-[10px] px-2 py-1 rounded font-bold uppercase">reguler</span>
                            <span class="bg-indigo-100 text-indigo-700 text-[9px] md:text-[10px] px-2 py-1 rounded font-bold uppercase">Charter</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10 pt-6 md:pt-8 border-t border-slate-100">
                <div>
                    <h3 class="text-lg md:text-xl font-bold text-slate-900 mb-3 md:mb-4"><i class="fa-solid fa-star text-yellow-400 mr-2"></i> Fasilitas Standar Armada</h3>
                    <ul class="list-none space-y-2 md:space-y-3 text-sm md:text-base text-slate-600">
                        <li class="flex items-center"><i class="fa-solid fa-check text-green-500 mr-3"></i> Full AC (Air Conditioner)</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-green-500 mr-3"></i> Reclining Seat</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-green-500 mr-3"></i> Karaoke</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-green-500 mr-3"></i> TV</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-green-500 mr-3"></i> Pemadam Standard Safety</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-green-500 mr-3"></i> Pemecah Kaca</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg md:text-xl font-bold text-slate-900 mb-3 md:mb-4"><i class="fa-solid fa-van-shuttle text-blue-600 mr-2"></i> Layanan Sewa (Charter)</h3>
                    <p class="text-sm md:text-base text-slate-600 leading-relaxed mb-3 md:mb-4">Selain melayani tiket rute reguler (Manado - Toraja PP), kami menyediakan layanan sewa bus penuh (Full Unit/Charter) dengan supir profesional.</p>
                    <p class="text-sm md:text-base text-slate-600 leading-relaxed">Sangat cocok untuk keperluan rombongan wisata, study tour, acara keluarga besar, maupun kunjungan kedinasan ke berbagai destinasi di seluruh penjuru Pulau Sulawesi.</p>
                </div>
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