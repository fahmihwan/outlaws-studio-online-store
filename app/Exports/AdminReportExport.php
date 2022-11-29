<?php

namespace App\Exports;

use App\Models\Penjualan;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdminReportExport implements FromCollection, FromQuery, WithMapping
{
    public function collection()
    {
        // return Penjualan::all();
        $items = Penjualan::with([
            'pembayaran:id,transaction_status',
            'user:id,email',
            'detail_penjualans.item:id,nama'
        ])
            ->where('status_pengiriman', 'confirmed')
            // ->whereBetween('tanggal_pembelian', [$request->start_date, $request->end_date])
            ->get();

        $this->map($items);
    }
    public function map($data): array
    {
        return [
            $data->pembayaran->transaction_status
            // Date::dateTimeToExcel($invoice->created_at),
        ];
    }
}
