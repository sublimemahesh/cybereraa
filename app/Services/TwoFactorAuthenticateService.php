<?php

namespace App\Services;

use App\Models\User;
use Hash;
use Laravel\Fortify\Events\RecoveryCodeReplaced;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticationProvider;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthenticateService
{
    public function checkPassword(User|null $user, $password): bool
    {
        return Hash::check($password, $user?->password);
    }

    public function isTwoFactorEnabled(User|null $user): bool
    {
        return $user?->two_factor_secret && in_array(TwoFactorAuthenticatable::class, class_uses_recursive($user), true);
    }

    public function checkTwoFactor(User|null $user, $code): bool
    {
        if ($this->isTwoFactorEnabled($user)) {
            if ($code === null) {
                return false;
            }

            $recoveryCode = collect($user?->recoveryCodes())->first(static function ($known_code) use ($code) {
                if (hash_equals($known_code, $code)) {
                    return $code;
                }
                return null;
            });

            if ($recoveryCode !== null) {
                $user?->replaceRecoveryCode($recoveryCode);
                event(new RecoveryCodeReplaced($user, $recoveryCode));
            } else {
                return (new TwoFactorAuthenticationProvider(new Google2FA))->verify(decrypt($user?->two_factor_secret), $code);
            }
        }
        return true;
    }
}
