<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Detail_penjualan;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;


class TransactionController extends Controller
{
    public function index()
    {
        $today_date = Carbon::now()->addDays(-7)->toDateTimeString();

        $items = Penjualan::with(['pembayaran:id,transaction_status', 'user:id,email'])
            // ->whereBetween('created_at', [$start, $end])
            ->where('created_at', '>=', $today_date)
            ->latest()->get();
        return view('cms.pages.transaction.index', [
            'items' => $items
        ]);
    }

    public function detail_pembelian($id)
    {


        $penjualan = Penjualan::with([
            'kurir',
            'pembayaran',
            'alamat'
        ])->where('id', $id)
            // ->whereIn('status_pengiriman', ['pending','rejected','pending'])
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

    public function konfirmasi_pembelian(Request $reques, $id)
    {
        Penjualan::where('id', $id)->update([
            'status_pengiriman' => $reques->status_pengiriman
        ]);
        return redirect()->back();
    }
}
