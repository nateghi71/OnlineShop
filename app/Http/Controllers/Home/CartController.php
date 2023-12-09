<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
//        dd(session()->get('cart'));
        return view('home.cart');
    }

    public function addToCart(Request $request)
    {
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
            ];
        }
        session()->put('cart', $cart);
        return back()->with('successCart', 'محصول به سبد خرید اضافه شد!');
    }

    public function update(Request $request , $rowId)
    {
        $cart = session()->get('cart');
        $cart[$rowId]["quantity"] = $request->quantity;
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
}
