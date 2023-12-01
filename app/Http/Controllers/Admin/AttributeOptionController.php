<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Product;
use Illuminate\Http\Request;

class AttributeOptionController extends Controller
{
    public function storeNormalAttribute($attributes , $product)
    {
        foreach ($attributes as $key => $value){
            $product->attributeOptions()->create([
                'attribute_id' => $key,
                'value' => $value,
                'is_variation' => 0 ,
            ]);
        }
    }
    public function storeVariation($attributeOptions , $product)
    {
        foreach ($attributeOptions as $key => $values)
        {
            foreach ($values as $value){
                $product->attributeOptions()->create([
                    'attribute_id' => $key,
                    'value' => $value,
                    'is_variation' => 1,
                ]);
            }
        }

    }

    public function edit(Product $product)
    {
        return view('admin.products.edit_attribute_option' , compact('product'));
    }

}
