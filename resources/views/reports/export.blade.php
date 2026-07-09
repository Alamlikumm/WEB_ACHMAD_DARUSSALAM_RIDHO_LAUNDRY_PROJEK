<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h2>Laporan Penjualan Laundry</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kode Order</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_date }}</td>
                <td>{{ $order->order_code }}</td>
                <td>{{ $order->customer->customer_name }}</td>
                <td>Rp {{ number_format($order->total) }}</td>
                <td>{{ $order->order_status == 1 ? 'Sudah Diambil' : 'Baru' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>