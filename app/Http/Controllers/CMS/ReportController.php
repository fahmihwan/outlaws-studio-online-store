<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function confirmed()
    {
        $items = Penjualan::with([
            'pembayaran:id,transaction_status',
            'user:id,email',
            'detail_penjualans.item:id,nama'
        ])
            ->where('status_pengiriman', 'confirmed')
            ->whereHas('pembayarans', function (Builder $query) {
            })
            // ->where('transaction_status', 'settlemet')
            ->get();


        return view('cms.pages.report.confirmed', [
            'items' => $items
        ]);
    }
    public function rejected()
    {
        $items = Penjualan::with([
            'pembayaran:id,transaction_status',
            'user:id,email',
            'detail_penjualans.item:id,nama'
        ])->get();


        return view('cms.pages.report.rejected', [
            'items' => $items
        ]);
    }
    public function failed()
    {
        $items = Penjualan::with([
            'pembayaran:id,transaction_status',
            'user:id,email',
            'detail_penjualans.item:id,nama'
        ])->get();


        return view('cms.pages.report.failed', [
            'items' => $items
        ]);
    }
}
