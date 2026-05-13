<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Layanan Kirana Ekspedisi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-white shadow-xl sm:rounded-2xl p-8 border-t-4 border-green-600">
                <div class="mb-8">
                    <h3 class="text-2xl font-extrabold text-gray-900">Formulir Pengiriman Barang</h3>
                    <p class="text-sm text-gray-500 mt-1">Pastikan data pengirim dan penerima sudah benar untuk memudahkan koordinasi.</p>
                </div>

                <form action="{{ route('cargos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-4 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                            <h4 class="font-bold text-blue-800 uppercase text-xs tracking-widest mb-4 flex items-center">
                                <span class="bg-blue-100 p-1 rounded mr-2">📦</span> Data Pengirim Asal
                            </h4>
                            <div>
                                <x-input-label value="Nama Pengirim" />
                                <x-text-input name="nama_pengirim" type="text" class="block mt-1 w-full" required />
                            </div>
                            <div>
                                <x-input-label value="No. Telepon Pengirim (Opsional)" />
                                <x-text-input name="telepon_pengirim" type="text" class="block mt-1 w-full" placeholder="08..." />
                            </div>
                            <div>
                                <x-input-label value="Kantor Perwakilan Pengiriman" />
                                <select name="kantor_pengiriman" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 transition" required>
                                    <option value="" disabled selected>Pilih Kantor Asal</option>
                                    <option value="Perwakilan Manado">Kantor Perwakilan Manado</option>
                                    <option value="Perwakilan Tondano">Kantor Perwakilan Tondano</option>
                                    <option value="Perwakilan Makale">Kantor Perwakilan Makale</option>
                                    <option value="Perwakilan Rantepao">Kantor Perwakilan Rantepao</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-4 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                            <h4 class="font-bold text-green-800 uppercase text-xs tracking-widest mb-4 flex items-center">
                                <span class="bg-green-100 p-1 rounded mr-2">📍</span> Data Penerima Tujuan
                            </h4>
                            <div>
                                <x-input-label value="Nama Penerima" />
                                <x-text-input name="nama_penerima" type="text" class="block mt-1 w-full" required />
                            </div>
                            <div>
                                <x-input-label value="No. Telepon Penerima" />
                                <x-text-input name="telepon_penerima" type="text" class="block mt-1 w-full" placeholder="Wajib untuk info pengambilan" required />
                            </div>
                            <div>
                                <x-input-label value="Kantor Perwakilan Pengambilan" />
                                <select name="perwakilan_ambil" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 transition" required>
                                    <option value="" disabled selected>Pilih Kantor Tujuan</option>
                                    <option value="Perwakilan Manado">Kantor Perwakilan Manado</option>
                                    <option value="Perwakilan Tondano">Kantor Perwakilan Tondano</option>
                                    <option value="Perwakilan Makale">Kantor Perwakilan Makale</option>
                                    <option value="Perwakilan Rantepao">Kantor Perwakilan Rantepao</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 p-6 bg-white border-2 border-dashed border-gray-200 rounded-2xl">
                        <h4 class="font-bold text-gray-700 uppercase text-xs tracking-widest mb-4">Informasi Barang</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <x-input-label value="Jenis Barang" />
                                    <select name="jenis_barang" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                        <option value="Dokumen">Dokumen / Surat</option>
                                        <option value="Pakaian">Pakaian / Tekstil</option>
                                        <option value="Elektronik">Elektronik</option>
                                        <option value="Makanan">Makanan / Sembako</option>
                                        <option value="Lainnya">Lain-lain</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label value="Estimasi Berat (Kg)" />
                                    <x-text-input name="berat_kg" type="number" step="0.1" min="0.5" class="block mt-1 w-full" required />
                                </div>
                                <div>
                                    <x-input-label value="Foto Barang" />
                                    <input type="file" name="foto_barang" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" accept="image/*" />
                                    <p class="text-[10px] text-gray-400 mt-1">*Format: JPG, PNG (Maks 2MB)</p>
                                </div>
                            </div>
                            <div>
                                <x-input-label value="Deskripsi Detail Barang" />
                                <textarea name="deskripsi_barang" rows="5" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-green-500" placeholder="Misal: Laptop Asus Seri X, 2 Box Mie Instan Rasa Kaldu, Pakaian Adat Toraja 3 Set" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-green-600 text-white px-10 py-4 rounded-xl font-bold hover:bg-green-700 transition shadow-lg shadow-green-200 uppercase tracking-wider">
                            Daftarkan Pengiriman
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold mb-6 text-gray-800 flex items-center">
                    <span class="mr-2">📋</span> Riwayat Pengiriman Barang Anda
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Informasi Barang</th>
                                <th class="px-6 py-4">Pengirim & Penerima</th>
                                <th class="px-6 py-4">Rute Kantor</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($cargos as $cargo)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            @if($cargo->foto_barang)
                                                <img src="{{ asset('storage/' . $cargo->foto_barang) }}" class="w-12 h-12 rounded-lg object-cover border shadow-sm">
                                            @else
                                                <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-[10px] text-gray-400">No Image</div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">{{ $cargo->jenis_barang }}</div>
                                            <div class="text-[10px] text-gray-500 italic line-clamp-1" title="{{ $cargo->deskripsi_barang }}">{{ $cargo->deskripsi_barang }}</div>
                                            <div class="text-[10px] font-semibold text-blue-600 mt-1">{{ $cargo->berat_kg }} Kg</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs"><span class="font-bold text-gray-400">DARI:</span> {{ $cargo->nama_pengirim }}</div>
                                    <div class="text-xs mt-1 text-green-700 font-medium"><span class="font-bold text-gray-400">KE:</span> {{ $cargo->nama_penerima }} ({{ $cargo->telepon_penerima }})</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs font-medium text-gray-600">
                                        {{ $cargo->kantor_pengiriman }} <span class="mx-1">➡️</span> {{ $cargo->perwakilan_ambil }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 mt-1">{{ $cargo->created_at->format('d M Y, H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    
                                    @php
                                        $status = $cargo->status_pengiriman;
                                        if (strtolower($status) == 'pending') {
                                            $status = 'Menunggu Penimbangan';
                                        }
                                    @endphp

                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border block w-max
                                        {{ $status == 'Menunggu Penimbangan' ? 'bg-gray-100 text-gray-600 border-gray-200' : '' }}
                                        {{ $status == 'Menunggu Pembayaran' ? 'bg-red-100 text-red-700 border-red-200' : '' }}
                                        {{ $status == 'Lunas / Diproses' ? 'bg-blue-100 text-blue-700 border-blue-200' : '' }}
                                        {{ $status == 'Dalam Perjalanan' ? 'bg-orange-100 text-orange-700 border-orange-200' : '' }}
                                        {{ $status == 'Diterima' ? 'bg-green-100 text-green-700 border-green-200' : '' }}">
                                        {{ $status }}
                                    </span>
                                    
                                    @if($status == 'Dalam Perjalanan' && !empty($cargo->lokasi_terkini))
                                        <div class="mt-2 flex items-center gap-1 text-[9px] text-gray-500 font-medium">
                                            <i class="fa-solid fa-location-dot text-red-500"></i>
                                            <span class="line-clamp-1" title="{{ $cargo->lokasi_terkini }}">{{ $cargo->lokasi_terkini }}</span>
                                        </div>
                                    @endif

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic font-medium">
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