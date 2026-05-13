<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi Email - Kirana Tongkonan Transport</title>
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

    <div class="relative z-10 flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-lg w-full bg-white/95 backdrop-blur-2xl rounded-[2rem] shadow-[0_20px_50px_rgba(0,_0,_0,_0.3)] p-10 md:p-12 border border-white/40">
            
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-tr from-blue-50 to-indigo-50 text-blue-600 rounded-2xl mb-6 shadow-sm border border-blue-100/50">
                    <i class="fa-solid fa-envelope-open-text text-2xl"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-3">Verifikasi Email</h2>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email dengan mengeklik tautan yang baru saja kami kirimkan? 
                    Jika Anda tidak menerimanya, kami akan mengirim ulang.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 bg-green-50 border border-green-100 text-green-700 p-4 rounded-xl shadow-sm text-sm font-bold flex items-start">
                    <i class="fa-solid fa-circle-check mt-0.5 mr-3 text-green-500"></i>
                    Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                </div>
            @endif

            <div class="mt-6 space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full group flex justify-center items-center py-4 px-4 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 transition-all shadow-lg shadow-indigo-600/25 hover:shadow-indigo-600/40 hover:-translate-y-0.5">
                        Kirim Ulang Email Verifikasi
                        <i class="fa-solid fa-paper-plane ml-2 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex justify-center items-center py-4 px-4 rounded-xl text-sm font-bold text-slate-600 bg-slate-50 border border-slate-200 hover:bg-slate-100 hover:text-slate-900 transition-all focus:outline-none">
                        Keluar Akun
                    </button>
                </form>
            </div>

        </div>
    </div>
</body>
</html>