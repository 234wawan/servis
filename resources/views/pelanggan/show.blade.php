@extends('layouts.app')

@section('title', 'Detail Pelanggan')

@section('content')
<h1>Detail Pelanggan</h1>

<div class="card mb-4">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nama</dt>
            <dd class="col-sm-9">{{ $pelanggan->nama }}</dd>
            <dt class="col-sm-3">Alamat</dt>
            <dd class="col-sm-9">{{ $pelanggan->alamat ?? '-' }}</dd>
            <dt class="col-sm-3">No. Telepon</dt>
            <dd class="col-sm-9">{{ $pelanggan->no_telp }}</dd>
            <dt class="col-sm-3">No. WhatsApp</dt>
            <dd class="col-sm-9">{{ $pelanggan->no_wa ?? '-' }}</dd>
            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $pelanggan->email ?? '-' }}</dd>
        </dl>
        <a href="{{ route('admin.pelanggan.edit', $pelanggan) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<h2>Kendaraan</h2>
<div class="card">
    <div class="card-body">
        @forelse ($pelanggan->kendaraans as $kendaraan)
            <div class="border rounded p-3 mb-3">
                <h5>{{ $kendaraan->merek }} {{ $kendaraan->model }}</h5>
                <dl class="row mb-0">
                    <dt class="col-sm-3">No. Polisi</dt>
                    <dd class="col-sm-9">{{ $kendaraan->no_polisi }}</dd>
                    <dt class="col-sm-3">Tahun</dt>
                    <dd class="col-sm-9">{{ $kendaraan->tahun ?? '-' }}</dd>
                    <dt class="col-sm-3">Warna</dt>
                    <dd class="col-sm-9">{{ $kendaraan->warna ?? '-' }}</dd>
                </dl>

                @if ($kendaraan->servis->count())
                    <h6 class="mt-3">Riwayat Servis:</h6>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No. Antrian</th>
                                <th>Tgl Masuk</th>
                                <th>Keluhan</th>
                                <th>Status</th>
                                <th>Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kendaraan->servis as $servis)
                                <tr>
                                    <td>{{ $servis->no_antrian ?? '-' }}</td>
                                    <td>{{ $servis->tgl_masuk }}</td>
                                    <td>{{ $servis->keluhan }}</td>
                                    <td>
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
                                    </td>
                                    <td>Rp {{ number_format($servis->total_bayar ?: $servis->biaya, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted mt-2 mb-0">Belum ada riwayat servis.</p>
                @endif
            </div>
        @empty
            <p class="text-muted mb-0">Belum ada kendaraan.</p>
        @endforelse
    </div>
</div>
@endsection
