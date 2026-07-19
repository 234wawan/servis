<div class="container py-4 py-sm-5" style="max-width: 640px;">
    <div class="text-center mb-4">
        <div class="d-inline-flex align-items-center gap-2 text-primary fw-semibold small px-3 py-1 rounded-pill mb-2" style="background: #dbeafe;">
            <i class="bi bi-check-circle"></i>
            Cek Status Servis
        </div>
        <h1 class="fw-bold" style="color: #0b2a3f; font-size: 2rem;">Cek Status Servis Motor</h1>
        <p class="text-secondary">Masukkan nomor antrian untuk mengecek status servis Anda</p>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3 p-sm-4">
            <form wire:submit.prevent="cari" class="d-flex flex-column flex-sm-row gap-3">
                <div class="flex-grow-1 position-relative">
                    <i class="bi bi-search position-absolute top-50 translate-middle-y text-secondary" style="left: 12px; font-size: 0.85rem;"></i>
                    <input type="text" wire:model="no_antrian" placeholder="Masukkan No. Antrian" class="form-control ps-5" autocomplete="off">
                </div>
                <button type="submit" class="btn text-white border-0 fw-semibold px-4 d-inline-flex align-items-center gap-2" style="background-color: #0b2a3f;">
                    <i class="bi bi-search"></i>
                    Cari
                </button>
            </form>
            <small class="text-secondary mt-2 d-block">Contoh: SRV-20260704-001</small>
        </div>
    </div>

    @if ($searched)
        @if ($servis)
            @php
                $statusMap = [
                    'pending' => ['label' => 'Menunggu', 'class' => 'bg-warning-subtle text-warning-emphasis border-warning-subtle', 'dot' => 'bg-warning'],
                    'proses'  => ['label' => 'Diproses',  'class' => 'bg-info-subtle text-info-emphasis border-info-subtle', 'dot' => 'bg-info'],
                    'selesai' => ['label' => 'Selesai',   'class' => 'bg-success-subtle text-success-emphasis border-success-subtle', 'dot' => 'bg-success'],
                    'diambil' => ['label' => 'Diambil',   'class' => 'bg-secondary-subtle text-secondary-emphasis border-secondary-subtle', 'dot' => 'bg-secondary'],
                ];
                $sts = $statusMap[$servis->status] ?? ['label' => 'Unknown', 'class' => 'bg-light text-secondary border-light', 'dot' => 'bg-secondary'];
            @endphp

            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header border-0 px-4 py-3" style="background-color: #0f2a44;">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                        <div>
                            <small class="text-info-emphasis" style="color: #93c5fd !important;">Nomor Antrian</small>
                            <h4 class="text-white fw-bold mb-0" style="word-break: break-all;">{{ $servis->no_antrian }}</h4>
                        </div>
                        <span class="badge d-inline-flex align-items-center gap-1 px-3 py-2 fw-semibold border {{ $sts['class'] }}">
                            <span class="rounded-circle d-inline-block {{ $sts['dot'] }}" style="width: 6px; height: 6px;"></span>
                            {{ $sts['label'] }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-3 p-sm-4">
                    {{-- Info Grid --}}
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <div class="p-3 rounded-3 border" style="background: #f8fafc; border-color: #f1f5f9 !important;">
                                <small class="text-secondary text-uppercase d-block mb-0" style="font-size: 0.65rem; letter-spacing: 0.05em;">Pelanggan</small>
                                <span class="fw-semibold small">{{ $servis->kendaraan?->pelanggan?->nama ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3 border" style="background: #f8fafc; border-color: #f1f5f9 !important;">
                                <small class="text-secondary text-uppercase d-block mb-0" style="font-size: 0.65rem; letter-spacing: 0.05em;">WhatsApp</small>
                                <span class="fw-semibold small">{{ $servis->kendaraan?->pelanggan?->no_wa ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3 border" style="background: #f8fafc; border-color: #f1f5f9 !important;">
                                <small class="text-secondary text-uppercase d-block mb-0" style="font-size: 0.65rem; letter-spacing: 0.05em;">Motor</small>
                                <span class="fw-semibold small">{{ $servis->kendaraan?->no_polisi ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3 border" style="background: #f8fafc; border-color: #f1f5f9 !important;">
                                <small class="text-secondary text-uppercase d-block mb-0" style="font-size: 0.65rem; letter-spacing: 0.05em;">Merek / Model</small>
                                <span class="fw-semibold small">{{ $servis->kendaraan?->merek ?? '-' }} {{ $servis->kendaraan?->model ?? '' }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3 border" style="background: #f8fafc; border-color: #f1f5f9 !important;">
                                <small class="text-secondary text-uppercase d-block mb-0" style="font-size: 0.65rem; letter-spacing: 0.05em;">Tgl Masuk</small>
                                <span class="fw-semibold small">{{ \Carbon\Carbon::parse($servis->tgl_masuk)->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3 border" style="background: #f8fafc; border-color: #f1f5f9 !important;">
                                <small class="text-secondary text-uppercase d-block mb-0" style="font-size: 0.65rem; letter-spacing: 0.05em;">Tgl Selesai</small>
                                <span class="fw-semibold small">{{ $servis->tgl_selesai ? \Carbon\Carbon::parse($servis->tgl_selesai)->format('d/m/Y') : '-' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Keluhan --}}
                    <div class="p-3 rounded-3 border mb-3" style="background: #f8fafc; border-color: #f1f5f9 !important;">
                        <small class="text-secondary text-uppercase d-block mb-1" style="font-size: 0.65rem; letter-spacing: 0.05em;">Keluhan</small>
                        <span class="small">{{ $servis->keluhan }}</span>
                    </div>

                    {{-- Paket Servis --}}
                    @if ($servis->masterServis)
                        <div class="p-3 rounded-3 border mb-3" style="background: #f8fafc; border-color: #f1f5f9 !important;">
                            <small class="text-secondary text-uppercase d-block mb-1" style="font-size: 0.65rem; letter-spacing: 0.05em;">Paket Servis</small>
                            <span class="fw-semibold small">{{ $servis->masterServis->nama_paket }}</span>
                        </div>
                    @endif

                    {{-- Spareparts --}}
                    @if ($servis->spareparts->isNotEmpty())
                        <div class="p-3 rounded-3 border mb-3" style="background: #f8fafc; border-color: #f1f5f9 !important;">
                            <small class="text-secondary text-uppercase d-block mb-2" style="font-size: 0.65rem; letter-spacing: 0.05em;">Sparepart Digunakan</small>
                            @foreach ($servis->spareparts as $sp)
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-secondary">{{ $sp->nama_sparepart }} <small class="text-muted">x{{ $sp->pivot->qty }}</small></span>
                                    <span class="fw-semibold">Rp{{ number_format($sp->pivot->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Total --}}
                    @if ($servis->total_bayar > 0)
                        <div class="p-3 rounded-3 d-flex justify-content-between align-items-center mb-3" style="background: #dbeafe; border: 1px solid #bfdbfe;">
                            <small class="text-secondary text-uppercase fw-medium" style="font-size: 0.65rem; letter-spacing: 0.05em;">Total Biaya</small>
                            <span class="fs-5 fw-bold text-primary">Rp{{ number_format($servis->total_bayar, 0, ',', '.') }}</span>
                        </div>
                        @if ($servis->metode_pembayaran)
                            <div class="d-flex justify-content-between small mb-3">
                                <small class="text-secondary text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.05em;">Pembayaran</small>
                                <span class="fw-semibold">{{ ucfirst($servis->metode_pembayaran) }}</span>
                            </div>
                        @endif
                    @endif

                    {{-- Progress Stepper --}}
                    <div class="mt-3">
                        <small class="text-secondary text-uppercase d-block mb-3" style="font-size: 0.65rem; letter-spacing: 0.05em;">Status Progress</small>
                        @php
                            $steps = ['pending' => 0, 'proses' => 1, 'selesai' => 2, 'diambil' => 3];
                            $current = $steps[$servis->status] ?? 0;
                            $labels = ['Diterima', 'Diproses', 'Selesai', 'Diambil'];
                        @endphp
                        <div class="d-flex align-items-center">
                            @foreach ($labels as $i => $label)
                                <div class="flex-grow-1 text-center" style="min-width: 0;">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold mx-auto mb-1" style="width: 32px; height: 32px; {{ $i <= $current ? 'background: #2563eb; color: white;' : 'background: #e2e8f0; color: #94a3b8;' }} font-size: 0.8rem;">
                                        @if ($i < $current)
                                            <i class="bi bi-check" style="font-size: 0.9rem;"></i>
                                        @else
                                            {{ $i + 1 }}
                                        @endif
                                    </div>
                                    <small class="d-block text-truncate px-1" style="font-size: 0.65rem; {{ $i <= $current ? 'color: #2563eb; font-weight: 500;' : 'color: #94a3b8;' }}">{{ $label }}</small>
                                </div>
                                @if ($i < count($labels) - 1)
                                    <div class="flex-grow-1 rounded-pill mx-1" style="height: 4px; {{ $i < $current ? 'background: #2563eb;' : 'background: #e2e8f0;' }}"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    @if ($servis->status === 'pending' || $servis->status === 'proses')
                        <div class="text-center mt-3">
                            <small class="text-secondary">Butuh bantuan? <a href="https://wa.me/" class="fw-semibold text-decoration-none" style="color: #2563eb;">Hubungi kami via WhatsApp</a></small>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4 p-sm-5">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3" style="width: 56px; height: 56px; background: #fef2f2; border: 1px solid #fecaca;">
                        <i class="bi bi-x-lg text-danger" style="font-size: 1.3rem;"></i>
                    </div>
                    <h5 class="fw-semibold mb-1">Servis Tidak Ditemukan</h5>
                    <p class="text-secondary small mb-4">Nomor antrian <strong>{{ $no_antrian }}</strong> tidak ditemukan.</p>
                    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                        <button wire:click="$set('no_antrian', '')" class="btn btn-sm btn-link text-decoration-none fw-medium">Coba lagi</button>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('chatPanel').classList.remove('d-none')" class="btn btn-sm text-white border-0 d-inline-flex align-items-center gap-2 fw-semibold" style="background-color: #0b2a3f;">
                            <i class="bi bi-chat-dots"></i>
                            Daftar Servis Baru
                        </a>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
