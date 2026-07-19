<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Performa Servis</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 5px; }
        .subtitle { text-align: center; color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background: #f5f5f5; font-weight: bold; }
        .text-end { text-align: right; }
        .summary { margin-bottom: 15px; }
        .summary table { border: none; }
        .summary td { border: none; padding: 3px 6px; }
    </style>
</head>
<body>
    <h1>Laporan Performa Servis</h1>
    <p class="subtitle">{{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}</p>

    <div class="summary">
        <table>
            <tr><td><strong>Servis Selesai:</strong></td><td>{{ $totalServis }}</td></tr>
            <tr><td><strong>Rata-rata Durasi:</strong></td><td>{{ number_format($rataHari, 1) }} Hari</td></tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>No Polisi</th>
                <th>Pemilik</th>
                <th>Tgl Masuk</th>
                <th>Tgl Selesai</th>
                <th class="text-end">Durasi (Hari)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($servisList as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->kendaraan->no_polisi ?? '-' }}</td>
                    <td>{{ $item->kendaraan->pelanggan->nama ?? '-' }}</td>
                    <td>{{ $item->tgl_masuk }}</td>
                    <td>{{ $item->tgl_selesai }}</td>
                    <td class="text-end">
                        {{ $item->tgl_masuk && $item->tgl_selesai ? \Carbon\Carbon::parse($item->tgl_masuk)->diffInDays(\Carbon\Carbon::parse($item->tgl_selesai)) : 0 }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
