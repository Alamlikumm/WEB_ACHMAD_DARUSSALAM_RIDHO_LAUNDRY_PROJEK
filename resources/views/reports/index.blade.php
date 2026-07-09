@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')

<form method="GET" action="{{ route('reports.index') }}" class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Baru</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Sudah Diambil</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </div>
</form>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h6>Total Pendapatan</h6>
                <h4>Rp {{ number_format($totalRevenue) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h6>Total Transaksi</h6>
                <h4>{{ $totalOrders }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h6>Sudah Diambil</h6>
                <h4>{{ $pickedUp }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h6>Belum Diambil</h6>
                <h4>{{ $pending }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Data Transaksi</h5>
    <div>
        <a href="{{ route('reports.export.pdf', request()->all()) }}" class="btn btn-danger me-2" target="_blank">
            <i class="bi bi-file-earmark-pdf-fill"></i> Export PDF
        </a>
        <a href="{{ route('reports.export.excel', request()->all()) }}" class="btn btn-success" target="_blank">
            <i class="bi bi-file-earmark-excel-fill"></i> Export Excel
        </a>
    </div>
</div>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Customer</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Bayar</th>
            <th>Kembalian</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $key => $order)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $order->order_code }}</td>
            <td>{{ $order->customer->customer_name }}</td>
            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
            <td>Rp {{ number_format($order->total) }}</td>
            <td>Rp {{ number_format($order->order_pay) }}</td>
            <td>Rp {{ number_format($order->order_change) }}</td>
            <td>
                @if($order->order_status == 0)
                    <span class="badge bg-warning text-dark">Baru</span>
                @else
                    <span class="badge bg-success">Diambil</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center">Tidak ada data untuk periode ini</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
