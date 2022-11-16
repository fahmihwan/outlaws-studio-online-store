<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use App\Models\Penjualan;
use App\Models\User;
use App\Models\Wish_list;
use Illuminate\Http\Request;

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
        // return $users->credential->tanggal_lahir;

        return view('toko.pages.customer.informasi_account', [
            'user' => $users
        ]);
    }
}
