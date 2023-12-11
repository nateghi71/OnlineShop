<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [	'user_id','address_id','coupon_id','status','total_amount','delivery_amount','coupon_amount','paying_amount','payment_type','description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function useraAddress()
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
