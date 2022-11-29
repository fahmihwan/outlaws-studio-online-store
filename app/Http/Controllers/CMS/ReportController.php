<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Detail_penjualan;
use App\Models\Penjualan;


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
        ])
            ->where('status_pengiriman', 'rejected')
            ->get();

        return view('cms.pages.report.rejected', [
            'items' => $items
        ]);
    }

    public function detail($id)
    {

        $penjualan = Penjualan::with([
            'kurir',
            'pembayaran',
            'alamat'
        ])->where('id', $id)
            ->first();

        $informasi_pemesanan = Detail_penjualan::select([
            'gambar',
            'items.nama as item_nama',
            'qty',
            'harga',
            'kategoris.nama as kategori_nama'
        ])
            ->join('items', 'detail_penjualans.item_id', '=', 'items.id')
            ->join('kategoris', 'items.kategori_id', '=', 'kategoris.id')
            ->where('detail_penjualans.penjualan_id', $id)
            ->selectRaw('qty * harga as harga_total')
            ->get()->makeHidden(['deskripsi']);


        return view('cms.pages.transaction.detail_pembelian', [
            'id' => $id,
            'penjualan' => $penjualan,
            'pembayaran' => $penjualan->pembayaran,
            'kurir' => $penjualan->kurir,
            'informasi_pemesanan' => $informasi_pemesanan,
            'alamat' => $penjualan->alamat
        ]);
    }
}
