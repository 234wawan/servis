<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Nota Terima - {{ $servis->no_antrian }}</title>
    <style>
        body { font-family: 'Courier New', monospace; font-size: 12px; width: 80mm; margin: 0 auto; padding: 10px; }
        .header { text-align: center; margin-bottom: 10px; }
        .header h2 { margin: 0; font-size: 16px; }
        .header p { margin: 2px 0; font-size: 11px; }
        hr { border-top: 1px dashed #000; margin: 8px 0; }
        table { width: 100%; font-size: 12px; }
        td { padding: 2px 0; vertical-align: top; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .antrian { font-size: 24px; text-align: center; letter-spacing: 3px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 10px; font-size: 11px; }
        @media print {
            body { margin: 0; padding: 5px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align:center;margin-bottom:10px;">
        <button onclick="window.print()" class="btn btn-primary">Cetak Nota</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
        <hr>
    </div>

    <div class="header">
        <h2>BENGKEL MOTOR</h2>
        <p>Jl. Contoh No. 123, Kota</p>
        <p>Telp: 0812-3456-7890</p>
    </div>
    <hr>

    <div class="antrian">
        <strong>{{ $servis->no_antrian ?? '-' }}</strong>
    </div>
    <hr>

    <div class="text-center mb-2">
        <strong>NOTA TANDA TERIMA SERVIS</strong><br>
        Tgl Masuk: {{ \Carbon\Carbon::parse($servis->tgl_masuk)->format('d/m/Y') }}<br>
        Kasir: {{ auth()->user()->name }}
    </div>
    <hr>

    <table>
        <tr><td style="width:90px;">Pemilik</td><td>: {{ $servis->kendaraan->pelanggan->nama ?? '-' }}</td></tr>
        <tr><td>No. Telp</td><td>: {{ $servis->kendaraan->pelanggan->no_telp ?? '-' }}</td></tr>
        <tr><td>Kendaraan</td><td>: {{ $servis->kendaraan->no_polisi ?? '-' }}</td></tr>
        <tr><td>Tipe</td><td>: {{ $servis->kendaraan->merek ?? '-' }} {{ $servis->kendaraan->model ?? '-' }}</td></tr>
        <tr><td>Keluhan</td><td>: {{ $servis->keluhan }}</td></tr>
        @if ($servis->kelengkapan)
            <tr><td>Kelengkapan</td><td>: {{ $servis->kelengkapan }}</td></tr>
        @endif
    </table>
    <hr>
    @if ($servis->spareparts->isNotEmpty())
    <div class="text-center mb-1"><strong>Sparepart:</strong></div>
    <table>
        @foreach ($servis->spareparts as $sp)
        <tr>
            <td>{{ $sp->nama_sparepart }} x{{ $sp->pivot->qty }}</td>
            <td class="text-end">Rp {{ number_format($sp->pivot->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>
    <hr>
    @endif

    <div class="footer">
        <p>Mohon simpan nota ini sebagai bukti terima</p>
        <p>Barang yang sudah selesai harap segera diambil</p>
    </div>

    <script>
        window.onload = function() { window.print(); }
    </script>
</body>
</html>
