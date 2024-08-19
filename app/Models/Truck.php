<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;
    protected $fillable = [
        'plate_number',
        'driver_id',
        'type',
        'capacity',
    ];

    /**
     * Get the driver that owns the truck.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
