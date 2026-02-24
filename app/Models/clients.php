<?php

namespace App\Models;
use App\Enums\ClientStatus;

use Illuminate\Database\Eloquent\Model;

class clients extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'status',
    ];

    protected $casts = [
        'status' => ClientStatus::class,
    ];

    public function contacts()
    {
        return $this->hasMany(contacts::class, 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($client) {
            if (!$client->user_id && auth()->check()) {
                $client->user_id = auth()->id();
            }
        });
    }
    
}
