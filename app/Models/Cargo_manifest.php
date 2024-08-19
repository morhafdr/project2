<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo_manifest extends Model
{
    use HasFactory;

    // Specify the table if it doesn't follow Laravel's naming convention
    protected $table = 'cargo_manifests';

    // Define the fillable fields
    protected $fillable = [
        'trip_id',
        'incoming_good_id',
    ];


    // Define the relationship with the Trip model
    public function trip()
    {
        return $this->belongsTo(Trips::class);
    }

    // Define the relationship with the IncomingGoods model
    public function incomingGoods()
    {
        return $this->belongsTo(Incoming_good::class, 'incoming_good_id');
    }



}
