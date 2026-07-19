@extends('layouts.app')

@section('title', 'Detail Kendaraan')

@section('content')
<h1>Detail Kendaraan</h1>

<div class="card mb-4">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">No. Polisi</dt>
            <dd class="col-sm-9">{{ $kendaraan->no_polisi }}</dd>
            <dt class="col-sm-3">Merek</dt>
            <dd class="col-sm-9">{{ $kendaraan->merek }}</dd>
            <dt class="col-sm-3">Model</dt>
            <dd class="col-sm-9">{{ $kendaraan->model }}</dd>
            <dt class="col-sm-3">Tahun</dt>
            <dd class="col-sm-9">{{ $kendaraan->tahun ?? '-' }}</dd>
            <dt class="col-sm-3">Warna</dt>
            <dd class="col-sm-9">{{ $kendaraan->warna ?? '-' }}</dd>
            <dt class="col-sm-3">Pemilik</dt>
            <dd class="col-sm-9">
                <a href="{{ route('admin.pelanggan.show', $kendaraan->pelanggan) }}">
                    {{ $kendaraan->pelanggan->nama }}
                </a>
            </dd>
        </dl>
        <a href="{{ route('admin.kendaraan.edit', $kendaraan) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('admin.kendaraan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<h2>Riwayat Servis</h2>
<div class="card">
    <div class="card-body">
        @forelse ($kendaraan->servis as $servis)
            <div class="border rounded p-3 mb-2">
                <div class="d-flex justify-content-between">
                    <strong>{{ $servis->tgl_masuk }}</strong>
                    @switch($servis->status)
                        @case('pending') <span class="badge bg-warning">Pending</span> @break
                        @case('proses') <span class="badge bg-info">Proses</span> @break
                        @case('selesai') <span class="badge bg-success">Selesai</span> @break
                    @endswitch
                </div>
                <p class="mb-1 mt-1">{{ $servis->keluhan }}</p>
                <small class="text-muted">Biaya: Rp {{ number_format($servis->biaya, 0, ',', '.') }}</small>
            </div>
        @empty
            <p class="text-muted mb-0">Belum ada riwayat servis.</p>
        @endforelse
    </div>
</div>
@endsection
