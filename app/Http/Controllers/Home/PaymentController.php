<?php

namespace App\Http\Controllers\Home;

use App\HelperClasses\IdPay;
use App\HelperClasses\NextPay;
use App\HelperClasses\Pay;
use App\Http\Controllers\Controller;
use App\Models\Sku;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function payment(Request $request)
    {
        $request->validate([
            'address_id' => 'required' ,
            'payment_method' => 'required'
        ]);

        $checkCart = $this->checkCart();
        if (array_key_exists('error', $checkCart)) {
            return redirect()->route('home.index')->with($checkCart);
        }

        $amounts = $this->getAmounts();
        if (array_key_exists('error', $amounts)) {
            return redirect()->route('home.index')->with($amounts);
        }

        if ($request->payment_method === 'pay')
        {
            $pay = new Pay();
            $result = $pay->requestForPayment($amounts , $request->address_id);
            if (array_key_exists('error', $result))
                return redirect()->back()->with($result);
            else
                return redirect()->to($result['success']);
        }
        elseif ($request->payment_method === 'IdPay')
        {
            $idPay = new IdPay();
            $result = $idPay->requestForPayment($amounts , $request->address_id);
            if (array_key_exists('error', $result))
                return redirect()->back()->with($result);
            else
                return redirect()->to($result['success']);
        }
    }

    public function payVerify(Request $request)
    {
        $pay = new Pay();
        $result = $pay->verifyPayment($request->token);
        if (array_key_exists('error', $result))
            return redirect()->route('home.index')->with($result);
        else
            return redirect()->route('home.index')->with($result);
    }

    public function idPayVerify(Request $request)
    {
        $idPay = new IdPay();
        $result = $idPay->verifyPayment($request->id , $request->order_id);
        if (array_key_exists('error', $result))
            return redirect()->route('home.index')->with($result);
        else
            return redirect()->route('home.index')->with($result);
    }

    public function checkCart()
    {
        if (count(session('cart')) <= 0) {
            return ['error' => 'سبد خرید شما خالی می باشد'];
        }

        foreach (session('cart') as $item) {
            $sku = Sku::find($item['sku_id']);
            $price = $sku->is_sale ? $sku->sale_price : $sku->price;

            if ($item['price'] != $price) {
                session()->forget('cart');
                return ['error' => 'قیمت محصول تغییر پیدا کرد'];
            }

            if ($item['quantity'] > $sku->quantity) {
                session()->forget('cart');
                return ['error' => 'تعداد محصول تغییر پیدا کرد'];
            }
        }

        return ['success' => 'success!'];
    }

    public function getAmounts()
    {
        if (session()->has('coupon')) {
            $checkCoupon = checkCoupon(session()->get('coupon.code'));
            if (array_key_exists('error', $checkCoupon)) {
                return $checkCoupon;
            }
        }

        return [
            'total_amount' => totalPrice(),
            'delivery_amount' => totalDelivery(),
            'coupon_amount' => session()->has('coupon') ? session()->get('coupon.amount') : 0,
            'paying_amount' => session()->has('coupon') ?
                (totalPrice() + totalDelivery()) - session()->get('coupon.amount') : (totalPrice() + totalDelivery()),
        ];
    }
}
