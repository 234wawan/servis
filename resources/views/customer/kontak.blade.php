@extends('layouts.customer')

@section('title', 'Kontak Kami - ServisMotor')

@section('content')
{{-- Hero Kecil --}}
<section style="background-color: #0b2a3f; padding: 60px 0;">
    <div class="container text-center">
        <h1 class="text-white fw-bold mb-2">Hubungi Kami</h1>
        <p class="text-white-50 mb-0">ServisMotor siap membantu Anda</p>
    </div>
</section>

{{-- Konten Kontak --}}
<section class="py-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @foreach ($kontaks as $kontak)
                @if ($kontak->tipe === 'sosmed') @continue @endif
                <div class="col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 text-center" style="background: #f8fafc;">
                        <div class="card-body p-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 64px; height: 64px; background: #dbeafe;">
                                <i class="bi {{ $kontak->icon ?? 'bi-geo-alt' }}" style="color: #2563eb; font-size: 1.5rem;"></i>
                            </div>
                            <h6 class="fw-bold mb-2">{{ $kontak->label }}</h6>
                            @if ($kontak->tipe === 'telepon')
                                <p class="text-secondary small mb-0">{{ $kontak->value }}</p>
                            @elseif ($kontak->tipe === 'email')
                                <p class="text-secondary small mb-0">{{ $kontak->value }}</p>
                            @elseif ($kontak->tipe === 'alamat')
                                <p class="text-secondary small mb-0">{{ $kontak->value }}</p>
                            @else
                                <p class="text-secondary small mb-0">{{ $kontak->value }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
