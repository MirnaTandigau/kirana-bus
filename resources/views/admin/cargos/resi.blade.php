<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resi Cargo #{{ $cargo->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39&family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; color: #000; }
        .barcode-font { font-family: 'Libre Barcode 39', cursive; font-size: 5rem; line-height: 0.8; }
        .barcode-small { font-family: 'Libre Barcode 39', cursive; font-size: 3rem; line-height: 0.8; }
        
        @media print { 
            .no-print { display: none !important; } 
            body { background-color: white !important; padding: 0 !important; }
            .print-container { box-shadow: none !important; margin: 0 !important; width: 100% !important; max-width: 100mm !important; }
            .print-border { border: 2px solid black !important; }
            * { -webkit-print-color-adjust: exact !important; color-adjust: exact !important; }
        }
    </style>
</head>
<body class="bg-gray-200 p-8 flex justify-center min-h-screen">

    <div class="print-container w-full max-w-[100mm] bg-white print-border border-2 border-black shadow-xl h-fit relative">
        
        <div class="flex justify-between items-center p-3 border-b-2 border-black border-dashed">
            <div class="flex items-center gap-2">
                <div class="bg-black text-white px-2 py-1 font-black text-lg tracking-widest">KIRANA</div>
                <div class="font-bold text-sm">CARGO</div>
            </div>
            <div class="font-black italic text-sm tracking-tighter">EXPRESS LOGISTICS</div>
        </div>

        <div class="border-b-2 border-black py-1 text-center bg-gray-100">
            <h2 class="font-bold text-sm uppercase tracking-widest">No. Resi: KRN-{{ str_pad($cargo->id, 7, '0', STR_PAD_LEFT) }}</h2>
        </div>

        <div class="text-center py-4 border-b-2 border-black border-dashed bg-white">
            <div class="barcode-font">*KRN{{ $cargo->id }}*</div>
        </div>

        <div class="flex border-b-2 border-black">
            <div class="w-1/2 p-2 border-r-2 border-black">
                <p class="font-bold text-[11px]">Penerima: {{ strtoupper($cargo->nama_penerima) }}</p>
                <p class="text-[11px] mb-2">{{ $cargo->telepon_penerima }}</p>
                <p class="text-[10px] leading-tight pr-2">
                    {{ strtoupper($cargo->perwakilan_ambil ?? 'Alamat Tujuan') }}
                </p>
            </div>
            <div class="w-1/2 p-2">
                <p class="font-bold text-[11px]">Pengirim: {{ strtoupper($cargo->nama_pengirim) }}</p>
                <p class="text-[11px] mb-2">{{ $cargo->telepon_pengirim }}</p>
                <p class="text-[10px] leading-tight pr-2">
                    {{ strtoupper($cargo->kantor_pengiriman ?? 'Alamat Asal') }}
                </p>
            </div>
        </div>

        <div class="flex p-2 gap-2 border-b-2 border-black bg-white">
            <div class="w-1/2 border-2 border-black py-1 text-center font-bold text-[10px] uppercase truncate px-1">
                KIRANA CARGO
            </div>
            <div class="w-1/2 border-2 border-black py-1 text-center font-bold text-[10px] uppercase truncate px-1 bg-black text-white">
                {{ substr(strtoupper($cargo->titik_turun ?? 'TUJUAN'), 0, 15) }}
            </div>
        </div>

        <div class="flex border-b-2 border-black">
            <div class="w-1/2 p-2 text-[10px]">
                <table class="w-full">
                    <tr>
                        <td class="font-bold py-0.5 w-16">Berat:</td>
                        <td>{{ $cargo->berat_final ?? '-' }} kg</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-0.5">Biaya:</td>
                        <td class="font-bold text-sm">Rp {{ number_format($cargo->harga_final ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-0.5">Tgl Kirim:</td>
                        <td>{{ $cargo->created_at->format('d-m-Y') }}</td>
                    </tr>
                </table>
            </div>
            <div class="w-1/2 p-2 flex flex-col justify-center items-center text-center">
                <div class="barcode-small">*KRN{{ $cargo->id }}*</div>
                <p class="text-[8px] font-bold mt-1">KRN-{{ str_pad($cargo->id, 7, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <div class="p-2">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b-2 border-black">
                        <th class="text-[9px] font-bold py-1 w-6">#</th>
                        <th class="text-[9px] font-bold py-1">Nama Barang / Deskripsi</th>
                        <th class="text-[9px] font-bold py-1 text-center w-12">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-[10px] py-1 align-top">1</td>
                        <td class="text-[10px] py-1 font-bold leading-tight">
                            {{ strtoupper($cargo->jenis_barang) }}
                            <div class="font-normal text-[9px] text-gray-600 mt-0.5">{{ $cargo->deskripsi_barang ?? '-' }}</div>
                        </td>
                        <td class="text-[10px] py-1 align-top text-center">1</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="p-2 pt-6 text-[9px]">
            Pesan: (KRN-{{ str_pad($cargo->id, 7, '0', STR_PAD_LEFT) }}) Simpan resi ini sebagai bukti pengiriman yang sah.
        </div>
    </div>

    <div class="no-print fixed top-8 right-8 flex flex-col gap-3 w-48">
        <button onclick="window.print()" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-3 rounded-xl font-bold uppercase text-sm shadow-xl flex items-center justify-center transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print Resi
        </button>
        <button onclick="window.close()" class="bg-white text-gray-800 border-2 border-gray-300 px-4 py-3 rounded-xl font-bold uppercase text-sm shadow-sm hover:bg-gray-50 transition">
            Tutup Tab
        </button>
        
        <div class="bg-blue-50 border border-blue-200 text-blue-800 text-[10px] p-3 rounded-xl mt-4">
            <strong>Tips Print:</strong><br>
            Pastikan pengaturan print Anda:<br>
            - Margins: <b>None</b><br>
            - Scale: <b>100% / Default</b>
        </div>
    </div>

</body>
</html>