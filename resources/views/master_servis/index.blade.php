@extends('layouts.app')

@section('title', 'Daftar Paket Servis')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Daftar Paket Servis</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm" onclick="openCreate()">
        + Tambah Paket
    </button>
</div>

<div class="card">
    <div class="card-body">
        <table id="tablePaket" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Paket</th>
                    <th>Keterangan</th>
                    <th>Biaya</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($masterServis as $paket)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $paket->nama_paket }}</td>
                        <td>{{ $paket->keterangan ?? '-' }}</td>
                        <td>Rp {{ number_format($paket->biaya, 0, ',', '.') }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning btn-edit"
                                data-id="{{ $paket->id }}"
                                data-nama="{{ $paket->nama_paket }}"
                                data-keterangan="{{ $paket->keterangan }}"
                                data-biaya="{{ $paket->biaya }}">
                                Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-danger btn-hapus"
                                data-id="{{ $paket->id }}"
                                data-nama="{{ $paket->nama_paket }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada paket servis.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Form (Create / Edit) --}}
<div class="modal fade" id="modalForm" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormTitle">Tambah Paket Servis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formPaket">
                <div class="modal-body">
                    <input type="hidden" id="paketId">
                    <div class="mb-3">
                        <label class="form-label">Nama Paket</label>
                        <input type="text" id="inputNamaPaket" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea id="inputKeterangan" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biaya (Rp)</label>
                        <input type="text" id="inputBiayaPaket" class="form-control" inputmode="numeric" required
                            onkeyup="this.value=formatRupiah(this.value)">
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
                <h5 class="modal-title">Hapus Paket Servis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus paket <strong id="hapusNamaPaket"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="btnConfirmHapus">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        var t = document.getElementById('tablePaket');
        if (t) new DataTable(t, {
            columnDefs: [
                { targets: 0, data: 0 },
                { targets: 1, data: 1 },
                { targets: 2, data: 2 },
                { targets: 3, data: 3 },
                { targets: 4, data: 4, orderable: false }
            ]
        });
    });

    function formatRupiah(v) {
        return v.replace(/[^\d]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    function unformatRupiah(v) {
        return v.replace(/\./g, '');
    }

    function openCreate() {
        document.getElementById('modalFormTitle').textContent = 'Tambah Paket Servis';
        document.getElementById('paketId').value = '';
        document.getElementById('inputNamaPaket').value = '';
        document.getElementById('inputKeterangan').value = '';
        document.getElementById('inputBiayaPaket').value = '';
    }

    document.querySelectorAll('.btn-edit').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('modalFormTitle').textContent = 'Edit Paket Servis';
            document.getElementById('paketId').value = this.dataset.id;
            document.getElementById('inputNamaPaket').value = this.dataset.nama;
            document.getElementById('inputKeterangan').value = this.dataset.keterangan || '';
            document.getElementById('inputBiayaPaket').value = formatRupiah(this.dataset.biaya);
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalForm')).show();
        });
    });

    let hapusId = null;
    document.querySelectorAll('.btn-hapus').forEach(function(btn) {
        btn.addEventListener('click', function() {
            hapusId = this.dataset.id;
            document.getElementById('hapusNamaPaket').textContent = this.dataset.nama;
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalHapus')).show();
        });
    });

    document.getElementById('formPaket').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('paketId').value;
        const url = id ? '{{ url("master-servis") }}/' + id : '{{ route("master-servis.store") }}';
        const method = id ? 'PUT' : 'POST';
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;

        fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: JSON.stringify({
                nama_paket: document.getElementById('inputNamaPaket').value,
                keterangan: document.getElementById('inputKeterangan').value,
                biaya: unformatRupiah(document.getElementById('inputBiayaPaket').value),
            })
        })
        .then(r => {
            if (!r.ok) throw new Error('Gagal');
            return r.json();
        })
        .then(() => location.reload())
        .catch(() => alert('Gagal menyimpan paket'))
        .finally(() => btn.disabled = false);
    });

    document.getElementById('btnConfirmHapus').addEventListener('click', function() {
        if (!hapusId) return;
        const btn = this;
        btn.disabled = true;

        fetch('{{ url("master-servis") }}/' + hapusId, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        })
        .then(r => {
            if (!r.ok) throw new Error('Gagal');
            return r.json();
        })
        .then(() => location.reload())
        .catch(() => alert('Gagal menghapus paket'))
        .finally(() => {
            btn.disabled = false;
            hapusId = null;
        });
    });
</script>
@endpush
