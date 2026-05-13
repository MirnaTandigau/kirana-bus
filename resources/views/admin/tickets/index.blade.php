<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Tiket & Manifest</h2>
    </x-slot>

    <div class="py-12 bg-gray-50" x-data="{ tab: 'manajemen' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 flex space-x-2 overflow-x-auto">
                <button @click="tab = 'manajemen'" 
                        :class="{ 'bg-blue-600 text-white shadow-md': tab === 'manajemen', 'text-gray-600 hover:bg-gray-100': tab !== 'manajemen' }"
                        class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all duration-200 whitespace-nowrap focus:outline-none">
                    <i class="fa-solid fa-desktop mr-2"></i> Manajemen Loket & Validasi
                </button>
                <button @click="tab = 'riwayat'" 
                        :class="{ 'bg-blue-600 text-white shadow-md': tab === 'riwayat', 'text-gray-600 hover:bg-gray-100': tab !== 'riwayat' }"
                        class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all duration-200 whitespace-nowrap focus:outline-none">
                    <i class="fa-solid fa-clipboard-check mr-2"></i> Riwayat Divalidasi & Cetak Manifest
                </button>
            </div>

            <div x-show="tab === 'manajemen'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="space-y-8">
                
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
                    <div class="border-b pb-4 mb-6">
                        <h3 class="text-xl font-black text-gray-800 uppercase tracking-wide">KIRANA TONGKONAN TRANSPORT</h3>
                        <p class="text-xs font-bold text-blue-600 uppercase mt-1">Pendaftaran Penumpang Loket (Offline)</p>
                    </div>

                    <form action="{{ route('admin.tickets.store_manual') }}" method="POST" id="adminManualForm" class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                        @csrf
                        
                        <div class="lg:col-span-5 flex justify-center">
                            <div class="bg-[#E5E7EB] rounded-[2.5rem] p-8 w-full max-w-[320px] shadow-inner flex flex-col items-center relative">
                                
                                <div class="flex justify-between w-full px-6 mb-8">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-10 bg-yellow-400 text-yellow-900 font-black rounded-lg flex items-center justify-center mb-2 shadow-sm text-sm">KN</div>
                                        <span class="text-[9px] text-gray-500 font-black uppercase tracking-wider">Kernet</span>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-10 bg-yellow-400 text-yellow-900 font-black rounded-lg flex items-center justify-center mb-2 shadow-sm text-sm">SP</div>
                                        <span class="text-[9px] text-gray-500 font-black uppercase tracking-wider">Sopir</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-5 gap-3 w-full px-2">
                                    @for($i=1; $i<=28; $i++)
                                        <label id="admin-label-seat-{{ $i }}" class="relative flex items-center justify-center h-10 border border-gray-300 bg-white cursor-pointer text-gray-600 rounded-lg text-xs transition shadow-sm hover:border-blue-400">
                                            <input type="checkbox" name="nomor_kursi[]" value="{{ $i }}" class="admin-seat-checkbox hidden" onchange="handleAdminSeatClick(this)">
                                            <span class="font-bold">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</span>
                                        </label>
                                        @if($i % 2 == 0 && $i % 4 != 0)
                                            <div class="col-span-1"></div>
                                        @endif
                                    @endfor
                                    
                                    @for($i=29; $i<=33; $i++)
                                        <label id="admin-label-seat-{{ $i }}" class="relative flex items-center justify-center h-10 border border-gray-300 bg-white cursor-pointer text-gray-600 rounded-lg text-xs transition shadow-sm hover:border-blue-400">
                                            <input type="checkbox" name="nomor_kursi[]" value="{{ $i }}" class="admin-seat-checkbox hidden" onchange="handleAdminSeatClick(this)">
                                            <span class="font-bold">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</span>
                                        </label>
                                    @endfor
                                </div>

                                <div class="flex flex-wrap gap-x-4 gap-y-2 mt-8 text-[9px] font-bold text-gray-700 justify-center uppercase w-full">
                                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-white border border-gray-400"></span> Kosong</div>
                                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-green-600"></span> Pilih</div>
                                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-red-500"></span> Lunas</div>
                                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-orange-600"></span> Validasi</div>
                                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-blue-400"></span> Pending</div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-7 flex flex-col justify-between">
                            <div class="space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1">Jadwal Keberangkatan</label>
                                        <select name="schedule_id" id="admin-schedule-select" class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" required onchange="updateAdminSeatMap(this.value)">
                                            <option value="">-- Pilih Jadwal Bus --</option>
                                            @foreach($schedules as $s)
                                                <option value="{{ $s->id }}">{{ $s->nama_bus }} - {{ $s->rute }} ({{ \Carbon\Carbon::parse($s->tanggal_berangkat)->format('d M') }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1">Nama Penumpang</label>
                                        <input type="text" name="nama_penumpang" class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1">Nomor Telepon / WA</label>
                                        <input type="text" name="nomor_telepon" class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1">Status Penumpang</label>
                                        <select name="kategori_penumpang" id="admin-kategori" class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" required onchange="calculateAdminTotal()">
                                            <option value="Umum">Umum</option>
                                            <option value="Mahasiswa">Mahasiswa (Disc Rp 50.000)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1">Titik Jemput</label>
                                        <input type="text" name="titik_jemput" class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1">Titik Turun</label>
                                        <input type="text" name="titik_turun" class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8">
                                <div class="bg-[#EEF2FF] rounded-2xl p-6 flex justify-between items-center mb-6">
                                    <span class="text-sm font-bold text-blue-900 uppercase">Total Estimasi:</span>
                                    <span id="admin-total-display" class="text-3xl font-black text-blue-600">Rp 0</span>
                                </div>

                                <button type="submit" class="w-full bg-blue-600 text-white rounded-xl font-bold py-4 hover:bg-blue-700 transition shadow-lg text-lg">
                                    Konfirmasi & Lanjut Bayar (Cash)
                                </button>
                                <input type="hidden" id="admin-hidden-harga-dasar" value="0">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                    <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 text-lg">Validasi Tiket <span class="text-blue-600">Reguler</span></h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full">Butuh Tindakan</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-white text-gray-500 uppercase text-[10px] font-bold border-b">
                                <tr>
                                    <th class="px-6 py-4">Penumpang & Rute</th>
                                    <th class="px-6 py-4">Tanggal Keberangkatan</th>
                                    <th class="px-6 py-4">Total Bayar</th>
                                    <th class="px-6 py-4 text-center">Bukti / Dokumen</th>
                                    <th class="px-6 py-4 text-center">Aksi Validasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($allTickets->where('booking_type', 'reguler')->whereIn('status_pembayaran', ['Menunggu Pembayaran', 'Menunggu Validasi', 'Draft']) as $t)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ $t->nama_penumpang }}</div>
                                        <div class="text-[10px] text-gray-500 mt-1 uppercase font-semibold">
                                            {{ $t->bus_name }} | {{ $t->schedule->rute ?? '-' }}<br>
                                            <span class="text-blue-600 font-bold">Kursi: 
                                            @php
                                                $seats = is_array($t->nomor_kursi) ? $t->nomor_kursi : json_decode($t->nomor_kursi, true);
                                                echo is_array($seats) ? implode(', ', $seats) : $t->nomor_kursi;
                                            @endphp
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($t->tanggal_berangkat)->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-black text-blue-700">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center flex flex-col gap-2 items-center justify-center">
                                        @if($t->bukti_pembayaran)
                                            <a href="{{ asset('storage/'.$t->bukti_pembayaran) }}" target="_blank" class="text-blue-600 font-bold hover:underline flex items-center justify-center text-[10px] bg-blue-50 px-2 py-1 rounded-md border border-blue-200 w-full">
                                                Lihat Bukti Transfer
                                            </a>
                                        @else
                                            <span class="text-gray-400 font-bold text-[10px]">-</span>
                                        @endif
                                        @if($t->kategori_penumpang == 'Mahasiswa' && $t->bukti_ktm)
                                            <a href="{{ asset('storage/'.$t->bukti_ktm) }}" target="_blank" class="text-purple-600 font-bold hover:underline flex items-center justify-center text-[10px] bg-purple-50 px-2 py-1 rounded-md border border-purple-200 w-full">
                                                Lihat KTM/KRS
                                            </a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col items-center justify-center">
                                            @if($t->status_pembayaran == 'Menunggu Validasi')
                                                <span class="text-[10px] font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-md border border-orange-200 mb-2 block w-full text-center">Perlu Divalidasi</span>
                                            @else
                                                <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md border border-gray-200 mb-2 block w-full text-center">Belum Bayar</span>
                                            @endif
                                            <div class="flex space-x-2">
                                                <form action="{{ route('admin.tickets.validate', $t->id) }}" method="POST" onsubmit="return confirm('Tandai pesanan ini LUNAS?')">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="Lunas">
                                                    <button type="submit" class="w-8 h-8 bg-green-500 text-white rounded-xl shadow-md flex items-center justify-center hover:scale-110 transition" title="Validasi Lunas">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.tickets.validate', $t->id) }}" method="POST" onsubmit="return tolakPembayaran(this)">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="Ditolak">
                                                    <button type="submit" class="w-8 h-8 bg-red-500 text-white rounded-xl shadow-md flex items-center justify-center hover:scale-110 transition" title="Tolak">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400 italic">Tidak ada pesanan reguler yang menunggu validasi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                    <div class="p-6 border-b border-gray-100 bg-indigo-50 flex justify-between items-center">
                        <h3 class="font-bold text-indigo-900 text-lg">Validasi Sewa <span class="text-indigo-600">Charter / Full Unit</span></h3>
                        <span class="bg-indigo-200 text-indigo-800 text-xs font-bold px-3 py-1 rounded-full">Butuh Tindakan</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-white text-gray-500 uppercase text-[10px] font-bold border-b">
                                <tr>
                                    <th class="px-6 py-4">Penyewa & Rute</th>
                                    <th class="px-6 py-4">Tanggal & Jam</th>
                                    <th class="px-6 py-4 text-center">Tipe Perjalanan</th> 
                                    <th class="px-6 py-4">Total Bayar</th>
                                    <th class="px-6 py-4 text-center">Bukti / Dokumen</th>
                                    <th class="px-6 py-4 text-center">Aksi Validasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($allTickets->where('booking_type', 'charter')->whereIn('status_pembayaran', ['Menunggu Pembayaran', 'Menunggu Validasi', 'Menunggu Tinjauan', 'Draft']) as $t)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ $t->nama_penumpang }}</div>
                                        <div class="text-[10px] text-gray-500 mt-1">
                                            <span class="font-bold text-indigo-600">Jemput:</span> {{ $t->titik_jemput }}<br>
                                            <span class="font-bold text-orange-600">Tujuan:</span> {{ $t->titik_turun }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($t->tanggal_berangkat)->format('d M Y') }}</div>
                                        <div class="text-[10px] text-indigo-600 font-bold mt-1">JAM: {{ \Carbon\Carbon::parse($t->jam_berangkat)->format('H:i') ?? '-' }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        @if($t->trip_type == 'round_trip')
                                            <span class="text-[10px] font-bold text-indigo-600 uppercase bg-indigo-50 px-2 py-1 rounded border border-indigo-100">Pulang Pergi</span>
                                        @else
                                            <span class="text-[10px] font-bold text-gray-600 uppercase bg-gray-100 px-2 py-1 rounded border border-gray-200">Sekali Jalan</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($t->total_bayar > 0)
                                            <span class="text-sm font-black text-indigo-700">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-xs italic text-gray-400">Belum ditentukan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center flex flex-col gap-2 items-center justify-center">
                                        @if($t->bukti_pembayaran)
                                            <a href="{{ asset('storage/'.$t->bukti_pembayaran) }}" target="_blank" class="text-indigo-600 font-bold hover:underline flex items-center justify-center text-[10px] bg-indigo-50 px-2 py-1 rounded-md border border-indigo-200 w-full">
                                                Lihat Bukti Transfer
                                            </a>
                                        @else
                                            <span class="text-gray-400 font-bold text-[10px]">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col items-center justify-center w-full max-w-[120px] mx-auto">
                                            @if($t->status_pembayaran == 'Menunggu Tinjauan')
                                                <form action="{{ route('admin.tickets.set_price', $t->id) }}" method="POST" class="flex flex-col gap-2 w-full">
                                                    @csrf @method('PATCH')
                                                    <input type="number" name="total_bayar" class="w-full text-xs rounded-lg border-gray-300 text-center" placeholder="Harga Rp" required>
                                                    <button type="submit" class="w-full bg-indigo-600 text-white px-2 py-1.5 rounded-lg text-xs font-bold shadow-md hover:bg-indigo-700">Kirim Harga</button>
                                                </form>
                                            @else
                                                @if($t->status_pembayaran == 'Menunggu Validasi')
                                                    <span class="text-[10px] font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-md border border-orange-200 mb-2 block w-full text-center">Perlu Divalidasi</span>
                                                @else
                                                    <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md border border-gray-200 mb-2 block w-full text-center">Belum Bayar</span>
                                                @endif
                                                <div class="flex space-x-2">
                                                    <form action="{{ route('admin.tickets.validate', $t->id) }}" method="POST" onsubmit="return confirm('Tandai pesanan charter ini LUNAS?')">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="Lunas">
                                                        <button type="submit" class="w-8 h-8 bg-green-500 text-white rounded-xl shadow-md flex items-center justify-center hover:scale-110 transition" title="Validasi Lunas">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.tickets.validate', $t->id) }}" method="POST" onsubmit="return tolakPembayaran(this)">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="Ditolak">
                                                        <button type="submit" class="w-8 h-8 bg-red-500 text-white rounded-xl shadow-md flex items-center justify-center hover:scale-110 transition" title="Tolak">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400 italic">Tidak ada pesanan charter yang menunggu validasi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div x-show="tab === 'riwayat'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="space-y-8">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h3 class="font-black text-gray-800 text-lg uppercase">Tiket Lunas & Manifest</h3>
                        <p class="text-xs text-gray-500 font-medium">Gunakan fitur ini untuk mencetak daftar penumpang sebelum bus berangkat.</p>
                    </div>
                    <form action="{{ route('admin.tickets.print') }}" method="GET" target="_blank" class="flex items-center gap-2 w-full md:w-auto">
                        <select name="schedule_id" class="rounded-lg text-sm border-gray-300 focus:ring-green-500 w-full md:w-64" required>
                            <option value="">-- Pilih Jadwal Bus --</option>
                            @foreach($schedules as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_bus }} ({{ \Carbon\Carbon::parse($s->tanggal_berangkat)->format('d M') }})</option>
                            @endforeach
                        </select>
                        <button type="submit" class="inline-flex items-center justify-center text-sm bg-gray-900 text-white px-5 py-2.5 rounded-lg font-bold shadow-md hover:bg-gray-800 whitespace-nowrap">
                            <i class="fa-solid fa-print mr-2"></i> Cetak Manifest
                        </button>
                    </form>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 text-lg">Riwayat Validasi <span class="text-blue-600">Reguler</span></h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-500 uppercase text-[10px] font-bold">
                                <tr>
                                    <th class="px-6 py-4">Penumpang & Rute</th>
                                    <th class="px-6 py-4">Tanggal Keberangkatan</th>
                                    <th class="px-6 py-4">Total Bayar</th>
                                    <th class="px-6 py-4 text-center">Bukti / Dokumen</th>
                                    <th class="px-6 py-4 text-center">Status Akhir</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($allTickets->where('booking_type', 'reguler')->whereIn('status_pembayaran', ['Lunas', 'Ditolak']) as $t)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ $t->nama_penumpang }}</div>
                                        <div class="text-[10px] text-gray-500 uppercase font-medium mt-1">
                                            {{ $t->bus_name }} | {{ $t->schedule->rute ?? '-' }}<br>
                                            <span class="text-gray-700 font-bold">Kursi: 
                                            @php
                                                $seats = is_array($t->nomor_kursi) ? $t->nomor_kursi : json_decode($t->nomor_kursi, true);
                                                echo is_array($seats) ? implode(', ', $seats) : $t->nomor_kursi;
                                            @endphp
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($t->tanggal_berangkat)->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-black text-gray-700">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($t->is_manual_booking)
                                            <span class="text-[10px] font-bold text-green-700 bg-green-100 px-3 py-1 rounded border border-green-200">CASH (OFFLINE)</span>
                                        @elseif($t->bukti_pembayaran)
                                            <a href="{{ asset('storage/'.$t->bukti_pembayaran) }}" target="_blank" class="text-[10px] font-bold text-blue-600 hover:underline">Lihat Bukti</a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($t->status_pembayaran == 'Lunas')
                                            <span class="inline-flex items-center text-green-600 font-bold text-xs bg-green-50 px-3 py-1 rounded-lg border border-green-200"><i class="fa-solid fa-check mr-1.5"></i> Lunas</span>
                                        @else
                                            <span class="inline-flex items-center text-red-600 font-bold text-xs bg-red-50 px-3 py-1 rounded-lg border border-red-200"><i class="fa-solid fa-xmark mr-1.5"></i> Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($t->status_pembayaran == 'Lunas')
                                            <a href="{{ route('tickets.download', $t->id) }}" class="inline-flex items-center justify-center bg-gray-800 text-white text-[10px] font-bold px-3 py-2 rounded-lg hover:bg-gray-700 transition">
                                                <i class="fa-solid fa-download mr-1.5"></i> Tiket
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400 italic">Belum ada data tiket reguler yang selesai divalidasi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 text-lg">Riwayat Validasi <span class="text-indigo-600">Charter</span></h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-500 uppercase text-[10px] font-bold">
                                <tr>
                                    <th class="px-6 py-4">Penyewa & Rute</th>
                                    <th class="px-6 py-4">Tanggal & Jam Keberangkatan</th>
                                    <th class="px-6 py-4 text-center">Tipe Perjalanan</th>
                                    <th class="px-6 py-4">Total Bayar</th>
                                    <th class="px-6 py-4 text-center">Bukti / Dokumen</th>
                                    <th class="px-6 py-4 text-center">Status Akhir</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($allTickets->where('booking_type', 'charter')->whereIn('status_pembayaran', ['Lunas', 'Ditolak']) as $t)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ $t->nama_penumpang }}</div>
                                        <div class="text-[10px] text-gray-500 uppercase font-medium mt-1">
                                            Jemput: {{ $t->titik_jemput }}<br>
                                            Tujuan: {{ $t->titik_turun }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($t->tanggal_berangkat)->format('d M Y') }}</div>
                                        <div class="text-[10px] text-indigo-600 font-bold mt-1">JAM: {{ \Carbon\Carbon::parse($t->jam_berangkat)->format('H:i') ?? '-' }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        @if($t->trip_type == 'round_trip')
                                            <span class="text-[10px] font-bold text-indigo-600 uppercase bg-indigo-50 px-2 py-1 rounded border border-indigo-100">Pulang Pergi</span>
                                        @else
                                            <span class="text-[10px] font-bold text-gray-600 uppercase bg-gray-100 px-2 py-1 rounded border border-gray-200">Sekali Jalan</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="text-sm font-black text-gray-700">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($t->is_manual_booking)
                                            <span class="text-[10px] font-bold text-green-700 bg-green-100 px-3 py-1 rounded border border-green-200">CASH (OFFLINE)</span>
                                        @elseif($t->bukti_pembayaran)
                                            <a href="{{ asset('storage/'.$t->bukti_pembayaran) }}" target="_blank" class="text-[10px] font-bold text-blue-600 hover:underline">Lihat Bukti</a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($t->status_pembayaran == 'Lunas')
                                            <span class="inline-flex items-center text-green-600 font-bold text-xs bg-green-50 px-3 py-1 rounded-lg border border-green-200"><i class="fa-solid fa-check mr-1.5"></i> Lunas</span>
                                        @else
                                            <span class="inline-flex items-center text-red-600 font-bold text-xs bg-red-50 px-3 py-1 rounded-lg border border-red-200"><i class="fa-solid fa-xmark mr-1.5"></i> Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($t->status_pembayaran == 'Lunas')
                                            <a href="{{ route('tickets.download', $t->id) }}" class="inline-flex items-center justify-center bg-gray-800 text-white text-[10px] font-bold px-3 py-2 rounded-lg hover:bg-gray-700 transition">
                                                <i class="fa-solid fa-download mr-1.5"></i> Tiket
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400 italic">Belum ada data sewa charter yang selesai divalidasi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        function tolakPembayaran(formElement) {
            let alasan = prompt("Masukkan alasan penolakan:");
            if (alasan === null) return false; 
            if (alasan.trim() === "") {
                alert("Gagal: Alasan penolakan wajib diisi!");
                return false;
            }
            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "alasan_penolakan";
            input.value = alasan;
            formElement.appendChild(input);
            return true; 
        }

        // Script Warna & Denah Kursi Realistis
        const bookedSeatsWithStatus = @json($bookedSeatsWithStatus);
        const schedulesData = @json($schedules); 

        function updateAdminSeatMap(scheduleId) {
            if (!scheduleId) {
                document.getElementById('admin-total-display').innerText = "Rp 0";
                return;
            }
            const selectedSchedule = schedulesData.find(s => s.id == scheduleId);
            if (selectedSchedule) {
                document.getElementById('admin-hidden-harga-dasar').value = selectedSchedule.harga;
            }

            const seatsData = bookedSeatsWithStatus[scheduleId] || {};
            
            document.querySelectorAll('.admin-seat-checkbox').forEach(cb => {
                const seatNum = parseInt(cb.value);
                const label = document.getElementById('admin-label-seat-' + seatNum);
                
                cb.disabled = false;
                cb.checked = false;
                
                let status = seatsData[seatNum] || seatsData[seatNum.toString()];

                if (status) {
                    cb.disabled = true;
                    if (status === 'Lunas') {
                        label.className = "relative flex items-center justify-center h-10 border border-red-600 bg-red-500 text-white cursor-not-allowed rounded-lg text-xs shadow-sm";
                    } else if (status === 'Menunggu Validasi') {
                        label.className = "relative flex items-center justify-center h-10 border border-orange-500 bg-orange-400 text-white cursor-not-allowed rounded-lg text-xs shadow-sm";
                    } else if (status === 'Menunggu Pembayaran' || status === 'Draft') {
                        label.className = "relative flex items-center justify-center h-10 border border-blue-500 bg-blue-400 text-white cursor-not-allowed rounded-lg text-xs shadow-sm";
                    }
                } else {
                    label.className = "relative flex items-center justify-center h-10 border border-gray-300 bg-white cursor-pointer text-gray-600 rounded-lg text-xs transition shadow-sm hover:border-blue-400";
                }
            });
            calculateAdminTotal();
        }

        function calculateAdminTotal() {
            const hargaDasar = parseInt(document.getElementById('admin-hidden-harga-dasar').value) || 0;
            const kategori = document.getElementById('admin-kategori').value;
            const jumlahTerpilih = document.querySelectorAll('.admin-seat-checkbox:checked').length;
            const potongan = (kategori === 'Mahasiswa') ? 50000 : 0;
            const total = (hargaDasar - potongan) * jumlahTerpilih;
            document.getElementById('admin-total-display').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        function handleAdminSeatClick(checkbox) {
            const label = document.getElementById('admin-label-seat-' + checkbox.value);
            if (checkbox.checked) {
                label.className = "relative flex items-center justify-center h-10 border border-green-700 bg-green-600 text-white rounded-lg text-xs transition shadow-md scale-105";
            } else {
                label.className = "relative flex items-center justify-center h-10 border border-gray-300 bg-white cursor-pointer text-gray-600 rounded-lg text-xs transition shadow-sm hover:border-blue-400";
            }
            calculateAdminTotal();
        }
    </script>
</x-app-layout>