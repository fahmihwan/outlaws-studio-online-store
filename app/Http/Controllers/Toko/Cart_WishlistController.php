<?php

namespace App\Http\Controllers\Toko;

use App\Console\Kernel;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Keranjang;
use App\Models\Wish_list;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Diff\Chunk;

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
            $cart_check = Keranjang::where([
                ['user_id', '=', auth()->user()->id],
                ['item_id', '=', $id],
                ['ukuran_id', '=', $validated['ukuran_id']]
            ]);

            // update qty & price in keranjang;
            if ($cart_check->count() > 0) {
                $get_data = $cart_check->first();
                // dd($get_data->qty);
                Keranjang::where('id', $get_data->id)->update([
                    'qty' => $get_data->qty + $validated['qty']
                ]);
            }

            // create keranjang
            if ($cart_check->count() == 0) {
                Keranjang::create([
                    'user_id' => auth()->user()->id,
                    'item_id' => $id,
                    'ukuran_id' => $validated['ukuran_id'],
                    'total' => '1',
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
            Keranjang::where([
                ['id', '=', $id],
                ['user_id', '=', auth()->user()->id]
            ])->update([
                'qty' => $request->qty
            ]);
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
            Keranjang::where([
                ['id', '=', $id],
                ['user_id', '=', auth()->user()->id]
            ])->update([
                'ukuran_id' => $validated['ukuran_id'],
                'qty' => $validated['qty']
            ]);

            return redirect('/checkout/cart');
        };
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
