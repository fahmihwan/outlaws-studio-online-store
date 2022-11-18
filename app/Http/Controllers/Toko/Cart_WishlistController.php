<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Keranjang;
use App\Models\List_ukuran;
use App\Models\Wish_list;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class Cart_WishlistController extends Controller
{
    public function store_cart(Request $request, $id)
    {


        if (!isset(auth()->user()->id)) {
            return redirect('/customer/account/login')->withErrors('Silahkan Login atau Registerasi terlebih dahulu');
        }
        $validated = $request->validate([
            'ukuran_id' => 'required|numeric',
            'qty' => 'required|numeric',
        ]);


        try {
            DB::beginTransaction();
            // cek ukuran dan item ada?

            $list_ukuran = List_ukuran::where([
                ['item_id', '=', $id],
                ['ukuran_id', '=', $validated['ukuran_id']]
            ])->first();


            $cart_check = Keranjang::where([
                ['user_id', '=', auth()->user()->id],
                ['item_id', '=', $id],
                ['ukuran_id', '=', $validated['ukuran_id']]
            ]);

            // update qty & price in keranjang;
            if ($cart_check->count() > 0) {
                $data_keranjang = $cart_check->first();
                $will_update_qty =  $validated['qty'] + $data_keranjang->qty;

                if ($will_update_qty > $list_ukuran->qty) {
                    throw new Exception('Kamu telah memasukkan ' . $data_keranjang->qty . ' item ke dalam keranjang. Kamu tidak bisa menambah jumlah barang, Pembelian telah mencapai batas maksimum! ', 1);
                }
                Keranjang::where('id', $data_keranjang->id)->update([
                    'qty' => $will_update_qty
                ]);
            }

            // create keranjang
            if ($cart_check->count() == 0) {
                if ($validated['qty'] > $list_ukuran->qty) {
                    throw new Exception('Pembelian telah mencapai batas maksimum!', 1);
                }
                Keranjang::create([
                    'user_id' => auth()->user()->id,
                    'item_id' => $id,
                    'ukuran_id' => $validated['ukuran_id'],
                    'qty' => $validated['qty']
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }

        //tes
        return redirect()->back();
    }

    public function destroy_cart($id)
    {
        Keranjang::where('id', $id)->delete();
        return redirect()->back();
    }


    // edit qty AJAX & edit qty + ukuran non AJAX
    public function update_cart_ajax(Request $request, $id)
    {

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'qty' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 404);
            }

            self::cek_keranjang($id, $validator, 'ajax');
            // Keranjang::where([
            //     ['id', '=', $id],
            //     ['user_id', '=', auth()->user()->id]
            // ])->update([
            //     'qty' => $request->qty
            // ]);
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diudapte!',
            ]);
        }
        if (!$request->ajax()) {
            $validated = $request->validate([
                'ukuran_id' => 'required|numeric',
                'qty' => 'required|numeric',
            ]);

            $cek =  self::cek_keranjang($id, $validated, 'non_ajax');

            return redirect()->back()->withErrors($cek);
        };
    }

    static function cek_keranjang($id, $validated)
    {
        try {
            DB::beginTransaction();
            $cart_check = Keranjang::where([
                ['id', '=', $id],
                ['user_id', '=', auth()->user()->id],
                ['ukuran_id', '=',  $validated['ukuran_id']],
            ]);
            $get_keranjang = $cart_check->first();
            $list_ukuran = List_ukuran::where([
                ['item_id', '=', $get_keranjang->item_id],
                ['ukuran_id', '=', $validated['ukuran_id']]
            ])->first();

            if ($validated['qty'] > $list_ukuran->qty) {
                throw new Exception('Kamu telah memasukkan ' . $get_keranjang->qty . ' item ke dalam keranjang. Kamu tidak bisa menambah jumlah barang, Pembelian telah mencapai batas maksimum! ', 1);
            }
            // end
            $cart_check->update([
                'ukuran_id' => $validated['ukuran_id'],
                'qty' => $validated['qty']
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function edit_cart($id)
    {

        $keranjang =   Keranjang::with([
            'item',
            'ukuran:id,nama'
        ])->where([
            ['user_id', '=', auth()->user()->id],
            ['id', '=', $id]
        ])->latest()->first();

        $item = Item::select(['id'])->with([
            'list_ukurans.ukuran:id,nama',
        ])->where('id', $keranjang->item_id)->first();


        return view('toko.pages.checkout.edit_keranjang', [
            'item' => $keranjang,
            'select_ukurans' => $item->list_ukurans
        ]);
    }

    // proses ajax
    public function store_wishlist(Request $request)
    {
        $check = Wish_list::where([
            'user_id' => auth()->user()->id,
            'item_id' => $request->id
        ])->count();


        if ($check > 0) {
            return 'fail';
        }

        Wish_list::create([
            'user_id' => auth()->user()->id,
            'item_id' => $request->id
        ]);
        return 'success';
    }

    // proses ajax
    public function destroy_wish_list(Request $request)
    {
        $check = Wish_list::where([
            'user_id' => auth()->user()->id,
            'item_id' => $request->id
        ])->count();

        if ($check == 0) {
            return 'fail';
        }

        Wish_list::where([
            'user_id' => auth()->user()->id,
            'item_id' => $request->id
        ])->delete();
        return redirect()->back();
    }
}
