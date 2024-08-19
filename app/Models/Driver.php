<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'national_id',
        'driver_License_number',
        'phone',
        'join_date',
        'status',
    ];
    public function trucks()
    {
        return $this->hasMany(Truck::class, 'driver_id');
    }
}
