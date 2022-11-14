<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class LandingpageController extends Controller
{

    public function landing_page()
    {

        return view('toko.pages.landing_page');
    }

    public function list_item()
    {
        $items = Item::with('wish_list')->select([
            'id', 'nama', 'harga', 'kategori_id', 'gambar'
        ])->with('kategori:id,nama')->latest()->get();

        // return $items;

        return view('toko.pages.list-item', [
            'items' => $items
        ]);
    }

    public function detail_item($id)
    {
        $item = Item::with([
            'kategori:id,nama',
            'list_ukurans.ukuran:id,nama',
        ])->where('id', $id)->first();

        return view('toko.pages.detail-item', [
            'item' => $item,
            'select_ukurans' =>  $item->list_ukurans
        ]);
    }
}
