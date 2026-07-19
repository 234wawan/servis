<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ServisMotor - Bengkel Motor Profesional')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>
<body>
    @php
        $currentRoute = request()->route()?->getName() ?? '';
        $footerKontaks = App\Models\Kontak::where('is_active', true)->orderBy('urutan')->get()->keyBy('key');
    @endphp

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('home') }}">
                <span class="bg-dark text-white rounded-2 px-2 py-1" style="background-color: #0b2a3f !important;">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.573-1.066z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <div>
                    <div class="lh-1">Servis<span style="color: #0b2a3f">Motor</span></div>
                    <small class="text-muted fw-normal" style="font-size: 0.65rem;">Bengkel Motor Profesional</small>
                </div>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link d-inline-flex align-items-center gap-1 {{ $currentRoute === 'home' ? 'active fw-bold' : '' }}" href="{{ route('home') }}" style="{{ $currentRoute === 'home' ? 'color: #0b2a3f !important;' : '' }}"><i class="bi bi-house-door"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-inline-flex align-items-center gap-1" href="#" onclick="event.preventDefault(); document.getElementById('chatPanel').classList.toggle('d-none')"><i class="bi bi-pencil-square"></i> Pendaftaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-inline-flex align-items-center gap-1 {{ str_starts_with($currentRoute, 'customer.cek-status') ? 'active fw-bold' : '' }}" href="{{ route('customer.cek-status') }}" style="{{ str_starts_with($currentRoute, 'customer.cek-status') ? 'color: #0b2a3f !important;' : '' }}"><i class="bi bi-search"></i> Cek Status Servis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-inline-flex align-items-center gap-1 {{ $currentRoute === 'customer.kontak' ? 'active fw-bold' : '' }}" href="{{ route('customer.kontak') }}" style="{{ $currentRoute === 'customer.kontak' ? 'color: #0b2a3f !important;' : '' }}"><i class="bi bi-envelope text-primary"></i> Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    {{-- Floating Chat Widget --}}
    <div class="whatsapp-float" style="z-index: 1050;">
        {{-- Chat Panel --}}
        <div id="chatPanel" class="position-absolute bottom-0 end-0 mb-2 shadow-lg overflow-hidden d-flex flex-column d-none" style="width: 380px; height: 560px; max-height: 80vh; max-width: calc(100vw - 32px); border-radius: 16px; right: 0; background: white;">
            {{-- Header --}}
            <div class="d-flex align-items-center gap-3 px-4 py-3 flex-shrink-0" style="background-color: #0f2a44;">
                <div class="position-relative">
                    <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: rgba(255,255,255,0.15);">
                        <i class="bi bi-person text-white" style="font-size: 1rem;"></i>
                    </div>
                    <span class="position-absolute bottom-0 end-0 rounded-circle border border-white d-inline-block" style="width: 10px; height: 10px; background: #22c55e;"></span>
                </div>
                <div class="flex-grow-1 min-w-0">
                    <h6 class="text-white fw-semibold mb-0 small">ServisMotor</h6>
                    <small class="d-flex align-items-center gap-1" style="color: #93c5fd; font-size: 0.65rem;">
                        <span class="rounded-circle d-inline-block" style="width: 5px; height: 5px; background: #22c55e;"></span>
                        Online
                    </small>
                </div>
                <div class="d-flex gap-1">
                    <button onclick="document.getElementById('chatPanel').classList.add('d-none')" class="btn btn-sm d-flex align-items-center justify-content-center p-0 text-white border-0" style="width: 28px; height: 28px; background: rgba(255,255,255,0.1); border-radius: 6px;">
                        <i class="bi bi-dash" style="font-size: 1rem;"></i>
                    </button>
                    <button onclick="document.getElementById('chatPanel').classList.add('d-none'); setTimeout(() => document.getElementById('btn-reset-chat')?.click(), 100)" class="btn btn-sm d-flex align-items-center justify-content-center p-0 text-white border-0" style="width: 28px; height: 28px; background: rgba(255,255,255,0.1); border-radius: 6px;">
                        <i class="bi bi-x" style="font-size: 1rem;"></i>
                    </button>
                </div>
            </div>

            @livewire('chatbot-servis', [], key('chatbot-widget'))
        </div>

        {{-- Toggle Button --}}
        <button onclick="document.getElementById('chatPanel').classList.toggle('d-none')" class="btn btn-lg rounded-circle d-flex align-items-center justify-content-center text-white border-0 shadow position-relative" style="background-color: #0b2a3f; width: 56px; height: 56px;">
            <i class="bi bi-chat-dots" style="font-size: 1.5rem;"></i>
            <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                <i class="bi bi-chat"></i>
            </span>
        </button>
    </div>

    {{-- Footer --}}
    @php
        $footerDeskripsi = $footerKontaks->get('deskripsi_footer')?->value ?? 'Bengkel motor profesional melayani jasa perbaikan dan perawatan segala jenis dan tipe motor.';
        $footerTelepon = $footerKontaks->get('no_telepon')?->value ?? '';
        $footerEmail = $footerKontaks->get('email')?->value ?? '';
        $footerAlamat = $footerKontaks->get('alamat')?->value ?? '';
        $footerWa = $footerKontaks->get('no_wa')?->value ?? '';
        $sosmedItems = $footerKontaks->filter(fn($k) => $k->tipe === 'sosmed');
        $kontakItems = $footerKontaks->filter(fn($k) => in_array($k->tipe, ['telepon', 'email']));
    @endphp
    <footer class="text-white pt-5 pb-3" style="background-color: #0b2a3f;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="bg-white/10 rounded-2 px-2 py-1">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.573-1.066z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </span>
                        <span class="fw-bold fs-5">ServisMotor</span>
                    </div>
                    <p class="text-white-50 small">{{ $footerDeskripsi }}</p>
                    @if ($sosmedItems->isNotEmpty())
                    <div class="d-flex gap-2 mt-3">
                        @foreach ($sosmedItems as $item)
                            @if ($item->value && $item->value !== '#')
                                <a href="{{ $item->value }}" class="text-white-50 hover-text-white" target="_blank" title="{{ $item->label }}"><i class="bi {{ $item->icon }}"></i></a>
                            @else
                                <span class="text-white-50" title="{{ $item->label }}"><i class="bi {{ $item->icon }}"></i></span>
                            @endif
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="col-lg-2 offset-lg-1">
                    <h6 class="fw-bold text-uppercase small mb-3">Layanan</h6>
                    <ul class="list-unstyled small text-white-50">
                        <li class="mb-2"><a href="#" onclick="event.preventDefault(); document.getElementById('chatPanel').classList.toggle('d-none')" class="text-white-50 text-decoration-none">Daftar Servis Online</a></li>
                        <li class="mb-2"><a href="{{ route('customer.cek-status') }}" class="text-white-50 text-decoration-none">Cek Status Servis</a></li>
                        <li class="mb-2"><a href="{{ route('home') }}#layanan" class="text-white-50 text-decoration-none">Paket Servis</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold text-uppercase small mb-3">Hubungi Kami</h6>
                    <ul class="list-unstyled small text-white-50">
                        @forelse ($kontakItems as $item)
                        <li class="mb-2 d-flex align-items-center gap-2"><i class="bi {{ $item->icon }}"></i> {{ $item->value }}</li>
                        @empty
                        <li class="mb-2 d-flex align-items-center gap-2"><i class="bi bi-telephone"></i> -</li>
                        <li class="mb-2 d-flex align-items-center gap-2"><i class="bi bi-envelope"></i> -</li>
                        @endforelse
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold text-uppercase small mb-3">Alamat</h6>
                    @if ($footerAlamat)
                    <p class="small text-white-50 d-flex align-items-start gap-2"><i class="bi bi-geo-alt mt-1"></i> {{ $footerAlamat }}</p>
                    @else
                    <p class="small text-white-50">-</p>
                    @endif
                </div>
            </div>
            <hr class="border-white/10 mt-4">
            <p class="text-center text-white-50 small mb-0">&copy; {{ date('Y') }} ServisMotor. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
