@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Kontak & Informasi Footer</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.konten.kontak.update') }}" method="POST">
            @csrf
            <div class="row">
                @forelse ($kontaks as $kontak)
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ $kontak->label }}</label>
                        <div class="input-group">
                            @if ($kontak->icon)
                                <span class="input-group-text"><i class="bi {{ $kontak->icon }}"></i></span>
                            @endif
                            <input type="text" name="kontak[{{ $kontak->key }}]" class="form-control"
                                value="{{ old('kontak.' . $kontak->key, $kontak->value) }}">
                        </div>
                        <small class="text-muted">{{ ucfirst($kontak->tipe) }}</small>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            Belum ada data kontak. Jalankan seeder terlebih dahulu.
                            <a href="#" onclick="event.preventDefault(); document.getElementById('seedForm').submit();" class="alert-link">Klik di sini untuk inisialisasi</a>
                            <form id="seedForm" method="POST" action="{{ route('admin.konten.kontak.seed') }}" class="d-none">@csrf</form>
                        </div>
                    </div>
                @endforelse
            </div>
            @if ($kontaks->isNotEmpty())
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h6 class="mb-0">Info</h6>
    </div>
    <div class="card-body">
        <p class="text-muted small mb-0">
            Data kontak ditampilkan di footer halaman utama website. Untuk menambah atau menghapus item kontak, hubungi developer.
        </p>
    </div>
</div>
@endsection
