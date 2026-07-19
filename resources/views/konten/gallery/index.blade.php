@extends('layouts.app')

@section('title', 'Galeri Foto')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Galeri Foto</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm" onclick="openCreate()">
        + Tambah Foto
    </button>
</div>

<div class="row g-3">
    @forelse ($galleries as $gallery)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm">
                <div class="ratio ratio-4x3" style="background:#e2e8f0;">
                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->judul ?? 'Galeri' }}" class="card-img-top" style="object-fit:cover;">
                </div>
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted text-truncate">{{ $gallery->judul ?? 'Tanpa Judul' }}</small>
                        <form action="{{ route('admin.konten.gallery.toggle', $gallery) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $gallery->is_active ? 'btn-success' : 'btn-secondary' }} px-2">
                                {{ $gallery->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </div>
                    <div class="mt-2 d-flex gap-1">
                        <button type="button" class="btn btn-sm btn-warning btn-edit flex-grow-1"
                            data-id="{{ $gallery->id }}"
                            data-judul="{{ $gallery->judul }}"
                            data-urutan="{{ $gallery->urutan }}">
                            Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger btn-hapus"
                            data-id="{{ $gallery->id }}"
                            data-judul="{{ $gallery->judul ?? 'Foto ini' }}">
                            Hapus
                        </button>
                    </div>
                    <small class="text-muted d-block mt-1">Urutan: {{ $gallery->urutan }}</small>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-image text-secondary" style="font-size:3rem;"></i>
                    <p class="text-muted mt-2">Belum ada foto galeri.</p>
                </div>
            </div>
        </div>
    @endforelse
</div>

{{-- Modal Form --}}
<div class="modal fade" id="modalForm" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormTitle">Tambah Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formGallery" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="galleryId" name="galleryId">
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" id="inputImage" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Format: jpg, jpeg, png, webp. Maks: 2MB</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Judul <small class="text-muted">Opsional</small></label>
                        <input type="text" id="inputJudul" name="judul" class="form-control">
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
                <h5 class="modal-title">Hapus Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus <strong id="hapusJudul"></strong>?</p>
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
    function openCreate() {
        document.getElementById('modalFormTitle').textContent = 'Tambah Foto';
        document.getElementById('galleryId').value = '';
        document.getElementById('inputImage').required = true;
        document.getElementById('inputJudul').value = '';
        document.getElementById('inputUrutan').value = '0';
        document.getElementById('formGallery').action = '{{ route("admin.konten.gallery.store") }}';
        document.getElementById('formGallery').querySelector('input[name="_method"]')?.remove();
    }

    document.querySelectorAll('.btn-edit').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('modalFormTitle').textContent = 'Edit Foto';
            document.getElementById('galleryId').value = this.dataset.id;
            document.getElementById('inputImage').required = false;
            document.getElementById('inputJudul').value = this.dataset.judul;
            document.getElementById('inputUrutan').value = this.dataset.urutan;
            const form = document.getElementById('formGallery');
            form.action = '{{ url("admin/konten/gallery") }}/' + this.dataset.id;
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                form.appendChild(methodInput);
            }
            methodInput.value = 'POST';
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalForm')).show();
        });
    });

    document.querySelectorAll('.btn-hapus').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('hapusJudul').textContent = this.dataset.judul;
            document.getElementById('formHapus').action = '{{ url("admin/konten/gallery") }}/' + this.dataset.id;
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalHapus')).show();
        });
    });
</script>
@endpush
