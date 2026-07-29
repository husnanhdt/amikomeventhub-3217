<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Transaction::with(['user', 'event'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Nama Pembeli',
            'Email',
            'Event',
            'Tanggal Event',
            'Total Harga',
            'Status',
            'Tanggal Transaksi',
        ];
    }

    public function map($trx): array
    {
        return [
            $trx->order_id,
            $trx->user->name ?? 'N/A',
            $trx->user->email ?? '-',
            $trx->event->title ?? '-',
            $trx->event->date ? \Carbon\Carbon::parse($trx->event->date)->format('d M Y') : '-',
            'Rp ' . number_format($trx->total_price, 0, ',', '.'),
            ucfirst($trx->status),
            $trx->created_at->format('d M Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}