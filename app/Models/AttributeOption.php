<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeOption extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id' ,'product_id' ,'value' ,'is_variation'];

    public function attr()
    {
        return $this->belongsTo(Attribute::class,'attribute_id' , 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function skus()
    {
        return $this->belongsToMany(Sku::class);
    }
}
