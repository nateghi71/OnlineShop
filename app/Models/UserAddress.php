<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = ['title','address','cellphone','postal_code','user_id','province_id','city_id','longitude','latitude'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
