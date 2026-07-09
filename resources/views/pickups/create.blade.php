@extends('layouts.app')

@section('title', 'Pengambilan Laundry')

@section('content')
<h3>Catat Pengambilan Laundry</h3>

<form method="POST" action="{{ route('pickups.store') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Pilih Order (Belum Diambil)</label>
        <select name="id_order" class="form-select" required>
            <option value="">-- Pilih Order --</option>
            @foreach($orders as $order)
                <option value="{{ $order->id }}">
                    {{ $order->order_code }} - {{ $order->customer->customer_name }} - Total: Rp {{ number_format($order->total) }}
                    @if($order->order_pay < $order->total)
                        (Kurang Bayar: Rp {{ number_format($order->total - $order->order_pay) }})
                    @endif
                </option>
            @endforeach
        </select>
        @error('id_order')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Tanggal Pengambilan</label>
        <input type="date" name="pickup_date" class="form-control" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Catatan</label>
        <textarea name="notes" class="form-control" rows="3" placeholder="Opsional"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('pickups.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection