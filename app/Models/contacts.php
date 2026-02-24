<?php

namespace App\Models;

use App\Enums\ContactType;


use Illuminate\Database\Eloquent\Model;

class contacts extends Model
{
    protected $fillable = [
        'client_id',
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'type',
    ];

    protected $casts = [
        'type' => ContactType::class,
    ];

    public function client()
    {
        return $this->belongsTo(clients::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($contact) {
            if (!$contact->user_id && auth()->check()) {
                $contact->user_id = auth()->id();
            }
        });
    }
}
