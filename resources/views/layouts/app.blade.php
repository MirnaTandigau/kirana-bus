<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kirana Tongkonan') }}</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased overflow-hidden" x-data="{ sidebarOpen: false }">

    <!-- PEMBUNGKUS UTAMA -->
    <div class="flex h-screen w-full relative">

        <!-- Latar Belakang Gelap untuk Mobile (Muncul saat sidebar terbuka) -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             x-transition.opacity 
             class="fixed inset-0 bg-slate-900/50 z-30 md:hidden cursor-pointer" style="display: none;">
        </div>

        <!-- 1. SIDEBAR (Kiri) -->
        <aside class="fixed md:static inset-y-0 left-0 w-64 bg-white border-r border-slate-100 flex flex-col justify-between z-40 shadow-xl md:shadow-sm transform transition-transform duration-300 ease-in-out md:translate-x-0"
               :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
            
            <div class="overflow-y-auto">
                <!-- Brand / Logo -->
                <div class="flex items-center justify-between p-6 border-b border-slate-50 mb-4">
                    <a href="{{ url('/') }}" class="hover:opacity-80 transition flex flex-col">
                        <h1 class="text-xl font-extrabold text-blue-600 tracking-tight flex items-center gap-2">
                            <i class="fa-solid fa-bus"></i> Kirana
                        </h1>
                        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-widest mt-1">Tongkonan Transport</p>
                    </a>
                    <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-red-500 transition">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <!-- Menu Navigasi -->
                <nav class="px-4 space-y-1.5 pb-6">
                    
                    <!-- Menu Global: Dashboard -->
                    @if(Auth::user()->is_admin)
                        <a href="{{ url('/admin/dashboard') }}" 
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition {{ request()->is('admin/dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <i class="fa-solid fa-gauge-high w-5 text-center"></i> 
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" 
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <i class="fa-solid fa-gauge-high w-5 text-center"></i> 
                            Dashboard
                        </a>
                    @endif

                    <!-- LOGIKA ROLE ADMIN VS USER -->
                    @if(Auth::user()->is_admin)
                        <div class="pt-4 pb-2 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Menu Admin</div>

                        <a href="{{ route('admin.explore.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition {{ request()->routeIs('admin.explore.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <i class="fa-solid fa-map-location-dot w-5 text-center"></i> Data Explore
                        </a>
                        <a href="{{ route('admin.schedules.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition {{ request()->routeIs('admin.schedules.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <i class="fa-regular fa-calendar-days w-5 text-center"></i> Jadwal Bus
                        </a>
                        <a href="{{ route('admin.tickets.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition {{ request()->routeIs('admin.tickets.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <i class="fa-solid fa-check-double w-5 text-center"></i> Validasi Tiket
                        </a>
                        <a href="{{ route('admin.cargos.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition {{ request()->routeIs('admin.cargos.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <i class="fa-solid fa-boxes-stacked w-5 text-center"></i> Manajemen Ekspedisi
                        </a>

                    @else
                        <!-- Menu Khusus User / Pelanggan -->
                        <div class="pt-4 pb-2 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Layanan</div>

                        <!-- 1. KIRANA EXPLORE -->
                        <a href="{{ route('explore.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition {{ request()->routeIs('explore.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <i class="fa-solid fa-mountain-sun w-5 text-center"></i> Kirana Explore
                        </a>

                        <!-- 2. KIRANA TICKET (Dengan Dropdown Sub-menu) -->
                        <div x-data="{ ticketOpen: {{ request()->routeIs('tickets.*') ? 'true' : 'false' }} }">
                            <!-- Induk Tombol (Bukan link, melainkan pembuka menu) -->
                            <button @click="ticketOpen = !ticketOpen" class="w-full flex items-center justify-between px-4 py-3 rounded-xl font-semibold text-sm transition {{ request()->routeIs('tickets.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-ticket w-5 text-center"></i> Kirana Ticket
                                </div>
                                <!-- Ikon panah yang akan berputar saat diklik -->
                                <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="ticketOpen ? 'rotate-180' : ''"></i>
                            </button>
                            
                            <!-- Isi Sub-menu Pemesanan Kursi & Charter Bus -->
                            <div x-show="ticketOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="mt-1 space-y-1 pl-11 pr-2" style="display: none;">
                                
                                <a href="{{ route('tickets.index') }}" class="block px-4 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('tickets.index') ? 'bg-blue-600 text-white' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">
                                    <i class="fa-solid fa-couch text-xs mr-2 opacity-50"></i> Pemesanan Kursi
                                </a>
                                                                
                                <a href="{{ route('tickets.charter.index') }}" class="block px-4 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('tickets.charter.index') ? 'bg-blue-600 text-white' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">
                                    <i class="fa-solid fa-van-shuttle text-xs mr-2 opacity-50"></i> Charter Bus
                                </a>
                            </div>
                        </div>

                        <!-- 3. KIRANA EKSPEDISI -->
                        <a href="{{ route('cargos.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition {{ request()->routeIs('cargos.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <i class="fa-solid fa-box-open w-5 text-center"></i> Kirana Ekspedisi
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Tombol Keluar / Profil Bawah -->
            <div class="p-4 border-t border-slate-50 space-y-2 bg-white">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 w-full px-4 py-2 text-slate-600 hover:bg-slate-50 rounded-xl font-bold text-sm transition">
                    <i class="fa-regular fa-user w-5 text-center"></i> Profil Saya
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl font-bold text-sm transition">
                        <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- 2. KONTEN UTAMA (Kanan) -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative w-full">
            
            <!-- Header Atas Dinamis -->
            <!-- Header Atas Dinamis -->
            <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-4 md:px-8 z-10 shadow-sm">
                
                <!-- Kiri: Tombol Hamburger & Slot Header -->
                <div class="flex items-center gap-4 flex-1 min-w-0">
                    <button @click="sidebarOpen = true" class="md:hidden shrink-0 w-10 h-10 rounded-xl bg-slate-50 text-slate-600 flex items-center justify-center hover:bg-slate-100 transition focus:outline-none">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <!-- Bungkus Header dilonggarkan menjadi w-full -->
                    <div class="flex-1 w-full">
                        @isset($header)
                            <!-- Slot dari file child akan masuk bebas di sini -->
                            <div class="font-bold text-slate-800 text-base md:text-lg w-full">
                                {{ $header }}
                            </div>
                        @else
                            <h2 class="font-bold text-slate-800 text-base md:text-lg">Sistem Informasi PO Kirana</h2>
                        @endisset
                    </div>
                </div>
                
                <!-- Kanan: Profil Pelanggan/Admin -->
                <div class="flex items-center gap-3 shrink-0 ml-4">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-bold text-slate-700">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-slate-400">{{ Auth::user()->is_admin ? 'Administrator' : 'Pelanggan' }}</div>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
                
            </header>

            <!-- Area Isi (Slot Konten) -->
            <main class="flex-1 overflow-y-auto bg-slate-50/50">
                {{ $slot }}
            </main>

        </div>

    </div>

</body>
</html>