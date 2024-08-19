<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariableValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'weight'
    ];

}
