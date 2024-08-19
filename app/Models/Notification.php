<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',            // Type of the notification
        'notifiable_type', // Model type that the notification is linked to
        'notifiable_id',   // ID of the model that the notification is linked to
        'data',            // JSON data containing details about the notification
        'read_at',         // Timestamp when the notification was marked as read (optional)
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'notifiable_id');
    }


}
