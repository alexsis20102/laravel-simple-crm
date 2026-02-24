<?php

namespace App\Enums;

enum ContactType: string
{
    case Other = 'other';
    case Mother = 'mother';
    case Father = 'father';
    case Brother = 'brother';
    case Sister = 'sister';

    public function label(): string
    {
        return match ($this) {
            self::Other     => 'Other',
            self::Mother  => 'Mother',
            self::Father => 'Father',
            self::Brother => 'Brother',
            self::Sister => 'Sister',
        };
    }

    
}