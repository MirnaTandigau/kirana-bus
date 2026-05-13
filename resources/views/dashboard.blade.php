<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Utama
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-indigo-800 rounded-3xl p-8 sm:p-10 shadow-lg relative overflow-hidden flex items-center justify-between">
                <div class="relative z-10 text-white max-w-2xl">
                    <span class="bg-white/20 px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase mb-4 inline-block backdrop-blur-sm border border-white/30">Kirana Tongkonan Info</span>
                    <h2 class="text-3xl sm:text-4xl font-black mb-2 tracking-tight italic">
                        Selamat Datang, {{ Auth::user()->name }}! 👋
                    </h2>
                    <p class="text-blue-100 text-sm sm:text-base font-medium">Senang melihat Anda kembali. Dapatkan pengalaman perjalanan dan pengiriman barang terbaik bersama Kirana Tongkonan Transport.</p>
                </div>
                <i class="fa-solid fa-bus text-9xl text-white opacity-10 absolute -right-4 -bottom-4 transform -rotate-12"></i>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    
                    @if($unpaidTickets->count() > 0)
                    <div class="bg-orange-50 border-l-4 border-orange-500 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="mt-1">
                                <span class="bg-orange-500 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-black text-orange-900 uppercase tracking-wider text-sm">Status Pesanan Anda</h3>
                                <p class="text-xs text-orange-800 mt-1 mb-3 font-medium">Anda memiliki {{ $unpaidTickets->count() }} pesanan tiket/sewa yang sedang berjalan. Perhatikan status terbarunya di bawah ini:</p>
                                
                                <div class="flex flex-wrap gap-2">
                                    @foreach($unpaidTickets->take(3) as $ut)
                                        @if($ut->status_pembayaran == 'Menunggu Pembayaran')
                                            <a href="{{ route('tickets.payment', $ut->id) }}" class="bg-orange-600 hover:bg-orange-700 text-white text-[10px] px-3 py-2 rounded-lg font-bold shadow-sm transition flex items-center gap-1.5 cursor-pointer animate-pulse">
                                                <i class="fa-solid fa-wallet"></i> Bayar #KRN-{{ $ut->id }}
                                            </a>
                                        @elseif($ut->status_pembayaran == 'Menunggu Validasi')
                                            <span class="bg-orange-200 text-orange-800 text-[10px] px-3 py-2 rounded-lg font-bold border border-orange-300 flex items-center gap-1.5 cursor-not-allowed">
                                                <i class="fa-solid fa-hourglass-half"></i> #KRN-{{ $ut->id }} Divalidasi Admin
                                            </span>
                                        @elseif($ut->status_pembayaran == 'Menunggu Tinjauan')
                                            <span class="bg-blue-100 text-blue-800 text-[10px] px-3 py-2 rounded-lg font-bold border border-blue-300 flex items-center gap-1.5 cursor-not-allowed">
                                                <i class="fa-solid fa-calculator"></i> #KRN-{{ $ut->id }} Menunggu Harga
                                            </span>
                                        @endif
                                    @endforeach
                                </div>

                                @if($unpaidTickets->count() > 3)
                                    <div class="mt-3 border-t border-orange-200 pt-2">
                                        <span class="text-[10px] text-orange-700 font-bold italic">+ {{ $unpaidTickets->count() - 3 }} pesanan lainnya. Cek di menu riwayat.</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-white">
                            <h3 class="font-black text-gray-800 text-lg flex items-center gap-2"><i class="fa-solid fa-ticket text-blue-600"></i> Perjalanan Terdekat</h3>
                        </div>
                        <div class="p-6 bg-gray-50/50">
                            @if($upcomingTicket)
                            <div class="bg-white rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] border border-gray-200 flex flex-col sm:flex-row overflow-hidden relative">
                                <div class="hidden sm:block absolute left-[28%] top-0 bottom-0 w-px border-l-2 border-dashed border-gray-200"></div>
                                <div class="hidden sm:block absolute left-[28%] -top-3 w-6 h-6 bg-gray-50/50 rounded-full border border-gray-200 transform -translate-x-1/2"></div>
                                <div class="hidden sm:block absolute left-[28%] -bottom-3 w-6 h-6 bg-gray-50/50 rounded-full border border-gray-200 transform -translate-x-1/2"></div>

                                <div class="bg-blue-600 text-white p-6 sm:w-[28%] flex flex-col justify-center items-center text-center">
                                    <div class="text-[10px] font-bold uppercase tracking-widest opacity-80 mb-1">Berangkat</div>
                                    <div class="text-3xl font-black leading-none">{{ \Carbon\Carbon::parse($upcomingTicket->tanggal_berangkat)->format('d') }}</div>
                                    <div class="text-sm font-bold uppercase">{{ \Carbon\Carbon::parse($upcomingTicket->tanggal_berangkat)->format('M Y') }}</div>
                                    <div class="mt-4 bg-white p-2 rounded-lg"><i class="fa-solid fa-qrcode text-3xl text-gray-900"></i></div>
                                </div>
                                <div class="p-6 flex-1 flex flex-col justify-center bg-white">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <span class="text-[9px] font-black text-blue-600 bg-blue-50 px-2 py-1 rounded uppercase border border-blue-100">{{ $upcomingTicket->booking_type == 'charter' ? 'Charter / Sewa' : 'Reguler' }}</span>
                                            <h4 class="text-xl font-black text-gray-900 mt-2">{{ $upcomingTicket->bus_name }}</h4>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-[10px] font-bold text-gray-400 uppercase">Jam Standby</div>
                                            <div class="font-black text-gray-800 text-lg">{{ \Carbon\Carbon::parse($upcomingTicket->jam_berangkat)->format('H:i') }}</div>
                                        </div>
                                    </div>
                                    <div class="flex gap-4 border-t border-gray-100 pt-4">
                                        <div>
                                            <p class="text-[9px] text-gray-400 uppercase font-bold">Rute / Tujuan</p>
                                            <p class="text-xs font-bold text-gray-800 line-clamp-1">{{ $upcomingTicket->titik_jemput }} - {{ $upcomingTicket->titik_turun }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                @php $routeDl = $upcomingTicket->booking_type == 'charter' ? 'tickets.charter.download' : 'tickets.download'; @endphp
                                <a href="{{ route($routeDl, $upcomingTicket->id) }}" class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 px-4 py-2 rounded-xl transition">
                                    <i class="fa-solid fa-download"></i> Download E-Ticket
                                </a>
                            </div>
                            @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400 text-2xl"><i class="fa-solid fa-ticket-simple"></i></div>
                                <p class="text-sm font-bold text-gray-500">Belum ada perjalanan terdekat.</p>
                                <a href="{{ route('tickets.index') }}" class="text-[10px] font-bold text-blue-600 hover:underline mt-2 inline-block">Pesan Tiket Sekarang</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-5 border-b border-gray-50 bg-white">
                            <h3 class="font-black text-gray-800 text-sm flex items-center gap-2"><i class="fa-solid fa-box-open text-orange-500"></i> Lacak Pengiriman</h3>
                        </div>
                        <div class="p-5 bg-gray-50/50">
                            @forelse($activeCargos as $cargo)
                            <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm mb-3 last:mb-0">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="font-bold text-gray-800 text-xs">{{ $cargo->jenis_barang }}</div>
                                    <span class="text-[8px] font-black text-white bg-orange-500 px-2 py-0.5 rounded uppercase shadow-sm">{{ $cargo->status_pengiriman }}</span>
                                </div>
                                <div class="text-[9px] text-gray-500 font-medium mb-3">Resi: #KRN-C{{ str_pad($cargo->id, 5, '0', STR_PAD_LEFT) }}</div>
                                
                                <div class="bg-gray-50 p-2 rounded-lg border border-gray-100">
                                    <div class="flex items-center gap-2 text-[10px]">
                                        <i class="fa-solid fa-location-dot text-red-500"></i>
                                        <span class="font-bold text-gray-700 line-clamp-1">Posisi: {{ $cargo->lokasi_terkini ?? 'Loket Pusat' }}</span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-6">
                                <p class="text-xs font-bold text-gray-400 italic">Tidak ada pengiriman aktif.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-5 border-b border-gray-50 bg-white">
                            <h3 class="font-black text-gray-800 text-sm flex items-center gap-2"><i class="fa-solid fa-clock-rotate-left text-gray-400"></i> Aktivitas Terkini</h3>
                        </div>
                        <div class="p-5">
                            <ul class="space-y-4">
                                @forelse($recentTickets as $rt)
                                <li class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $rt->status_pembayaran == 'Lunas' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                        <i class="fa-solid {{ $rt->booking_type == 'charter' ? 'fa-van-shuttle' : 'fa-bus' }} text-[10px]"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs font-bold text-gray-800">Tiket {{ ucfirst($rt->booking_type) }}</p>
                                        <p class="text-[9px] text-gray-500">{{ \Carbon\Carbon::parse($rt->created_at)->diffForHumans() }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[9px] font-black {{ $rt->status_pembayaran == 'Lunas' ? 'text-green-600' : 'text-orange-500' }}">{{ $rt->status_pembayaran }}</span>
                                    </div>
                                </li>
                                @empty
                                <li class="text-center text-xs text-gray-400 italic">Belum ada riwayat transaksi.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="mb-4">
                    <h3 class="font-black text-gray-800 text-lg">Pusat Informasi</h3>
                    <p class="text-xs text-gray-500">Pelajari lebih lanjut tentang layanan Kirana Tongkonan Transport.</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('tentang-kami') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:border-blue-300 hover:shadow-md transition text-left group block">
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-3 group-hover:bg-blue-600 group-hover:text-white transition">
                            <i class="fa-solid fa-circle-info text-lg"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm">Tentang Kami</h4>
                        <p class="text-[10px] text-gray-400 mt-1 line-clamp-2">Profil dan sejarah Kirana Tongkonan.</p>
                    </a>

                    <a href="{{ route('informasi-bus') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:border-indigo-300 hover:shadow-md transition text-left group block">
                        <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mb-3 group-hover:bg-indigo-600 group-hover:text-white transition">
                            <i class="fa-solid fa-bus-simple text-lg"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm">Informasi Armada</h4>
                        <p class="text-[10px] text-gray-400 mt-1 line-clamp-2">Fasilitas dan rute yang tersedia.</p>
                    </a>

                    <a href="{{ route('kontak') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:border-green-300 hover:shadow-md transition text-left group block">
                        <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center mb-3 group-hover:bg-green-600 group-hover:text-white transition">
                            <i class="fa-solid fa-headset text-lg"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm">Kontak Bantuan</h4>
                        <p class="text-[10px] text-gray-400 mt-1 line-clamp-2">Hubungi CS atau kunjungi kantor kami.</p>
                    </a>

                    <a href="{{ route('syarat-ketentuan') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:border-orange-300 hover:shadow-md transition text-left group block">
                        <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center mb-3 group-hover:bg-orange-600 group-hover:text-white transition">
                            <i class="fa-solid fa-file-contract text-lg"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm">Syarat & Ketentuan</h4>
                        <p class="text-[10px] text-gray-400 mt-1 line-clamp-2">Aturan pemesanan tiket dan kargo.</p>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>