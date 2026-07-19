@extends('layouts.app')

@section('title', 'Dashboard')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
$(function() {
    $('#tableServisTerbaru').DataTable({
        paging: false,
        info: false,
        searching: false,
        columnDefs: [
            { targets: 0, data: 0 },
            { targets: 1, data: 1 },
            { targets: 2, data: 2 },
            { targets: 3, data: 3 },
            { targets: 4, data: 4 }
        ]
    });
});

const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

@php
        $pendapatanData = [];
        $servisData = [];
        for ($m = 1; $m <= 12; $m++) {
            $pendapatanData[] = $chartPendapatan[$m] ?? 0;
            $servisData[] = $chartServis[$m] ?? 0;
        }
@endphp

new Chart(document.getElementById('chartPendapatan'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Pendapatan',
            data: @json($pendapatanData),
            backgroundColor: 'rgba(99, 102, 241, 0.7)',
            borderColor: '#6366f1',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } } }
    }
});

new Chart(document.getElementById('chartServis'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Servis',
            data: @json($servisData),
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
</script>
@endpush

@section('content')
<div class="page-header">
    <h1>Dashboard</h1>
    <p>Selamat datang, {{ Auth::user()->name }}! Berikut ringkasan data servis kendaraan.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="content-card d-flex align-items-center gap-3" style="border-left: 4px solid #6366f1;">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 52px; height: 52px; background: #eef2ff; color: #6366f1; font-size: 1.5rem;">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <p class="text-muted mb-0" style="font-size: 0.8rem;">Total Pelanggan</p>
                <h3 class="mb-0 fw-bold" style="color: #1f2937;">{{ $totalPelanggan }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="content-card d-flex align-items-center gap-3" style="border-left: 4px solid #10b981;">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 52px; height: 52px; background: #ecfdf5; color: #10b981; font-size: 1.5rem;">
                <i class="bi bi-truck-front-fill"></i>
            </div>
            <div>
                <p class="text-muted mb-0" style="font-size: 0.8rem;">Total Kendaraan</p>
                <h3 class="mb-0 fw-bold" style="color: #1f2937;">{{ $totalKendaraan }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="content-card d-flex align-items-center gap-3" style="border-left: 4px solid #f59e0b;">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 52px; height: 52px; background: #fffbeb; color: #f59e0b; font-size: 1.5rem;">
                <i class="bi bi-tools"></i>
            </div>
            <div>
                <p class="text-muted mb-0" style="font-size: 0.8rem;">Total Servis</p>
                <h3 class="mb-0 fw-bold" style="color: #1f2937;">{{ $totalServis }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="content-card d-flex align-items-center gap-3" style="border-left: 4px solid #8b5cf6;">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 52px; height: 52px; background: #f5f3ff; color: #8b5cf6; font-size: 1.5rem;">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div>
                <p class="text-muted mb-0" style="font-size: 0.8rem;">Total Pendapatan</p>
                <h3 class="mb-0 fw-bold" style="color: #1f2937;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-2 col-md-4 col-6">
        <div class="content-card d-flex align-items-center gap-2" style="border-left: 4px solid #f59e0b;">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 36px; height: 36px; background: #fffbeb; color: #f59e0b; font-size: 1rem;">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <p class="text-muted mb-0" style="font-size: 0.7rem;">Pending</p>
                <h5 class="mb-0 fw-bold text-warning">{{ $servisPending }}</h5>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="content-card d-flex align-items-center gap-2" style="border-left: 4px solid #0ea5e9;">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 36px; height: 36px; background: #f0f9ff; color: #0ea5e9; font-size: 1rem;">
                <i class="bi bi-arrow-repeat"></i>
            </div>
            <div>
                <p class="text-muted mb-0" style="font-size: 0.7rem;">Diproses</p>
                <h5 class="mb-0 fw-bold text-info">{{ $servisProses }}</h5>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="content-card d-flex align-items-center gap-2" style="border-left: 4px solid #10b981;">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 36px; height: 36px; background: #ecfdf5; color: #10b981; font-size: 1rem;">
                <i class="bi bi-check2-circle"></i>
            </div>
            <div>
                <p class="text-muted mb-0" style="font-size: 0.7rem;">Selesai</p>
                <h5 class="mb-0 fw-bold text-success">{{ $servisSelesai }}</h5>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="content-card d-flex align-items-center gap-2" style="border-left: 4px solid #3b82f6;">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 36px; height: 36px; background: #eff6ff; color: #3b82f6; font-size: 1rem;">
                <i class="bi bi-box-seam"></i>
            </div>
            <div>
                <p class="text-muted mb-0" style="font-size: 0.7rem;">Diambil</p>
                <h5 class="mb-0 fw-bold text-primary">{{ $servisDiambil }}</h5>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="content-card d-flex align-items-center gap-2" style="border-left: 4px solid #8b5cf6;">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 36px; height: 36px; background: #f5f3ff; color: #8b5cf6; font-size: 1rem;">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <p class="text-muted mb-0" style="font-size: 0.7rem;">Pengguna</p>
                <h5 class="mb-0 fw-bold" style="color:#8b5cf6">{{ $totalUsers }}</h5>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="content-card d-flex align-items-center gap-2" style="border-left: 4px solid #ef4444;">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 36px; height: 36px; background: #fef2f2; color: #ef4444; font-size: 1rem;">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div>
                <p class="text-muted mb-0" style="font-size: 0.7rem;">Stok Menipis</p>
                <h5 class="mb-0 fw-bold text-danger">{{ $stokMenipis }}</h5>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="content-card d-flex align-items-center gap-2" style="border-left: 4px solid #6366f1;">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 36px; height: 36px; background: #eef2ff; color: #6366f1; font-size: 1rem;">
                <i class="bi bi-box-seam"></i>
            </div>
            <div>
                <p class="text-muted mb-0" style="font-size: 0.7rem;">Sparepart</p>
                <h5 class="mb-0 fw-bold" style="color:#6366f1">{{ $totalSparepart }}</h5>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="content-card">
            <h5 class="fw-bold mb-3">Pendapatan Bulanan ({{ date('Y') }})</h5>
            <canvas id="chartPendapatan" height="150"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="content-card">
            <h5 class="fw-bold mb-3">Servis Bulanan ({{ date('Y') }})</h5>
            <canvas id="chartServis" height="150"></canvas>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0" style="color: #1f2937;">
            <i class="bi bi-clock-history me-2 text-primary"></i>Servis Terbaru
        </h5>
        <a href="{{ route('admin.servis.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table id="tableServisTerbaru" class="table">
            <thead>
                <tr>
                    <th>Kendaraan</th>
                    <th>Pemilik</th>
                    <th>Tgl Masuk</th>
                    <th>Status</th>
                    <th class="text-end">Biaya</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($servisTerbaru as $item)
                    <tr class="{{ $item->is_void ? 'text-muted' : '' }}">
                        <td>
                            <span class="fw-semibold">{{ $item->kendaraan->no_polisi ?? '-' }}</span>
                            <small class="d-block text-muted">{{ $item->kendaraan->merek ?? '' }} {{ $item->kendaraan->model ?? '' }}</small>
                        </td>
                        <td>{{ $item->kendaraan->pelanggan->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_masuk)->format('d/m/Y') }}</td>
                        <td>
                            @if ($item->is_void)
                                <span class="badge bg-secondary rounded-pill px-3">Void</span>
                            @else
                                @switch($item->status)
                                    @case('pending') <span class="badge text-bg-warning rounded-pill px-3">Pending</span> @break
                                    @case('proses') <span class="badge text-bg-info rounded-pill px-3">Proses</span> @break
                                    @case('selesai') <span class="badge text-bg-success rounded-pill px-3">Selesai</span> @break
                                @endswitch
                            @endif
                        </td>
                        <td class="text-end fw-semibold">Rp {{ number_format($item->biaya, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada servis.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
