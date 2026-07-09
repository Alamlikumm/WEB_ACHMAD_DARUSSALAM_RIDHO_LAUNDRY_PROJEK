@extends('layouts.app')

@section('title', 'Tambah Jenis Layanan')

@section('content')
<h3>Tambah Jenis Layanan</h3>

<form method="POST" action="{{ route('type-of-services.store') }}">
    @csrf

    <div class="mb-3">
        <label for="service_name" class="form-label">Nama Layanan</label>
        <input
            type="text"
            name="service_name"
            id="service_name"
            class="form-control @error('service_name') is-invalid @enderror"
            value="{{ old('service_name') }}"
            required
        >
        @error('service_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Harga</label>
        <input
            type="text"
            name="price"
            id="price"
            class="form-control @error('price') is-invalid @enderror"
            value="{{ old('price') }}"
            required
        >
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="unit" class="form-label">Satuan</label>
        <select name="unit" id="unit" class="form-select @error('unit') is-invalid @enderror" required>
            <option value="">-- Pilih Satuan --</option>
            <option value="Kg" {{ old('unit') == 'Kg' ? 'selected' : '' }}>Kg</option>
            <option value="Pcs" {{ old('unit') == 'Pcs' ? 'selected' : '' }}>Pcs</option>
        </select>
        @error('unit')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea
            name="description"
            id="description"
            class="form-control @error('description') is-invalid @enderror"
        >{{ old('description') }}
        </textarea> 
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>  

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('type-of-services.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
