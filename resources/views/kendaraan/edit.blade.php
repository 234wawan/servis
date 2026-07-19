@extends('layouts.app')

@section('title', 'Edit Kendaraan')

@section('content')
<h1>Edit Kendaraan</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.kendaraan.update', $kendaraan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Pemilik</label>
                <select name="pelanggan_id" class="form-select @error('pelanggan_id') is-invalid @enderror" required>
                    @foreach ($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id', $kendaraan->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>
                            {{ $pelanggan->nama }} ({{ $pelanggan->no_telp }})
                        </option>
                    @endforeach
                </select>
                @error('pelanggan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">No. Polisi</label>
                <input type="text" name="no_polisi" class="form-control @error('no_polisi') is-invalid @enderror"
                    value="{{ old('no_polisi', $kendaraan->no_polisi) }}" required>
                @error('no_polisi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" name="merek" class="form-control @error('merek') is-invalid @enderror"
                        value="{{ old('merek', $kendaraan->merek) }}" required>
                    @error('merek')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Model</label>
                    <input type="text" name="model" class="form-control @error('model') is-invalid @enderror"
                        value="{{ old('model', $kendaraan->model) }}" required>
                    @error('model')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror"
                        value="{{ old('tahun', $kendaraan->tahun) }}">
                    @error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Warna</label>
                    <input type="text" name="warna" class="form-control @error('warna') is-invalid @enderror"
                        value="{{ old('warna', $kendaraan->warna) }}">
                    @error('warna')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.kendaraan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
