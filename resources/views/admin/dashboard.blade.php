<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-gauge-high mr-2 text-blue-600"></i> {{ __('Admin Control Panel') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-gradient-to-r from-blue-800 to-indigo-900 rounded-[2rem] p-8 md:p-10 text-white shadow-xl flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 opacity-10 pointer-events-none">
                    <svg class="w-64 h-64 transform translate-x-1/3 -translate-y-1/4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 22h20L12 2zm0 4.5l6.5 13h-13L12 6.5z"/></svg>
                </div>

                <div class="z-10 w-full md:w-1/2">
                    <h3 class="text-3xl font-black mb-2 tracking-tight">Selamat Datang, Admin! 👋</h3>
                    <p class="text-blue-200 text-sm font-medium leading-relaxed">
                        Pusat kendali operasi Kirana Tongkonan. Selesaikan tiket yang menunggu validasi, perbarui status ekspedisi, dan pantau performa layanan hari ini.
                    </p>
                </div>

                <div class="z-10 w-full md:w-auto flex gap-4">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 text-center min-w-[120px] {{ $totalTiketBaru > 0 ? 'ring-2 ring-orange-400 animate-pulse' : '' }}">
                        <div class="text-3xl font-black">{{ $totalTiketBaru }}</div>
                        <div class="text-[10px] text-blue-200 uppercase font-bold mt-1">Antrean Tiket</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 text-center min-w-[120px] {{ $cargoPending > 0 ? 'ring-2 ring-orange-400 animate-pulse' : '' }}">
                        <div class="text-3xl font-black">{{ $cargoPending }}</div>
                        <div class="text-[10px] text-blue-200 uppercase font-bold mt-1">Antrean Ekspedisi</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
                
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-gray-50 bg-white flex justify-between items-center">
                        <h3 class="font-black text-gray-800 text-lg flex items-center gap-2">
                            <span class="w-8 h-8 rounded-full bg-red-100 text-red-500 flex items-center justify-center text-xs"><i class="fa-solid fa-bell"></i></span>
                            Tiket Butuh Tindakan
                        </h3>
                        <a href="{{ route('admin.tickets.index') }}" class="text-[10px] font-bold text-blue-600 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="p-4 flex-1">
                        <ul class="divide-y divide-gray-50">
                            @forelse($pendingTickets as $ticket)
                            <li class="py-3 px-2 hover:bg-gray-50 rounded-xl transition flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg {{ $ticket->booking_type == 'charter' ? 'bg-indigo-100 text-indigo-600' : 'bg-emerald-100 text-emerald-600' }} flex items-center justify-center">
                                        <i class="fa-solid {{ $ticket->booking_type == 'charter' ? 'fa-van-shuttle' : 'fa-bus' }}"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-black text-gray-900">{{ $ticket->nama_penumpang }}</div>
                                        <div class="text-[10px] text-gray-500 mt-0.5">ID: KRN-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }} • {{ ucfirst($ticket->booking_type) }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($ticket->status_pembayaran == 'Menunggu Validasi')
                                        <span class="inline-block bg-orange-100 text-orange-700 text-[9px] font-bold px-2 py-1 rounded border border-orange-200 mb-1">Cek Transfer</span>
                                    @elseif($ticket->status_pembayaran == 'Menunggu Tinjauan')
                                        <span class="inline-block bg-blue-100 text-blue-700 text-[9px] font-bold px-2 py-1 rounded border border-blue-200 mb-1">Beri Harga Charter</span>
                                    @endif
                                    <br>
                                    <a href="{{ route('admin.tickets.index') }}" class="text-[10px] font-bold text-gray-400 hover:text-blue-600 transition">Proses <i class="fa-solid fa-angle-right ml-1"></i></a>
                                </div>
                            </li>
                            @empty
                            <li class="py-10 text-center text-gray-400">
                                <i class="fa-solid fa-check-circle text-3xl mb-2 text-gray-200"></i>
                                <p class="text-xs font-bold uppercase tracking-wider">Semua Tiket Tervalidasi</p>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-gray-50 bg-white flex justify-between items-center">
                        <h3 class="font-black text-gray-800 text-lg flex items-center gap-2">
                            <span class="w-8 h-8 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center text-xs"><i class="fa-solid fa-box-open"></i></span>
                            Cargo Menunggu Timbang
                        </h3>
                        <a href="{{ route('admin.cargos.index') }}" class="text-[10px] font-bold text-blue-600 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="p-4 flex-1">
                        <ul class="divide-y divide-gray-50">
                            @forelse($pendingCargosList as $cargo)
                            <li class="py-3 px-2 hover:bg-gray-50 rounded-xl transition flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 text-gray-500 flex items-center justify-center overflow-hidden border border-gray-200">
                                        @if($cargo->foto_barang)
                                            <img src="{{ asset('storage/' . $cargo->foto_barang) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-box"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-xs font-black text-gray-900 line-clamp-1">{{ $cargo->jenis_barang }}</div>
                                        <div class="text-[10px] text-gray-500 mt-0.5">Dari: {{ $cargo->nama_pengirim }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block bg-gray-100 text-gray-600 text-[9px] font-bold px-2 py-1 rounded border border-gray-200 mb-1">Input Berat/Harga</span>
                                    <br>
                                    <a href="{{ route('admin.cargos.index') }}" class="text-[10px] font-bold text-gray-400 hover:text-orange-600 transition">Timbang <i class="fa-solid fa-angle-right ml-1"></i></a>
                                </div>
                            </li>
                            @empty
                            <li class="py-10 text-center text-gray-400">
                                <i class="fa-solid fa-boxes-packing text-3xl mb-2 text-gray-200"></i>
                                <p class="text-xs font-bold uppercase tracking-wider">Tidak Ada Antrean Barang</p>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Pendapatan (Lunas)</div>
                        <div class="text-2xl font-black text-gray-900">Rp {{ number_format($totalPendapatanTiket + $totalPendapatanCargo, 0, ',', '.') }}</div>
                        <div class="mt-2 flex gap-3 text-[10px] font-bold">
                            <span class="text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">Tiket: Rp {{ number_format($totalPendapatanTiket, 0, ',', '.') }}</span>
                            <span class="text-orange-600 bg-orange-50 px-2 py-1 rounded-md">Ekspedisi: Rp {{ number_format($totalPendapatanCargo, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-green-50 text-green-500 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Pelanggan Terdaftar</div>
                        <div class="text-2xl font-black text-gray-900">{{ $totalUser }} <span class="text-sm text-gray-500 font-medium">Pengguna</span></div>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>