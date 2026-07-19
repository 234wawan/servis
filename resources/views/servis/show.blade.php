@extends('layouts.app')

@section('title', 'Detail Servis')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <i class="bi bi-eye fs-2 text-info"></i>
    <h1 class="mb-0">Detail Servis</h1>
</div>

@if ($servis->is_void)
    <div class="alert alert-secondary d-flex align-items-center gap-2">
        <i class="bi bi-x-circle-fill"></i>
        <strong>Servis ini telah di-void</strong> pada {{ $servis->voided_at ? \Carbon\Carbon::parse($servis->voided_at)->format('d/m/Y H:i') : '-' }}
        oleh {{ $servis->voidedBy->name ?? 'Unknown' }}.
        @if ($servis->alasan_void)
            <br>Alasan: {{ $servis->alasan_void }}
        @endif
    </div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="bi bi-info-circle"></i> Informasi Servis</h5>
                <dl class="row mb-0">
                    <dt class="col-sm-4">No. Antrian</dt>
                    <dd class="col-sm-8"><span class="badge bg-dark fs-6">{{ $servis->no_antrian ?? '-' }}</span></dd>
                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8">
                        @if ($servis->is_void)
                            <span class="badge bg-secondary">Void</span>
                        @else
                            @switch($servis->status)
                                @case('pending') <span class="badge bg-warning">Pending</span> @break
                                @case('proses') <span class="badge bg-info">Proses</span> @break
                                @case('selesai') <span class="badge bg-success">Selesai</span> @break
                                @case('diambil') <span class="badge bg-primary">Diambil</span> @break
                            @endswitch
                        @endif
                    </dd>
                    <dt class="col-sm-4">Tgl Masuk</dt>
                    <dd class="col-sm-8">{{ $servis->tgl_masuk }}</dd>
                    <dt class="col-sm-4">Tgl Selesai</dt>
                    <dd class="col-sm-8">{{ $servis->tgl_selesai ?? '-' }}</dd>
                    <dt class="col-sm-4">Tipe Barang</dt>
                    <dd class="col-sm-8">{{ $servis->tipe_barang ?? '-' }}</dd>
                    <dt class="col-sm-4">Keluhan</dt>
                    <dd class="col-sm-8">{{ $servis->keluhan }}</dd>
                    <dt class="col-sm-4">Kelengkapan</dt>
                    <dd class="col-sm-8">{{ $servis->kelengkapan ?? '-' }}</dd>
                    <dt class="col-sm-4">Catatan</dt>
                    <dd class="col-sm-8">{{ $servis->catatan ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="bi bi-truck"></i> Kendaraan & Pemilik</h5>
                <dl class="row mb-0">
                    <dt class="col-sm-4">No. Polisi</dt>
                    <dd class="col-sm-8">{{ $servis?->kendaraan?->no_polisi ?? '-' }}</dd>
                    <dt class="col-sm-4">Merek/Model</dt>
                    <dd class="col-sm-8">{{ $servis?->kendaraan?->merek ?? '-' }} {{ $servis?->kendaraan?->model ?? '-' }}</dd>
                    <dt class="col-sm-4">Pemilik</dt>
                    <dd class="col-sm-8">
                        <a href="{{ $servis?->kendaraan?->pelanggan ? route('admin.pelanggan.show', $servis->kendaraan->pelanggan) : '#' }}">
                            {{ $servis?->kendaraan?->pelanggan?->nama ?? '-' }}
                        </a>
                    </dd>
                    <dt class="col-sm-4">No. Telp</dt>
                    <dd class="col-sm-8">{{ $servis?->kendaraan?->pelanggan?->no_telp ?? '-' }}</dd>
                    <dt class="col-sm-4">No. WA</dt>
                    <dd class="col-sm-8">{{ $servis?->kendaraan?->pelanggan?->no_wa ?? '-' }}</dd>
                </dl>
            </div>
        </div>

        @if ($servis->spareparts->isNotEmpty())
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="bi bi-box-seam"></i> Sparepart Digunakan</h5>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Sparepart</th>
                            <th>Qty</th>
                            <th>@Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($servis->spareparts as $sp)
                        <tr>
                            <td>{{ $sp->nama_sparepart }}</td>
                            <td>{{ $sp->pivot->qty }}</td>
                            <td>Rp {{ number_format($sp->pivot->harga_jual, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($sp->pivot->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="3">Total Sparepart</td>
                            <td>Rp {{ number_format($servis->spareparts->sum(fn($s) => $s->pivot->subtotal), 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @endif

        <div class="card mt-3">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="bi bi-currency-dollar"></i> Pembayaran</h5>
                <dl class="row mb-0">
                    <dt class="col-sm-4">Biaya</dt>
                    <dd class="col-sm-8">Rp {{ number_format($servis->biaya, 0, ',', '.') }}</dd>
                    @if ($servis->diskon > 0)
                        <dt class="col-sm-4">Diskon</dt>
                        <dd class="col-sm-8">
                            @if ($servis->tipe_diskon === 'persen')
                                {{ $servis->diskon }}%
                            @endif
                            - Rp {{ number_format($servis->getDiskonRupiah(), 0, ',', '.') }}
                        </dd>
                    @endif
                    <dt class="col-sm-4">Total Bayar</dt>
                    <dd class="col-sm-8 fw-bold fs-5 text-success">Rp {{ number_format($servis->total_bayar ?: $servis->biaya, 0, ',', '.') }}</dd>
                    @if ($servis->metode_pembayaran)
                        <dt class="col-sm-4">Metode</dt>
                        <dd class="col-sm-8"><span class="badge bg-info">{{ strtoupper($servis->metode_pembayaran) }}</span></dd>
                        <dt class="col-sm-4">Tgl Bayar</dt>
                        <dd class="col-sm-8">{{ $servis->tgl_pembayaran ? \Carbon\Carbon::parse($servis->tgl_pembayaran)->format('d/m/Y H:i') : '-' }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</div>

<div class="mt-3 d-flex gap-2">
    @if (!$servis->is_void && auth()->user()->role !== 'kasir')
        <a href="{{ route('admin.servis.edit', $servis) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
    @endif

    <a href="{{ route('admin.servis.nota', $servis) }}" target="_blank" class="btn btn-outline-dark">
        <i class="bi bi-receipt"></i> Nota Terima
    </a>

    @if ($servis->metode_pembayaran)
        <a href="{{ route('admin.servis.struk', $servis) }}" target="_blank" class="btn btn-outline-success">
            <i class="bi bi-printer"></i> Struk Bayar
        </a>
    @endif

    @if ($servis->status === 'selesai' && !$servis->metode_pembayaran)
        <a href="{{ route('admin.servis.checkout', $servis) }}" class="btn btn-success">
            <i class="bi bi-cash-coin"></i> Checkout / Bayar
        </a>
    @endif

    <a href="{{ route('admin.servis.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
