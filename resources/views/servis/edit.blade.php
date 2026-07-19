@extends('layouts.app')

@section('title', 'Edit Servis')

@section('content')
<h1>Edit Servis</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.servis.update', $servis) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kendaraan</label>
                    <select name="kendaraan_id" class="form-select @error('kendaraan_id') is-invalid @enderror" required>
                        @foreach ($kendaraans as $k)
                            <option value="{{ $k->id }}" {{ old('kendaraan_id', $servis->kendaraan_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->no_polisi }} - {{ $k->merek }} {{ $k->model }} ({{ $k->pelanggan->nama ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                    @error('kendaraan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tipe Barang</label>
                    <select name="tipe_barang" class="form-select @error('tipe_barang') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="motor" {{ old('tipe_barang', $servis->tipe_barang) === 'motor' ? 'selected' : '' }}>Motor</option>
                        <option value="mobil" {{ old('tipe_barang', $servis->tipe_barang) === 'mobil' ? 'selected' : '' }}>Mobil</option>
                        <option value="lainnya" {{ old('tipe_barang', $servis->tipe_barang) === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('tipe_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="pending" {{ old('status', $servis->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="proses" {{ old('status', $servis->status) == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ old('status', $servis->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="diambil" {{ old('status', $servis->status) == 'diambil' ? 'selected' : '' }}>Diambil</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Keluhan</label>
                <textarea name="keluhan" class="form-control @error('keluhan') is-invalid @enderror"
                    rows="3" required>{{ old('keluhan', $servis->keluhan) }}</textarea>
                @error('keluhan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Kelengkapan</label>
                <textarea name="kelengkapan" class="form-control @error('kelengkapan') is-invalid @enderror"
                    rows="2">{{ old('kelengkapan', $servis->kelengkapan) }}</textarea>
                @error('kelengkapan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror"
                    rows="2">{{ old('catatan', $servis->catatan) }}</textarea>
                @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Paket Servis</label>
                <div class="input-group">
                    <select id="paket_servis" class="form-select">
                        <option value="" data-biaya="0">-- Pilih Paket (opsional) --</option>
                        @foreach ($masterServis as $paket)
                            <option value="{{ $paket->id }}"
                                data-biaya="{{ $paket->biaya }}"
                                data-keterangan="{{ $paket->keterangan }}"
                                {{ $servis->master_servis_id == $paket->id ? 'selected' : '' }}>
                                {{ $paket->nama_paket }} — Rp {{ number_format($paket->biaya, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalPaket">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
                <div id="paketInfo" class="form-text mt-1"></div>
                <input type="hidden" name="paket_biaya" id="paket_biaya" value="0">
                <input type="hidden" name="master_servis_id" id="master_servis_id" value="">
            </div>

            <div class="card border-primary mb-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-box-seam"></i> Sparepart Digunakan</span>
                    <button type="button" class="btn btn-sm btn-light" onclick="tambahSparepart()">
                        <i class="bi bi-plus-lg"></i> Tambah
                    </button>
                </div>
                <div class="card-body" id="sparepartContainer">
                    @forelse ($servis->spareparts as $sp)
                    <div class="row g-2 mb-2 sparepart-row">
                        <div class="col-md-6">
                            <select name="spareparts[{{ $loop->index }}][id]" class="form-select form-select-sm sparepart-select" required>
                                <option value="">-- Pilih Sparepart --</option>
                                @foreach ($spareparts as $opt)
                                    <option value="{{ $opt->id }}" data-harga="{{ $opt->harga_jual }}" data-stok="{{ $opt->stok }}"
                                        {{ $sp->id == $opt->id ? 'selected' : '' }}>
                                        {{ $opt->nama_sparepart }} ({{ $opt->kategori->nama_kategori ?? '-' }}) — Stok: {{ $opt->stok }} — Rp {{ number_format($opt->harga_jual, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="spareparts[{{ $loop->index }}][qty]" class="form-control form-control-sm sparepart-qty"
                                value="{{ $sp->pivot->qty }}" min="1" required oninput="hitungTotalSparepart()">
                        </div>
                        <div class="col-md-3">
                            <span class="sparepart-subtotal d-inline-block mt-2">Rp {{ number_format($sp->pivot->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="col-md-1 d-flex align-items-center">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapusSparepart(this)">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted mb-0" id="sparepartEmpty">Belum ada sparepart dipilih.</p>
                    @endforelse
                </div>
                <div class="card-footer text-end">
                    <strong>Subtotal Sparepart:</strong> <span id="sparepartSubtotal">Rp {{ number_format($servis->spareparts->sum(fn($s) => $s->pivot->subtotal), 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Biaya Jasa Tambahan (Rp) <span class="text-danger">*</span></label>
                    <input type="text" name="biaya" id="biaya" class="form-control @error('biaya') is-invalid @enderror"
                        value="{{ old('biaya') ? number_format(old('biaya'), 0, ',', '.') : number_format($servis->biaya, 0, ',', '.') }}" inputmode="numeric" required
                        onkeyup="this.value=formatRupiah(this.value); hitungTotalBiaya();">
                    <div class="form-text">Biaya jasa (sudah termasuk paket jika ada)</div>
                    @error('biaya')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Total Biaya</label>
                    <h3 id="totalBiayaDisplay">Rp {{ number_format($servis->biaya + optional($servis->spareparts)->sum(fn($s) => $s->pivot->subtotal) ?? 0, 0, ',', '.') }}</h3>
                    <input type="hidden" id="totalBiayaHidden" value="{{ $servis->biaya + optional($servis->spareparts)->sum(fn($s) => $s->pivot->subtotal) ?? 0 }}">
                    <div class="form-text" id="totalRincian"></div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tgl Selesai</label>
                    <input type="date" name="tgl_selesai" class="form-control @error('tgl_selesai') is-invalid @enderror"
                        value="{{ old('tgl_selesai', $servis->tgl_selesai) }}">
                    @error('tgl_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <input type="hidden" name="paket_biaya" id="paket_biaya" value="0">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.servis.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection

<div class="modal fade" id="modalPaket" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Paket Servis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formPaket">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Paket</label>
                        <input type="text" id="inputNamaPaket" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea id="inputKeterangan" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biaya (Rp)</label>
                        <input type="text" id="inputBiayaPaket" class="form-control" inputmode="numeric"
                            onkeyup="this.value=formatRupiah(this.value)" required>
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

<template id="templateSparepart">
    <div class="row g-2 mb-2 sparepart-row">
        <div class="col-md-6">
            <select name="spareparts[__INDEX__][id]" class="form-select form-select-sm sparepart-select" required>
                <option value="">-- Pilih Sparepart --</option>
                @foreach ($spareparts as $sp)
                    <option value="{{ $sp->id }}" data-harga="{{ $sp->harga_jual }}" data-stok="{{ $sp->stok }}">
                        {{ $sp->nama_sparepart }} ({{ $sp->kategori->nama_kategori ?? '-' }}) — Stok: {{ $sp->stok }} — Rp {{ number_format($sp->harga_jual, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="spareparts[__INDEX__][qty]" class="form-control form-control-sm sparepart-qty"
                value="1" min="1" required oninput="hitungTotalSparepart()">
        </div>
        <div class="col-md-3">
            <span class="sparepart-subtotal d-inline-block mt-2">Rp 0</span>
        </div>
        <div class="col-md-1 d-flex align-items-center">
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapusSparepart(this)">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>
</template>

@push('scripts')
<script>
    let sparepartIndex = {{ $servis->spareparts->count() }};

    function formatRupiah(v) {
        return v.replace(/[^\d]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    function unformatRupiah(v) {
        return v.replace(/\./g, '');
    }

    function tambahSparepart(selectedId, qty) {
        const template = document.getElementById('templateSparepart');
        const clone = template.content.cloneNode(true);
        const row = clone.querySelector('.sparepart-row');
        row.querySelectorAll('[name*="__INDEX__"]').forEach(el => {
            el.name = el.name.replace('__INDEX__', sparepartIndex);
        });

        const container = document.getElementById('sparepartContainer');
        const empty = document.getElementById('sparepartEmpty');
        if (empty) empty.remove();

        const select = row.querySelector('.sparepart-select');
        select.addEventListener('change', function() { hitungTotalSparepart(); });

        const qtyInput = row.querySelector('.sparepart-qty');
        qtyInput.addEventListener('input', function() { hitungTotalSparepart(); });

        if (selectedId) select.value = selectedId;
        if (qty) qtyInput.value = qty;

        container.appendChild(row);
        sparepartIndex++;
        hitungTotalSparepart();
    }

    function hapusSparepart(btn) {
        btn.closest('.sparepart-row').remove();
        hitungTotalSparepart();
        const container = document.getElementById('sparepartContainer');
        if (!container.querySelector('.sparepart-row')) {
            container.innerHTML = '<p class="text-muted mb-0" id="sparepartEmpty">Belum ada sparepart dipilih.</p>';
        }
    }

    function hitungTotalSparepart() {
        let total = 0;
        document.querySelectorAll('.sparepart-row').forEach(row => {
            const select = row.querySelector('.sparepart-select');
            const qty = parseInt(row.querySelector('.sparepart-qty').value) || 1;
            const opt = select.options[select.selectedIndex];
            const harga = opt ? parseFloat(opt.getAttribute('data-harga')) || 0 : 0;
            const subtotal = qty * harga;
            total += subtotal;
            row.querySelector('.sparepart-subtotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
        });
        document.getElementById('sparepartSubtotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        hitungTotalBiaya();
    }

    function hitungTotalBiaya() {
        const paketBiaya = parseFloat(document.getElementById('paket_biaya').value) || 0;
        const biayaJasa = parseFloat(unformatRupiah(document.getElementById('biaya').value)) || 0;
        let sparepartTotal = 0;
        document.querySelectorAll('.sparepart-row').forEach(row => {
            const select = row.querySelector('.sparepart-select');
            const qty = parseInt(row.querySelector('.sparepart-qty').value) || 1;
            const opt = select.options[select.selectedIndex];
            const harga = opt ? parseFloat(opt.getAttribute('data-harga')) || 0 : 0;
            sparepartTotal += qty * harga;
        });
        const total = paketBiaya + biayaJasa + sparepartTotal;
        document.getElementById('totalBiayaDisplay').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        document.getElementById('totalBiayaHidden').value = total;

        const parts = [];
        if (paketBiaya > 0) parts.push('Paket: Rp ' + new Intl.NumberFormat('id-ID').format(paketBiaya));
        if (biayaJasa > 0) parts.push('Jasa: Rp ' + new Intl.NumberFormat('id-ID').format(biayaJasa));
        if (sparepartTotal > 0) parts.push('Sparepart: Rp ' + new Intl.NumberFormat('id-ID').format(sparepartTotal));
        document.getElementById('totalRincian').textContent = parts.join(' | ');
    }

    document.querySelector('form').addEventListener('submit', function() {
        const paketBiaya = parseFloat(document.getElementById('paket_biaya').value) || 0;
        const biayaJasa = parseFloat(unformatRupiah(document.getElementById('biaya').value)) || 0;
        document.getElementById('biaya').value = paketBiaya + biayaJasa;
    });

    document.getElementById('paket_servis').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const biaya = parseFloat(selected.getAttribute('data-biaya')) || 0;
        const keterangan = selected.getAttribute('data-keterangan');
        document.getElementById('paket_biaya').value = biaya;
        document.getElementById('master_servis_id').value = selected.value || '';

        const info = document.getElementById('paketInfo');
        if (biaya > 0) {
            info.innerHTML = 'Paket terpilih: <strong>' + selected.textContent + '</strong>';
        } else {
            info.innerHTML = '';
        }
        if (keterangan) {
            document.querySelector('textarea[name="catatan"]').value = keterangan;
        }
        hitungTotalBiaya();
    });

    document.getElementById('formPaket').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;

        fetch('{{ route("master-servis.quick") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({
                nama_paket: document.getElementById('inputNamaPaket').value,
                keterangan: document.getElementById('inputKeterangan').value,
                biaya: unformatRupiah(document.getElementById('inputBiayaPaket').value),
            })
        })
        .then(r => r.json())
        .then(data => {
            const select = document.getElementById('paket_servis');
            const opt = document.createElement('option');
            opt.value = data.id;
            opt.setAttribute('data-biaya', data.biaya);
            opt.setAttribute('data-keterangan', data.keterangan || '');
            opt.textContent = data.nama_paket + ' — Rp ' + new Intl.NumberFormat('id-ID').format(data.biaya);
            select.appendChild(opt);
            select.value = data.id;
            select.dispatchEvent(new Event('change'));

            document.getElementById('inputNamaPaket').value = '';
            document.getElementById('inputKeterangan').value = '';
            document.getElementById('inputBiayaPaket').value = '';
            bootstrap.Modal.getInstance(document.getElementById('modalPaket')).hide();
        })
        .catch(() => alert('Gagal menyimpan paket'))
        .finally(() => btn.disabled = false);
    });

    // Init paket info if paket already selected
    if (document.getElementById('paket_servis').value) {
        document.getElementById('paket_servis').dispatchEvent(new Event('change'));
    }

    hitungTotalBiaya();
</script>
@endpush
