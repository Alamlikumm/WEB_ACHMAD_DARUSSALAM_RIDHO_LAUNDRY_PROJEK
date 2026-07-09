@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<h3>Edit Customer</h3>

<form method="POST" action="{{ route('customers.update', $customer) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="customer_name" class="form-label">Nama Customer</label>
        <input
            type="text"
            name="customer_name"
            id="customer_name"
            class="form-control @error('customer_name') is-invalid @enderror"
            value="{{ old('customer_name', $customer->customer_name) }}"
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
            value="{{ old('phone', $customer->phone) }}"
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
        >{{ old('address', $customer->address) }}</textarea>
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection