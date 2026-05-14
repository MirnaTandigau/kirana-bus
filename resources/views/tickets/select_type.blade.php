<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pilih Jenis Pemesanan - Kirana Ticket</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-900">
    <div class="relative min-h-screen flex flex-col items-center justify-center px-4 md:px-6 py-8 md:py-12">
        
        <div class="text-center mb-8 md:mb-12">
            <div class="w-12 h-12 md:w-16 md:h-16 bg-blue-600 text-white rounded-xl md:rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 mx-auto mb-4 md:mb-6">
                <i class="fa-solid fa-ticket-simple text-xl md:text-2xl"></i>
            </div>
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 mb-2">Kirana Ticket</h2>
            <p class="text-slate-500 text-sm md:text-base">Pilih jenis layanan perjalanan yang Anda butuhkan</p>
        </div>

        <div class="max-w-4xl w-full grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
            
            <a href="{{ route('tickets.index') }}" class="group bg-white p-6 md:p-8 rounded-3xl md:rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 transition-all hover:-translate-y-2 flex flex-col items-center text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-blue-50 rounded-xl md:rounded-2xl flex items-center justify-center mb-4 md:mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-chair text-2xl md:text-3xl text-blue-600"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-extrabold text-slate-800 mb-2 md:mb-3">Pemesanan Kursi</h3>
                <p class="text-slate-500 text-xs md:text-sm leading-relaxed mb-4 md:mb-6">
                    Pesan tiket per orang dengan pilihan nomor kursi. Cocok untuk perjalanan pribadi atau keluarga kecil.
                </p>
                <span class="mt-auto px-4 py-1.5 md:px-6 md:py-2 rounded-full bg-slate-100 text-slate-600 font-bold text-[10px] md:text-xs group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    PILIH KURSI <i class="fa-solid fa-arrow-right ml-1"></i>
                </span>
            </a>

            <a href="{{ route('tickets.charter.index') }}" class="group bg-white p-6 md:p-8 rounded-3xl md:rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 transition-all hover:-translate-y-2 flex flex-col items-center text-center ring-4 ring-transparent hover:ring-indigo-500/5">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-indigo-50 rounded-xl md:rounded-2xl flex items-center justify-center mb-4 md:mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-bus-simple text-2xl md:text-3xl text-indigo-600"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-extrabold text-slate-800 mb-2 md:mb-3">Charter Bus</h3>
                <p class="text-slate-500 text-xs md:text-sm leading-relaxed mb-4 md:mb-6">
                    Sewa 1 unit bus penuh untuk rombongan. Tentukan tanggal bebas dan rute penjemputan sendiri.
                </p>
                <span class="mt-auto px-4 py-1.5 md:px-6 md:py-2 rounded-full bg-slate-100 text-slate-600 font-bold text-[10px] md:text-xs group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    SEWA UNIT <i class="fa-solid fa-arrow-right ml-1"></i>
                </span>
            </a>

        </div>

        <div class="mt-10 md:mt-16 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 md:px-6 md:py-3 border border-gray-300 shadow-sm text-sm md:text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 md:w-5 md:h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>