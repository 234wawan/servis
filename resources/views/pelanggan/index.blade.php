@extends('layouts.app')

@section('title', 'Daftar Pelanggan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Daftar Pelanggan</h1>
    <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-primary">+ Tambah Pelanggan</a>
</div>

<div class="card">
    <div class="card-body">
        <table id="tablePelanggan" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>No. Telp</th>
                    <th>No. WA</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pelanggans as $pelanggan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pelanggan->nama }}</td>
                        <td>{{ $pelanggan->no_telp }}</td>
                        <td>{{ $pelanggan->no_wa ?? '-' }}</td>
                        <td>{{ Str::limit($pelanggan->alamat, 30) ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.pelanggan.show', $pelanggan) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('admin.pelanggan.edit', $pelanggan) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.pelanggan.destroy', $pelanggan) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada pelanggan.</td>
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
    $('#tablePelanggan').DataTable({
        columnDefs: [
            { targets: 0, data: 0 },
            { targets: 1, data: 1 },
            { targets: 2, data: 2 },
            { targets: 3, data: 3 },
            { targets: 4, data: 4 },
            { targets: 5, data: 5, orderable: false }
        ]
    });
});
</script>
@endpush
