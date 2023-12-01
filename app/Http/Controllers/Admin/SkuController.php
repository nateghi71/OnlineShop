<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sku;
use Illuminate\Http\Request;

class SkuController extends Controller
{
    public function store($variations ,$product , $skus)
    {
        $attr_ids = collect();
        for($i=0 ; $i < count($skus['code']) ; $i++)
        {
            if($skus['code'][$i] !== null)
            {
                foreach ($variations as $key => $value){
                    $attr_id = $product->attributeOptions()->where('attribute_id' , $key)
                        ->where('value' , $value[$i])->first()->id;
                    $attr_ids->push($attr_id);
                }

                $skuStored = $product->skus()->create([
                    'code' => $skus['code'][$i] ,
                    'price' => $skus['price'][$i] ,
                    'quantity' => $skus['quantity'][$i] ,
                    'sale_price' => $skus['sale_price'][$i] ,
                    'date_on_sale_from' => $skus['date_on_sale_from'][$i] ,
                    'date_on_sale_to' => $skus['date_on_sale_to'][$i]
                ]);

                $skuStored->attributeOptions()->attach($attr_ids);
                $attr_ids = collect();
            }
        }
    }
}
