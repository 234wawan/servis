@extends('layouts.app')

@section('title', 'Fitur Layanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Fitur Layanan</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm" onclick="openCreate()">
        + Tambah Fitur
    </button>
</div>

<div class="card">
    <div class="card-body">
        <table id="tableFitur" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Icon</th>
                    <th>Badge</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fiturs as $fitur)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><i class="bi {{ $fitur->icon }}" style="font-size:1.2rem;"></i></td>
                        <td>{{ $fitur->badge }}</td>
                        <td>{{ $fitur->judul }}</td>
                        <td>{{ Str::limit($fitur->deskripsi, 50) }}</td>
                        <td>{{ $fitur->urutan }}</td>
                        <td>
                            <form action="{{ route('admin.konten.fitur.toggle', $fitur) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $fitur->is_active ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $fitur->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning btn-edit"
                                data-id="{{ $fitur->id }}"
                                data-icon="{{ $fitur->icon }}"
                                data-badge="{{ $fitur->badge }}"
                                data-judul="{{ $fitur->judul }}"
                                data-deskripsi="{{ $fitur->deskripsi }}"
                                data-urutan="{{ $fitur->urutan }}">
                                Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-danger btn-hapus"
                                data-id="{{ $fitur->id }}"
                                data-judul="{{ $fitur->judul }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada fitur layanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Form --}}
<div class="modal fade" id="modalForm" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormTitle">Tambah Fitur Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formFitur" action="{{ route('admin.konten.fitur.store') }}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <input type="hidden" id="fiturId" name="fiturId">
                    <div class="mb-3">
                        <label class="form-label">Icon Bootstrap</label>
                        <input type="text" id="inputIcon" name="icon" class="form-control" placeholder="bi bi-lightning-charge" required>
                        <small class="text-muted">Gunakan class icon Bootstrap, cth: bi bi-lightning-charge</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Badge</label>
                        <input type="text" id="inputBadge" name="badge" class="form-control" placeholder="5 Tahun" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" id="inputJudul" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea id="inputDeskripsi" name="deskripsi" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Urutan</label>
                        <input type="number" id="inputUrutan" name="urutan" class="form-control" value="0" min="0" required>
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

{{-- Modal Hapus --}}
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Fitur Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus fitur <strong id="hapusJudul"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="formHapus" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        var t = document.getElementById('tableFitur');
        if (t) new DataTable(t, {
            columnDefs: [
                { targets: 0, data: 0 },
                { targets: 1, data: 1, orderable: false },
                { targets: 2, data: 2 },
                { targets: 3, data: 3 },
                { targets: 4, data: 4 },
                { targets: 5, data: 5 },
                { targets: 6, data: 6, orderable: false },
                { targets: 7, data: 7, orderable: false }
            ]
        });
    });

    function openCreate() {
        document.getElementById('modalFormTitle').textContent = 'Tambah Fitur Layanan';
        document.getElementById('fiturId').value = '';
        document.getElementById('inputIcon').value = '';
        document.getElementById('inputBadge').value = '';
        document.getElementById('inputJudul').value = '';
        document.getElementById('inputDeskripsi').value = '';
        document.getElementById('inputUrutan').value = '0';
        document.getElementById('formFitur').action = '{{ route("admin.konten.fitur.store") }}';
        document.getElementById('formFitur').querySelector('input[name="_method"]').value = 'POST';
    }

    document.querySelectorAll('.btn-edit').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('modalFormTitle').textContent = 'Edit Fitur Layanan';
            document.getElementById('fiturId').value = this.dataset.id;
            document.getElementById('inputIcon').value = this.dataset.icon;
            document.getElementById('inputBadge').value = this.dataset.badge;
            document.getElementById('inputJudul').value = this.dataset.judul;
            document.getElementById('inputDeskripsi').value = this.dataset.deskripsi;
            document.getElementById('inputUrutan').value = this.dataset.urutan;
            document.getElementById('formFitur').action = '{{ url("admin/konten/fitur-layanan") }}/' + this.dataset.id;
            document.getElementById('formFitur').querySelector('input[name="_method"]').value = 'PUT';
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalForm')).show();
        });
    });

    document.querySelectorAll('.btn-hapus').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('hapusJudul').textContent = this.dataset.judul;
            document.getElementById('formHapus').action = '{{ url("admin/konten/fitur-layanan") }}/' + this.dataset.id;
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalHapus')).show();
        });
    });
</script>
@endpush
