<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket Reguler Kirana Transport</title>
    <style>
        @page { margin: 0px; }
        body { font-family: 'Helvetica', sans-serif; background-color: #f8fafc; padding: 40px; }
        .ticket-card { background-color: white; border-radius: 15px; overflow: hidden; border: 1px solid #e2e8f0; }
        .header { background-color: #1e293b; color: white; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; letter-spacing: 2px; }
        .header p { margin: 5px 0 0 0; opacity: 0.8; font-size: 12px; font-weight: bold; letter-spacing: 1px; }
        .main-content { padding: 30px; }
        .route-header { text-align: center; margin-bottom: 30px; }
        .info-grid { width: 100%; margin-top: 20px; border-collapse: collapse; }
        .info-box { padding: 15px; border-bottom: 1px solid #f1f5f9; }
        .label { font-size: 10px; color: #64748b; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .value { font-size: 14px; color: #1e293b; font-weight: bold; }
        .status-section { margin-top: 30px; background-color: #f0fdf4; border: 1px solid #bbf7d0; padding: 15px; border-radius: 10px; text-align: center; }
        .status-text { color: #166534; font-weight: bold; font-size: 16px; }
    </style>
</head>
<body>
    <div class="ticket-card">
        <div class="header">
            <h1>KIRANA TONGKONAN TRANSPORT</h1>
            <p>OFFICIAL ELECTRONIC TICKET - <span style="color: #60a5fa;">LAYANAN REGULER</span></p>
        </div>

        <div class="main-content">
            <div class="route-header">
                <p style="text-transform: uppercase; font-size: 10px; color: #64748b; margin-bottom: 5px; font-weight: bold;">Rute Perjalanan</p>
                <h1 style="color: #1e40af; font-weight: 800; font-size: 26px; margin: 0;">
                    {{ str_replace('-', ' - ', strtoupper($ticket->schedule->rute ?? $ticket->rute ?? 'MANADO - TORAJA')) }}
                </h1>
            </div>

            <table class="info-grid">
                <tr>
                    <td class="info-box" width="50%">
                        <div class="label">Nama Penumpang</div>
                        <div class="value">{{ strtoupper($ticket->nama_penumpang) }}</div>
                    </td>
                    <td class="info-box" width="50%">
                        <div class="label">ID Transaksi</div>
                        <div class="value">#KRN-{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="info-box">
                        <div class="label">Armada Bus</div>
                        <div class="value">{{ strtoupper($ticket->bus_name ?? $ticket->schedule->nama_bus ?? 'KIRANA BUS') }}</div>
                    </td>
                    <td class="info-box">
                        <div class="label">Waktu Keberangkatan</div>
                        <div class="value">
                            {{ \Carbon\Carbon::parse($ticket->tanggal_berangkat)->format('d M Y') }} | 
                            {{ \Carbon\Carbon::parse($ticket->jam_berangkat)->format('H:i') }} WITA
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="info-box" colspan="2" style="background-color: #f8fafc; text-align: center;">
                        <div class="label">Nomor Kursi</div>
                        <div class="value" style="font-size: 24px; color: #2563eb;">
                            @php
                                $kursi = '-';
                                if(!empty($ticket->nomor_kursi)) {
                                    $decoded = json_decode($ticket->nomor_kursi, true);
                                    $kursi = is_array($decoded) ? implode(', ', $decoded) : $ticket->nomor_kursi;
                                }
                            @endphp
                            SEAT: {{ $kursi }}
                        </div>
                    </td>
                </tr>
            </table>

            <div class="status-section">
                <div class="status-text">STATUS: PEMBAYARAN LUNAS (PAID)</div>
                <div style="font-size: 14px; font-weight: bold; color: #166534; margin-top: 5px;">
                    Total Bayar: Rp {{ number_format($ticket->total_bayar ?? 0, 0, ',', '.') }}
                </div>
            </div>

            <div style="text-align: center; margin-top: 20px;">
                @php
                    $qrContent = "KIRANA TRANSPORT\nID: #KRN-".str_pad($ticket->id, 5, '0', STR_PAD_LEFT)."\nNama: ".$ticket->nama_penumpang."\nTipe: REGULER\nStatus: LUNAS";
                @endphp
                <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(90)->generate($qrContent)) }}">
            </div>
        </div>
    </div>
</body>
</html>