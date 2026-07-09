@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<h3>Tambah User</h3>

<form method="POST" action="{{ route('users.store') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nama User</label>
        <input
            type="text"
            name="name"
            id="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name') }}"
            required
        >
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
            type="text"
            name="email"
            id="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email') }}"
            required
        >
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input
            type="password"
            name="password"
            id="password"
            class="form-control @error('password') is-invalid @enderror"
            value="{{ old('password') }}"
            required
        >
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
    <label for="id_level" class="form-label">Level</label>
    <select name="id_level" id="id_level" class="form-select" required>
        <option value="">-- Pilih Level --</option>
        @foreach($levels as $level)
            <option value="{{ $level->id }}" {{ old('id_level') == $level->id ? 'selected' : '' }}>
                {{ $level->level_name }}
            </option>
        @endforeach
    </select>
    @error('id_level')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
