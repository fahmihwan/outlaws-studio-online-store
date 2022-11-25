<?php

namespace App\Http\Controllers;

use App\Mail\Transaction_accepted_mail;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Notification;

class HandleNotificationMidtrans extends Controller
{

    public function payment_handler(Request $request)
    {

        $email=  Pembayaran::select('email')->leftJoin('penjualans', 'pembayarans.id', '=', 'penjualans.pembayaran_id')
            ->leftJoin('users', 'penjualans.user_id', '=', 'users.id')
            ->where('code_order', $request->order_id)
            ->first()->email;

        // require_once dirname(__FILE__) . '/../../../vendor/midtrans/midtrans-php/Midtrans.php';
        
        
        // \Midtrans\Config::$isProduction = false;
        // \Midtrans\Config::$serverKey = env('SERVER_KEY_MIDTRANS');
        // $notif = new \Midtrans\Notification();

        Config::$isProduction = false;
        Config::$serverKey = env('SERVER_KEY_MIDTRANS');
        $notif = new Notification();



        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    echo "Transaction order_id: " . $order_id . " is challenged by FDS";
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            Mail::to($email)->send(new Transaction_accepted_mail());
            self::updateStatus($order_id, $transaction);
            echo "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            self::updateStatus($order_id, $transaction);
            echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            self::updateStatus($order_id, $transaction);
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        } else if ($transaction == 'expire') {
            self::updateStatus($order_id, $transaction);
            // TODO set payment status in merchant's database to 'expire'
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
        } else if ($transaction == 'cancel') {
            self::updateStatus($order_id, $transaction);
            // TODO set payment status in merchant's database to 'Denied'
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
        }
    }

    static function updateStatus($order_id, $transaction)
    {
        Pembayaran::where('code_order', $order_id)->update([
            'transaction_status' => $transaction
        ]);
    }
}
