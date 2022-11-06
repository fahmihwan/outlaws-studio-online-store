<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wish_list;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function account()
    {
        $user =  User::with('credential')->where('id', auth()->user()->id)->first();
        // return $user;
        return view('toko.pages.customer.account', [
            'user' => $user
        ]);
    }

    public function pesanan()
    {
        return view('toko.pages.customer.pesanan');
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
        return view('toko.pages.customer.address');
    }
    public function informasi_account()
    {
        return view('toko.pages.customer.informasi_account');
    }
}
