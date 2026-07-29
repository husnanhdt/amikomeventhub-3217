<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi - Organizer</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4F46E5; color: white; }
        .text-right { text-align: right; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Transaksi - AmikomEventHub</h2>
        <p>Organizer Panel</p>
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Order ID</th>
                <th>Nama Pembeli</th>
                <th>Event</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($transactions as $trx)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $trx->order_id }}</td>
                <td>{{ $trx->customer_name }}<br><small>{{ $trx->customer_email }}</small></td>
                <td>{{ $trx->event->title ?? '-' }}</td>
                <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
                <td>{{ ucfirst($trx->status) }}</td>
                <td class="text-right">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>