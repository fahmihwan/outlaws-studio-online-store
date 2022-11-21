<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use App\Models\Penjualan;
use App\Models\User;
use App\Models\Wish_list;

class CustomerController extends Controller
{
    public function account()
    {
        $user =  User::with('credential:id,nama_depan,nama_belakang')->where('id', auth()->user()->id)->select(['id', 'email', 'credential_id'])->first();

        $items = Penjualan::with([
            'alamat:id,nama_depan,nama_belakang',
            'pembayaran:id,transaction_status'
        ])->where('user_id', auth()->user()->id)->get();

        return view('toko.pages.customer.account', [
            'user' => $user,
            'items' => $items
        ]);
    }

    public function pesanan()
    {
        $items = Penjualan::with([
            'alamat:id,nama_depan,nama_belakang',
            'pembayaran:id,transaction_status'
        ])->where('user_id', auth()->user()->id)->get();
        return view('toko.pages.customer.pesanan', [
            'items' => $items
        ]);
    }

    public function lihat_detail_pesanan($id)
    {
        $item = Penjualan::with([
            'alamat',
            'pembayaran:id,transaction_status,code_bank',
            'detail_penjualans.item',
            'detail_penjualans.ukuran',
            'detail_penjualans.item.kategori',
            'kurir',
            'alamat'
        ])->where([
            ['user_id', '=', auth()->user()->id],
            ['id', '=', $id]
        ])->first();

        $subTotal = $item->detail_penjualans->sum(function ($q) {
            return $q->qty * $q->item->harga;
        });

        return view('toko.pages.customer.lihat_detail', [
            'item' => $item,
            'detail_penjualans' => $item->detail_penjualans,
            'pengiriman' => $item->kurir,
            'sub_total' => $subTotal,
            'total' => $item->total,
            'alamat' => $item->alamat,
            'pembayaran' => $item->pembayaran->code_bank
        ]);
    }

    public function wish_list()
    {
        $data =  Wish_list::with('item')
            ->where('user_id', auth()->user()->id)
            ->latest()->get();
        return view('toko.pages.customer.wish_list', [
            'items' => $data
        ]);
    }

    public function address()
    {
        $alamats = Alamat::where('user_id', auth()->user()->id)->get();
        return view('toko.pages.customer.address', [
            'alamats' => $alamats
        ]);
    }

    public function informasi_account()
    {

        $users = User::with('credential')->Where('id', auth()->user()->id)->first();


        $tanggal = explode('-', $users->credential->tanggal_lahir);

        return view('toko.pages.customer.informasi_account', [
            'user' => $users,
            'date' => $tanggal,
            'telp' => explode('+', $users->credential->telp)[1]
        ]);
    }
}
