<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;
    protected $fillable=['user_id','office_id'];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function offices()
    {
        return $this->belongsTo(Office::class,'office_id');
    }
}
