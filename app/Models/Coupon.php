<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['name','code','percentage','max_percentage_amount','expired_at','description'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
