<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Detail_penjualan;
use App\Models\Item;
use App\Models\Keranjang;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $items = Penjualan::with(['pembayaran:id,transaction_status', 'user:id,email'])->get();

        return view('cms.pages.transaction.index', [
            'items' => $items
        ]);
    }

    public function detail_pembelian($id)
    {
        $penjualan = Penjualan::with([
            'kurir',
            'pembayaran',
            'alamat',
        ])->where('id', $id)->first();

        $informasi_pemesanan = Detail_penjualan::select([
            'gambar',
            'items.nama as item_nama',
            'qty',
            'harga',
            'kategoris.nama as kategori_nama'
        ])
            ->join('items', 'detail_penjualans.item_id', '=', 'items.id')
            ->join('kategoris', 'items.kategori_id', '=', 'kategoris.id')
            ->selectRaw('qty * harga as harga_total')
            ->get()->makeHidden(['deskripsi']);


        return view(
            'cms.pages.transaction.detail_pembelian',
            [
                'penjualan' => $penjualan,
                'pembayaran' => $penjualan->pembayaran,
                'kurir' => $penjualan->kurir,
                'informasi_pemesanan' => $informasi_pemesanan,
                'alamat' => $penjualan->alamat
            ]
        );
    }
}
