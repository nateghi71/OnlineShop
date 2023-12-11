<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Admin\SkuController;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Mockery\Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->loadCount(['comments' => function(Builder $query){
            $query->where('approved' , 1);
        }])->loadAvg('rates' , 'rate');
        return view('home.product' , compact('product'));
    }

    public function setPrice(Request $request , Product $product)
    {

        $sku = $product->skus()->whereHas('attributeOptions',function (Builder $query) use($request){
            $query->whereIn('id' , $request->variations);
        } , count($request->variations))->first();

        if($sku && $sku->code !== null && $sku->quantity > 0)
        {
            if($sku->sale_price !== null && $sku->date_on_sale_from < Carbon::now() && $sku->date_on_sale_to > Carbon::now())
            {
                return ['exist' => true , 'is_sale' => true , 'quantity'=> $sku->quantity, 'price'=> $sku->price , 'sale_price'=> $sku->sale_price ,'sku_id' => $sku->id];
            }
            else
            {
                return ['exist' => true , 'is_sale' => false ,'quantity'=> $sku->quantity, 'price'=> $sku->price , 'sale_price'=> $sku->sale_price ,'sku_id' => $sku->id];
            }
        }
        else
        {
            return ['exist' => false , 'state'=> 'ناموجود'];
        }
    }

    public function searchByCategory(Request $request , Category $category)
    {
        $attributes = $category->attrs;
        $products = $category->products()->filter()->search()->paginate(9);
        return view('home.searchByCategory' , compact('products' , 'category' , 'attributes'));
    }

    public function searchByTag(Request $request , Tag $tag)
    {
        $products = $tag->products()->filter()->paginate(9);
        return view('home.searchByTags' , compact('tag' , 'products'));
    }

    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
