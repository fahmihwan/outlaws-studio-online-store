<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Http\Resources\KeranjangResource;
use App\Models\Alamat;
use App\Models\Keranjang;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function keranjang()
    {
        $items = Keranjang::with([
            'item',
            'ukuran:id,nama'
        ])->where('user_id', auth()->user()->id)->latest()->get();

        $total_keranjang = $items->sum(function ($item) {
            return $item->qty * $item->item->harga;
        });

        return view('toko.pages.checkout.keranjang', [
            'items' => $items,
            'total_keranjang' => $total_keranjang
        ]);
    }

    public function pengiriman()
    {







        $alamats = Alamat::where('user_id', auth()->user()->id)->get();
        $keranjang = Keranjang::with([
            'item:id,nama,gambar,harga,kategori_id',
            'item.kategori',
            'ukuran:id,nama'
        ])->where('user_id', auth()->user()->id)->get();
        return view('toko.pages.checkout.pengiriman', [
            'alamats' => $alamats,
            'items' => $keranjang
        ]);
    }

    public function payment_midtrans()
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-M-Ef7A7rQPSKOwbvEW4VkO9s';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            ),
            'customer_details' => array(
                'first_name' => 'budi',
                'last_name' => 'pratama',
                'email' => 'budi.pra@example.com',
                'phone' => '08111222333',
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('snap');
    }
}
