<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Syarat & Ketentuan - Kirana Tongkonan Transport</title>
    
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

    <!-- NAVBAR SIMPLE (Warna Senada Footer) -->
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
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-300 hover:text-white transition">
                        Masuk
                    </a>
                    <span class="text-slate-500">/</span>
                    <a href="{{ route('register') }}" class="text-sm font-bold text-slate-300 hover:text-white transition">
                        Daftar
                    </a>
                </div>
            @endguest

            @auth
                @if(Auth::user()->is_admin)
                    <a href="{{ url('/admin/dashboard') }}" class="text-sm font-bold text-slate-300 hover:text-white transition flex items-center gap-2">
                        Dashboard Admin <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-300 hover:text-white transition flex items-center gap-2">
                        Dashboard <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @endif
            @endauth
        </div>
    </nav>

    <!-- BAGIAN TENGAH (SYARAT & KETENTUAN) -->
    <main class="flex-grow pt-12 pb-24 px-6">
        <div class="max-w-4xl mx-auto bg-white p-10 md:p-14 rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 border-b-4 border-blue-600 pb-4 inline-block">Syarat & Ketentuan</h1>
            
            <div class="space-y-8 text-slate-600 leading-relaxed text-sm md:text-base">
                
                <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">1. Pemesanan & Pembayaran Tiket</h3>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Tiket yang sudah berstatus "Lunas" akan mendapatkan nomor kursi resmi.</li>
                        <li>Batas waktu pembayaran (*expired*) tertera pada sistem. Jika melewati batas waktu, tiket otomatis dibatalkan.</li>
                    </ul>
                </section>

                <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">2. Diskon Khusus Mahasiswa</h3>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Untuk mendapatkan tarif khusus mahasiswa, pelanggan <strong>WAJIB</strong> mengunggah foto Kartu Tanda Mahasiswa (KTM) atau Kartu Rencana Studi (KRS) yang masih aktif saat memesan tiket.</li>
                        <li>Jika terbukti menggunakan dokumen palsu, Admin berhak membatalkan pesanan secara sepihak.</li>
                    </ul>
                </section>

                <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">3. Layanan Ekspedisi (Kargo)</h3>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Kami tidak menerima pengiriman barang terlarang, narkotika, senjata tajam, maupun hewan hidup peliharaan tanpa kandang khusus.</li>
                        <li>Harga final ekspedisi dihitung berdasarkan berat aktual (timbangan) di kantor perwakilan, bukan estimasi di aplikasi.</li>
                    </ul>
                </section>

                <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">4. Pembatalan & Keterlambatan</h3>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Penumpang diharapkan tiba di lokasi keberangkatan (Titik Jemput/Kantor) minimal 30 menit sebelum jadwal keberangkatan.</li>
                        <li>Tiket tidak dapat di-refund secara sepihak di hari keberangkatan.</li>
                    </ul>
                </section>

            </div>
        </div>
    </main>

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

</body>
</html>