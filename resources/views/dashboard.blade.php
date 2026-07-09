@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2>Dashboard Laundry</h2>
            <p>Selamat datang, {{ auth()->user()
    ->name }}!</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5>Total Transaksi</h5>
                    <h2>{{ App\Models\TransOrder::count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Sudah Diambil</h5>
                    <h2>{{ App\Models\TransOrder::where('order_status', 1)->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5>Belum Diambil</h5>
                    <h2>{{ App\Models\TransOrder::where('order_status', 0)->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5>Total Customer</h5>
                    <h2>{{ App\Models\Customer::count() }}</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
