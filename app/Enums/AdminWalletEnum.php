<?php

namespace App\Enums;

trait AdminWalletEnum
{
    public static function walletTypes(): array
    {
        return [
            'P2P_FEE',
            'WITHDRAWAL_FEE',
            'GAS_FEE',
            'DISQUALIFIED_COMMISSION',
            'LESS_LEVEL_COMMISSION',
            'GIFT',
            'BONUS',
            'STAKING_GAS_FEE',
            'STAKING_WITHDRAWAL_FEE',
        ];
    }
}
