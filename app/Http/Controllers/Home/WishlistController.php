<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function showWishlist()
    {
        if (auth()->check())
        {
            $products = auth()->user()->wishlist()->paginate(10);
            return view('home.user_profile.wishlist' , compact('products'));
        }

        return back();
    }

    public function add(Product $product)
    {
        if (auth()->check())
        {
            $wishlist = auth()->user()->wishlist;

            if($wishlist->contains($product))
            {
                return back()->with('wishlistError' , 'در لیست علاقه مندی ها وجود دارد.');
            }

            auth()->user()->wishlist()->attach($product->id);
            return back()->with('wishlistSuccess' , 'به لیست علاقه مندی ها اضافه شد.');
        }

        return back()->with('wishlistError' , 'ابتدا وارد سایت شوید.');
    }

    public function destroy(Product $product)
    {
        if (auth()->check())
        {
            $wishlist = auth()->user()->wishlist;
//            dd($wishlist);
            if($wishlist->contains($product))
            {
                auth()->user()->wishlist()->detach($product->id);
                return back()->with('wishlistSuccess' , 'از لیست علاقه مندی ها حذف شد.');
            }

            return back()->with('wishlistError' , 'در لیست علاقه مندی ها وجود ندارد.');
        }

        return back()->with('wishlistError' , 'ابتدا وارد سایت شوید.');
    }
}

