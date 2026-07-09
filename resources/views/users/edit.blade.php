@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<h3>Edit User</h3>

<form method="POST" action="{{ route('users.update', $user) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nama User</label>
        <input
            type="text"
            name="name"
            id="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name) }}"
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
            value="{{ old('email', $user->email) }}"
            required
        >
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    {{-- <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input
            type="text"
            name="password"
            id="password"
            class="form-control @error('password') is-invalid @enderror"
            value="{{ old('password', $user->password) }}"
            required
        >
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div> --}}
    <div class="mb-3">
    <label for="id_level" class="form-label">Level</label>
    <select name="id_level" id="id_level" class="form-select" required>
        <option value="">-- Pilih Level --</option>
        @foreach($levels as $level)
            <option value="{{ $level->id }}" {{ old('id_level', $user->id_level ?? '') == $level->id ? 'selected' : '' }}>
                {{ $level->level_name }}
            </option>
        @endforeach
    </select>
    @error('id_level')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection