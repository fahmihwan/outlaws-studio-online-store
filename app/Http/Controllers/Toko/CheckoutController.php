<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Mail\Bill_mail;
use App\Models\Alamat;
use App\Models\Credential;
use App\Models\Keranjang;
use App\Models\Penjualan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
// use App\Mail\DemoMail;

use Illuminate\Support\Facades\Mail;


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
        $alamats = Alamat::with('credential:id,alamat_id')->where('user_id', auth()->user()->id)->get();


        $keranjang = Keranjang::with([
            'item:id,nama,gambar,harga,kategori_id',
            'item.kategori',
            'ukuran:id,nama'
        ])->where('user_id', auth()->user()->id)->get();

        $sub_total = $keranjang->sum(function ($item) {
            return $item->qty * $item->item->harga;
        });

        return view('toko.pages.checkout.pengiriman', [
            'alamats' => $alamats,
            'items' => $keranjang,
            'sub_total' => $sub_total
        ]);
    }




    public function pembayaran()
    {
        // get session
        $get_sesssion_rajaongkir = session()->get('rajaongkir');
        $get_session_credential = session()->get('rajaongkir_credential');

        if (request('metode_pengiriman') == null || request('ongkir') == null) {
            return redirect()->back()->withErrors('pilih layanan paket');
        }
        $get_detail_rajaongkir =  $this->cek_session_rajaongkir($get_sesssion_rajaongkir, $get_session_credential);

        $keranjang = Keranjang::with([
            'item:id,nama,gambar,harga,kategori_id',
            'item.kategori',
            'ukuran:id,nama'
        ])->where('user_id', auth()->user()->id)->get();

        $sub_total = $keranjang->sum(function ($item) {
            return $item->qty * $item->item->harga;
        });

        $total =  $sub_total +  $get_detail_rajaongkir['cost'][0]['value'];

        return view('toko.pages.checkout.pembayaran', [
            'items' => $keranjang,
            'sub_total' =>  $sub_total,
            'total' => $total,
            'info_pengiriman' => [
                'code' => $get_session_credential['code'],
                'value' => $get_detail_rajaongkir['cost'][0]['value'],
                'service' => $get_session_credential['service'],
                'description' => $get_detail_rajaongkir['description']
            ]
        ]);
    }

    private function cek_session_rajaongkir($get_sesssion_rajaongkir, $get_session_credential)
    {
        if ($get_sesssion_rajaongkir == null || $get_session_credential == null) {
            return redirect()->back()->withErrors('pilih metode pengiriman');
        }
        if ($get_sesssion_rajaongkir[0]['code'] == $get_session_credential['code']) {
            foreach ($get_sesssion_rajaongkir[0]['costs'] as $service) {
                if ($service['service'] == $get_session_credential['service']) {
                    $get_detail_rajaongkir = $service;
                }
            }
            return $get_detail_rajaongkir;
        } else {
            return redirect()->back()->withErrors('terjadi kesalahan');
        }
    }


    // midtrans
    public function pay(Request $request)
    {

        //  nota
        $nota = $this->create_nota();

        $get_sesssion_rajaongkir = session()->get('rajaongkir');
        $get_session_credential = session()->get('rajaongkir_credential');

        // ongkir
        $get_detail_rajaongkir =  $this->cek_session_rajaongkir($get_sesssion_rajaongkir, $get_session_credential);

        // subtotal
        $sub_total = Keranjang::where('user_id', auth()->user()->id)
            ->join('items', 'keranjangs.item_id', '=', 'items.id')
            ->selectRaw('sum(keranjangs.qty * items.harga) as sub_total')
            ->first();

        // total
        $gross_amount = $sub_total['sub_total'] + $get_detail_rajaongkir['cost'][0]['value'];




        // // sini
        // $data = $this->cek_metode_pembayaran($request->bank, $gross_amount);
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/charge",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30000,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => json_encode($data),
        //     CURLOPT_HTTPHEADER => array(
        //         'Accept: application/json',
        //         'Authorization: Basic U0ItTWlkLXNlcnZlci1NLUVmN0E3clFQU0tPd2J2RVc0VmtPOXM6',
        //         'Content-Type: application/json',
        //     ),
        // ));

        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        // curl_close($curl);

        // if ($err) {
        //     echo "cURL Error #:" . $err;
        //     return $err;
        // } else {

        //     $response_success = json_decode($response, true);
        //     Mail::to(auth()->user()->email)->send(new Bill_mail($response_success));
        // }
        return view('toko.layout.transaksi_success', [
            'nomor_order' => $nota,
            'status_pesanan' => 'belum',
            'nominal_pesanan' => $gross_amount,
            'metode_pembayaran' => $request->bank,
            'batas_akhir_pembayaran' => 'belum',
            'kode_pembayaran' => 'belum',
        ]);
    }



    private function cek_metode_pembayaran($bank, $gross_amount)
    {
        if ($bank == 'echannel') {
            $data = [
                "payment_type" => $bank,
                "transaction_details" => [
                    "order_id" => rand(),
                    "gross_amount" => $gross_amount
                ], "echannel" => [
                    "bill_info1" => "Payment:",
                    "bill_info2" => "Online purchase"
                ]
            ];
        } else {
            $data = [
                "payment_type" => "bank_transfer",
                "transaction_details" => [
                    "order_id" => rand(),
                    "gross_amount" => $gross_amount
                ],
                "bank_transfer" => [
                    "bank" => $bank
                ],
            ];
        }
        $keranjang = Keranjang::with([
            'item:id,nama,harga'
        ])
            ->select(['id', 'user_id', 'qty', 'item_id'])
            ->where('user_id', auth()->user()->id)
            ->get();

        foreach ($keranjang as $item) {
            $data['items_details'][] = [
                "id" => $item->item->id,
                "price" => $item->item->harga,
                "quantity" => $item->qty,
                "name" => $item->item->nama
            ];
        }
        $user = User::with([
            'credential.alamat',
        ])->get()->first();


        $data['customer_details'] =   [
            "first_name" => $user->credential->nama_depan,
            "last_name" => $user->credential->nama_belakang,
            "email" => $user->email,
            "phone" => $user->credential->telp,
            "shipping_address" => [
                "first_name" => $user->credential->nama_depan,
                "last_name" => $user->credential->nama_belakang,
                "email" => $user->email,
                "phone" => $user->credential->alamat->telp,
                "address" => $user->credential->alamat->alamat,
                "city" => $user->credential->alamat->kota,
                "postal_code" => $user->credential->alamat->kode_pos,
                "country_code" => "IDN"
            ]
        ];
        $data["custom_expiry"] = [
            "order_time" => Carbon::now(),
            "expiry_duration" => 1440,
            "unit" => "minute"
        ];

        return $data;
    }

    private function create_nota()
    {
        $notaDB = Penjualan::select('nota')->latest()->first();
        if ($notaDB == null) {
            $nota = 'OS' . date('m') . '-' . date('Y') . '0001' . date('d') . 'E';
        } elseif (substr($notaDB->nota, 2, 2) != date('m')) {
            $nota = 'OS' . date('m') . '-' . date('Y') . '0001' . date('d') . 'E';
        } else {
            $cut =  substr($notaDB->nota, 10, -3);
            $number = str_pad($cut + 1, 4, "0", STR_PAD_LEFT);;
            $nota = 'OS' . date('m') . '-' . date('Y') . $number . date('d') . 'E';
        }
        return $nota;
    }

    public function set_alamat_primary_customer($idAlamat)
    {

        $credential = Alamat::select(['id', 'alamat', 'user_id'])->with(
            ['user:id,credential_id']
        )->where([
            ['id', '=', $idAlamat],
            ['user_id', '=', auth()->user()->id]
        ])->first();


        Credential::where('id', $credential->user->credential_id)->update([
            'alamat_id' => $idAlamat
        ]);

        return response()->json([
            'code' => 'User Updated Successfully!',
            'data' => $credential->alamat
        ]);
    }
}
