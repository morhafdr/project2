<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    protected $fillable=['governorate_id','city','address','phone', 'latitude', 'longitude'];

    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }
    public function employees()
    {
        return $this->hasMany(Employee::class, 'office_id');
    }
    public function wareHouse()
    {
        return $this->hasOne(Warehouse::class );
    }
    public function rates()
    {
        return $this->hasMany(Rate::class );
    }
    public function invoice()
    {
        return $this->hasMany(Invoice::class ,'office_id');
    }

    public function favouritedBy()
    {
        return $this->belongsToMany(User::class, 'favourites');
    }





    //scops
    public function scopeByGovernorate(Builder $query, ?string $governorate): Builder
    {
        return $query->when(!empty($governorate), fn($query) => $query->whereHas('governorate', fn($q) => $q->where('name', $governorate)));
    }

    public function scopeByCity(Builder $query, ?string $city): Builder
    {
        return $query->when(!empty($city), fn($query) => $query->where('city', $city));
    }
}
