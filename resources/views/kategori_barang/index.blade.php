@extends('layouts.app')

@section('title', 'Kategori Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Kategori Barang</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalKategori">
        + Tambah Kategori
    </button>
</div>

<div class="card">
    <div class="card-body">
        <table id="tableKategori" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Sparepart</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategoris as $kategori)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kategori->nama_kategori }}</td>
                        <td>{{ $kategori->deskripsi ?? '-' }}</td>
                        <td>{{ $kategori->spareparts_count }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning btn-edit-kategori"
                                data-id="{{ $kategori->id }}"
                                data-nama="{{ $kategori->nama_kategori }}"
                                data-deskripsi="{{ $kategori->deskripsi }}">
                                Edit
                            </button>
                            <form action="{{ route('admin.kategori-barang.destroy', $kategori) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalKategori" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKategoriTitle">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formKategori" action="{{ route('admin.kategori-barang.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="POST" id="methodKategori">
                <input type="hidden" name="kategori_id" id="kategoriId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="inputNamaKategori" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="inputDeskripsiKategori" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#tableKategori').DataTable({
        columnDefs: [
            { targets: 0, data: 0 },
            { targets: 1, data: 1 },
            { targets: 2, data: 2 },
            { targets: 3, data: 3 },
            { targets: 4, data: 4, orderable: false }
        ]
    });
});

    document.querySelectorAll('.btn-edit-kategori').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            document.getElementById('modalKategoriTitle').textContent = 'Edit Kategori';
            document.getElementById('kategoriId').value = id;
            document.getElementById('inputNamaKategori').value = this.dataset.nama;
            document.getElementById('inputDeskripsiKategori').value = this.dataset.deskripsi || '';
            document.getElementById('formKategori').action = '{{ url("kategori-barang") }}/' + id;
            document.getElementById('methodKategori').value = 'PUT';
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalKategori')).show();
        });
    });

    document.getElementById('modalKategori').addEventListener('hidden.bs.modal', function() {
        document.getElementById('modalKategoriTitle').textContent = 'Tambah Kategori';
        document.getElementById('kategoriId').value = '';
        document.getElementById('inputNamaKategori').value = '';
        document.getElementById('inputDeskripsiKategori').value = '';
        document.getElementById('formKategori').action = '{{ route("kategori-barang.store") }}';
        document.getElementById('methodKategori').value = 'POST';
    });
</script>
@endpush
