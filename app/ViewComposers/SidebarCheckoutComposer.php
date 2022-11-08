<?php

namespace App\ViewComposers;

use App\Models\Keranjang;
use Illuminate\View\View;

class SidebarCheckoutComposer
{
    /**
     * @param View $view
     */

    public function compose(View $view)
    {

        if (!auth()->check()) {
            $data = [
                'data_cart' => [],
                'count' => 0,
            ];
        } else {
            $keranjang = Keranjang::with([
                'item:id,nama,gambar,harga,kategori_id',
                'item.kategori',
                'ukuran:id,nama'
            ])->where('user_id', auth()->user()->id)->get();


            $total_harga = $keranjang->sum(function ($item) {
                return $item->qty * $item->item->harga;
            });

            $data = [
                'items' => $keranjang,
                'total_harga' => $total_harga
            ];
        }

        $view->with($data);
    }
}
