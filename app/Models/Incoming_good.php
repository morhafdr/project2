<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incoming_good extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id','price','order_id',
         'good_name', 'quantity', 'weight', 'status'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
    public function Invoice()
    {
        return $this->hasOne(Invoice::class, 'invoice_id');
    }
    public function orders() : BelongsTo
    {
        return $this->BelongsTo(Order::class, 'order_id');
    }

    /**
     * Get the receive invoice associated with the incoming good.
     */



}
