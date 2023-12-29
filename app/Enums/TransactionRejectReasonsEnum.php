<?php

namespace App\Enums;

trait TransactionRejectReasonsEnum
{
    public static function reasons(): array
    {
        return [
            'Insufficient Funds' => "Insufficient Funds",
            'Invalid Account Information' => "Invalid Account Information",
            'Unrecognized Payee' => "Unrecognized Payee",
            'Security Concerns' => "Security Concerns",
            'Transaction Limit Exceeded' => "Transaction Limit Exceeded",
            'Payment Authorization Failure' => "Payment Authorization Failure",
            'Technical Error' => "Technical Error",
            'Duplicate Transaction' => "Duplicate Transaction",
            'Account Frozen or Restricted' => "Account Frozen or Restricted",
            'Policy Violation' => "Policy Violation",
        ];
    }
}
