<?php

namespace App\HelperClasses;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Sku;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class Payment
{
    public function createOrder($addressId, $amounts, $token, $gateway_name)
    {
        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'address_id' => $addressId,
                'coupon_id' => session()->has('coupon') ? session()->get('coupon.id') : null,
                'total_amount' => $amounts['total_amount'],
                'delivery_amount' => $amounts['delivery_amount'],
                'coupon_amount' => $amounts['coupon_amount'],
                'paying_amount' => $amounts['paying_amount'],
                'payment_type' => 'online',
            ]);

            foreach (session('cart') as $item) {
                $order->orderItems()->create([
                    'product_id' => $item['product_id'],
                    'sku_id' => $item['sku_id'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['multiplyPrice']
                ]);
            }

            $order->transaction()->create([
                'user_id' => auth()->id(),
                'amount' => $amounts['paying_amount'],
                'token' => $token,
                'gateway_name' => $gateway_name
            ]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return ['error' => $ex->getMessage()];
        }

        return ['success' => 'success!'];
    }

    public function updateOrder($token, $refId)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaction::where('token', $token)->firstOrFail();

            $transaction->update([
                'status' => 1,
                'ref_id' => $refId
            ]);

            $order = Order::findOrFail($transaction->order_id);
            $order->update([
                'payment_status' => 1,
                'status' => 1
            ]);

            foreach ($order->orderItems as $item) {
                $sku = $item->sku;
                $sku->update([
                    'quantity' => $sku->quantity - $item->quantity
                ]);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return ['error' => $ex->getMessage()];
        }

        return ['success' => 'success!'];
    }
}
