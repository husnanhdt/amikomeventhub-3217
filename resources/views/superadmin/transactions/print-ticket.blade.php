<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Tiket - {{ $transaction->order_id }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 20px;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            border: 2px solid #667eea;
            border-radius: 10px;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            opacity: 0.9;
        }

        .content {
            display: table;
            width: 100%;
        }

        .left-section {
            display: table-cell;
            width: 65%;
            padding: 20px;
            background: #f8fafc;
            vertical-align: top;
        }

        .right-section {
            display: table-cell;
            width: 35%;
            padding: 20px;
            background: white;
            border-left: 2px dashed #cbd5e1;
            vertical-align: top;
            text-align: center;
        }

        .event-title {
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 15px;
        }

        .info-row {
            margin-bottom: 12px;
        }

        .info-label {
            color: #64748b;
            font-size: 10px;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 3px;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: #1e293b;
            font-weight: bold;
            font-size: 13px;
        }

        .order-id-box {
            background: #667eea;
            color: white;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            font-family: monospace;
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
            letter-spacing: 2px;
        }

        .qr-box {
            background: #f1f5f9;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            text-align: center;
        }

        .qr-label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }

        .stat-box {
            margin-bottom: 15px;
        }

        .stat-label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 3px;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;

            .stat-value.status-success {
                color: #22c55e;
            }

            .stat-value.status-warning {
                color: #eab308;
            }
        }

        .footer {
            background: #1e293b;
            color: white;
            padding: 12px;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>E-TIKET AMIKOMEVENTHUB</h1>
            <p>Tiket resmi untuk acara {{ $transaction->event->title ?? 'Event' }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Left Section: Event & Buyer Info -->
            <div class="left-section">
                <div class="event-title">{{ $transaction->event->title ?? 'Event' }}</div>

                <div style="display: table; width: 100%; margin-bottom: 15px;">
                    <div style="display: table-cell; width: 50%; padding-right: 10px;">
                        <div class="info-row">
                            <div class="info-label">TANGGAL & WAKTU</div>
                            <div class="info-value">{{ $transaction->event->date ? \Carbon\Carbon::parse($transaction->event->date)->format('d M Y, H:i') : '-' }}</div>
                        </div>
                    </div>
                    <div style="display: table-cell; width: 50%;">
                        <div class="info-row">
                            <div class="info-label">LOKASI</div>
                            <div class="info-value">{{ $transaction->event->location ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div style="display: table; width: 100%; margin-bottom: 15px;">
                    <div style="display: table-cell; width: 50%; padding-right: 10px;">
                        <div class="info-row">
                            <div class="info-label">KATEGORI</div>
                            <div class="info-value">{{ $transaction->event->category->name ?? '-' }}</div>
                        </div>
                    </div>
                    <div style="display: table-cell; width: 50%;">
                        <div class="info-row">
                            <div class="info-label">PEMBELI</div>
                            <div class="info-value">{{ $transaction->user->name ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">EMAIL</div>
                    <div class="info-value">{{ $transaction->user->email ?? '-' }}</div>
                </div>

                <div class="order-id-box">
                    #{{ $transaction->order_id }}
                </div>
            </div>

            <!-- Right Section: QR Code & Stats -->
            <div class="right-section">
                <div class="qr-box">
                    <div class="qr-label">SCAN QR UNTUK CHECK-IN</div>
                    <div style="text-align: center; padding: 10px;">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(130)->generate($transaction->order_id) !!}
                    </div>
                </div>

                <div class="stat-box">
                    <div class="stat-label">JUMLAH TIKET</div>
                    <div class="stat-value">{{ $transaction->quantity ?? 1 }} Tiket</div>
                </div>

                <div class="stat-box">
                    <div class="stat-label">TOTAL PEMBAYARAN</div>
                    <div class="stat-value" style="color: #22c55e;">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</div>
                </div>

                <div class="stat-box">
                    <div class="stat-label">STATUS</div>
                    <div class="stat-value {{ in_array($transaction->status, ['success', 'paid', 'settlement']) ? 'status-success' : 'status-warning' }}">
                        {{ ucfirst($transaction->status) }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            Tiket ini valid untuk 1 orang. Tunjukkan QR Code saat memasuki venue. | AmikomEventHub - Platform Event Terpercaya
        </div>
    </div>
</body>

</html>