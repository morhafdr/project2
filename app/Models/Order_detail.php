<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'S_user',
        'S_national_id',
        'S_phone_number',
        'S_family_registration',
        'S_mother_name',
        'S_Location',
        'R_user',
        'longitude',
        'latitude',
        'R_phone_number',
        'payment_timing',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

}
