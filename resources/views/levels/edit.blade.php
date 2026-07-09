@extends('layouts.app')

@section('title', 'Edit Level')

@section('content')
<h3>Edit Level</h3>

<form method="POST" action="{{ route('levels.update', $level) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="level_name" class="form-label">Nama Level</label>
        <input
            type="text"
            name="level_name"
            id="level_name"
            class="form-control @error('level_name') is-invalid @enderror"
            value="{{ old('level_name', $level->level_name) }}"
            required
        >
        @error('level_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('levels.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection