<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('approved' , 1);
    }

    public function rates()
    {
        return $this->hasMany(ProductRate::class);
    }

    public function wishlist()
    {
        return $this->belongsToMany(User::class , 'wishlist');
    }

    public function scopeFilter(Builder $query)
    {
        if (request()->has('attribute')) {
            foreach (request()->attribute as $attribute) {
                $query->whereHas('attributeOptions', function ($query) use ($attribute) {
                    foreach (explode('-', $attribute) as $index => $item) {
                        if ($index == 0) {
                            $query->where('value', $item);
                        } else {
                            $query->orWhere('value', $item);
                        }
                    }
                });
            }
        }

        if (request()->has('sortBy')) {
            $sortBy = request()->sortBy;

            switch ($sortBy) {
                case 'max':
                    $query->orderByDesc(Sku::select('price')->whereColumn('skus.product_id', 'products.id')->orderBy('sale_price', 'desc')->take(1));
                    break;
                case 'min':
                    $query->orderBy(Sku::select('price')->whereColumn('skus.product_id', 'products.id')->orderBy('sale_price', 'desc')->take(1));
                    break;
                case 'latest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                default:
                    $query;
                    break;
            }
        }
        // dd($query->toSql());
        return $query;
    }
    public function scopeSearch(Builder $query)
    {
        $keyword = request()->search;
        if (request()->has('search') && trim($keyword) != '') {
            $query->where('name', 'LIKE', '%'. trim($keyword) .'%');
        }

        return $query;
    }
}
