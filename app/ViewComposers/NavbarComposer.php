<?php

// namespace App\View\Composers;
namespace App\ViewComposers;

use App\Models\Keranjang;
use Illuminate\View\View;

class NavbarComposer
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
            $keranjang = Keranjang::with(['item', 'ukuran'])->where('user_id', auth()->user()->id)->latest()->get();

            $total_harga = $keranjang->sum(function ($item) {
                return $item->qty * $item->item->harga;
            });

            $data = [
                'data_cart' => $keranjang,
                'count' => $keranjang->count(),
                'total_harga' => $total_harga,
            ];
        }
        $view->with($data);
    }
}
