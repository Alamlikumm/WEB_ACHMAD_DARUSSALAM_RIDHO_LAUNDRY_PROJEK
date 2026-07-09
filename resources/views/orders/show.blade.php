@extends('layouts.app')

@section('title', 'Detail Transaksi')

@push('styles')
<style>
    /* ===== PRINT-ONLY RECEIPT STYLES ===== */
    #receipt-print {
        display: none;
    }

    @media print {
        /* Sembunyikan semua elemen web kecuali receipt */
        #sidebar, header, footer, .page-title, .btn,
        .web-view-content, .burger-btn, .badge,
        #sidebar .sidebar-wrapper {
            display: none !important;
        }

        #app, #main, .page-heading, .section {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* Tampilkan receipt */
        #receipt-print {
            display: block !important;
        }

        @page {
            margin: 0;
            size: 100mm auto;
        }

        body {
            width: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            color: #000;
            background: #fff;
        }

        /* Receipt Container */
        .receipt {
            width: 92mm;
            margin: 0 auto;
            padding: 5mm 0;
        }

        /* Header */
        .receipt-header {
            text-align: center;
            padding-bottom: 3mm;
            border-bottom: 2px dashed #000;
            margin-bottom: 3mm;
        }
        .receipt-header .shop-name {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 0;
        }
        .receipt-header .shop-icon {
            font-size: 26px;
            margin-bottom: 2px;
        }
        .receipt-header .shop-tagline {
            font-size: 12px;
            margin: 2px 0 0;
            color: #333;
        }

        /* Separator Dashes */
        .receipt-separator {
            border: none;
            border-top: 1px dashed #000;
            margin: 3mm 0;
        }

        /* Info Section */
        .receipt-info {
            margin-bottom: 2mm;
        }
        .receipt-info-row {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
            font-size: 13px;
        }
        .receipt-info-row .label {
            font-weight: bold;
            flex-shrink: 0;
            width: 42%;
        }
        .receipt-info-row .value {
            text-align: right;
            flex-grow: 1;
        }

        /* Items Table */
        .receipt-items {
            width: 100%;
            border-collapse: collapse;
            margin: 2mm 0;
        }
        .receipt-items th {
            font-size: 13px;
            text-align: left;
            padding: 3px 2px;
            border-bottom: 1px solid #000;
            font-weight: bold;
        }
        .receipt-items th:last-child,
        .receipt-items td:last-child {
            text-align: right;
        }
        .receipt-items th:nth-child(2),
        .receipt-items td:nth-child(2) {
            text-align: center;
        }
        .receipt-items td {
            font-size: 13px;
            padding: 3px 2px;
            vertical-align: top;
        }

        /* Totals */
        .receipt-totals {
            margin-top: 1mm;
        }
        .receipt-total-row {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
            font-size: 14px;
        }
        .receipt-total-row.grand-total {
            font-size: 16px;
            font-weight: bold;
            padding: 3px 0;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            margin: 3mm 0;
        }

        /* Status */
        .receipt-status {
            text-align: center;
            padding: 3mm 0;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid #000;
            margin: 3mm 0;
        }

        /* Footer */
        .receipt-footer {
            text-align: center;
            padding-top: 3mm;
            border-top: 2px dashed #000;
            margin-top: 3mm;
        }
        .receipt-footer p {
            font-size: 13px;
            margin: 2px 0;
            color: #333;
        }
        .receipt-footer .thank-you {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 4px;
            color: #000;
        }
    }
</style>
@endpush

@section('content')

{{-- ===== TAMPILAN WEB (hidden saat print) ===== --}}
<div class="web-view-content">
    <div class="d-flex justify-content-between align-items-md-center flex-column flex-md-row mb-3 gap-3">
        <h3 class="mb-0">Detail Transaksi {{ $order->order_code }}</h3>
        <div>
            <button onclick="window.print()" class="btn btn-primary me-2">
                <i class="bi bi-printer"></i> Cetak
            </button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="table-responsive">
                <table class="table">
                <tr>
                    <th width="150">Kode Order</th>
                    <td>{{ $order->order_code }}</td>
                </tr>
                <tr>
                    <th>Customer</th>
                    <td>{{ $order->customer->customer_name }}</td>
                </tr>
                <tr>
                    <th>Telepon</th>
                    <td>{{ $order->customer->phone }}</td>
                </tr>
                <tr>
                    <th>Tanggal Order</th>
                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Selesai</th>
                    <td>{{ \Carbon\Carbon::parse($order->order_end_date)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($order->order_status == 0)
                            <span class="badge bg-warning text-dark">Baru</span>
                        @else
                            <span class="badge bg-success">Sudah Diambil</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Pembayaran</th>
                    <td>
                        @if($order->order_pay >= $order->total)
                            <span class="badge bg-success">Lunas</span>
                        @else
                            <span class="badge bg-danger">Belum Lunas</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Metode</th>
                    <td>
                        <span class="badge bg-info">{{ $order->payment_method ?? 'Cash' }}</span>
                    </td>
                </tr>
            </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="table-responsive">
                <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Layanan</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails as $detail)
                    <tr>
                        <td>{{ $detail->service->service_name }}</td>
                        <td>{{ $detail->qty }} {{ $detail->service->unit ?? 'Kg' }}</td>
                        <td>Rp {{ number_format($detail->qty > 0 ? $detail->subtotal / $detail->qty : 0) }}</td>
                        <td>Rp {{ number_format($detail->subtotal) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th>Rp {{ number_format($order->total) }}</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">Bayar</th>
                        <th>Rp {{ number_format($order->order_pay) }}</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">Kembalian</th>
                        <th>Rp {{ number_format($order->order_change) }}</th>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
    </div>
</div>

{{-- ===== TAMPILAN CETAK / STRUK (hidden di web, muncul saat print) ===== --}}
<div id="receipt-print">
    <div class="receipt">
        {{-- Header Struk --}}
        <div class="receipt-header">
            <div class="shop-icon">✦</div>
            <p class="shop-name">LAUNDRY</p>
            <p class="shop-tagline">Bersih, Wangi & Rapi</p>
        </div>

        {{-- Info Transaksi --}}
        <div class="receipt-info">
            <div class="receipt-info-row">
                <span class="label">No. Order</span>
                <span class="value">{{ $order->order_code }}</span>
            </div>
            <div class="receipt-info-row">
                <span class="label">Tanggal</span>
                <span class="value">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</span>
            </div>
            <div class="receipt-info-row">
                <span class="label">Selesai</span>
                <span class="value">{{ \Carbon\Carbon::parse($order->order_end_date)->format('d/m/Y') }}</span>
            </div>
        </div>

        <hr class="receipt-separator">

        {{-- Info Customer --}}
        <div class="receipt-info">
            <div class="receipt-info-row">
                <span class="label">Customer</span>
                <span class="value">{{ $order->customer->customer_name }}</span>
            </div>
            <div class="receipt-info-row">
                <span class="label">Telepon</span>
                <span class="value">{{ $order->customer->phone }}</span>
            </div>
        </div>

        <hr class="receipt-separator">

        {{-- Tabel Item Layanan --}}
        <table class="receipt-items">
            <thead>
                <tr>
                    <th>Layanan</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderDetails as $detail)
                <tr>
                    <td>{{ $detail->service->service_name }}</td>
                    <td>{{ $detail->qty }} {{ $detail->service->unit ?? 'Kg' }}</td>
                    <td>Rp {{ number_format($detail->subtotal) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <hr class="receipt-separator">

        {{-- Totals --}}
        <div class="receipt-totals">
            <div class="receipt-total-row grand-total">
                <span>TOTAL</span>
                <span>Rp {{ number_format($order->total) }}</span>
            </div>
            <div class="receipt-total-row">
                <span>Bayar</span>
                <span>Rp {{ number_format($order->order_pay) }}</span>
            </div>
            <div class="receipt-total-row">
                <span>Kembalian</span>
                <span>Rp {{ number_format($order->order_change) }}</span>
            </div>
        </div>

        <hr class="receipt-separator">

        {{-- Status --}}
        <div class="receipt-status">
            @if($order->order_status == 0)
                STATUS: BARU
            @else
                STATUS: SUDAH DIAMBIL
            @endif
            <br>
            @if($order->order_pay >= $order->total)
                PEMBAYARAN: LUNAS
            @else
                PEMBAYARAN: BELUM LUNAS
            @endif
            <br>
            METODE: {{ $order->payment_method ?? 'Cash' }}
        </div>

        {{-- Footer --}}
        <div class="receipt-footer">
            <p class="thank-you">Terima Kasih!</p>
            <p>Simpan struk ini sebagai bukti</p>
            <p>pengambilan laundry Anda.</p>
            <p style="margin-top: 4px;" id="receipt-datetime"></p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Set waktu real (lokal browser) pada struk cetak
    const now = new Date();
    const day = String(now.getDate()).padStart(2, '0');
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const year = now.getFullYear();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    document.getElementById('receipt-datetime').textContent = day + '/' + month + '/' + year + ' ' + hours + ':' + minutes;
</script>
@endpush
