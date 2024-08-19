<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'office_id',
        'incoming_good_id',
        'status',
        'value',
        'payment_method',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
    public function office()
    {
        return $this->belongsTo(Office::class,'office_id');
    }
    public function incomingGood()
    {
        return $this->belongsTo(incoming_good::class,'incoming_good_id');
    }
    public function outdoingGood()
    {
        return $this->belongsTo(Outdoing_good::class,'outdoing_good_id');
    }

}
