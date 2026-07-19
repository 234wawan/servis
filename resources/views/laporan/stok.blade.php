@extends('layouts.app')

@section('title', 'Laporan Stok Menipis')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Laporan Stok Menipis</h1>
    <a href="{{ route('admin.laporan.stok.export') }}" class="btn btn-success">
        <i class="bi bi-file-earmark-excel"></i> Export CSV
    </a>
</div>

<div class="alert alert-warning d-flex align-items-center gap-2">
    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
    Berikut adalah daftar sparepart dengan stok yang sudah mencapai atau di bawah batas minimum.
</div>

<div class="card">
    <div class="card-body">
        <table id="tableStok" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama Sparepart</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Stok Minimum</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($spareparts as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_sparepart }}</td>
                        <td>{{ $item->nama_sparepart }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $item->stok == 0 ? 'bg-dark' : 'bg-danger' }} rounded-pill px-3">
                                {{ $item->stok }}
                            </span>
                        </td>
                        <td>{{ $item->stok_minimum }}</td>
                        <td>
                            @if ($item->stok == 0)
                                <span class="badge bg-dark rounded-pill px-3">Habis</span>
                            @else
                                <span class="badge bg-warning text-dark rounded-pill px-3">Menipis</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.sparepart.edit', $item) }}" class="btn btn-sm btn-warning">Restok</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-success fw-semibold">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            Semua stok sparepart dalam kondisi aman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#tableStok').DataTable({
        columnDefs: [
            { targets: 0, data: 0 },
            { targets: 1, data: 1 },
            { targets: 2, data: 2 },
            { targets: 3, data: 3 },
            { targets: 4, data: 4 },
            { targets: 5, data: 5 },
            { targets: 6, data: 6 },
            { targets: 7, data: 7, orderable: false }
        ]
    });
});
</script>
@endpush
