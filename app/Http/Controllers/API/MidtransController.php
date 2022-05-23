<?php

namespace App\Http\Controllers\API;

use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        //set configuration midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //make intance midtrans notification
        $notification = new Notification();

        //assign to variable
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        //find id transaction
        $transaction = Transaction::findOrFail($order_id);

        //handle notification
        if ($status == 'capture') {
            if ($type == 'creadit_card') {
                if ($fraud == 'challange') {
                    $transaction->status = 'PENDING';
                } else {
                    $transaction->status = 'SUCCESS';
                }
            }
        } else if ($status == 'settlement') {
            $transaction->status = 'SUCCESS';
        } else if ($status == 'pending') {
            $transaction->status = 'PENDING';
        } else if ($status == 'deny') {
            $transaction->status = 'CENCELED';
        } else if ($status == 'expire') {
            $transaction->status = 'CENCELED';
        } else if ($status == 'cancel') {
            $transaction->status = 'CENCELED';
        }

        //save transaction
        $transaction->save();
    }

    public function success()
    {
        return view('midtrans.success');
    }


    public function unfinish()
    {
        return view('midtrans.unfinish');
    }



    public function error()
    {
        return view('midtrans.error');
    }
}
