<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'balance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Inside Wallet model
    public function deposit($amount)
    {
        $this->balance += $amount;
        $this->save();
    }

    public function withdraw($amount)
    {
        if ($amount > $this->balance) {
            throw new \Exception('Insufficient funds');
        }

        $this->balance -= $amount;
        $this->save();
    }

}
