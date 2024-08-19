<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status',
        'from_office_id',
        'to_office_id',
        'employee_id',
        'customer_id',
        'payment_method',
        'payment_type',
        'total_price',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fromOffice()
    {
        return $this->belongsTo(Office::class, 'from_office_id');
    }

    public function toOffice()
    {
        return $this->belongsTo(Office::class, 'to_office_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function Invoices()
    {
        return $this->hasMany(Invoice::class,'order_id');
    }

    public function order_details()
    {
        return $this->hasone(Order_detail::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function incomingGoods() : HasMany
    {
        return $this->hasMany(Incoming_good::class);

    }
}
