<?php

use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Support\Carbon;

function totalDelivery()
{
    $totalDelivery = 0;
    foreach (session()->get('cart') as $cart){
        if($cart['quantity'] > 1){
            $totalDelivery += (($cart['quantity'] - 1) * $cart['delivery_amount_per_product']);
        }
        $totalDelivery += $cart['delivery_amount'];
    }
    return $totalDelivery;
}

function totalPrice()
{
    $totalPrices = 0;
    foreach (session()->get('cart') as $cart){
        $totalPrices += $cart['multiplyPrice'];
    }
    return $totalPrices;
}

function checkCoupon($code)
{
    $coupon = Coupon::where('code', $code)->where('expired_at', '>', Carbon::now())->first();

    if ($coupon == null) {
        session()->forget('coupon');
        return ['error' => 'کد تخفیف وارد شده وجود ندارد'];
    }

    if (Order::where('user_id', auth()->id())->where('coupon_id', $coupon->code)->where('payment_status', 1)->exists()) {
        session()->forget('coupon');
        return ['error' => 'شما قبلا از این کد تخفیف استفاده کرده اید'];
    }

    $couponAmount = (((totalPrice() + totalDelivery()) * $coupon->percentage) / 100) > $coupon->max_percentage_amount ? $coupon->max_percentage_amount : (((totalPrice() + totalDelivery()) * $coupon->percentage) / 100);
    session()->put('coupon', ['id' => $coupon->id, 'code' => $coupon->code, 'amount' => $couponAmount]);

    return ['success' => 'کد تخفیف برای شما ثبت شد'];
}
