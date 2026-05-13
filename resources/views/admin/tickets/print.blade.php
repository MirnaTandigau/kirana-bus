<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manifest Penumpang - Kirana Tongkonan Transport</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            @page { size: A4; margin: 0.8cm; }
            body { background: white; padding: 0; }
            .print-container { box-shadow: none !important; border: none !important; width: 100% !important; max-width: none !important; }
            tr { page-break-inside: avoid; }
        }
        .ticket-table th { background-color: #f3f4f6 !important; -webkit-print-color-adjust: exact; }
        .check-box { width: 18px; height: 18px; border: 1.5px solid #1e293b; margin: 0 auto; }
    </style>
</head>
<body class="bg-gray-100 p-4">

    <div class="max-w-5xl mx-auto no-print mb-4 flex justify-between items-center bg-white p-3 rounded-xl shadow-sm">
        <a href="{{ route('admin.tickets.index') }}" class="text-sm font-bold text-gray-600 flex items-center">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
        </a>
        <button onclick="window.print()" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-bold text-sm shadow-md hover:bg-blue-700 transition">
            🖨️ CETAK MANIFEST
        </button>
    </div>

    <div class="max-w-5xl mx-auto bg-white p-8 shadow-lg border border-gray-200 print-container text-slate-900">
        <div class="flex justify-between items-end border-b-4 border-slate-900 pb-4 mb-6">
            <div>
                <h1 class="text-2xl font-black uppercase tracking-tighter">Kirana Tongkonan Transport</h1>
                <p class="text-xs text-slate-600 font-bold italic">Layanan Manado - Toraja PP</p>
            </div>
            <div class="text-right">
                <h2 class="text-lg font-black text-slate-800 uppercase underline">Manifest Penumpang</h2>
                <p class="text-[10px] text-slate-500 font-bold mt-1 uppercase">{{ now()->format('d/m/Y - H:i') }}</p>
            </div>
        </div>

        @if($tickets->count() > 0)
        <div class="grid grid-cols-3 gap-4 mb-6 bg-slate-50 p-3 rounded-xl border border-slate-200">
            <div>
                <p class="text-[9px] text-slate-400 uppercase font-black tracking-widest">Armada</p>
                <p class="text-sm font-black text-slate-900 uppercase">{{ $tickets->first()->bus_name }}</p>
            </div>
            <div>
                <p class="text-[9px] text-slate-400 uppercase font-black tracking-widest">Rute</p>
                <p class="text-sm font-black text-slate-900 uppercase">{{ $tickets->first()->schedule->rute ?? 'MANADO-TORAJA' }}</p>
            </div>
            <div>
                <p class="text-[9px] text-slate-400 uppercase font-black tracking-widest">Tanggal</p>
                <p class="text-sm font-black text-slate-900 uppercase">{{ $tickets->first()->tanggal_berangkat->format('d F Y') }}</p>
            </div>
        </div>

        <table class="w-full ticket-table border-collapse border-2 border-slate-900">
            <thead>
                <tr class="text-center border-b-2 border-slate-900 text-[10px]">
                    <th class="p-2 border-r border-slate-900 w-12 uppercase font-black">Kursi</th>
                    <th class="p-2 border-r border-slate-900 text-left uppercase font-black">Penumpang</th>
                    <th class="p-2 border-r border-slate-900 text-left uppercase font-black">Jemput</th>
                    <th class="p-2 border-r border-slate-900 text-left uppercase font-black">Turun</th>
                    <th class="p-2 border-r border-slate-900 uppercase font-black w-24 text-right">Harga</th>
                    <th class="p-2 border-r border-slate-900 w-10 font-black uppercase">Naik</th>
                    <th class="p-2 w-10 font-black uppercase text-center">Turun</th>
                </tr>
            </thead>
            <tbody class="text-[11px]">
                @php $totalManifest = 0; @endphp
                @foreach($tickets as $ticket)
                    @php
                        $seats = is_array($ticket->nomor_kursi) ? $ticket->nomor_kursi : json_decode($ticket->nomor_kursi, true);
                        $hargaPerKursi = ($ticket->total_bayar / $ticket->jumlah_kursi);
                        $totalManifest += $ticket->total_bayar;
                    @endphp

                    @foreach($seats as $seat)
                    <tr class="border-b border-slate-300">
                        <td class="p-2 border-r border-slate-900 text-center font-black text-lg bg-slate-50">
                            {{ $seat < 10 ? '0'.$seat : $seat }}
                        </td>
                        <td class="p-2 border-r border-slate-900">
                            <div class="font-black uppercase text-sm leading-none">{{ $ticket->nama_penumpang }}</div>
                            <div class="flex items-center gap-1 mt-1">
                                <span class="bg-slate-200 text-slate-700 px-1.5 py-0.5 rounded-[4px] text-[8px] font-black uppercase">
                                    {{ $ticket->kategori_penumpang }}
                                </span>
                                <span class="text-[9px] font-bold text-slate-500">{{ $ticket->nomor_telepon }}</span>
                            </div>
                        </td>
                        <td class="p-2 border-r border-slate-900 font-bold text-blue-800 uppercase leading-tight">
                            {{ $ticket->titik_jemput ?? '-' }}
                        </td>
                        <td class="p-2 border-r border-slate-900 font-bold text-red-700 uppercase leading-tight">
                            {{ $ticket->titik_turun ?? '-' }}
                        </td>
                        <td class="p-2 border-r border-slate-900 text-right">
                            <div class="font-black">Rp{{ number_format($hargaPerKursi, 0, ',', '.') }}</div>
                            <div class="text-[8px] font-bold uppercase text-slate-400">
                                {{ $ticket->is_manual_booking ? 'Cash' : 'Transfer' }}
                            </div>
                        </td>
                        <td class="p-2 border-r border-slate-900 text-center">
                            <div class="check-box"></div>
                        </td>
                        <td class="p-2 text-center">
                            <div class="check-box"></div>
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-slate-100 font-black border-t-2 border-slate-900">
                    <td colspan="4" class="p-3 text-right uppercase text-xs">Total Setoran Terbayar:</td>
                    <td class="p-3 text-right text-sm">Rp{{ number_format($totalManifest, 0, ',', '.') }}</td>
                    <td colspan="2" class="bg-white"></td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-12 grid grid-cols-2 gap-20">
            <div class="text-center">
                <p class="text-xs font-bold mb-16 text-slate-600 italic">Admin Operasional,</p>
                <div class="border-t-2 border-slate-900 pt-2 text-sm font-black uppercase">{{ Auth::user()->name }}</div>
            </div>
            <div class="text-center">
                <p class="text-xs font-bold mb-16 text-slate-600 italic">Supir / Kru,</p>
                <div class="border-t-2 border-slate-900 pt-2 text-sm font-black italic text-slate-300">(Nama & Cap)</div>
            </div>
        </div>

        <div class="mt-8 text-[8px] text-slate-400 font-bold italic border-t border-slate-100 pt-3 uppercase">
            * MANIFEST INI ADALAH DOKUMEN RESMI. SUPIR WAJIB MEMASTIKAN AKURASI PENUMPANG NAIK/TURUN.
        </div>

        @else
            <div class="text-center py-20 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 text-slate-300 font-black uppercase italic tracking-widest">
                Data Penumpang Kosong
            </div>
        @endif
    </div>

</body>
</html>