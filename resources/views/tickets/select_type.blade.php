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
    <div class="relative min-h-screen flex flex-col items-center justify-center px-6">
        
        <div class="text-center mb-12">
            <div class="w-16 h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 mx-auto mb-6">
                <i class="fa-solid fa-ticket-simple text-2xl"></i>
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2">Kirana Ticket</h2>
            <p class="text-slate-500">Pilih jenis layanan perjalanan yang Anda butuhkan</p>
        </div>

        <div class="max-w-4xl w-full grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <a href="{{ route('tickets.index') }}" class="group bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 transition-all hover:-translate-y-2 flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-chair text-3xl text-blue-600"></i>
                </div>
                <h3 class="text-2xl font-extrabold text-slate-800 mb-3">Pemesanan Kursi</h3>
                <p class="text-slate-500 text-sm leading-relaxed mb-6">
                    Pesan tiket per orang dengan pilihan nomor kursi. Cocok untuk perjalanan pribadi atau keluarga kecil.
                </p>
                <span class="mt-auto px-6 py-2 rounded-full bg-slate-100 text-slate-600 font-bold text-xs group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    PILIH KURSI <i class="fa-solid fa-arrow-right ml-1"></i>
                </span>
            </a>

            <a href="{{ route('tickets.charter.index') }}" class="group bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 transition-all hover:-translate-y-2 flex flex-col items-center text-center ring-4 ring-transparent hover:ring-indigo-500/5">
                <div class="w-20 h-20 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-bus-simple text-3xl text-indigo-600"></i>
                </div>
                <h3 class="text-2xl font-extrabold text-slate-800 mb-3">Charter Bus</h3>
                <p class="text-slate-500 text-sm leading-relaxed mb-6">
                    Sewa 1 unit bus penuh untuk rombongan. Tentukan tanggal bebas dan rute penjemputan sendiri.
                </p>
                <span class="mt-auto px-6 py-2 rounded-full bg-slate-100 text-slate-600 font-bold text-xs group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    SEWA UNIT <i class="fa-solid fa-arrow-right ml-1"></i>
                </span>
            </a>

        </div>

        <div class="mt-16 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>