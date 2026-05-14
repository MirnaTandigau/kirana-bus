<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg md:text-xl text-gray-800 leading-tight">
            {{ __('Layanan Kirana Ekspedisi') }}
        </h2>
    </x-slot>

    <div class="py-8 md:py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 md:space-y-8">
            
            <div class="bg-white shadow-xl sm:rounded-2xl p-5 md:p-8 lg:p-10 border-t-4 border-green-600">
                <div class="mb-6 md:mb-8">
                    <h3 class="text-xl md:text-2xl lg:text-3xl font-extrabold text-gray-900">Formulir Pengiriman Barang</h3>
                    <p class="text-xs md:text-sm lg:text-base text-gray-500 mt-2">Pastikan data pengirim dan penerima sudah benar untuk memudahkan koordinasi.</p>
                </div>

                <form action="{{ route('cargos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 md:gap-8">
                        <div class="space-y-4 p-5 md:p-6 lg:p-8 bg-gray-50 rounded-2xl border border-gray-100">
                            <h4 class="font-bold text-blue-800 uppercase text-[10px] md:text-xs tracking-widest mb-3 md:mb-4 flex items-center">
                                <span class="bg-blue-100 p-1 rounded mr-2">📦</span> Data Pengirim Asal
                            </h4>
                            <div>
                                <x-input-label value="Nama Pengirim" />
                                <x-text-input name="nama_pengirim" type="text" class="block mt-1 w-full text-sm md:text-base" required />
                            </div>
                            <div>
                                <x-input-label value="No. Telepon Pengirim (Opsional)" />
                                <x-text-input name="telepon_pengirim" type="text" class="block mt-1 w-full text-sm md:text-base" placeholder="08..." />
                            </div>
                            <div>
                                <x-input-label value="Kantor Perwakilan Pengiriman" />
                                <select name="kantor_pengiriman" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 transition text-sm md:text-base" required>
                                    <option value="" disabled selected>Pilih Kantor Asal</option>
                                    <option value="Perwakilan Manado">Kantor Perwakilan Manado</option>
                                    <option value="Perwakilan Tondano">Kantor Perwakilan Tondano</option>
                                    <option value="Perwakilan Makale">Kantor Perwakilan Makale</option>
                                    <option value="Perwakilan Rantepao">Kantor Perwakilan Rantepao</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-4 p-5 md:p-6 lg:p-8 bg-gray-50 rounded-2xl border border-gray-100">
                            <h4 class="font-bold text-green-800 uppercase text-[10px] md:text-xs tracking-widest mb-3 md:mb-4 flex items-center">
                                <span class="bg-green-100 p-1 rounded mr-2">📍</span> Data Penerima Tujuan
                            </h4>
                            <div>
                                <x-input-label value="Nama Penerima" />
                                <x-text-input name="nama_penerima" type="text" class="block mt-1 w-full text-sm md:text-base" required />
                            </div>
                            <div>
                                <x-input-label value="No. Telepon Penerima" />
                                <x-text-input name="telepon_penerima" type="text" class="block mt-1 w-full text-sm md:text-base" placeholder="Wajib untuk info pengambilan" required />
                            </div>
                            <div>
                                <x-input-label value="Kantor Perwakilan Pengambilan" />
                                <select name="perwakilan_ambil" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 transition text-sm md:text-base" required>
                                    <option value="" disabled selected>Pilih Kantor Tujuan</option>
                                    <option value="Perwakilan Manado">Kantor Perwakilan Manado</option>
                                    <option value="Perwakilan Tondano">Kantor Perwakilan Tondano</option>
                                    <option value="Perwakilan Makale">Kantor Perwakilan Makale</option>
                                    <option value="Perwakilan Rantepao">Kantor Perwakilan Rantepao</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 md:mt-8 p-5 md:p-6 lg:p-8 bg-white border-2 border-dashed border-gray-200 rounded-2xl">
                        <h4 class="font-bold text-gray-700 uppercase text-[10px] md:text-xs tracking-widest mb-3 md:mb-4">Informasi Barang</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                            <div class="space-y-4">
                                <div>
                                    <x-input-label value="Jenis Barang" />
                                    <select name="jenis_barang" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm md:text-base" required>
                                        <option value="Dokumen">Dokumen / Surat</option>
                                        <option value="Pakaian">Pakaian / Tekstil</option>
                                        <option value="Elektronik">Elektronik</option>
                                        <option value="Makanan">Makanan / Sembako</option>
                                        <option value="Lainnya">Lain-lain</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label value="Estimasi Berat (Kg)" />
                                    <x-text-input name="berat_kg" type="number" step="0.1" min="0.5" class="block mt-1 w-full text-sm md:text-base" required />
                                </div>
                                <div>
                                    <x-input-label value="Foto Barang" />
                                    <input type="file" name="foto_barang" class="block mt-1 w-full text-xs md:text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs md:file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" accept="image/*" />
                                    <p class="text-[9px] md:text-[10px] text-gray-400 mt-1">*Format: JPG, PNG (Maks 2MB)</p>
                                </div>
                            </div>
                            <div>
                                <x-input-label value="Deskripsi Detail Barang" />
                                <textarea name="deskripsi_barang" rows="5" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 text-sm md:text-base" placeholder="Misal: Laptop Asus Seri X, 2 Box Mie Instan Rasa Kaldu, Pakaian Adat Toraja 3 Set" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 md:mt-8 flex justify-end">
                        <button type="submit" class="bg-green-600 text-white text-sm md:text-base px-6 py-3 md:px-10 md:py-4 rounded-xl font-bold hover:bg-green-700 transition shadow-lg shadow-green-200 uppercase tracking-wider w-full md:w-auto">
                            Daftarkan Pengiriman
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-2xl p-5 md:p-8 border border-gray-100">
                <h3 class="text-base md:text-lg lg:text-xl font-bold mb-4 md:mb-6 text-gray-800 flex items-center">
                    <span class="mr-2">📋</span> Riwayat Pengiriman Barang Anda
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs md:text-sm text-left min-w-[600px]">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-[10px] md:text-xs font-bold tracking-wider">
                            <tr>
                                <th class="px-4 py-3 md:px-6 md:py-4">Informasi Barang</th>
                                <th class="px-4 py-3 md:px-6 md:py-4">Pengirim & Penerima</th>
                                <th class="px-4 py-3 md:px-6 md:py-4">Rute Kantor</th>
                                <th class="px-4 py-3 md:px-6 md:py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($cargos as $cargo)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 md:px-6 md:py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            @if($cargo->foto_barang)
                                                <img src="{{ asset('storage/' . $cargo->foto_barang) }}" class="w-10 h-10 md:w-12 md:h-12 rounded-lg object-cover border shadow-sm">
                                            @else
                                                <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-gray-100 flex items-center justify-center text-[9px] md:text-[10px] text-gray-400">No Image</div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 text-xs md:text-sm">{{ $cargo->jenis_barang }}</div>
                                            <div class="text-[9px] md:text-[10px] text-gray-500 italic line-clamp-1" title="{{ $cargo->deskripsi_barang }}">{{ $cargo->deskripsi_barang }}</div>
                                            <div class="text-[9px] md:text-[10px] font-semibold text-blue-600 mt-1">{{ $cargo->berat_kg }} Kg</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 md:px-6 md:py-4">
                                    <div class="text-[10px] md:text-xs"><span class="font-bold text-gray-400">DARI:</span> {{ $cargo->nama_pengirim }}</div>
                                    <div class="text-[10px] md:text-xs mt-1 text-green-700 font-medium"><span class="font-bold text-gray-400">KE:</span> {{ $cargo->nama_penerima }} <br class="md:hidden"> ({{ $cargo->telepon_penerima }})</div>
                                </td>
                                <td class="px-4 py-3 md:px-6 md:py-4">
                                    <div class="text-[10px] md:text-xs font-medium text-gray-600">
                                        {{ $cargo->kantor_pengiriman }} <br class="md:hidden"> <span class="mx-1">➡️</span> {{ $cargo->perwakilan_ambil }}
                                    </div>
                                    <div class="text-[9px] md:text-[10px] text-gray-400 mt-1">{{ $cargo->created_at->format('d M Y, H:i') }}</div>
                                </td>
                                <td class="px-4 py-3 md:px-6 md:py-4">
                                    
                                    @php
                                        $status = $cargo->status_pengiriman;
                                        if (strtolower($status) == 'pending') {
                                            $status = 'Menunggu Penimbangan';
                                        }
                                    @endphp

                                    <span class="px-2 py-1 md:px-3 md:py-1 rounded-full text-[9px] md:text-[10px] font-bold uppercase tracking-widest border block w-max
                                        {{ $status == 'Menunggu Penimbangan' ? 'bg-gray-100 text-gray-600 border-gray-200' : '' }}
                                        {{ $status == 'Menunggu Pembayaran' ? 'bg-red-100 text-red-700 border-red-200' : '' }}
                                        {{ $status == 'Lunas / Diproses' ? 'bg-blue-100 text-blue-700 border-blue-200' : '' }}
                                        {{ $status == 'Dalam Perjalanan' ? 'bg-orange-100 text-orange-700 border-orange-200' : '' }}
                                        {{ $status == 'Diterima' ? 'bg-green-100 text-green-700 border-green-200' : '' }}">
                                        {{ $status }}
                                    </span>
                                    
                                    @if($status == 'Dalam Perjalanan' && !empty($cargo->lokasi_terkini))
                                        <div class="mt-2 flex items-center gap-1 text-[8px] md:text-[9px] text-gray-500 font-medium">
                                            <i class="fa-solid fa-location-dot text-red-500"></i>
                                            <span class="line-clamp-1" title="{{ $cargo->lokasi_terkini }}">{{ $cargo->lokasi_terkini }}</span>
                                        </div>
                                    @endif

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 md:px-6 md:py-10 text-center text-gray-400 italic font-medium text-xs md:text-sm">
                                    Belum ada riwayat pengiriman barang.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>