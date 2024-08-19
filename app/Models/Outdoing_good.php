<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outdoing_good extends Model
{
    use HasFactory;

    protected $fillable = [
        'incoming_good_id',
    ];

    public function incomingGood()
    {
        return $this->belongsTo(Incoming_good::class);
    }
//    public function Invoice()
//    {
//        return $this->hasOne(Invoice::class, 'invoice_id');
//    }
}
