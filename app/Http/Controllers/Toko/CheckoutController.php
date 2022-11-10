<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Mail\Bill_mail;
use App\Models\Alamat;
use App\Models\Credential;
use App\Models\Keranjang;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
// use App\Mail\DemoMail;

use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\returnSelf;

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

        if ($get_sesssion_rajaongkir == null || $get_session_credential == null) {
            return redirect()->back()->withErrors('pilih metode pengiriman');
        }

        if ($get_sesssion_rajaongkir[0]['code'] == $get_session_credential['code']) {
            foreach ($get_sesssion_rajaongkir[0]['costs'] as $service) {
                if ($service['service'] == $get_session_credential['service']) {
                    $get_detail_rajaongkir = $service;
                }
            }
        } else {
            return redirect()->back()->withErrors('terjadi kesalahan');
        }

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


    // midtrans
    public function pay()
    {

        // dd(session()->get('rajaongkir_credential'));
        dd(session()->get('rajaongkir'));


        // $rajaOngkir = json_decode(session()->get('rajaongkir'), true);

        // $arr = [];
        // foreach ($rajaOngkir['rajaongkir']['results'][0]['costs'] as $service) {

        //     if ($service['service'] == session()->get('service')) {
        //         $arr[] = $service['service'];
        //     }
        // }
        // dd($arr);



        // bca, bni, bri
        // $data = [
        //     "payment_type" => "bank_transfer",
        //     "transaction_details" => [
        //         "order_id" => rand(),
        //         "gross_amount" => 44000
        //     ],
        //     "bank_transfer" => [
        //         "bank" => "bri"
        //     ]
        // ];

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
        //         // Set Here Your Requesred Headers
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
        //     // return $err;
        // } else {

        //     $response_success = json_decode($response, true);
        //     // Mail::to('fahmiihwan86@gmail.com')->send(new Bill_mail($response_success));
        // }
        return view('toko.layout.transaksi_success');
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




// curl 'https://api.sandbox.midtrans.com/v2/token?client_key={YOUR-CLIENT-KEY}&card_cvv=123&gross_amount=20000&currency=IDR&card_number=4811111111111114&card_exp_month=02&card_exp_year=2025'
// response midtrans BCA
// {
//     "status_code": "201",
//     "status_message": "Success, Bank Transfer transaction is created",
//     "transaction_id": "07d90a8a-ad55-400e-b5f9-d66762ab5035",
//     "order_id": "order-105",
//     "merchant_id": "G712224979",
//     "gross_amount": "44000.00",
//     "currency": "IDR",
//     "payment_type": "bank_transfer",
//     "transaction_time": "2022-11-06 23:59:34",
//     "transaction_status": "pending",
//     "va_numbers": [
//       {
//         "bank": "bca",
//         "va_number": "24979148978"
//       }
//     ],
//     "fraud_status": "accept"
//   }
