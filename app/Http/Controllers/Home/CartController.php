<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CartController extends Controller
{
    public function index()
    {
        return view('home.cart');
    }

    public function addToCart(Request $request)
    {
//        session()->forget('cart');
        $product = Product::findOrFail($request->product_id);
        $sku = Sku::findOrFail($request->sku_id);

        if ($request->quantity > $sku->quantity) {
            return back()->with('errorCart' , 'تعداد وارد شده از محصول درست نمی باشد');
        }

        $cart = session()->get('cart', []);
        $rowId = $product->id . '-' . $sku->id;

        if(isset($cart[$rowId])) {
            $cart[$rowId]['quantity'] = $request->quantity;
        } else {
            $cart[$rowId] = [
                "name" => $product->name,
                "sku_id" => $sku->id,
                "product_id" => $product->id,
                "quantity" => $request->quantity,
                "price" => $sku->isSale ? $sku->sale_price : $sku->price,
                "delivery_amount" => $product->delivery_amount,
                "delivery_amount_per_product" => $product->delivery_amount_per_product,
                "multiplyPrice" => $request->quantity * ($sku->isSale ? $sku->sale_price : $sku->price),
            ];
        }
        session()->put('cart', $cart);
        return back()->with('successCart', 'محصول به سبد خرید اضافه شد!');
    }

    public function update(Request $request , $rowId)
    {
        $cart = session()->get('cart');
        $cart[$rowId]["quantity"] = $request->quantity;
        $cart[$rowId]["multiplyPrice"] = $request->quantity * $cart[$rowId]["price"];
        session()->put('cart', $cart);
        return session()->get('cart');
    }

    public function remove($rowId)
    {
        $cart = session()->get('cart');
        if(isset($cart[$rowId])) {
            unset($cart[$rowId]);
            session()->put('cart', $cart);
            if(count(session('cart')) <= 0){
                session()->forget('cart');
                return response()->json();
            }
        }
        return session()->get('cart');
    }

    public function applyCoupon(Request $request)
    {
        if($request->code === null)
        {
            return ['couponMessage' => 'کوپن قابل استفاده نیست.'];
        }

        $couponAmount = 0;
        $totalAmount = totalPrice() + totalDelivery();


        $result = checkCoupon($request->code);

        if (array_key_exists('error', $result)) {
            return ['couponMessage' => ['couponAmount' => $couponAmount ,'totalDelivery' => totalDelivery() ,
                'totalPrice' => totalPrice() ,'totalAmount' => $totalAmount , 'message' => $result['error']]];
        }

        $couponAmount = session()->get('coupon.amount');
        $totalAmount = (totalPrice() + totalDelivery()) - $couponAmount;
        return ['couponMessage' => ['couponAmount' => $couponAmount ,'totalDelivery' => totalDelivery() ,
            'totalPrice' => totalPrice() ,'totalAmount' => $totalAmount , 'message' => 'کوپن اعمال شد.']];
    }

    public function checkout()
    {
        return view('home.checkout');
    }
}
