@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Laporan Keuangan</h1>
    <div>
        <a href="{{ route('admin.laporan.keuangan.export', request()->query()) }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Export CSV
        </a>
        <a href="{{ route('admin.laporan.keuangan.pdf', request()->query()) }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>
</div>

<div class="content-card mb-4">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Periode</label>
            <select name="period" class="form-select" onchange="togglePeriod(this.value)">
                <option value="bulanan" {{ $period === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                <option value="harian" {{ $period === 'harian' ? 'selected' : '' }}>Harian</option>
            </select>
        </div>
        <div class="col-md-3" id="fieldBulan" style="{{ $period === 'harian' ? 'display:none' : '' }}">
            <label class="form-label">Bulan</label>
            <select name="month" class="form-select">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2" id="fieldTahunBulan" style="{{ $period === 'harian' ? 'display:none' : '' }}">
            <label class="form-label">Tahun</label>
            <select name="year" class="form-select">
                @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3" id="fieldStartDate" style="{{ $period === 'bulanan' ? 'display:none' : '' }}">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
        </div>
        <div class="col-md-3" id="fieldEndDate" style="{{ $period === 'bulanan' ? 'display:none' : '' }}">
            <label class="form-label">Tanggal Akhir</label>
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date', now()->format('Y-m-d')) }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="content-card d-flex align-items-center gap-3" style="border-left: 4px solid #10b981;">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 52px; height: 52px; background: #ecfdf5; color: #10b981; font-size: 1.5rem;">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div>
                <p class="text-muted mb-0" style="font-size: 0.8rem;">Total Pendapatan</p>
                <h3 class="mb-0 fw-bold" style="color: #1f2937;">Rp {{ number_format($pendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="content-card d-flex align-items-center gap-3" style="border-left: 4px solid #6366f1;">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 52px; height: 52px; background: #eef2ff; color: #6366f1; font-size: 1.5rem;">
                <i class="bi bi-tools"></i>
            </div>
            <div>
                <p class="text-muted mb-0" style="font-size: 0.8rem;">Jumlah Servis</p>
                <h3 class="mb-0 fw-bold" style="color: #1f2937;">{{ $totalServis }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="content-card mb-4">
    <h5 class="fw-bold mb-3">Riwayat Pendapatan Bulanan</h5>
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th class="text-end">Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pendapatanBulanan as $pb)
                    <tr>
                        <td>{{ \Carbon\Carbon::create()->month($pb->bulan)->format('F') }} {{ $pb->tahun }}</td>
                        <td class="text-end fw-semibold">Rp {{ number_format($pb->total, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-center">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="content-card">
    <h5 class="fw-bold mb-3">Detail Transaksi</h5>
    <div class="table-responsive">
        <table id="tableKeuangan" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No Polisi</th>
                    <th>Pemilik</th>
                    <th>Tgl Masuk</th>
                    <th>Tgl Selesai</th>
                    <th>Keluhan</th>
                    <th class="text-end">Biaya</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($servisList as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kendaraan->no_polisi ?? '-' }}</td>
                        <td>{{ $item->kendaraan->pelanggan->nama ?? '-' }}</td>
                        <td>{{ $item->tgl_masuk }}</td>
                        <td>{{ $item->tgl_selesai }}</td>
                        <td>{{ Str::limit($item->keluhan, 30) }}</td>
                        <td class="text-end fw-semibold">Rp {{ number_format($item->biaya, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $('#tableKeuangan').DataTable({
            columnDefs: [
                { targets: 0, data: 0 },
                { targets: 1, data: 1 },
                { targets: 2, data: 2 },
                { targets: 3, data: 3 },
                { targets: 4, data: 4 },
                { targets: 5, data: 5 },
                { targets: 6, data: 6, orderable: false }
            ]
        });
    });

    function togglePeriod(val) {
        document.getElementById('fieldBulan').style.display = val === 'harian' ? 'none' : '';
        document.getElementById('fieldTahunBulan').style.display = val === 'harian' ? 'none' : '';
        document.getElementById('fieldStartDate').style.display = val === 'bulanan' ? 'none' : '';
        document.getElementById('fieldEndDate').style.display = val === 'bulanan' ? 'none' : '';
    }
</script>
@endpush
