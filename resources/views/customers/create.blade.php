@extends('layouts.app')

@section('title', 'Tambah Customer')

@section('content')
<h3>Tambah Customer</h3>

<form method="POST" action="{{ route('customers.store') }}">
    @csrf

    <div class="mb-3">
        <label for="customer_name" class="form-label">Nama Customer</label>
        <input
            type="text"
            name="customer_name"
            id="customer_name"
            class="form-control @error('customer_name') is-invalid @enderror"
            value="{{ old('customer_name') }}"
            required
        >
        @error('customer_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Nomor Telepon</label>
        <input
            type="text"
            name="phone"
            id="phone"
            class="form-control @error('phone') is-invalid @enderror"
            value="{{ old('phone') }}"
            required
        >
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Alamat</label>
        <textarea
            name="address"
            id="address" 
            placeholder="Masukkan Alamat Lengkap"
            class="form-control @error('address') is-invalid @enderror"
            required
        >{{ old('address') }}
        </textarea> 
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
