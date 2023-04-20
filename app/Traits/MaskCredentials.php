<?php

namespace App\Traits;

trait MaskCredentials
{
    public static function maskedEmailAddress($email): string
    {
        return substr($email, 0, 2) . '*****' . substr($email, -11);
    }

    public static function maskedPhone($phone): string
    {
        return substr($phone, 0, 5) . '*****' . substr($phone, -2);
    }
}
