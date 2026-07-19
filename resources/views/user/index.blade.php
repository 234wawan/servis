@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Manajemen Pengguna</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Tambah Pengguna</a>
</div>

<div class="card">
    <div class="card-body">
        <table id="tableUsers" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="role-badge {{ $user->role === 'admin' ? 'role-admin' : ($user->role === 'teknisi' ? 'bg-success' : 'role-kasir') }} text-white">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if ($user->is_active)
                                <span class="badge bg-success rounded-pill px-3">Aktif</span>
                            @else
                                <span class="badge bg-danger rounded-pill px-3">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} pengguna ini?')">
                                @csrf
                                <button class="btn btn-sm {{ $user->is_active ? 'btn-danger' : 'btn-success' }}">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            @if ($user->id !== Auth::id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#tableUsers').DataTable({
        columnDefs: [
            { targets: 0, data: 0 },
            { targets: 1, data: 1 },
            { targets: 2, data: 2 },
            { targets: 3, data: 3 },
            { targets: 4, data: 4 },
            { targets: 5, data: 5, orderable: false }
        ]
    });
});
</script>
@endpush
