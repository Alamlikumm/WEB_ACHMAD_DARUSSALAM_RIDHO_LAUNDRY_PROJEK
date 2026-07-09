@extends('layouts.app')

@section('title', 'Data Jenis Layanan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Daftar Jenis Layanan</h4>
        <a href="{{ route('type-of-services.create') }}" class="btn btn-sm btn-primary">+ Tambah</a>
    </div>
    <div class="card-body">

<!-- <form method="GET" action="{{ route('type-of-services.index') }}" class="mb-3 d-flex">
    <input type="text" name="search" class="form-control me-2" style="color: black;" placeholder="Cari Nama Layanan..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary">Cari</button>
    <a href="{{ route('type-of-services.index') }}" class="btn btn-secondary">Reset</a>
</form> -->

<div class="table-responsive">
    <table class="table table-bordered table-striped mb-0">
        <thead class="table-dark">
            <tr>
                <th width="50">No</th>
                <th>Nama Layanan</th>
                <th>Deskripsi</th>
                <th>Harga / Satuan</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $key => $service)
            <tr>
                <td>{{ $services->firstItem() + $key }}</td>
                <td>{{ $service->service_name }}</td>
                <td>{{ $service->description ?? '-' }}</td>
                <td>Rp {{ number_format($service->price) }} / {{ $service->unit ?? 'Kg' }}</td>
                <td>
                    <a href="{{ route('type-of-services.edit', $service) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="{{ route('type-of-services.destroy', $service) }}" class="form-delete" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Belum Ada Data Jenis Layanan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $services->withQueryString()->links('pagination::bootstrap-5') }}
</div>

    </div>
</div>
@endsection