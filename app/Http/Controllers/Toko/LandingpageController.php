<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Kategori;
use Illuminate\Http\Request;

class LandingpageController extends Controller
{

    public function landing_page()
    {



        return view('toko.pages.landing_page');
    }

    public function list_item()
    {

        // $items = Item::select([
        //     'id', 'nama', 'harga',
        // ])->filter([
        //     'filter' => 'desc',
        //     'isChecked' => []
        // ])->get();
        // return $items;


        // $items = Item::with('wish_list')->select([
        //     'id', 'nama', 'harga', 'kategori_id', 'gambar'
        // ])->with('kategori:id,nama')->latest()->get();


        return view('toko.pages.list-item', [
            'kategories' => Kategori::all()
        ]);
    }

    public function ajax_list_items(Request $request)
    {

        if ($request->ajax()) {
            try {

                $items = Item::with(['wish_list', 'kategori:id,nama'])->select(['id', 'nama', 'harga', 'kategori_id', 'gambar'])
                    ->filter([
                        'filter' => isset($request->filter) ? $request->filter : null,
                        'isChecked' => isset($request->isChecked) ? $request->isChecked : []
                    ])->get();
                //code...


            } catch (\Throwable $th) {
                //throw $th;
                return $th->getMessage();
            }
            return $items;
        }
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
