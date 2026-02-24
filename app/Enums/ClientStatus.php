<?php

namespace App\Enums;

enum ClientStatus: string
{
    case New = 'new';
    case Active = 'active';
    case InProgress = 'in_progress';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::New     => 'New',
            self::Active  => 'Active',
            self::InProgress => 'Progress',
            self::Closed => 'Closed',
        };
    }

    
}