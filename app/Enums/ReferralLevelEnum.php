<?php

namespace App\Enums;


trait ReferralLevelEnum
{
    public static function level(): array
    {
        return [
            1 => 'DIRECT',
            2 => 'LEVEL 1',
            3 => 'LEVEL 2',
            4 => 'LEVEL 3',
            5 => 'LEVEL 4',
            6 => 'LEVEL 5',
            7 => 'LEVEL 6',
        ];
    }
}
