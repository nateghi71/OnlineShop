<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


    public function isSale(): Attribute
    {
        return Attribute::get(
            function(){
                return ($this->sale_price != null && $this->date_on_sale_from < Carbon::now() && $this->date_on_sale_to > Carbon::now()) ? true : false;
            }
        );
    }

}
