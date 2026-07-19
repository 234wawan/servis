@extends('layouts.customer')

@section('title', 'ServisMotor - Bengkel Motor Profesional')

@section('content')
{{-- Hero --}}
<section class="position-relative overflow-hidden" style="background-color: #0b2a3f;">
    <div class="position-absolute inset-0" style="background: linear-gradient(135deg, rgba(11,42,63,0.92), rgba(11,42,63,0.7));"></div>
    <div class="container position-relative py-5 py-sm-6">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="display-4 fw-bold text-white lh-1 mb-3">
                    Servis Motor <span class="text-info-emphasis" style="color: #93c5fd !important;">Terpercaya</span>
                </h1>
                <p class="text-white-50 fs-6 mb-4 mx-auto mx-lg-0" style="max-width: 540px;">
                    Daftarkan motor Anda untuk servis dengan mudah melalui chatbot interaktif kami. Cepat, praktis, tanpa antre panjang.
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('chatPanel').classList.remove('d-none')" class="btn btn-light btn-lg fw-bold px-5 py-3 shadow d-inline-flex align-items-center gap-2" style="color: #0b2a3f;">
                        <i class="bi bi-chat-dots"></i>
                        Daftar Servis Online
                    </a>
                    <a href="{{ route('customer.cek-status') }}" class="btn btn-outline-light btn-lg fw-semibold px-5 py-3 d-inline-flex align-items-center gap-2">
                        Cek Status Servis
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center overflow-hidden"
                 x-data="{
                    images: [
                        'https://placehold.co/400x400/0b2a3f/e2e8f0?text=Servis+Motor',
                        'https://placehold.co/400x400/1a4a6f/e2e8f0?text=Servis+Motor',
                        'https://placehold.co/400x400/0d3550/e2e8f0?text=Servis+Motor',
                    ],
                    current: 0,
                    init() { setInterval(() => { this.current = (this.current + 1) % this.images.length }, 3000) }
                 }">
                <div class="position-relative d-inline-block rounded-circle overflow-hidden border border-light" style="width: 288px; height: 288px; border-width: 4px !important; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);">
                    <template x-for="(img, i) in images" :key="i">
                        <img :src="img" alt="ServisMotor" class="hero-image position-absolute w-100 h-100" style="object-fit: cover; inset: 0;" :class="i === current ? 'opacity-100' : 'opacity-0'" style="transition: opacity 0.8s ease;">
                    </template>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Best Services (Fitur Layanan) --}}
@if ($fiturs->isNotEmpty())
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4">
            @foreach ($fiturs as $fitur)
            <div class="col-md-4 text-center">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 60px; height: 60px; background: #dbeafe;">
                    <i class="bi {{ $fitur->icon }}" style="color: #2563eb; font-size: 1.3rem;"></i>
                </div>
                <span class="badge text-bg-info mb-2 px-3 py-2 fw-medium">{{ $fitur->badge }}</span>
                <p class="text-secondary small">{{ $fitur->deskripsi }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- About --}}
@if ($about)
<section class="py-5" style="background: #f8fafc;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                @if ($about->image)
                <div class="ratio ratio-4x3 rounded-4 overflow-hidden" style="background: #e2e8f0;">
                    <img src="{{ asset('storage/' . $about->image) }}" alt="{{ $about->judul }}" style="object-fit:cover;width:100%;height:100%;">
                </div>
                @else
                <div class="ratio ratio-4x3 rounded-4 overflow-hidden" style="background: #e2e8f0;">
                    <div class="d-flex align-items-center justify-content-center">
                        <svg width="100" height="100" fill="#94a3b8" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.573-1.066z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-lg-6">
                <h6 class="text-primary fw-semibold text-uppercase small mb-2">{{ $about->badge_text }}</h6>
                <h2 class="fw-bold mb-2" style="color: #0b2a3f; font-size: 1.75rem;">{{ $about->judul }}</h2>
                @if ($about->subtitle)
                <h5 class="fw-bold text-secondary mb-3">{{ $about->subtitle }}</h5>
                @endif
                <p class="text-secondary small lh-lg">{{ $about->deskripsi }}</p>
                @if ($about->deskripsi_2)
                <p class="text-secondary small lh-lg">{{ $about->deskripsi_2 }}</p>
                @endif
                <a href="#" onclick="event.preventDefault(); document.getElementById('chatPanel').classList.remove('d-none')" class="btn text-white border-0 fw-semibold px-4 py-2 d-inline-flex align-items-center gap-2" style="background-color: #0b2a3f;">
                    {{ $about->tombol_text }}
                    <i class="bi bi-arrow-right"></i>
                </a>
                @if ($about->highlights)
                <div class="row g-2 mt-4 pt-4 border-top" style="border-color: #e2e8f0 !important;">
                    @foreach ($about->highlights as $highlight)
                    <div class="col-4 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-1" style="width: 40px; height: 40px; background: rgba(11,42,63,0.1);">
                            <i class="bi bi-lightning-charge" style="color: #0b2a3f;"></i>
                        </div>
                        <small class="d-block fw-semibold text-secondary">{{ $highlight }}</small>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

{{-- Layanan (Paket Servis) --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4">
            @forelse ($pakets as $paket)
            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 h-100 shadow-sm" style="background: #f8fafc;">
                    <div class="card-body text-center p-4">
                        <span class="badge text-bg-info mb-3 px-3 py-1 fw-semibold">Layanan</span>
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 56px; height: 56px; background: #dbeafe;">
                            <i class="bi bi-gear" style="color: #2563eb; font-size: 1.2rem;"></i>
                        </div>
                        <h6 class="fw-bold">{{ $paket->nama_paket }}</h6>
                        <p class="text-secondary small">{{ $paket->keterangan ?? 'Layanan servis motor profesional.' }}</p>
                        <p class="fw-bold text-primary mb-0">Rp {{ number_format($paket->biaya, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada paket layanan tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Gallery --}}
@if ($galleries->isNotEmpty())
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-semibold text-uppercase small mb-2">Dokumentasi</h6>
            <h2 class="fw-bold" style="color: #0b2a3f; font-size: 1.75rem;">Galeri Foto</h2>
        </div>
        <div class="row g-3">
            @foreach ($galleries as $gallery)
            <div class="col-6 col-md-3">
                <div class="ratio ratio-4x3 rounded-3 overflow-hidden" style="background: #e2e8f0;">
                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->judul ?? 'Galeri' }}" class="w-100 h-100" style="object-fit:cover;">
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Cara Daftar --}}
<section class="py-5" style="background: #f8fafc;">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-semibold text-uppercase small mb-2">Panduan</h6>
            <h2 class="fw-bold" style="color: #0b2a3f; font-size: 1.75rem;">Cara Mendaftar Servis</h2>
        </div>
        <div class="row g-4">
            @php
                $steps = [
                    ['num' => '1', 'title' => 'Klik Daftar Servis', 'desc' => 'Mulai percakapan dengan chatbot kami'],
                    ['num' => '2', 'title' => 'Isi Data', 'desc' => 'Masukkan data diri & kendaraan Anda'],
                    ['num' => '3', 'title' => 'Pilih Paket', 'desc' => 'Pilih layanan servis yang dibutuhkan'],
                    ['num' => '4', 'title' => 'Dapatkan Antrian', 'desc' => 'Datang sesuai nomor antrian Anda'],
                ];
            @endphp
            @foreach ($steps as $s)
            <div class="col-6 col-lg-3 text-center">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold mb-3 shadow-sm" style="width: 64px; height: 64px; background-color: #0b2a3f; font-size: 1.25rem;">
                    {{ $s['num'] }}
                </div>
                <h6 class="fw-bold small mb-1">{{ $s['title'] }}</h6>
                <small class="text-secondary">{{ $s['desc'] }}</small>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-5" style="background: #f8fafc;">
    <div class="container text-center" style="max-width: 720px;">
        <h2 class="fw-bold mb-3" style="color: #0b2a3f; font-size: 1.75rem;">Siap Servis Motor Anda?</h2>
        <p class="text-secondary mb-4 mx-auto" style="max-width: 480px;">Daftarkan sekarang melalui chatbot kami. Cepat, mudah, dan tanpa antre.</p>
        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
            <a href="#" onclick="event.preventDefault(); document.getElementById('chatPanel').classList.remove('d-none')" class="btn btn-lg fw-bold px-5 py-3 text-white border-0 shadow d-inline-flex align-items-center gap-2" style="background-color: #0b2a3f;">
                <i class="bi bi-chat-dots"></i>
                Daftar Servis Online
            </a>
            <a href="{{ route('customer.cek-status') }}" class="btn btn-lg fw-semibold px-5 py-3 d-inline-flex align-items-center gap-2" style="border: 2px solid #0b2a3f; color: #0b2a3f;">
                <i class="bi bi-check-circle"></i>
                Cek Status
            </a>
        </div>
    </div>
</section>
@endsection
