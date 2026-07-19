@extends('layouts.app')

@section('title', 'Laporan Performa Servis')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Laporan Performa Servis</h1>
    <div>
        <a href="{{ route('admin.laporan.performa.export', request()->query()) }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Export CSV
        </a>
        <a href="{{ route('admin.laporan.performa.pdf', request()->query()) }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>
</div>

<div class="content-card mb-4">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Tahun</label>
            <select name="year" class="form-select">
                @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Bulan</label>
            <select name="month" class="form-select">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="content-card d-flex align-items-center gap-3" style="border-left: 4px solid #10b981;">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 52px; height: 52px; background: #ecfdf5; color: #10b981; font-size: 1.5rem;">
                <i class="bi bi-tools"></i>
            </div>
            <div>
                <p class="text-muted mb-0" style="font-size: 0.8rem;">Servis Selesai</p>
                <h3 class="mb-0 fw-bold" style="color: #1f2937;">{{ $totalServis }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="content-card d-flex align-items-center gap-3" style="border-left: 4px solid #f59e0b;">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 52px; height: 52px; background: #fffbeb; color: #f59e0b; font-size: 1.5rem;">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <p class="text-muted mb-0" style="font-size: 0.8rem;">Rata-rata Durasi Servis</p>
                <h3 class="mb-0 fw-bold" style="color: #1f2937;">{{ number_format($rataHari, 1) }} Hari</h3>
            </div>
        </div>
    </div>
</div>

<div class="content-card">
    <h5 class="fw-bold mb-3">Performa Servis Per Bulan</h5>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th class="text-end">Jumlah Servis</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($servisPerBulan as $spb)
                    <tr>
                        <td>{{ \Carbon\Carbon::create()->month($spb->bulan)->format('F') }} {{ $spb->tahun }}</td>
                        <td class="text-end fw-semibold">{{ $spb->total }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-center">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
