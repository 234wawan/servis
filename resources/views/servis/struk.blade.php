<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Struk Pembayaran - {{ $servis->no_antrian }}</title>
    <style>
        body { font-family: 'Courier New', monospace; font-size: 12px; width: 80mm; margin: 0 auto; padding: 10px; }
        .header { text-align: center; margin-bottom: 10px; }
        .header h2 { margin: 0; font-size: 16px; }
        .header p { margin: 2px 0; font-size: 11px; }
        hr { border-top: 1px dashed #000; margin: 8px 0; }
        table { width: 100%; font-size: 12px; }
        td { padding: 2px 0; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .total { font-size: 14px; }
        .footer { text-align: center; margin-top: 10px; font-size: 11px; }
        .info { margin: 5px 0; }
        @media print {
            body { margin: 0; padding: 5px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align:center;margin-bottom:10px;">
        <button onclick="window.print()" class="btn btn-primary">Cetak Struk</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
        <hr>
    </div>

    <div class="header">
        <h2>BENGKEL MOTOR</h2>
        <p>Jl. Contoh No. 123, Kota</p>
        <p>Telp: 0812-3456-7890</p>
    </div>
    <hr>

    <div class="info">
        <strong>STRUK PEMBAYARAN</strong><br>
        No. Antrian: <strong>{{ $servis->no_antrian ?? '-' }}</strong><br>
        Tgl Bayar: {{ $servis->tgl_pembayaran ? \Carbon\Carbon::parse($servis->tgl_pembayaran)->format('d/m/Y H:i') : '-' }}<br>
        Kasir: {{ auth()->user()->name }}
    </div>
    <hr>

    <table>
        <tr><td>Kendaraan</td><td class="text-end">{{ $servis->kendaraan->no_polisi ?? '-' }}</td></tr>
        <tr><td>Pemilik</td><td class="text-end">{{ $servis->kendaraan->pelanggan->nama ?? '-' }}</td></tr>
        <tr><td>Keluhan</td><td class="text-end">{{ Str::limit($servis->keluhan, 25) }}</td></tr>
    </table>
    <hr>

    <table>
        <tr><td>Biaya Jasa</td><td class="text-end">Rp {{ number_format($servis->biaya, 0, ',', '.') }}</td></tr>
        @if ($servis->spareparts->isNotEmpty())
        <tr><td colspan="2"><strong>Sparepart:</strong></td></tr>
        @foreach ($servis->spareparts as $sp)
        <tr>
            <td class="ps-3">{{ $sp->nama_sparepart }} x{{ $sp->pivot->qty }}</td>
            <td class="text-end">Rp {{ number_format($sp->pivot->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr>
            <td>Total Sparepart</td>
            <td class="text-end">Rp {{ number_format($servis->spareparts->sum(fn($s) => $s->pivot->subtotal), 0, ',', '.') }}</td>
        </tr>
        @endif
        @if ($servis->diskon > 0)
            <tr>
                <td>Diskon
                    @if ($servis->tipe_diskon === 'persen')
                        ({{ $servis->diskon }}%)
                    @endif
                </td>
                <td class="text-end">- Rp {{ number_format($servis->getDiskonRupiah(), 0, ',', '.') }}</td>
            </tr>
        @endif
        <tr class="total">
            <td><strong>TOTAL BAYAR</strong></td>
            <td class="text-end"><strong>Rp {{ number_format($servis->total_bayar, 0, ',', '.') }}</strong></td>
        </tr>
    </table>
    <hr>

    <p class="text-center">
        Metode Bayar: <strong>{{ strtoupper($servis->metode_pembayaran) }}</strong><br>
        Status: <strong>LUNAS / DIAMBIL</strong>
    </p>

    <div class="footer">
        <p>Terima kasih telah menggunakan jasa kami</p>
        <p>Barang yang sudah diambil > 1 hari<br>menjadi tanggung jawab pelanggan</p>
    </div>

    <script>
        window.onload = function() { window.print(); }
    </script>
</body>
</html>
