<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Logistik Kirana Ekspedisi</h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-[10px] font-bold">
                            <tr>
                                <th class="px-6 py-4">Barang & Pengirim</th>
                                <th class="px-6 py-4">Data Fisik (Timbangan)</th>
                                <th class="px-6 py-4">Status & Tracking</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($cargos as $c)
                            <tr class="hover:bg-gray-50 transition relative" x-data="{ detailOpen: false }">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 text-sm mb-1 uppercase">{{ $c->jenis_barang }}</div>
                                    <div class="text-[10px] text-gray-500 font-medium">
                                        ID Resi: #KRN-C{{ str_pad($c->id, 5, '0', STR_PAD_LEFT) }}<br>
                                    </div>
                                    
                                    <button @click="detailOpen = true" class="mt-2 text-[10px] font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100 hover:bg-blue-600 hover:text-white transition-colors inline-flex items-center gap-1.5">
                                        <i class="fa-solid fa-eye"></i> Lihat Detail Pengiriman
                                    </button>

                                    <div x-show="detailOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center">
                                        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="detailOpen = false" x-transition.opacity></div>
                                        
                                        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl mx-4 overflow-hidden flex flex-col max-h-[90vh]" 
                                             x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                                             x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                                            
                                            <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                                                <div>
                                                    <h3 class="font-black text-gray-800 text-xl uppercase tracking-tight">Detail Logistik #KRN-{{ $c->id }}</h3>
                                                    <p class="text-[10px] text-blue-600 font-bold uppercase">Kirana Tongkonan Transport Ekspedisi</p>
                                                </div>
                                                <button @click="detailOpen = false" class="text-gray-400 hover:text-red-500 hover:bg-red-50 w-10 h-10 rounded-full flex items-center justify-center transition">
                                                    <i class="fa-solid fa-xmark text-xl"></i>
                                                </button>
                                            </div>

                                            <div class="p-8 overflow-y-auto space-y-8">
                                                <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                                                    <div class="md:col-span-5">
                                                        <span class="block text-[10px] font-black text-gray-400 uppercase mb-3 tracking-widest">Foto Fisik Barang</span>
                                                        <div class="bg-gray-100 rounded-3xl p-2 border-2 border-dashed border-gray-200">
                                                            @if($c->foto_barang)
                                                                <img src="{{ asset('storage/' . $c->foto_barang) }}" class="w-full aspect-square object-cover rounded-2xl shadow-md" alt="Foto Barang">
                                                            @else
                                                                <div class="w-full aspect-square flex flex-col items-center justify-center text-gray-400 italic">
                                                                    <i class="fa-solid fa-image text-4xl mb-2 opacity-20"></i>
                                                                    <span class="text-xs">Foto tidak tersedia</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="md:col-span-7 flex flex-col justify-center">
                                                        <div class="bg-indigo-50 p-6 rounded-3xl border border-indigo-100 shadow-sm">
                                                            <div class="text-[10px] font-black text-indigo-600 uppercase mb-2 tracking-widest">Nama / Jenis Barang</div>
                                                            <div class="text-2xl font-black text-indigo-900 mb-4">{{ $c->jenis_barang }}</div>
                                                            
                                                            <div class="text-[10px] font-black text-indigo-600 uppercase mb-1 tracking-widest">Deskripsi Detail dari Pengirim:</div>
                                                            <div class="text-sm text-indigo-800 leading-relaxed italic bg-white/50 p-4 rounded-xl border border-indigo-100">
                                                                "{{ $c->deskripsi_barang ?? $c->keterangan ?? 'Tidak ada deskripsi tambahan dari pengirim.' }}"
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                    <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100">
                                                        <div class="flex items-center gap-3 mb-4">
                                                            <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs shadow-md"><i class="fa-solid fa-arrow-up"></i></div>
                                                            <h4 class="text-sm font-black text-blue-900 uppercase tracking-wider">Informasi Pengirim</h4>
                                                        </div>
                                                        <div class="space-y-3">
                                                            <div>
                                                                <p class="text-[9px] font-bold text-blue-400 uppercase">Nama Lengkap</p>
                                                                <p class="text-sm font-bold text-blue-900">{{ $c->nama_pengirim ?? $c->user->name }}</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-[9px] font-bold text-blue-400 uppercase">Nomor WhatsApp</p>
                                                                <p class="text-sm font-bold text-blue-900">{{ $c->telepon_pengirim ?? $c->user->phone ?? '-' }}</p>
                                                            </div>
                                                            <div class="pt-2 border-t border-blue-100">
                                                                <p class="text-[9px] font-bold text-blue-600 uppercase">Kantor Asal (Drop Barang)</p>
                                                                <p class="text-xs font-black text-blue-800 uppercase mt-1">{{ $c->kantor_pengiriman ?? 'Loket Pusat' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="bg-orange-50/50 p-6 rounded-3xl border border-orange-100">
                                                        <div class="flex items-center gap-3 mb-4">
                                                            <div class="w-8 h-8 bg-orange-600 text-white rounded-full flex items-center justify-center text-xs shadow-md"><i class="fa-solid fa-arrow-down"></i></div>
                                                            <h4 class="text-sm font-black text-orange-900 uppercase tracking-wider">Informasi Penerima</h4>
                                                        </div>
                                                        <div class="space-y-3">
                                                            <div>
                                                                <p class="text-[9px] font-bold text-orange-400 uppercase">Nama Lengkap</p>
                                                                <p class="text-sm font-bold text-orange-900">{{ $c->nama_penerima }}</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-[9px] font-bold text-orange-400 uppercase">Nomor WhatsApp</p>
                                                                <p class="text-sm font-bold text-orange-900">{{ $c->telepon_penerima ?? '-' }}</p>
                                                            </div>
                                                            <div class="pt-2 border-t border-orange-100">
                                                                <p class="text-[9px] font-bold text-orange-600 uppercase">Kantor Tujuan (Ambil Barang)</p>
                                                                <p class="text-xs font-black text-orange-800 uppercase mt-1">{{ $c->perwakilan_ambil ?? '-' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex justify-end">
                                                <button @click="detailOpen = false" class="bg-gray-900 hover:bg-black text-white text-xs font-bold py-3 px-8 rounded-2xl transition shadow-lg uppercase tracking-widest">
                                                    Tutup Detail
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.cargos.process', $c->id) }}" method="POST" class="flex flex-col gap-2">
                                        @csrf @method('PATCH')
                                        
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="berat_final" step="0.01" value="{{ $c->berat_final ?? $c->berat_kg }}" class="w-20 text-[10px] rounded-lg border-gray-300" placeholder="Berat (Kg)">
                                            <input type="number" name="harga_final" value="{{ $c->harga_final }}" class="w-full text-[10px] rounded-lg border-gray-300" placeholder="Harga (Rp)">
                                        </div>

                                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-[10px] font-bold shadow-sm transition flex items-center justify-center gap-1.5">
                                            <i class="fa-solid fa-floppy-disk"></i> Simpan
                                        </button>
                                    </form>
                                    <div class="text-[10px] text-gray-400 mt-2 text-center italic">Est. Pengirim: <span class="font-bold">{{ $c->berat_kg }} kg</span></div>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.cargos.tracking', $c->id) }}" method="POST" class="space-y-2">
                                        @csrf @method('PATCH')
                                        <select name="status_pengiriman" class="w-full text-[10px] rounded-lg border-gray-300 font-bold text-gray-700">
                                            <option value="Menunggu Penimbangan" {{ $c->status_pengiriman == 'Menunggu Penimbangan' ? 'selected' : '' }}>Menunggu Penimbangan</option>
                                            <option value="Menunggu Pembayaran" {{ $c->status_pengiriman == 'Menunggu Pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                            <option value="Lunas / Diproses" {{ $c->status_pengiriman == 'Lunas / Diproses' ? 'selected' : '' }}>Lunas / Diproses</option>
                                            <option value="Dalam Perjalanan" {{ $c->status_pengiriman == 'Dalam Perjalanan' ? 'selected' : '' }}>Dalam Perjalanan</option>
                                            <option value="Diterima" {{ $c->status_pengiriman == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                        </select>
                                        <input type="text" name="lokasi_terkini" value="{{ $c->lokasi_terkini }}" class="w-full text-[10px] rounded-lg border-gray-300" placeholder="Lokasi Terkini">
                                        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white p-1.5 rounded-lg text-[10px] font-bold shadow-sm transition">Update Tracking</button>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-2 w-full max-w-[120px] mx-auto">
                                        @if($c->status_pengiriman != 'Menunggu Penimbangan')
                                            <a href="{{ route('admin.cargos.resi', $c->id) }}" target="_blank" class="bg-gray-800 hover:bg-gray-900 text-white px-3 py-2 rounded-lg text-[10px] font-bold flex items-center justify-center gap-1.5 transition shadow-sm">
                                                <i class="fa-solid fa-print"></i> Cetak Resi
                                            </a>
                                        @else
                                            <span class="text-gray-400 bg-gray-100 text-[9px] py-2 px-2 rounded-lg text-center font-bold uppercase border border-gray-200">Timbang Dahulu</span>
                                        @endif

                                        <form action="{{ route('admin.cargos.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengiriman ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg text-[10px] font-bold flex items-center justify-center gap-1.5 transition">
                                                <i class="fa-solid fa-trash-can"></i> Hapus Data
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">Belum ada data pengiriman barang masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>