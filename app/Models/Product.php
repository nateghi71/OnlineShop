<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory , Sluggable;

    protected $fillable = ['name' ,'category_id' ,'slug' ,'description' ,'is_active' ,'delivery_amount' ,'delivery_amount_per_product' ,];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function attributeOptions()
    {
        return $this->hasMany(AttributeOption::class);
    }
    public function skus()
    {
        return $this->hasMany(Sku::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
