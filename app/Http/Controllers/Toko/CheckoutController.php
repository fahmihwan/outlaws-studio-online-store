<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Mail\Bill_mail;
use App\Models\Alamat;
use App\Models\Credential;
use App\Models\Keranjang;
use App\Models\User;
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
        // kota_id
        //

        $alamats = Alamat::with('credential:id,alamat_id')->where('user_id', auth()->user()->id)->get();

        return view('toko.pages.checkout.pengiriman', [
            'alamats' => $alamats,
        ]);
    }


    public function pembayaran()
    {

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('SERVER_KEY_MIDTRANS');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            ),
            'customer_details' => array(
                'first_name' => 'budi',
                'last_name' => 'pratama',
                'email' => 'budi.pra@example.com',
                'phone' => '08111222333',
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);


        return view('toko.pages.checkout.pembayaran', [
            'snap_token' => $snapToken,
        ]);
    }


    // midtrans
    public function pay()
    {

        $mailData = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp.'
        ];

        // Mail::to('fahmiihwan86@gmail.com')->send(new Bill_mail($mailData));
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
        //     // dd($response);
        //     return $response;
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
