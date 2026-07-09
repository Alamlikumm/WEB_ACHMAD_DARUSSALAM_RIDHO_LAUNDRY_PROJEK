@extends('layouts.app')

@section('title', 'Tambah Level')

@section('content')
<h3>Tambah Level</h3>

<form method="POST" action="{{ route('levels.store') }}">
    @csrf

    <div class="mb-3">
        <label for="level_name" class="form-label">Nama Level</label>
        <input
            type="text"
            name="level_name"
            id="level_name"
            class="form-control @error('level_name') is-invalid @enderror"
            value="{{ old('level_name') }}"
            required
        >
        @error('level_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('levels.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
