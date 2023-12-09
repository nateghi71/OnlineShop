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

    public function checkCoupon(Request $request)
    {
        if($request->code === null)
        {
            return ['couponMessage' => 'کوپن قابل استفاده نیست.'];
        }

        $couponAmount = 0;
        $totalPrice = 0;
        $totalDelivery = 0;
        foreach (session()->get('cart') as $cart){
            $totalPrice += $cart['multiplyPrice'];
        }

        foreach (session()->get('cart') as $cart){
            if($cart['quantity'] > 1){
                $totalDelivery += (($cart['quantity'] - 1) * $cart['delivery_amount_per_product']);
            }
            $totalDelivery += $cart['delivery_amount'];
        }
        $totalAmount = $totalPrice + $totalDelivery;

        $coupon = Coupon::where('code', $request->code)->where('expired_at', '>', Carbon::now())->first();

        if($coupon != null)
        {
            $couponAmount = ((($totalPrice + $totalDelivery) * $coupon->percentage) / 100) > $coupon->max_percentage_amount ? $coupon->max_percentage_amount : ((($totalPrice + $totalDelivery) * $coupon->percentage) / 100);

            $totalAmount = ($totalPrice + $totalDelivery) - $couponAmount;
            session()->put('coupon', ['id' => $coupon->id, 'code' => $coupon->code , 'amount' => $couponAmount]);
            return ['couponMessage' => ['couponAmount' => $couponAmount ,'totalDelivery' => $totalDelivery ,
                'totalPrice' => $totalPrice ,'totalAmount' => $totalAmount , 'message' => 'کوپن اعمال شد.']];
        }

        session()->forget('coupon');
        return ['couponMessage' => ['couponAmount' => $couponAmount ,'totalDelivery' => $totalDelivery ,
            'totalPrice' => $totalPrice ,'totalAmount' => $totalAmount , 'message' => 'کوپن قابل استفاده نیست.']];
    }

    public function checkout()
    {
        return view('home.checkout');
    }
}
