@extends('layouts.app')

@section('title', 'Daftar Sparepart')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Daftar Sparepart</h1>
    <a href="{{ route('admin.sparepart.create') }}" class="btn btn-primary">+ Tambah Sparepart</a>
</div>

<div class="card">
    <div class="card-body">
        <table id="tableSparepart" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama Sparepart</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Stok Min</th>
                    <th>Harga Jual</th>
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
                            <span class="badge {{ $item->stok <= $item->stok_minimum ? 'bg-danger' : 'bg-success' }} rounded-pill px-3">
                                {{ $item->stok }}
                            </span>
                        </td>
                        <td>{{ $item->stok_minimum }}</td>
                        <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('admin.sparepart.show', $item) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('admin.sparepart.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.sparepart.destroy', $item) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada sparepart.</td>
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
    $('#tableSparepart').DataTable({
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
