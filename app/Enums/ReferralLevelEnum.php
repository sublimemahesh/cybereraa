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
        ];
    }
}
