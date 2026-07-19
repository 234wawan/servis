@extends('layouts.app')

@section('title', 'Tambah Sparepart')

@section('content')
<h1>Tambah Sparepart</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.sparepart.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Sparepart</label>
                    <input type="text" name="kode_sparepart" class="form-control @error('kode_sparepart') is-invalid @enderror"
                        value="{{ old('kode_sparepart') }}" required>
                    @error('kode_sparepart')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Sparepart</label>
                <input type="text" name="nama_sparepart" class="form-control @error('nama_sparepart') is-invalid @enderror"
                    value="{{ old('nama_sparepart') }}" required>
                @error('nama_sparepart')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Satuan</label>
                    <select name="satuan" class="form-select @error('satuan') is-invalid @enderror" required>
                        <option value="pcs" {{ old('satuan') === 'pcs' ? 'selected' : '' }}>Pcs</option>
                        <option value="liter" {{ old('satuan') === 'liter' ? 'selected' : '' }}>Liter</option>
                        <option value="kg" {{ old('satuan') === 'kg' ? 'selected' : '' }}>Kg</option>
                        <option value="meter" {{ old('satuan') === 'meter' ? 'selected' : '' }}>Meter</option>
                        <option value="set" {{ old('satuan') === 'set' ? 'selected' : '' }}>Set</option>
                    </select>
                    @error('satuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                        value="{{ old('stok', 0) }}" min="0" required>
                    @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Stok Minimum</label>
                    <input type="number" name="stok_minimum" class="form-control @error('stok_minimum') is-invalid @enderror"
                        value="{{ old('stok_minimum', 5) }}" min="0" required>
                    @error('stok_minimum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Beli (Rp)</label>
                    <input type="text" name="harga_beli" class="form-control @error('harga_beli') is-invalid @enderror"
                        value="{{ old('harga_beli') ? number_format(old('harga_beli'), 0, ',', '.') : '' }}"
                        inputmode="numeric" onkeyup="this.value=formatRupiah(this.value)">
                    @error('harga_beli')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Jual (Rp)</label>
                    <input type="text" name="harga_jual" class="form-control @error('harga_jual') is-invalid @enderror"
                        value="{{ old('harga_jual') ? number_format(old('harga_jual'), 0, ',', '.') : '' }}"
                        inputmode="numeric" onkeyup="this.value=formatRupiah(this.value)">
                    @error('harga_jual')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.sparepart.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function formatRupiah(v) {
        return v.replace(/[^\d]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
</script>
@endpush
