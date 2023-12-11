<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.products.index' , compact('products' ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        $categories = Category::where('parent_id' , '!=' , 0)->get();
        $attributes = Attribute::all();
        return view('admin.products.create' , compact('categories' , 'tags' , 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        dd($request);
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'is_active' => 'required',
            'tag_ids.*' => 'required',
            'description' => 'required',
            'primary_image' => 'required|mimes:jpg,jpeg,png,svg',
            'images' => 'required',
            'images.*' => 'mimes:jpg,jpeg,png,svg',
            'attribute_ids' => 'required',
            'attribute_ids.*' => 'required',
            'variations.*.*' => 'required',
            'skus.price.*' => 'nullable|integer',
            'skus.code.*' => 'nullable|integer',
            'skus.quantity.*' => 'nullable|integer',
            'delivery_amount' => 'required|integer',
            'delivery_amount_per_product' => 'nullable|integer',
        ]);

        try {
            DB::beginTransaction();
            $category = Category::findOrFail($request->category_id);
            $product = $category->products()->create([
                'name' => $request->name,
                'description' => $request->description ,
                'is_active' => $request->is_active ,
                'delivery_amount' => $request->delivery_amount ,
                'delivery_amount_per_product' => $request->delivery_amount_per_product ,
            ]);

            $productImage = new ProductImageController();
            $productImage->Store($request->primary_image , $request->images , $product);

            $productOption = new AttributeOptionController();
            $productOption->storeNormalAttribute($request->attribute_ids  , $product);
            $productOption->storeVariation($request->attribute_options  , $product);

            $sku = new SkuController();
            $sku->store($request->variations  , $product , $request->skus);

            $product->tags()->attach($request->tag_ids);
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()->with('errorDatabase',$e->getMessage());
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $tags = Tag::all();
        $categories = Category::where('parent_id' , '!=' , 0)->get();
        return view('admin.products.show' , compact('product' ,
            'categories' , 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $tags = Tag::all();
        $categories = Category::where('parent_id' , '!=' , 0)->get();
        return view('admin.products.edit' , compact('product' ,'categories' , 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'is_active' => 'required',
            'tag_ids.*' => 'required',
            'description' => 'required',
            'delivery_amount' => 'required|integer',
            'delivery_amount_per_product' => 'nullable|integer',
        ]);

        try {
            DB::beginTransaction();
            $product->update([
                'name' => $request->name,
                'category_id' => $request->category_id ,
                'description' => $request->description ,
                'is_active' => $request->is_active ,
                'delivery_amount' => $request->delivery_amount ,
                'delivery_amount_per_product' => $request->delivery_amount_per_product ,
            ]);

            $product->tags()->detach();
            $product->tags()->attach($request->tag_ids);
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()->with('errorDatabase',$e->getMessage());
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back();
    }
}
