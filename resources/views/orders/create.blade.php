@extends('layouts.app')

@section('title', 'Transaksi Baru')

@section('content')
<h3>Transaksi Laundry Baru</h3>

<form method="POST" action="{{ route('orders.store') }}" id="orderForm">
    @csrf

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Customer</label>
                    <select name="id_customer" class="form-select" required>
                        <option value="">-- Pilih Customer --</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}" {{ old('id_customer') == $c->id ? 'selected' : '' }}>
                                {{ $c->customer_name }} - {{ $c->phone }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_customer')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Order</label>
                    <input type="date" name="order_date" class="form-control" value="{{ old('order_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="order_end_date" class="form-control" min="{{ date('Y-m-d') }}" required>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Detail Layanan</h5>
        </div>
        <div class="card-body">
            <div id="service-rows">
                <!-- Baris pertama -->
                <div class="row mb-2 service-row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Layanan</label>
                        <select name="services[0][id_service]" class="form-select service-select" required>
                            <option value="">-- Pilih --</option>
                            @foreach($services as $s)
                                <option value="{{ $s->id }}" data-price="{{ $s->price }}">
                                    {{ $s->service_name }} - Rp {{ number_format($s->price) }}/{{ $s->unit ?? 'Kg' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">      
                        <label class="form-label">Qty</label>
                        <input type="number" name="services[0][qty]" class="form-control qty-input" min="0.1" value="" step="0.1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Catatan</label>
                        <input type="text" name="services[0][notes]" class="form-control" placeholder="Opsional">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Subtotal</label>
                        <input type="text" class="form-control subtotal-display" readonly tabindex="-1">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-row">Hapus</button>
                    </div>
                </div>
            </div>

            <button type="button" id="add-row" class="btn btn-success btn-sm">+ Tambah Layanan</button>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Waktu Pembayaran</label>
                    <select id="payment_method" class="form-select">
                        <option value="sekarang">Bayar Sekarang</option>
                        <option value="nanti">Bayar Nanti (Hutang)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="payment_method" id="payment_type" class="form-select" required>
                        <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="QRIS" {{ old('payment_method') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Pajak (%)</label>
                    <input type="number" name="tax_percent" id="tax_percent" class="form-control" value="{{ old('tax_percent', 10) }}" min="0" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Bayar (Rp)</label>
                    <input type="text" id="order_pay_display" class="form-control" required>
                    <input type="hidden" name="order_pay" id="order_pay">
                    @error('order_pay')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Total</label>
                    <input type="text" id="grand_total" class="form-control fw-bold" readonly tabindex="-1">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kembalian</label>
                    <input type="text" id="change_amount" class="form-control fw-bold" readonly tabindex="-1">
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-danger d-none" id="payment-warning-alert">
        <i class="bi bi-x-circle-fill me-2"></i> <strong>Uang Kurang!</strong> Pembayaran tidak bisa sebagian. Transaksi tidak dapat diproses.
    </div>

    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection

@push('scripts')
<script>
let rowIndex = 1;

function calculateRow(row) {
    const select = row.querySelector('.service-select');
    const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
    const option = select.options[select.selectedIndex];
    const price = option && option.dataset.price ? parseInt(option.dataset.price) : 0;
    const subtotal = price * qty;
    row.querySelector('.subtotal-display').value = subtotal ? 'Rp ' + subtotal.toLocaleString('id-ID') : '';
    calculateGrandTotal();
}

function calculateGrandTotal() {
    let subtotalAll = 0;
    document.querySelectorAll('.service-row').forEach(row => {
        const select = row.querySelector('.service-select');
        const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
        const option = select.options[select.selectedIndex];
        const price = option && option.dataset.price ? parseInt(option.dataset.price) : 0;
        subtotalAll += price * qty;
    });

    const taxPercent = parseFloat(document.getElementById('tax_percent').value) || 0;
    const tax = subtotalAll * (taxPercent / 100);
    const total = subtotalAll + tax;
    
    const methodTiming = document.getElementById('payment_method').value;
    const methodType = document.getElementById('payment_type').value;
    const payInput = document.getElementById('order_pay');
    const payDisplay = document.getElementById('order_pay_display');

    // Auto-fill pay if QRIS and Bayar Sekarang
    if (methodTiming === 'sekarang' && methodType === 'QRIS') {
        const roundedTotal = Math.round(total);
        payInput.value = roundedTotal;
        payDisplay.value = 'Rp ' + roundedTotal.toLocaleString('id-ID');
    }

    const pay = parseInt(payInput.value) || 0;

    document.getElementById('grand_total').value = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('change_amount').value = 'Rp ' + (pay - total).toLocaleString('id-ID');

    // Munculkan alert jika bayar kurang dari total
    const btnSubmit = document.querySelector('button[type="submit"]');
    if (methodTiming === 'sekarang' && pay > 0 && pay < total) {
        document.getElementById('payment-warning-alert').classList.remove('d-none');
        btnSubmit.disabled = true;
    } else {
        document.getElementById('payment-warning-alert').classList.add('d-none');
        btnSubmit.disabled = false;
    }
}

// Tambah baris layanan baru
document.getElementById('add-row').addEventListener('click', function() {
    const firstRow = document.querySelector('.service-row');
    const newRow = firstRow.cloneNode(true);

    // Ganti index array
    newRow.querySelectorAll('[name]').forEach(input => {
        input.name = input.name.replace('services[0]', 'services[' + rowIndex + ']');
        if (input.type !== 'hidden') {
            if (input.tagName === 'SELECT') {
                input.selectedIndex = 0;
            } else if (input.classList.contains('subtotal-display')) {
                input.value = '';
            } else if (input.type === 'number' && input.classList.contains('qty-input')) {
                input.value = '';
            } else {
                input.value = '';
            }
        }
    });

    document.getElementById('service-rows').appendChild(newRow);
    rowIndex++;
});

// Hapus baris layanan
document.getElementById('service-rows').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-row')) {
        const rows = document.querySelectorAll('.service-row');
        if (rows.length > 1) {
            e.target.closest('.service-row').remove();
            calculateGrandTotal();
        }
    }
});

// Hitung saat service atau qty berubah
document.getElementById('service-rows').addEventListener('change', function(e) {
    if (e.target.classList.contains('service-select') || e.target.classList.contains('qty-input')) {
        calculateRow(e.target.closest('.service-row'));
    }
});

// Format input bayar saat diketik
document.getElementById('order_pay_display').addEventListener('input', function(e) {
    let val = this.value.replace(/[^0-9]/g, '');
    if (val) {
        document.getElementById('order_pay').value = val;
        this.value = 'Rp ' + parseInt(val).toLocaleString('id-ID');
    } else {
        document.getElementById('order_pay').value = '';
        this.value = '';
    }
    calculateGrandTotal();
});

// Hitung saat pajak berubah
document.getElementById('tax_percent').addEventListener('input', calculateGrandTotal);

// Ubah waktu pembayaran (Sekarang/Nanti)
document.getElementById('payment_method').addEventListener('change', function() {
    const payInput = document.getElementById('order_pay');
    const payDisplay = document.getElementById('order_pay_display');
    const paymentType = document.getElementById('payment_type').value;
    if (this.value === 'nanti') {
        payInput.value = 0;
        payDisplay.value = 'Rp 0';
        payDisplay.readOnly = true;
    } else {
        if (paymentType === 'QRIS') {
            payDisplay.readOnly = true;
        } else {
            payInput.value = '';
            payDisplay.value = '';
            payDisplay.readOnly = false;
        }
    }
    calculateGrandTotal();
});

// Ubah tipe pembayaran (Cash/QRIS)
document.getElementById('payment_type').addEventListener('change', function() {
    const payInput = document.getElementById('order_pay');
    const payDisplay = document.getElementById('order_pay_display');
    const methodTiming = document.getElementById('payment_method').value;
    
    if (methodTiming === 'sekarang') {
        if (this.value === 'QRIS') {
            payDisplay.readOnly = true;
        } else {
            payDisplay.readOnly = false;
            // Kosongkan agar bisa diisi ulang jika kembali ke Cash
            if (parseInt(payInput.value) > 0) {
                payInput.value = ''; 
                payDisplay.value = '';
            }
        }
    }
    calculateGrandTotal();
});

// Hitung awal
calculateGrandTotal();

// Konfirmasi jika bayar kurang dari total (opsional saat submit)
document.getElementById('orderForm').addEventListener('submit', function(e) {
    const total = parseInt(document.getElementById('grand_total').value.replace(/[^0-9]/g, '')) || 0;
    const pay = parseInt(document.getElementById('order_pay').value) || 0;
    const method = document.getElementById('payment_method').value;
    
    if (method === 'sekarang' && pay > 0 && pay < total) {
        e.preventDefault();
        alert('Uang kurang! Transaksi tidak dapat diproses karena pembayaran sebagian tidak diizinkan.');
    }
});
</script>
@endpush
