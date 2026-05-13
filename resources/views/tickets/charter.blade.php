<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Layanan Kirana Charter (Sewa Unit)') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Pilih Jadwal Bus (Unit Free)</h3>
                    <span class="text-[10px] bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-black uppercase">Charter Service</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-[11px] font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Informasi Bus</th>
                                <th class="px-6 py-4">Wilayah Standby</th>
                                <th class="px-6 py-4">Tersedia Mulai</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($schedules as $bus)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-5">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold shadow-sm">
                                            <i class="fa-solid fa-bus"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">{{ $bus->nama_bus }}</div>
                                            <div class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $bus->kapasitas }} Kursi</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-[10px] font-bold border border-gray-200 uppercase">
                                        {{ $bus->rute }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="font-bold text-gray-800">{{ $bus->tanggal_berangkat->format('d M Y') }}</div>
                                    <div class="text-[11px] text-gray-400 italic">Standby: {{ \Carbon\Carbon::parse($bus->jam_berangkat)->format('H:i') }} WITA</div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <button onclick="openCharterForm({{ $bus->id }}, '{{ $bus->nama_bus }}', '{{ $bus->tanggal_berangkat->format('Y-m-d') }}')" 
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl text-xs font-bold shadow-lg shadow-indigo-100 transition">
                                        Pesan Unit
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="charter-form-container" class="hidden bg-white shadow-xl sm:rounded-[2.5rem] overflow-hidden border border-gray-100 border-t-8 border-indigo-600">
                <div class="p-8 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-black text-gray-900 uppercase">Detail Rute & Waktu Sewa</h3>
                        <p class="text-xs text-gray-500 mt-1 uppercase font-bold tracking-widest">Bus: <span id="display-bus-name" class="text-indigo-600"></span></p>
                    </div>
                    <button type="button" onclick="document.getElementById('charter-form-container').classList.add('hidden')" class="text-gray-400 hover:text-red-500 text-2xl font-bold">&times;</button>
                </div>

                <div class="p-8 lg:p-12">
                    <form id="charterForm" action="{{ route('tickets.charter.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="schedule_id" id="input-schedule-id">
                        <input type="hidden" name="tanggal" id="input-tanggal">
                        
                        <div class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <x-input-label value="Nama Lengkap / Instansi" />
                                    <x-text-input name="nama_penumpang" type="text" class="block mt-1 w-full bg-gray-50" value="{{ Auth::user()->name }}" required />
                                </div>
                                <div>
                                    <x-input-label value="Nomor WhatsApp" />
                                    <x-text-input name="nomor_telepon" type="text" class="block mt-1 w-full bg-gray-50" value="{{ Auth::user()->phone ?? Auth::user()->no_telp ?? '' }}" required />
                                </div>
                                <div>
                                    <x-input-label value="Jam Keberangkatan Diinginkan" />
                                    <x-text-input name="jam_berangkat" type="time" class="block mt-1 w-full bg-indigo-50 border-indigo-200" required />
                                    <p class="text-[9px] text-indigo-500 mt-1 font-medium italic">* Anda bebas menentukan jam berangkat sendiri.</p>
                                </div>
                                <div>
                                    <x-input-label value="Tipe Perjalanan" />
                                    <select name="trip_type" class="block mt-1 w-full border-gray-300 rounded-xl focus:ring-indigo-500 text-sm" required>
                                        <option value="one_way">Sekali Jalan (One Way)</option>
                                        <option value="round_trip">Pulang Pergi (Round Trip)</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2 bg-indigo-50 p-4 rounded-2xl border border-indigo-100 flex items-center">
                                    <p class="text-[10px] text-indigo-700 font-bold uppercase leading-tight">
                                        <i class="fa-solid fa-info-circle mr-1 text-base"></i> Harga akan dihitung manual oleh admin setelah meninjau detail rute dan jam keberangkatan Anda.
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label value="Titik Penjemputan" />
                                    <textarea name="pickup_point" class="block mt-1 w-full border-gray-300 rounded-2xl bg-gray-50 text-sm" rows="3" placeholder="Contoh: Jl. Ahmad Yani No. 5, Depan Toko..." required></textarea>
                                </div>
                                <div>
                                    <x-input-label value="Titik Tujuan" />
                                    <textarea name="destination_point" class="block mt-1 w-full border-gray-300 rounded-2xl bg-gray-50 text-sm" rows="3" placeholder="Contoh: Lokasi Wisata / Alamat lengkap tujuan..." required></textarea>
                                </div>
                            </div>

                            <button type="button" onclick="confirmCharter()" class="w-full h-14 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black shadow-lg shadow-indigo-100 transition-all flex items-center justify-center gap-3 uppercase tracking-widest">
                                <span>Kirim Permintaan Sewa</span>
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Riwayat Sewa Unit Saya</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-[11px] font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Informasi Bus</th>
                                <th class="px-6 py-4">Detail Rute</th>
                                <th class="px-6 py-4">Waktu</th> 
                                <th class="px-6 py-4 text-center">Tipe Perjalanan</th>
                                <th class="px-6 py-4 text-center">Harga</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($myTickets as $t)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-5 font-bold text-gray-900 uppercase">
                                    {{ $t->bus_name }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-[10px] font-bold text-blue-600 uppercase">Jemput: {{ Str::limit($t->titik_jemput, 30) }}</div>
                                    <div class="text-[10px] font-bold text-indigo-600 uppercase">Tujuan: {{ Str::limit($t->titik_turun, 30) }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="font-bold text-gray-800">{{ $t->tanggal_berangkat->format('d M Y') }}</div>
                                    <div class="text-xs text-indigo-600 font-black italic">Pukul: {{ \Carbon\Carbon::parse($t->jam_berangkat)->format('H:i') }} WITA</div>
                                </td>
                                
                                <td class="px-6 py-5 text-center">
                                    @if($t->trip_type == 'round_trip')
                                        <span class="text-[10px] font-bold text-indigo-600 uppercase bg-indigo-50 px-2 py-1 rounded">Pulang Pergi</span>
                                    @else
                                        <span class="text-[10px] font-bold text-gray-600 uppercase bg-gray-100 px-2 py-1 rounded">Sekali Jalan</span>
                                    @endif
                                </td>

                                <td class="px-6 py-5 text-center">
                                    @if($t->total_bayar && $t->total_bayar > 0)
                                        <span class="text-xs font-black text-green-600">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-[10px] text-gray-400 italic">Menunggu Admin</span>
                                    @endif
                                </td>

                                <td class="px-6 py-5 text-center">
                                    @if($t->status_pembayaran == 'Menunggu Tinjauan')
                                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase bg-orange-100 text-orange-700 border border-orange-200">
                                            Menunggu Harga
                                        </span>
                                    @elseif($t->status_pembayaran == 'Menunggu Pembayaran')
                                        <a href="{{ route('tickets.payment', $t->id) }}" class="px-3 py-1 rounded-full text-[9px] font-black uppercase bg-blue-600 text-white shadow-sm hover:bg-blue-700 transition">
                                            Bayar Tiket
                                        </a>
                                    @elseif($t->status_pembayaran == 'Dibatalkan')
                                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase bg-red-100 text-red-700 border border-red-200">
                                            Dibatalkan
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase bg-green-100 text-green-700 border border-green-200">
                                            {{ $t->status_pembayaran }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        
                                        @if($t->status_pembayaran == 'Lunas')
                                            <a href="{{ route('tickets.charter.download', $t->id) }}" class="text-[10px] font-bold text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-lg transition w-full flex items-center justify-center gap-1 shadow-sm">
                                                <i class="fa-solid fa-download"></i> Tiket
                                            </a>
                                        @endif

                                        @if($t->status_pembayaran == 'Menunggu Tinjauan')
                                            <button type="button" onclick="batalPesanan({{ $t->id }})" class="text-[10px] font-bold text-orange-600 hover:text-orange-800 bg-orange-50 hover:bg-orange-100 px-3 py-1 rounded-lg transition w-full">
                                                Batalkan
                                            </button>
                                            <form id="batal-form-{{ $t->id }}" action="{{ route('tickets.charter.cancel', $t->id) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('PATCH')
                                            </form>
                                        @endif
                                        
                                        <button type="button" onclick="hapusRiwayat({{ $t->id }})" class="text-[10px] font-bold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-lg transition w-full">
                                            Hapus
                                        </button>
                                        <form id="hapus-form-{{ $t->id }}" action="{{ route('tickets.charter.destroy', $t->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="px-6 py-10 text-center text-gray-400 italic">Belum ada riwayat sewa unit.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openCharterForm(scheduleId, busName, date) {
            const container = document.getElementById('charter-form-container');
            container.classList.remove('hidden');
            
            document.getElementById('input-schedule-id').value = scheduleId;
            document.getElementById('input-tanggal').value = date;
            document.getElementById('display-bus-name').innerText = busName;

            window.scrollTo({
                top: container.offsetTop - 50,
                behavior: 'smooth'
            });
        }

        function confirmCharter() {
            const form = document.getElementById('charterForm');
            if (!form.pickup_point.value || !form.destination_point.value || !form.nomor_telepon.value || !form.jam_berangkat.value) {
                Swal.fire('Data Kurang', 'Lengkapi titik jemput, tujuan, nomor telepon, dan jam keberangkatan.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Kirim Permintaan?',
                text: "Admin akan segera menghitung biaya sewa berdasarkan rute dan jam pilihan Anda.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                confirmButtonText: 'Ya, Kirim'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        }

        function batalPesanan(id) {
            Swal.fire({
                title: 'Batalkan Pesanan?',
                text: "Apakah Anda yakin ingin membatalkan pengajuan sewa ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f97316', 
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('batal-form-' + id).submit();
                }
            });
        }

        function hapusRiwayat(id) {
            Swal.fire({
                title: 'Hapus Riwayat?',
                text: "Data riwayat ini akan dihapus permanen dari daftar Anda.",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', 
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('hapus-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>