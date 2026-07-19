@extends('layouts.app')

@section('title', 'Status Servis')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center gap-2">
        <i class="bi bi-clipboard-data fs-2 text-primary"></i>
        <h1 class="mb-0">Status Servis</h1>
    </div>
    <a href="{{ route('admin.servis.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Check-In Baru
    </a>
</div>

<div class="content-card mb-4">
    <div class="row g-2">
        <div class="col-md-2 col-4">
            <a href="{{ route('admin.servis.index') }}"
                class="btn btn-outline-secondary w-100 {{ !$statusFilter ? 'active' : '' }}">
                Semua
            </a>
        </div>
        <div class="col-md-2 col-4">
            <a href="{{ route('admin.servis.index', ['status' => 'pending']) }}"
                class="btn btn-outline-warning w-100 {{ $statusFilter === 'pending' ? 'active' : '' }}">
                ⏳ Pending
            </a>
        </div>
        <div class="col-md-2 col-4">
            <a href="{{ route('admin.servis.index', ['status' => 'proses']) }}"
                class="btn btn-outline-info w-100 {{ $statusFilter === 'proses' ? 'active' : '' }}">
                🔧 Diproses
            </a>
        </div>
        <div class="col-md-2 col-4">
            <a href="{{ route('admin.servis.index', ['status' => 'selesai']) }}"
                class="btn btn-outline-success w-100 {{ $statusFilter === 'selesai' ? 'active' : '' }}">
                ✅ Selesai
            </a>
        </div>
        <div class="col-md-2 col-4">
            <a href="{{ route('admin.servis.index', ['status' => 'diambil']) }}"
                class="btn btn-outline-primary w-100 {{ $statusFilter === 'diambil' ? 'active' : '' }}">
                📦 Diambil
            </a>
        </div>
        <div class="col-md-2 col-4">
            <a href="{{ route('admin.servis.index', ['status' => 'void']) }}"
                class="btn btn-outline-secondary w-100 {{ $statusFilter === 'void' ? 'active' : '' }}">
                🚫 Void
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="tableServis" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Antrian</th>
                    <th>Kendaraan</th>
                    <th>Pemilik</th>
                    <th>Tgl Masuk</th>
                    <th>Keluhan</th>
                    <th>Status</th>
                    <th>Sparepart</th>
                    <th>Biaya</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($servis as $item)
                    <tr class="{{ $item->is_void ? 'text-muted' : '' }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="badge bg-dark rounded-pill px-3">{{ $item->no_antrian ?? '-' }}</span>
                        </td>
                        <td>{{ $item->kendaraan->no_polisi ?? '-' }}</td>
                        <td>{{ $item->kendaraan->pelanggan->nama ?? '-' }}</td>
                        <td>{{ $item->tgl_masuk }}</td>
                        <td>{{ Str::limit($item->keluhan, 25) }}</td>
                        <td>
                            @if ($item->is_void)
                                <span class="badge bg-secondary rounded-pill px-3">Void</span>
                            @else
                                @switch($item->status)
                                    @case('pending') <span class="badge bg-warning rounded-pill px-3">Pending</span> @break
                                    @case('proses') <span class="badge bg-info rounded-pill px-3">Proses</span> @break
                                    @case('selesai') <span class="badge bg-success rounded-pill px-3">Selesai</span> @break
                                    @case('diambil') <span class="badge bg-primary rounded-pill px-3">Diambil</span> @break
                                @endswitch
                            @endif
                        </td>
                        <td>
                            @php $spCount = optional($item->spareparts)->count() ?? 0; @endphp
                            @if ($spCount > 0)
                                <span class="badge bg-info rounded-pill" title="Lihat sparepart">
                                    <i class="bi bi-box-seam"></i> {{ $spCount }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($item->total_bayar ?: $item->biaya, 0, ',', '.') }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                    Aksi
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('admin.servis.show', $item) }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.servis.nota', $item) }}" target="_blank">
                                        <i class="bi bi-receipt"></i> Nota Terima
                                    </a></li>

                                    @if (!$item->is_void)
                                        @if (auth()->user()->role !== 'kasir')
                                            <li><a class="dropdown-item" href="{{ route('admin.servis.edit', $item) }}">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a></li>
                                        @endif

                                        @if ($item->status === 'pending' && auth()->user()->role !== 'kasir')
                                            <li>
                                                <form action="{{ route('admin.servis.update-status', $item) }}" method="POST" class="d-inline update-status-form">
                                                    @csrf
                                                    <input type="hidden" name="status" value="proses">
                                                    <button class="dropdown-item" type="submit">
                                                        <i class="bi bi-arrow-right-circle"></i> Proses
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                        @if ($item->status === 'proses' && auth()->user()->role !== 'kasir')
                                            <li>
                                                <form action="{{ route('admin.servis.update-status', $item) }}" method="POST" class="d-inline update-status-form">
                                                    @csrf
                                                    <input type="hidden" name="status" value="selesai">
                                                    <button class="dropdown-item" type="submit">
                                                        <i class="bi bi-check-circle"></i> Selesai
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                        @if ($item->status === 'selesai' && !$item->metode_pembayaran)
                                            <li><a class="dropdown-item text-success fw-semibold" href="{{ route('admin.servis.checkout', $item) }}">
                                                <i class="bi bi-cash-coin"></i> Checkout / Bayar
                                            </a></li>
                                        @endif

                                        @if ($item->metode_pembayaran)
                                            <li><a class="dropdown-item" href="{{ route('admin.servis.struk', $item) }}" target="_blank">
                                                <i class="bi bi-printer"></i> Cetak Struk
                                            </a></li>
                                        @endif

                                        @if (auth()->user()->role === 'admin' && $item->status === 'pending')
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button type="button" class="dropdown-item text-secondary btn-void"
                                                    data-id="{{ $item->id }}"
                                                    data-kendaraan="{{ $item->kendaraan->no_polisi ?? '-' }}">
                                                    <i class="bi bi-x-circle"></i> Void
                                                </button>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.servis.destroy', $item) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus servis {{ $item->kendaraan->no_polisi ?? '-' }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item text-danger" type="submit" onclick="event.stopPropagation();">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">
                            <i class="bi bi-inbox fs-3 d-block text-muted mb-2"></i>
                            Tidak ada data servis.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Void --}}
<div class="modal fade" id="modalVoid" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Void Servis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formVoid" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        Batalkan servis <strong id="voidKendaraan"></strong>?
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan Void <span class="text-danger">*</span></label>
                        <textarea name="alasan_void" class="form-control" rows="3" required placeholder="Masukkan alasan pembatalan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Konfirmasi Void</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#tableServis').DataTable({
        columnDefs: [
            { targets: 0, data: 0 },
            { targets: 1, data: 1 },
            { targets: 2, data: 2 },
            { targets: 3, data: 3 },
            { targets: 4, data: 4 },
            { targets: 5, data: 5 },
            { targets: 6, data: 6 },
            { targets: 7, data: 7 },
            { targets: 8, data: 8 },
            { targets: 9, data: 9, orderable: false }
        ]
    });
});

    document.querySelectorAll('.btn-void').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('voidKendaraan').textContent = this.dataset.kendaraan;
            document.getElementById('formVoid').action = '{{ url("servis") }}/' + this.dataset.id + '/void';
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalVoid')).show();
        });
    });

    document.querySelectorAll('.update-status-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button');
            btn.disabled = true;

            fetch(this.action, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ status: this.querySelector('input[name="status"]').value })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) location.reload();
                else alert('Gagal');
            })
            .catch(() => alert('Gagal update status'))
            .finally(() => btn.disabled = false);
        });
    });
</script>
@endpush
