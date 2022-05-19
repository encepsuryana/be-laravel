<?php

namespace App\Http\Controllers\API;

use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $food_id = $request->input('food_id');
        $status = $request->input('status');

        if ($id) {
            $transaction = Transaction::with(['food', 'user'])->find($id);
            if ($transaction) {
                return ResponseFormatter::success($transaction, 'Transaction found');
            } else {
                return ResponseFormatter::error(
                    null,
                    'Transaction not found',
                    404
                );
            }
        }

        $transaction = Transaction::with(['food', 'user'])
            ->where('user_id', Auth::user()->id);

        if ($food_id) {
            $transaction->where('food_id', $food_id);
        }

        if ($status) {
            $transaction->where('status', $status);
        }


        return ResponseFormatter::success(
            $transaction->paginate($limit),
            'Transactions found'
        );
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findIrFail($id);

        $transaction->update($request->all());

        return ResponseFormatter::success(
            $transaction,
            'Transaction updated'
        );
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'food_id' => 'required|exists:foods,id',
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required',
            'total' => 'required',
            'status' => 'required',
        ]);

        $transaction = Transaction::create([
            'food_id' => $request->food_id,
            'user_id' => $request->user_id,
            'quantity' => $request->quantity,
            'total' => $request->total,
            'status' => $request->status,
            'payment_url' => ""
        ]);

        //configuration midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //call transaction build
        $transaction = Transaction::with(['food', 'user'])->find($transaction->id);

        //make transaction midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => (int) $transaction->total,
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
            ],
            'enabled_payments' => ['dana', 'gopay', 'shopee_pay', 'bank_transfer'],
            'vtweb' => [],
        ];

        //get midtrans
        try {
            //get page midtrans
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            $transaction->paymant_url = $paymentUrl;
            $transaction->save();

            //return data to API
            return ResponseFormatter::success(
                $transaction,
                'Transaction Success'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error(
                $e->getMessage(),
                'Transaction Failed',
            );
        }

        //callback midtrans
    }
}
