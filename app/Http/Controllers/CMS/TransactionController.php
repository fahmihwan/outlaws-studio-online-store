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
            'detail_penjualan.item:id,nama,harga,gambar',
            'detail_penjualan.ukuran'
        ])->where('id', $id)->first();


        // $orders = DB::table('orders')
        // ->select('department', DB::raw('SUM(price) as total_sales'))
        // ->groupBy('department')
        // ->havingRaw('SUM(price) > ?', [2500])
        // ->get();




        return Detail_penjualan::join('items', 'detail_penjualans.item_id', '=', 'items.id')
            // ->where('penjualan_id', $id)
            ->withSum('item', 'harga')
            ->get();


        return view(
            'cms.pages.transaction.detail_pembelian',
            [
                'penjualan' => $penjualan,
                'pembayaran' => $penjualan->pembayaran,
                'kurir' => $penjualan->kurir,
                'detail_penjualans' => $penjualan->detail_penjualan,
                'alamat' => $penjualan->alamat
            ]
        );
    }
}
