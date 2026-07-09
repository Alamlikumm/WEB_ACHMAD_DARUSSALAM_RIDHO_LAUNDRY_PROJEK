@extends('layouts.app')

@section('title', 'Data Roles')

@section('content')
<div class="card">
    {{-- <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Daftar Level</h4>
        <a href="{{ route('levels.create') }}" class="btn btn-sm btn-primary">+ Tambah</a>
    </div> --}}
    <div class="card-body">

<!-- <form method="GET" action="{{ route('levels.index') }}" class="mb-3 d-flex">
    <input type="text" name="search" class="form-control me-2" placeholder="Cari Nama Level..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary">Cari</button>
    <a href="{{ route('levels.index') }}" class="btn btn-secondary">Reset</a>
</form> -->

<div class="table-responsive">
    <table class="table table-bordered table-striped mb-0">
        <thead class="table-dark">
            <tr>
                <th width="50">No</th>
                <th>Nama Roles</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($levels as $key => $level)
            <tr>
                <td>{{ $levels->firstItem() + $key }}</td>
                <td>{{ $level->level_name }}</td>
                <td>
                    <a href="{{ route('levels.edit', $level) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="{{ route('levels.destroy', $level) }}" class="form-delete" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Belum Ada Data Roles</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $levels->withQueryString()->links('pagination::bootstrap-5') }}
</div>

    </div>
</div>
@endsection