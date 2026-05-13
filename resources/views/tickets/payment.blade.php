<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Menu Pembayaran Tiket</h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-[2.5rem] p-10 border border-gray-100 text-center">
                
                <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-8 flex items-center justify-center space-x-3">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <p class="text-sm font-bold uppercase tracking-wider">
                        Tenggat Bayar: {{ $ticket->expired_at ? \Carbon\Carbon::parse($ticket->expired_at)->format('d M Y, H:i') : 'Segera Lakukan Pembayaran' }}
                    </p>
                </div>

                <h3 class="text-2xl font-bold text-gray-900 mb-6">Informasi Rekening Transfer</h3>

                <div class="space-y-4 mb-10">
                    <div class="p-6 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 relative">
                        <p class="text-xs text-slate-400 font-bold uppercase mb-2">Nomor Rekening BCA</p>
                        <p class="text-3xl font-black text-slate-800 tracking-widest" id="norek">0261 680 521</p>
                        <p class="text-xs mt-2 font-bold text-slate-500 uppercase">A/N WICO NETA SILONGAN</p>
                        <button onclick="copyNorek()" class="mt-4 px-6 py-2 bg-white border rounded-full text-xs font-bold hover:bg-slate-100 transition shadow-sm">SALIN NO REK</button>
                    </div>
                </div>

                <div class="bg-blue-600 text-white rounded-3xl p-8 mb-10">
                    <p class="text-sm opacity-80 mb-1 font-bold">Total Pembayaran</p>
                    <p class="text-4xl font-black">Rp {{ number_format($ticket->total_bayar, 0, ',', '.') }}</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 text-left text-sm font-bold border border-red-100">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="text-left">
                    <form action="{{ route('tickets.upload', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        @if($ticket->kategori_penumpang == 'Mahasiswa' && empty($ticket->bukti_ktm))
                            <h4 class="font-bold text-orange-600 mb-2 mt-4"><i class="fa-solid fa-id-card"></i> Upload Bukti KTM/KRS (Wajib)</h4>
                            <div class="mb-6 p-4 border-2 border-dashed border-orange-200 bg-orange-50 rounded-2xl transition">
                                <input type="file" name="bukti_ktm" accept="image/*,.pdf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200" required>
                                <p class="text-[10px] text-orange-600 italic mt-2">*Sistem mendeteksi Anda belum mengunggah file KTM/KRS pada halaman sebelumnya.</p>
                            </div>
                        @endif

                        <h4 class="font-bold text-gray-800 mb-2 mt-4">Upload Bukti Transaksi</h4>
                        <div class="mb-6 p-4 border-2 border-dashed border-gray-200 rounded-2xl hover:bg-gray-50 transition">
                            <input type="file" name="bukti_pembayaran" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-4 mt-8">
                            <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-slate-800 transition shadow-xl">
                                Konfirmasi & Selesaikan
                            </button>
                            <a href="{{ route('dashboard') }}" class="text-center text-sm text-gray-400 hover:text-gray-600 font-medium py-2">Nanti Saja, Kembali ke Dashboard</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyNorek() {
            const norek = "0261680521";
            navigator.clipboard.writeText(norek).then(() => {
                alert("Nomor Rekening Berhasil Disalin!");
            });
        }
    </script>
</x-app-layout>