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
            //'MONTHLY_DISQUALIFIED_BONUS',
        ];
    }
}
