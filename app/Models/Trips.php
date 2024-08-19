<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trips extends Model
{
    use HasFactory;
    protected $fillable = [
        'truck_id',
        'from_office_id',
        'to_office_id',
        'distancePerKm',
        'status',
    ];

    public function truck()
    {
        return $this->belongsTo(Truck::class,'truck_id');
    }
    public function fromOffice()
    {
        return $this->belongsTo(Office::class,'from_office_id');
    }
    public function toOffice()
    {
        return $this->belongsTo(Office::class,'to_office_id');
    }
    public function cargoManifests()
    {
        return $this->hasMany(Cargo_manifest::class, 'trip_id'); // Ensure 'trip_id' is the correct column
    }
}
