<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function showComparePage(Product $product)
    {
        return view('home.compare' , compact('product'));
    }

    public function add(Product $product)
    {

    }

    public function destroy(Product $product)
    {

    }
}
