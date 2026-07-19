@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<h1>Edit Pelanggan</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.pelanggan.update', $pelanggan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                    value="{{ old('nama', $pelanggan->nama) }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                    rows="3">{{ old('alamat', $pelanggan->alamat) }}</textarea>
                @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                    <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror"
                        value="{{ old('no_telp', $pelanggan->no_telp) }}" required>
                    @error('no_telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. WhatsApp</label>
                    <input type="text" name="no_wa" class="form-control @error('no_wa') is-invalid @enderror"
                        value="{{ old('no_wa', $pelanggan->no_wa) }}" placeholder="08xxxx">
                    @error('no_wa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $pelanggan->email) }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
