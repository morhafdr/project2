<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'employee_id',
        'status',
    ];
    /**
     * Get the order associated with the delivery order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the employee associated with the delivery order.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
