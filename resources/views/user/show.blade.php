@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('content')
<h1>Detail Pengguna</h1>

<div class="card">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nama</dt>
            <dd class="col-sm-9">{{ $user->name }}</dd>
            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $user->email }}</dd>
            <dt class="col-sm-3">Role</dt>
            <dd class="col-sm-9">
                <span class="role-badge {{ $user->role === 'admin' ? 'role-admin' : ($user->role === 'teknisi' ? 'bg-success' : 'role-kasir') }} text-white">
                    {{ ucfirst($user->role) }}
                </span>
            </dd>
            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                @if ($user->is_active)
                    <span class="badge bg-success rounded-pill px-3">Aktif</span>
                @else
                    <span class="badge bg-danger rounded-pill px-3">Nonaktif</span>
                @endif
            </dd>
            <dt class="col-sm-3">Bergabung</dt>
            <dd class="col-sm-9">{{ $user->created_at->format('d/m/Y H:i') }}</dd>
            <dt class="col-sm-3">Terakhir Update</dt>
            <dd class="col-sm-9">{{ $user->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" class="d-inline"
            onsubmit="return confirm('Yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} pengguna ini?')">
            @csrf
            <button class="btn btn-{{ $user->is_active ? 'danger' : 'success' }}">
                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
            </button>
        </form>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
