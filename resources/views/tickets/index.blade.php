<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg md:text-xl text-gray-800 leading-tight">
            {{ __('Layanan Kirana Ticket') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-8 md:py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 md:space-y-8">
            
            <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                <div class="p-4 md:p-6 border-b border-gray-50">
                    <h3 class="text-base md:text-lg font-bold text-gray-800">Daftar Jadwal Bus</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs md:text-sm text-left min-w-[700px]">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-[9px] md:text-[11px] font-bold tracking-wider">
                            <tr>
                                <th class="px-4 py-3 md:px-6 md:py-4">Informasi Bus</th>
                                <th class="px-4 py-3 md:px-6 md:py-4">Rute Keberangkatan</th>
                                <th class="px-4 py-3 md:px-6 md:py-4">Waktu & Tanggal</th>
                                <th class="px-4 py-3 md:px-6 md:py-4">Harga Tiket</th>
                                <th class="px-4 py-3 md:px-6 md:py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($schedules as $bus)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 md:px-6 md:py-5">
                                    <div class="flex items-center space-x-3 md:space-x-4">
                                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-[10px] md:text-xs shadow-sm">
                                            {{ substr($bus->nama_bus, -1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 text-sm md:text-base">{{ $bus->nama_bus }}</div>
                                            <div class="text-[9px] md:text-[10px] text-gray-400">Kapasitas: {{ $bus->kapasitas }} Kursi</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 md:px-6 md:py-5">
                                    <span class="px-2 py-1 md:px-3 md:py-1 bg-gray-100 text-gray-600 rounded-md text-[9px] md:text-[10px] font-bold border border-gray-200 uppercase">
                                        {{ $bus->rute }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 md:px-6 md:py-5">
                                    <div class="font-bold text-gray-800 text-xs md:text-sm">{{ $bus->tanggal_berangkat->format('d M Y') }}</div>
                                    <div class="text-[9px] md:text-[11px] text-orange-500 font-medium italic">Jam {{ \Carbon\Carbon::parse($bus->jam_berangkat)->format('H:i') }} WITA</div>
                                </td>
                                <td class="px-4 py-3 md:px-6 md:py-5 font-bold text-emerald-600 text-sm md:text-base">
                                    Rp {{ number_format($bus->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 md:px-6 md:py-5 text-center">
                                    <button onclick="openForm({{ $bus->id }}, '{{ addslashes($bus->nama_bus) }}', {{ $bus->harga }}, '{{ $bus->tanggal_berangkat->format('Y-m-d') }} {{ $bus->jam_berangkat }}', {{ $bus->kapasitas }})" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 md:px-6 md:py-2 rounded-xl text-[10px] md:text-xs font-bold shadow-lg shadow-blue-100 transition whitespace-nowrap">
                                        Pesan Tiket
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="form-container" class="hidden bg-white shadow-xl sm:rounded-2xl p-5 md:p-8 border-t-4 border-blue-600">
                <div class="flex justify-between items-center mb-4 md:mb-6 text-center md:text-left">
                    <div class="w-full md:w-auto">
                        <h3 class="text-xl md:text-2xl font-extrabold text-gray-900 uppercase">Kirana Tongkonan Transport</h3>
                        <p class="text-[10px] md:text-xs text-gray-500 mt-1 uppercase font-bold tracking-widest">Bus: <span id="display-bus" class="text-blue-600"></span></p>
                    </div>
                    <button onclick="document.getElementById('form-container').classList.add('hidden')" class="text-gray-400 hover:text-red-500 text-xl md:text-2xl font-bold ml-4">&times;</button>
                </div>

                <form id="ticketForm" action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="schedule_id" id="input-schedule-id">
                    <input type="hidden" name="ticket_id" id="input-ticket-id">
                    <input type="hidden" name="bus_name" id="input-bus">
                    <input type="hidden" name="harga_satuan" id="input-harga">
                    <input type="hidden" name="tanggal_berangkat" id="input-tanggal">
                    <input type="hidden" name="action" id="form-action">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                        
                        <div class="bg-gray-200 p-5 md:p-8 rounded-3xl md:rounded-[40px] border-4 border-gray-300 shadow-inner max-w-[320px] mx-auto lg:mx-0 w-full">
                            <div class="flex justify-between items-center mb-6 md:mb-8 px-2 md:px-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-8 h-8 md:w-10 md:h-10 bg-yellow-400 rounded-xl flex items-center justify-center text-white font-black shadow-sm text-xs md:text-base">KN</div>
                                    <span class="text-[7px] md:text-[8px] font-bold text-gray-500 mt-1 uppercase">Kernet</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-8 h-8 md:w-10 md:h-10 bg-yellow-400 rounded-xl flex items-center justify-center text-white font-black shadow-sm text-xs md:text-base">SP</div>
                                    <span class="text-[7px] md:text-[8px] font-bold text-gray-500 mt-1 uppercase">Sopir</span>
                                </div>
                            </div>

                            <div id="dynamic-seat-grid" class="grid grid-cols-5 gap-y-3 md:gap-y-4 gap-x-2"></div>

                            <div class="mt-8 md:mt-10 flex flex-wrap justify-center gap-3 md:gap-4 text-[8px] md:text-[9px] font-bold uppercase border-t border-gray-300 pt-4 md:pt-6">
                                <div class="flex items-center gap-1"><div class="w-2.5 h-2.5 md:w-3 md:h-3 bg-white border border-gray-400 rounded"></div> Kosong</div>
                                <div class="flex items-center gap-1"><div class="w-2.5 h-2.5 md:w-3 md:h-3 bg-red-500 rounded"></div> Terisi</div>
                                <div class="flex items-center gap-1"><div class="w-2.5 h-2.5 md:w-3 md:h-3 bg-green-500 rounded"></div> Pilih</div>
                            </div>
                        </div>

                        <div class="lg:col-span-2 space-y-4 md:space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                <div><x-input-label value="Nama Penumpang" /><x-text-input name="nama_penumpang" id="nama_penumpang" type="text" class="block mt-1 w-full bg-gray-50 font-bold text-sm md:text-base" value="{{ Auth::user()->name }}" required /></div>
                                <div><x-input-label value="Nomor Telepon" /><x-text-input name="nomor_telepon" id="nomor_telepon" type="text" class="block mt-1 w-full bg-gray-50 font-bold text-sm md:text-base" value="{{ Auth::user()->phone ?? '' }}" required /></div>
                                <div>
                                    <x-input-label value="Status Penumpang" />
                                    <select name="kategori_penumpang" id="kategori" onchange="handleCategoryChange()" class="block mt-1 w-full border-gray-300 rounded-xl focus:ring-blue-500 text-sm md:text-base">
                                        <option value="Umum">Umum</option>
                                        <option value="Mahasiswa">Mahasiswa (Diskon 50rb)</option>
                                    </select>
                                </div>
                                <div><x-input-label value="Jumlah Kursi" /><x-text-input name="jumlah_kursi" id="qty" type="number" min="1" max="5" value="1" onchange="updateSeatSelection()" class="block mt-1 w-full text-sm md:text-base" required /></div>
                            </div>

                            <div id="bukti-mahasiswa-container" class="hidden p-3 md:p-4 bg-orange-50 border border-orange-200 rounded-2xl mt-4">
                                <x-input-label value="Upload Bukti Mahasiswa (KTM / KRS Aktif)" class="text-orange-700 font-bold" />
                                <input type="file" name="bukti_ktm" id="bukti_ktm" accept="image/*,.pdf" class="mt-2 block w-full text-xs md:text-sm text-gray-500 file:mr-4 file:py-1.5 md:file:py-2 file:px-3 md:file:px-4 file:rounded-full file:border-0 file:text-xs md:file:text-sm file:font-semibold file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200" />
                                <p class="mt-2 text-[9px] md:text-[10px] text-orange-600 italic">*Wajib diunggah untuk mendapatkan potongan harga Mahasiswa.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 pt-4 border-t border-gray-100">
                                <div><x-input-label value="Titik Jemput" /><x-text-input name="titik_jemput" id="titik_jemput" type="text" class="block mt-1 w-full text-sm md:text-base" required /></div>
                                <div><x-input-label value="Titik Turun" /><x-text-input name="titik_turun" id="titik_turun" type="text" class="block mt-1 w-full text-sm md:text-base" required /></div>
                            </div>

                            <div class="mt-6 md:mt-8 p-4 md:p-6 bg-blue-50 rounded-2xl md:rounded-3xl flex justify-between items-center border border-blue-100 shadow-inner">
                                <span class="text-xs md:text-sm font-bold text-blue-900 uppercase">Total Estimasi:</span>
                                <span id="total-price-display" class="text-2xl md:text-3xl font-black text-blue-600 tracking-tighter">Rp 0</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4 mt-6 md:mt-8 items-start">
                                <div>
                                    <button type="button" onclick="submitForm('draft')" class="w-full py-3 md:py-4 rounded-xl md:rounded-2xl border-2 border-slate-800 text-slate-800 font-bold hover:bg-slate-50 transition text-sm md:text-base">Simpan Draft</button>
                                    <p class="text-[9px] md:text-[10px] text-red-500 mt-2 text-center font-bold leading-tight">*PENTING: Draft tidak mengunci kursi.</p>
                                </div>
                                <button type="button" onclick="submitForm('confirm')" class="h-12 md:h-14 rounded-xl md:rounded-2xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition shadow-xl text-sm md:text-base">Konfirmasi & Lanjut Bayar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                <div class="p-4 md:p-6 border-b border-gray-50">
                    <h3 class="text-base md:text-lg font-bold text-gray-800">Riwayat Pesanan Saya</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs md:text-sm text-left min-w-[750px]">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-[9px] md:text-[11px] font-bold tracking-wider">
                            <tr>
                                <th class="px-4 py-3 md:px-6 md:py-4">Informasi Bus</th>
                                <th class="px-4 py-3 md:px-6 md:py-4">Rute</th>
                                <th class="px-4 py-3 md:px-6 md:py-4">Waktu & Tanggal</th>
                                <th class="px-4 py-3 md:px-6 md:py-4 text-center">Status</th>
                                <th class="px-4 py-3 md:px-6 md:py-4 text-center">Kursi</th>
                                <th class="px-4 py-3 md:px-6 md:py-4 text-right">Total</th>
                                <th class="px-4 py-3 md:px-6 md:py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($myTickets as $t)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 md:px-6 md:py-5">
                                    <div class="font-bold text-gray-900 uppercase text-xs md:text-sm">{{ $t->bus_name }}</div>
                                    <div class="text-[9px] md:text-[10px] text-gray-400 italic">ID: #{{ $t->id }}</div>
                                </td>
                                <td class="px-4 py-3 md:px-6 md:py-5 font-bold text-gray-600 uppercase text-[9px] md:text-[10px]">
                                    {{ $t->schedule->rute ?? 'MANADO-TORAJA' }}
                                </td>
                                <td class="px-4 py-3 md:px-6 md:py-5">
                                    <div class="font-bold text-gray-800 text-xs md:text-sm">{{ $t->tanggal_berangkat->format('d M Y') }}</div>
                                    <div class="text-[9px] md:text-[10px] text-gray-500 tracking-tighter">{{ \Carbon\Carbon::parse($t->tanggal_berangkat)->format('H:i') }} WITA</div>
                                </td>
                                <td class="px-4 py-3 md:px-6 md:py-5 text-center">
                                    <span class="px-2 py-1 md:px-3 md:py-1 rounded-full text-[8px] md:text-[9px] font-bold uppercase whitespace-nowrap
                                        @if($t->status_pembayaran == 'Lunas') bg-green-100 text-green-700 
                                        @elseif($t->status_pembayaran == 'Menunggu Validasi') bg-blue-100 text-blue-700
                                        @else bg-yellow-100 text-yellow-700 @endif">
                                        {{ $t->status_pembayaran }}
                                    </span>
                                    @if($t->status_pembayaran == 'Ditolak' && $t->alasan_penolakan)
                                        <div class="mt-2 text-[8px] md:text-[9px] text-red-600 bg-red-50 p-1 md:p-1.5 rounded border border-red-100 text-left leading-tight">
                                            <span class="font-bold">Alasan:</span> {{ $t->alasan_penolakan }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 md:px-6 md:py-5">
                                    <div class="flex flex-wrap justify-center gap-1">
                                        @foreach(is_array($t->nomor_kursi) ? $t->nomor_kursi : json_decode($t->nomor_kursi, true) as $seat)
                                            <span class="bg-blue-50 text-blue-700 px-1.5 py-0.5 md:px-2 md:py-0.5 rounded text-[9px] md:text-[10px] font-bold border border-blue-100">{{ $seat }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-4 py-3 md:px-6 md:py-5 font-bold text-blue-600 text-right text-xs md:text-sm whitespace-nowrap">
                                    Rp {{ number_format($t->total_bayar, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 md:px-6 md:py-5 text-center">
                                    <div class="flex justify-center gap-1.5 md:gap-2">
                                        @if($t->status_pembayaran == 'Draft')
                                            <button onclick='openEditForm(@json($t))' class="bg-orange-500 text-white px-2 py-1 md:px-3 md:py-1.5 rounded-lg text-[9px] md:text-[10px] font-bold hover:bg-orange-600 whitespace-nowrap">Lanjut</button>
                                            <button onclick="confirmDelete('{{ route('tickets.destroy', $t->id) }}')" class="bg-red-500 text-white px-2 py-1 md:px-3 md:py-1.5 rounded-lg text-[9px] md:text-[10px] font-bold hover:bg-red-600 whitespace-nowrap">Hapus</button>
                                        @elseif($t->status_pembayaran == 'Menunggu Pembayaran')
                                            <a href="{{ route('tickets.payment', $t->id) }}" class="bg-blue-600 text-white px-2 py-1 md:px-4 md:py-1.5 rounded-lg text-[9px] md:text-[10px] font-bold hover:bg-blue-700 whitespace-nowrap">Bayar</a>
                                            <button onclick="confirmDelete('{{ route('tickets.destroy', $t->id) }}')" class="bg-red-500 text-white px-2 py-1 md:px-3 md:py-1.5 rounded-lg text-[9px] md:text-[10px] font-bold hover:bg-red-600 whitespace-nowrap">Batal</button>
                                        @elseif($t->status_pembayaran == 'Menunggu Validasi')
                                            @if($t->bukti_pembayaran)
                                                <a href="{{ asset('storage/'.$t->bukti_pembayaran) }}" target="_blank" class="bg-indigo-600 text-white px-2 py-1 md:px-4 md:py-1.5 rounded-lg text-[9px] md:text-[10px] font-bold hover:bg-indigo-700 shadow-sm flex items-center gap-1 whitespace-nowrap">
                                                    <i class="fa-solid fa-file-invoice"></i> Cek
                                                </a>
                                            @endif
                                            <button onclick="confirmDelete('{{ route('tickets.destroy', $t->id) }}')" class="bg-red-500 text-white px-2 py-1 md:px-3 md:py-1.5 rounded-lg text-[9px] md:text-[10px] font-bold hover:bg-red-600 shadow-sm whitespace-nowrap">Batal</button>
                                        @elseif($t->status_pembayaran == 'Lunas')
                                            <a href="{{ route('tickets.download', $t->id) }}" class="bg-emerald-600 text-white px-3 py-1 md:px-4 md:py-1.5 rounded-lg text-[9px] md:text-[10px] font-bold hover:bg-emerald-700 transition whitespace-nowrap">Download</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="px-4 py-8 md:px-6 md:py-10 text-center text-gray-400 italic text-xs md:text-sm">Belum ada riwayat pemesanan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <form id="deleteForm" method="POST" class="hidden">@csrf @method('DELETE')</form>

    <script>
        const bookedSeatsBySchedule = @json($bookedSeats);
        let currentBusCapacity = 33; 

        function openForm(scheduleId, name, price, departure, capacity) {
            document.getElementById('ticketForm').reset();
            document.getElementById('input-ticket-id').value = "";
            document.getElementById('input-schedule-id').value = scheduleId; 
            document.getElementById('nama_penumpang').value = "{{ addslashes(Auth::user()->name) }}";
            document.getElementById('nomor_telepon').value = "{{ Auth::user()->phone ?? '' }}";
            
            handleCategoryChange(); 
            
            const container = document.getElementById('form-container');
            container.classList.remove('hidden');
            document.getElementById('display-bus').innerText = name;
            document.getElementById('input-bus').value = name;
            document.getElementById('input-harga').value = price;
            document.getElementById('input-tanggal').value = departure;
            currentBusCapacity = capacity || 33; 
            
            renderSeatGrid(scheduleId);
            calculateTotal();
            window.scrollTo({ top: container.offsetTop - 50, behavior: 'smooth' });
        }

        function handleCategoryChange() {
            const kategori = document.getElementById('kategori').value;
            const container = document.getElementById('bukti-mahasiswa-container');
            const fileInput = document.getElementById('bukti_ktm');
            
            if (kategori === 'Mahasiswa') {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
                fileInput.value = ''; 
            }
            calculateTotal();
        }

        function renderSeatGrid(scheduleId, currentTicketSeats = []) {
            const grid = document.getElementById('dynamic-seat-grid');
            grid.innerHTML = ''; 
            const idKey = scheduleId.toString();
            const bookedForThisSchedule = bookedSeatsBySchedule[idKey] || [];
            for (let i = 1; i <= currentBusCapacity; i++) {
                const isBooked = bookedForThisSchedule.some(s => s.toString() === i.toString());
                const isMySeat = currentTicketSeats.some(s => s.toString() === i.toString());
                const disabled = (isBooked && !isMySeat) ? 'disabled' : '';
                const bgClass = (isBooked && !isMySeat) ? 'bg-red-500 border-red-600 text-white opacity-70 cursor-not-allowed' : 'bg-white border-gray-300 text-gray-700 hover:border-blue-500';
                const checked = isMySeat ? 'checked' : '';
                const activeBg = isMySeat ? 'bg-green-500 border-green-600 text-white shadow-lg' : '';
                const seatHTML = `<label id="label-seat-${i}" class="relative flex items-center justify-center p-2.5 md:p-3 border-2 rounded-xl shadow-sm transition-all duration-200 cursor-pointer font-black text-[9px] md:text-[10px] ${bgClass} ${activeBg}"><input type="checkbox" name="nomor_kursi[]" value="${i}" class="seat-checkbox hidden" onchange="handleSeatClick(this, ${i})" ${disabled} ${checked}>${i < 10 ? '0' + i : i}</label>`;
                grid.insertAdjacentHTML('beforeend', seatHTML);
                if (i <= 28 && i % 4 === 2) grid.insertAdjacentHTML('beforeend', '<div class="w-full"></div>');
            }
        }

        function openEditForm(t) {
            const container = document.getElementById('form-container');
            container.classList.remove('hidden');
            document.getElementById('input-ticket-id').value = t.id;
            document.getElementById('input-schedule-id').value = t.schedule_id; 
            fillFormData(t);
            handleCategoryChange(); 
            
            currentBusCapacity = t.schedule ? t.schedule.kapasitas : 33;
            let savedSeats = [];
            try { savedSeats = typeof t.nomor_kursi === 'string' ? JSON.parse(t.nomor_kursi) : t.nomor_kursi; } catch(e){}
            
            renderSeatGrid(t.schedule_id, savedSeats);
            calculateTotal();
            window.scrollTo({ top: container.offsetTop - 50, behavior: 'smooth' });
        }

        function fillFormData(t) {
            document.getElementById('display-bus').innerText = t.bus_name;
            document.getElementById('input-bus').value = t.bus_name;
            document.getElementById('input-harga').value = t.total_bayar / t.jumlah_kursi;
            document.getElementById('input-tanggal').value = t.tanggal_berangkat;
            document.getElementById('nama_penumpang').value = t.nama_penumpang;
            document.getElementById('nomor_telepon').value = t.nomor_telepon;
            document.getElementById('kategori').value = t.kategori_penumpang;
            document.getElementById('qty').value = t.jumlah_kursi;
            document.getElementById('titik_jemput').value = t.titik_jemput;
            document.getElementById('titik_turun').value = t.titik_turun;
        }

        function handleSeatClick(checkbox, id) {
            let limit = parseInt(document.getElementById('qty').value);
            const label = document.getElementById('label-seat-' + id);
            if (document.querySelectorAll('.seat-checkbox:checked').length > limit) {
                Swal.fire('Batas Kursi', 'Maksimal ' + limit + ' kursi.', 'warning');
                checkbox.checked = false;
                return;
            }
            if (checkbox.checked) {
                label.className = "relative flex items-center justify-center p-2.5 md:p-3 border-2 bg-green-500 border-green-600 text-white rounded-xl shadow-lg scale-110 transition-all font-black text-[9px] md:text-[10px]";
            } else {
                label.className = "relative flex items-center justify-center p-2.5 md:p-3 border-2 bg-white border-gray-300 text-gray-700 rounded-xl shadow-sm transition-all font-black text-[9px] md:text-[10px]";
            }
            calculateTotal();
        }

        function calculateTotal() {
            let qty = parseInt(document.getElementById('qty').value) || 0;
            let hargaDasar = parseInt(document.getElementById('input-harga').value) || 0;
            let kategori = document.getElementById('kategori').value;
            let total = (hargaDasar - (kategori === 'Mahasiswa' ? 50000 : 0)) * qty;
            document.getElementById('total-price-display').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        function updateSeatSelection() {
            const scheduleId = document.getElementById('input-schedule-id').value;
            renderSeatGrid(scheduleId);
            calculateTotal();
        }

        function submitForm(type) {
            const form = document.getElementById('ticketForm');
            document.getElementById('form-action').value = type;
            const qtyRequired = parseInt(document.getElementById('qty').value);
            const seatsSelected = document.querySelectorAll('.seat-checkbox:checked').length;
            const kategori = document.getElementById('kategori').value;
            const buktiFile = document.getElementById('bukti_ktm').value;
            
            if (!form.nama_penumpang.value || !form.nomor_telepon.value || !form.titik_jemput.value || !form.titik_turun.value) {
                Swal.fire('Data Tidak Lengkap', 'Harap lengkapi semua informasi penumpang dan rute.', 'error'); return;
            }
            
            if (kategori === 'Mahasiswa' && !buktiFile && type === 'confirm') {
                Swal.fire('Bukti Mahasiswa Wajib', 'Silakan upload foto/pdf KTM atau KRS Anda sebelum lanjut konfirmasi bayar.', 'warning'); return;
            }

            if (seatsSelected !== qtyRequired) {
                Swal.fire('Pilih Kursi', `Harap pilih tepat ${qtyRequired} kursi pada denah.`, 'warning'); return;
            }

            if (type === 'draft') {
                Swal.fire({ 
                    title: 'Simpan ke Draft?', 
                    text: 'Kursi yang Anda pilih belum terkunci dan masih bisa dipesan oleh orang lain sebelum Anda membayarnya.',
                    icon: 'info', 
                    showCancelButton: true, 
                    confirmButtonText: 'Ya, Simpan'
                }).then((result) => { if (result.isConfirmed) form.submit(); });
            } else {
                Swal.fire({ 
                    title: 'Konfirmasi Pesanan?', 
                    text: 'Anda akan diarahkan ke halaman pembayaran.',
                    icon: 'question', 
                    showCancelButton: true, 
                    confirmButtonText: 'Lanjut Bayar'
                }).then((result) => { if (result.isConfirmed) form.submit(); });
            }
        }

        function confirmDelete(url) {
            Swal.fire({ 
                title: 'Batalkan Pesanan?', 
                text: "Kursi ini akan dilepas kembali.",
                icon: 'warning', 
                showCancelButton: true, 
                confirmButtonColor: '#d33', 
                confirmButtonText: 'Ya, Batalkan'
            }).then((result) => { 
                if (result.isConfirmed) { 
                    const form = document.getElementById('deleteForm'); 
                    form.action = url; 
                    form.submit(); 
                }
            });
        }
    </script>
</x-app-layout>