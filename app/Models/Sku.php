<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    use HasFactory;

    protected $fillable =['code' ,'product_id' ,'price' ,'quantity' ,'sale_price' ,'date_on_sale_from' ,'date_on_sale_to' ,];

    public function attributeOptions()
    {
        return $this->belongsToMany(AttributeOption::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
