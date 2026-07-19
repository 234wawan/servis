@extends('layouts.app')

@section('title', 'Detail Sparepart')

@section('content')
<h1>Detail Sparepart</h1>

<div class="card">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Kode Sparepart</dt>
            <dd class="col-sm-9">{{ $sparepart->kode_sparepart }}</dd>
            <dt class="col-sm-3">Nama Sparepart</dt>
            <dd class="col-sm-9">{{ $sparepart->nama_sparepart }}</dd>
            <dt class="col-sm-3">Kategori</dt>
            <dd class="col-sm-9">{{ $sparepart->kategori->nama_kategori ?? '-' }}</dd>
            <dt class="col-sm-3">Satuan</dt>
            <dd class="col-sm-9">{{ $sparepart->satuan }}</dd>
            <dt class="col-sm-3">Stok</dt>
            <dd class="col-sm-9">
                <span class="badge {{ $sparepart->stok <= $sparepart->stok_minimum ? 'bg-danger' : 'bg-success' }} rounded-pill px-3">
                    {{ $sparepart->stok }} {{ $sparepart->satuan }}
                </span>
            </dd>
            <dt class="col-sm-3">Stok Minimum</dt>
            <dd class="col-sm-9">{{ $sparepart->stok_minimum }}</dd>
            <dt class="col-sm-3">Harga Beli</dt>
            <dd class="col-sm-9">Rp {{ number_format($sparepart->harga_beli, 0, ',', '.') }}</dd>
            <dt class="col-sm-3">Harga Jual</dt>
            <dd class="col-sm-9">Rp {{ number_format($sparepart->harga_jual, 0, ',', '.') }}</dd>
            <dt class="col-sm-3">Deskripsi</dt>
            <dd class="col-sm-9">{{ $sparepart->deskripsi ?? '-' }}</dd>
        </dl>
        <a href="{{ route('admin.sparepart.edit', $sparepart) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('admin.sparepart.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
