@extends('layouts.app')

@section('title', 'Checkout Servis')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <i class="bi bi-cash-coin fs-2 text-success"></i>
    <h1 class="mb-0">Checkout / Pembayaran</h1>
</div>

<div class="row g-3">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.servis.bayar', $servis) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Informasi Servis</label>
                        <table class="table table-bordered">
                            <tr>
                                <td class="text-muted" style="width: 120px;">No. Antrian</td>
                                <td class="fw-bold">{{ $servis->no_antrian ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Kendaraan</td>
                                <td>{{ $servis->kendaraan->no_polisi ?? '-' }} ({{ $servis->kendaraan->merek ?? '' }} {{ $servis->kendaraan->model ?? '' }})</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Pemilik</td>
                                <td>{{ $servis->kendaraan->pelanggan->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Keluhan</td>
                                <td>{{ $servis->keluhan }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Biaya Servis (Rp)</label>
                        <input type="text" name="biaya" id="biaya" class="form-control form-control-lg @error('biaya') is-invalid @enderror"
                            value="{{ number_format($servis->biaya, 0, ',', '.') }}" inputmode="numeric" required
                            onkeyup="hitungTotal()">
                        @error('biaya')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Tipe Diskon</label>
                            <select name="tipe_diskon" id="tipe_diskon" class="form-select" onchange="hitungTotal()">
                                <option value="">Tidak Ada</option>
                                <option value="nominal">Nominal (Rp)</option>
                                <option value="persen">Persen (%)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Diskon</label>
                            <input type="text" name="diskon" id="diskon" class="form-control"
                                value="0" inputmode="numeric" onkeyup="hitungTotal()">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Total Bayar</label>
                            <h2 class="text-success fw-bold" id="totalBayarDisplay">Rp {{ number_format($servis->biaya, 0, ',', '.') }}</h2>
                            <input type="hidden" name="total_bayar" id="totalBayarInput" value="{{ $servis->biaya }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Metode Pembayaran <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" value="tunai" id="bayarTunai" required>
                                <label class="form-check-label" for="bayarTunai">
                                    <i class="bi bi-cash"></i> Tunai
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" value="transfer" id="bayarTransfer">
                                <label class="form-check-label" for="bayarTransfer">
                                    <i class="bi bi-bank"></i> Transfer
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" value="qris" id="bayarQris">
                                <label class="form-check-label" for="bayarQris">
                                    <i class="bi bi-qr-code"></i> QRIS
                                </label>
                            </div>
                        </div>
                        @error('metode_pembayaran')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    </div>

                    <hr>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success btn-lg" onclick="this.form.biaya.value=unformatRupiah(this.form.biaya.value);this.form.diskon.value=unformatRupiah(this.form.diskon.value)">
                            <i class="bi bi-check-lg"></i> Proses Pembayaran
                        </button>
                        <a href="{{ route('admin.servis.index') }}" class="btn btn-secondary btn-lg">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="bi bi-info-circle"></i> Ringkasan</h5>
                <table class="table table-sm">
                    <tr>
                        <td>Biaya Jasa</td>
                        <td class="text-end" id="ringkasanBiaya">Rp {{ number_format($servis->biaya, 0, ',', '.') }}</td>
                    </tr>
                    @if ($servis->spareparts->isNotEmpty())
                    <tr>
                        <td colspan="2" class="fw-semibold">Sparepart:</td>
                    </tr>
                    @foreach ($servis->spareparts as $sp)
                    <tr>
                        <td class="ps-4">{{ $sp->nama_sparepart }} x{{ $sp->pivot->qty }}</td>
                        <td class="text-end">Rp {{ number_format($sp->pivot->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>Total Sparepart</td>
                        <td class="text-end" id="ringkasanSparepart">Rp {{ number_format($servis->spareparts->sum(fn($s) => $s->pivot->subtotal), 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Diskon</td>
                        <td class="text-end text-danger" id="ringkasanDiskon">Rp 0</td>
                    </tr>
                    <tr class="fw-bold">
                        <td>Total Bayar</td>
                        <td class="text-end text-success fs-5" id="ringkasanTotal">Rp {{ number_format($servis->biaya + $servis->spareparts->sum(fn($s) => $s->pivot->subtotal), 0, ',', '.') }}</td>
                    </tr>
                </table>

                @if ($servis->kendaraan->pelanggan->no_wa)
                    <div class="alert alert-info py-2">
                        <i class="bi bi-whatsapp"></i> WA: {{ $servis->kendaraan->pelanggan->no_wa }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function formatRupiah(v) {
        return v.replace(/[^\d]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    function unformatRupiah(v) {
        return v.replace(/\./g, '');
    }

    const sparepartSubtotal = {{ $servis->spareparts->sum(fn($s) => $s->pivot->subtotal) }};

    function hitungTotal() {
        const biaya = parseFloat(unformatRupiah(document.getElementById('biaya').value)) || 0;
        const tipeDiskon = document.getElementById('tipe_diskon').value;
        let diskon = parseFloat(unformatRupiah(document.getElementById('diskon').value)) || 0;
        let diskonRupiah = 0;
        const totalSebelumDiskon = biaya + sparepartSubtotal;

        if (tipeDiskon === 'persen') {
            diskonRupiah = totalSebelumDiskon * (diskon / 100);
        } else if (tipeDiskon === 'nominal') {
            diskonRupiah = diskon;
        }

        const total = Math.max(0, totalSebelumDiskon - diskonRupiah);

        document.getElementById('totalBayarDisplay').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        document.getElementById('totalBayarInput').value = total;
        document.getElementById('ringkasanBiaya').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(biaya);
        document.getElementById('ringkasanDiskon').textContent = '- Rp ' + new Intl.NumberFormat('id-ID').format(diskonRupiah);
        document.getElementById('ringkasanTotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }
</script>
@endpush
