<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function attributeOptions()
    {
        return $this->hasMany(AttributeOption::class);
    }
}
