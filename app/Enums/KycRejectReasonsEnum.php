<?php

namespace App\Enums;

trait KycRejectReasonsEnum
{
    public static function reasons(): array
    {
        return [
            "Incomplete Documentation" => "Incomplete Documentation",
            "Expired Documents" => "Expired Documents",
            "Mismatched Information" => "Mismatched Information",
            "Suspected Fraud" => "Suspected Fraud",
            "High-Risk Profile" => "High-Risk Profile",
            "Politically Exposed Person (PEP) Status" => "Politically Exposed Person (PEP) Status",
            "Sanctions and Embargoes" => "Sanctions and Embargoes",
            "Adverse Media Coverage" => "Adverse Media Coverage",
            "Non-Compliance with Regulatory Requirements" => "Non-Compliance with Regulatory Requirements",
            "Uncleared or Blurred Documents" => "Uncleared or Blurred Documents",
        ];
    }
}
