@extends('layouts.app')

@section('title', 'Daftar Kendaraan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Daftar Kendaraan</h1>
    <a href="{{ route('admin.kendaraan.create') }}" class="btn btn-primary">+ Tambah Kendaraan</a>
</div>

<div class="card">
    <div class="card-body">
        <table id="tableKendaraan" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No. Polisi</th>
                    <th>Merek</th>
                    <th>Model</th>
                    <th>Pemilik</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kendaraans as $kendaraan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kendaraan->no_polisi }}</td>
                        <td>{{ $kendaraan->merek }}</td>
                        <td>{{ $kendaraan->model }}</td>
                        <td>{{ $kendaraan->pelanggan->nama ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.kendaraan.show', $kendaraan) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('admin.kendaraan.edit', $kendaraan) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.kendaraan.destroy', $kendaraan) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada kendaraan.</td>
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
    $('#tableKendaraan').DataTable({
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
