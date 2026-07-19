@extends('layouts.app')

@section('title', 'About')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>About</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.konten.about.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Badge Text</label>
                    <input type="text" name="badge_text" class="form-control" value="{{ old('badge_text', $about->badge_text ?? 'Sekilas tentang') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $about->judul ?? 'ServisMotor') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Subtitle</label>
                    <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $about->subtitle ?? '') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tombol Text</label>
                    <input type="text" name="tombol_text" class="form-control" value="{{ old('tombol_text', $about->tombol_text ?? 'Daftar Servis Online') }}" required>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Deskripsi (Paragraf 1)</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $about->deskripsi ?? '') }}</textarea>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Deskripsi (Paragraf 2) <small class="text-muted">Opsional</small></label>
                    <textarea name="deskripsi_2" class="form-control" rows="4">{{ old('deskripsi_2', $about->deskripsi_2 ?? '') }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    @if ($about && $about->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $about->image) }}" alt="About" style="max-height:100px;border-radius:8px;">
                        </div>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-check form-switch mt-2">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" class="form-check-input" value="1" id="isActiveAbout" {{ ($about && $about->is_active) ? 'checked' : 'checked' }}>
                        <label class="form-check-label" for="isActiveAbout">Aktif</label>
                    </div>
                </div>
            </div>

            <hr>
            <h6 class="fw-bold mb-3">Highlights (Icon + Label)</h6>
            <div class="row" id="highlightsContainer">
                @php
                    $highlights = $about->highlights ?? ['Motor All Brand', 'Motor All Type', 'Matic / Manual'];
                @endphp
                @foreach ($highlights as $i => $h)
                <div class="col-md-4 mb-2">
                    <label class="form-label small">Highlight {{ $i + 1 }}</label>
                    <input type="text" name="highlights[]" class="form-control" value="{{ $h }}" placeholder="Motor All Brand">
                </div>
                @endforeach
                @for ($i = count($highlights); $i < 3; $i++)
                <div class="col-md-4 mb-2">
                    <label class="form-label small">Highlight {{ $i + 1 }}</label>
                    <input type="text" name="highlights[]" class="form-control" value="" placeholder="Motor All Brand">
                </div>
                @endfor
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
