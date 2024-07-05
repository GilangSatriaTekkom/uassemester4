<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelNotification extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id', 'notifiable_type', 'notifiable_id', 'type', 'data', 'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
