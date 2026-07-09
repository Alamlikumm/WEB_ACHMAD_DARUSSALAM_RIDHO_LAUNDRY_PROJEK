@extends('layouts.app')

@section('title', 'Data User')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Daftar User</h4>
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">+ Tambah</a>
    </div>
    <div class="card-body">

<!-- <form method="GET" action="{{ route('users.index') }}" class="mb-3 d-flex">
    <input type="text" name="search" class="form-control me-2" style="color: black;" placeholder="Cari Nama atau Email..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary">Cari</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Reset</a>
</form> -->

<div class="table-responsive">
    <table class="table table-bordered table-striped mb-0">
        <thead class="table-dark">
            <tr>
                <th width="50">No</th>
                <th>Nama User</th>
                <th>Email</th>
                <th>Level</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $key => $user)
            <tr>
                <td>{{ $users->firstItem() + $key }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->level->level_name ?? "" }}</td>
                <td>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
                    @if(strtolower($user->level->level_name ?? "") !== 'super admin')
                    <form method="POST" action="{{ route('users.destroy', $user) }}" class="form-delete" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-danger btn-delete">Hapus</button>
    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum Ada Data User</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
</div>

    </div>
</div>
@endsection