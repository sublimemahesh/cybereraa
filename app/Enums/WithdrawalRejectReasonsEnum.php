<?php

namespace App\Enums;

trait WithdrawalRejectReasonsEnum
{
    public static function reasons(): array
    {
        return [
            "Insufficient Funds" => "Insufficient Funds",
            "Invalid Withdrawal Address" => "Invalid Withdrawal Address",
            "Security Verification Failure" => "Security Verification Failure",
            "Account Under Review" => "Account Under Review",
            "Withdrawal Limit Exceeded" => "Withdrawal Limit Exceeded",
            "Suspicious Activity Detected" => "Suspicious Activity Detected",
            "Unverified Identity" => "Unverified Identity",
            "Pending KYC Verification" => "Pending KYC Verification",
            "Withdrawal Suspended for Security Reasons" => "Withdrawal Suspended for Security Reasons",
            "Withdrawal Address Whitelist Restriction" => "Withdrawal Address Whitelist Restriction",
        ];
    }
}
