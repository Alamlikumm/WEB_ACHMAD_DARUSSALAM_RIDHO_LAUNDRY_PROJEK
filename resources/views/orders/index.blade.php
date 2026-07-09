@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Daftar Transaksi</h4>
        <a href="{{ route('orders.create') }}" class="btn btn-sm btn-primary">+ Tambah</a>
    </div>
    <div class="card-body">

<!-- <form method="GET" action="{{ route('orders.index') }}" class="mb-3 d-flex">
    <input type="text" name="search" class="form-control me-2" style="color: black;" placeholder="Cari Kode Order atau Nama Customer..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary">Cari</button>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Reset</a>
</form> -->

<div class="table-responsive">
    <table class="table table-bordered table-striped mb-0">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Kode Order</th>
                <th>Customer</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $key => $order)
            <tr>
                <td>{{ $orders->firstItem() + $key }}</td>
                <td>{{ $order->order_code }}</td>
                <td>{{ $order->customer->customer_name }}</td>
                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                <td>Rp {{ number_format($order->total) }}</td>
                <td>
                    @if($order->order_status == 0)
                        <span class="badge bg-warning text-dark">Baru</span>
                    @else
                        <span class="badge bg-success">Sudah Diambil</span>
                    @endif
                    <br>
                    @if($order->order_pay >= $order->total)
                        <span class="badge bg-success mt-1">Lunas</span>
                    @else
                        <span class="badge bg-danger mt-1">Belum Lunas</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
</div>

    </div>
</div>
@endsection
