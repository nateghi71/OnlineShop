<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductRate;
use Illuminate\Http\Request;

class ProductRateController extends Controller
{
    public function index()
    {
        $rates = ProductRate::paginate(10);
        return view('admin.rates.index' , compact('rates'));
    }

    public function destroy(ProductRate $productRate){
        $productRate->delete();
        return back();
    }
}
