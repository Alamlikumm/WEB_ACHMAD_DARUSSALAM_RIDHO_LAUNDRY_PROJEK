@extends('layouts.app')

@section('title', 'Data Pengambilan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Daftar Pengambilan</h4>
        <a href="{{ route('pickups.create') }}" class="btn btn-sm btn-primary">+ Catat Pengambilan</a>
    </div>
    <div class="card-body">

<!-- <form method="GET" action="{{ route('pickups.index') }}" class="mb-3 d-flex">
    <input type="text" name="search" class="form-control me-2" style="color: black;" placeholder="Cari Kode Order atau Nama Customer..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary">Cari</button>
    <a href="{{ route('pickups.index') }}" class="btn btn-secondary">Reset</a>
</form> -->

<div class="table-responsive">
    <table class="table table-bordered table-striped mb-0">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Kode Order</th>
                <th>Customer</th>
                <th>Tanggal Pickup</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pickups as $key => $pickup)
            <tr>
                <td>{{ $pickups->firstItem() + $key }}</td>
                <td>{{ $pickup->order->order_code }}</td>
                <td>{{ $pickup->order->customer->customer_name }}</td>
                <td>{{ \Carbon\Carbon::parse($pickup->pickup_date)->format('d/m/Y') }} {{ $pickup->pickup_time }}</td>
                <td>{{ $pickup->notes ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum Ada Data Pengambilan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $pickups->withQueryString()->links('pagination::bootstrap-5') }}
</div>

    </div>
</div>
@endsection