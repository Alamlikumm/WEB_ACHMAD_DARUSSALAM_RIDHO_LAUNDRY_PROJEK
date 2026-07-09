@extends('layouts.app')

@section('title', 'Data Customer')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Daftar Customer</h4>
        <a href="{{ route('customers.create') }}" class="btn btn-sm btn-primary">+ Tambah</a>
    </div>
    <div class="card-body">

<!-- <form method="GET" action="{{ route('customers.index') }}" class="mb-3 d-flex">
    <input type="text" name="search" class="form-control me-2" style="color: black;" placeholder="Cari Nama atau Telepon..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary">Cari</button>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Reset</a>
</form> -->

<div class="table-responsive">
    <table class="table table-bordered table-striped mb-0">
        <thead class="table-dark">
            <tr>
                <th width="50">No</th>
                <th>Nama Customer</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $key => $customer)
            <tr>
                <td>{{ $customers->firstItem() + $key }}</td>
                <td>{{ $customer->customer_name }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->address }}</td>
                <td>
                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="{{ route('customers.destroy', $customer) }}" class="form-delete" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum Ada Data Customer</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $customers->withQueryString()->links('pagination::bootstrap-5') }}
</div>

    </div>
</div>
@endsection