<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi - {{ date('d-m-Y') }}</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 12px; color: #333; }
        h1 { text-align: center; color: #1e293b; margin-bottom: 5px; }
        .header { text-align: center; margin-bottom: 25px; }
        .header p { color: #64748b; margin-top: 0; }
        
        .stats { margin-bottom: 25px; text-align: center; }
        .stats div { 
            display: inline-block; 
            margin: 0 15px; 
            padding: 15px 25px; 
            background: #f1f5f9; 
            border-radius: 8px; 
            border-left: 4px solid #3b82f6;
        }
        .stats div strong { display: block; font-size: 14px; color: #475569; margin-bottom: 5px; }
        .stats div span { font-size: 18px; font-weight: bold; color: #0f172a; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #3b82f6; color: white; padding: 10px 8px; text-align: left; font-size: 11px; text-transform: uppercase; }
        td { padding: 10px 8px; border-bottom: 1px solid #e2e8f0; font-size: 11px; }
        tr:nth-child(even) { background: #f8fafc; }
        
        /* ✅ STATUS BADGE YANG HIDUP & VIBRANT */
        .status { 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 10px; 
            font-weight: bold; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
            text-align: center;
            min-width: 70px;
        }
        .success { 
            background: #22c55e; /* Hijau Terang */
            color: white; 
            box-shadow: 0 2px 4px rgba(34, 197, 94, 0.3);
        }
        .pending { 
            background: #eab308; /* Kuning Terang */
            color: white; 
            box-shadow: 0 2px 4px rgba(234, 179, 8, 0.3);
        }
        .failed { 
            background: #ef4444; /* Merah Terang */
            color: white; 
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
        }

        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN TRANSAKSI</h1>
        <p>AmikomEventHub - {{ date('d F Y') }}</p>
    </div>

    <div class="stats">
        <div>
            <strong>Total Transaksi</strong>
            <span>{{ number_format($totalTransactions) }}</span>
        </div>
        <div style="border-left-color: #22c55e;">
            <strong>Total Pendapatan</strong>
            <span style="color: #16a34a;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Order ID</th>
                <th>Pembeli</th>
                <th>Event</th>
                <th style="width: 90px;">Total</th>
                <th style="width: 80px; text-align: center;">Status</th>
                <th style="width: 90px;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $index => $trx)
            @php
                // ✅ Logika Status Anti-Gagal (Case-Insensitive)
                $statusLower = strtolower(trim($trx->status));
                $statusClass = 'failed'; // Default merah
                
                if (in_array($statusLower, ['success', 'paid', 'settlement'])) {
                    $statusClass = 'success';
                } elseif ($statusLower === 'pending') {
                    $statusClass = 'pending';
                }
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="font-family: monospace; font-weight: bold; color: #3b82f6;">#{{ $trx->order_id }}</td>
                <td>
                    <strong>{{ $trx->user->name ?? 'N/A' }}</strong><br>
                    <small style="color: #64748b;">{{ $trx->user->email ?? '-' }}</small>
                </td>
                <td>{{ $trx->event->title ?? '-' }}</td>
                <td style="font-weight: bold;">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                <td style="text-align: center;">
                    <span class="status {{ $statusClass }}">
                        {{ ucfirst($trx->status) }}
                    </span>
                </td>
                <td>{{ $trx->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis pada {{ date('d F Y H:i:s') }}</p>
        <p>AmikomEventHub - Platform Event Terpercaya</p>
        <p style="margin-top: 5px; font-weight: bold; color: #475569;">* Pendapatan dihitung dari transaksi dengan status: Success, Paid, atau Settlement</p>
    </div>
</body>
</html>