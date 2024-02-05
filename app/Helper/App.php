<?php

use App\Models\PurchasedPackage;
use App\Models\Strategy;

function authUserFolder(): string
{
    $folder = '';
    if (Auth::check()) {
        $roles = Auth::user()->getRoleNames()->toArray();
        if (in_array('user', $roles, true)) {
            $folder = 'user';
        } elseif (in_array('super_admin', $roles, true)) {
            $folder = 'super_admin';
        } else {
            $folder = 'admin';
        }
    }
    return $folder;
}

function getPendingEarningsCount(mixed $earningPendingActivePackagesDate): int
{
    $investment_start_at = Strategy::where('name', 'investment_start_at')->firstOr(fn() => new Strategy(['value' => 2]));
    if (\Carbon::parse($earningPendingActivePackagesDate)->isWeekend()) {
        $earningPendingActivePackages = 0;
    } else {
        $earningPendingActivePackages = PurchasedPackage::with('user')
            ->where('status', 'ACTIVE')
            ->where('is_free_package', 0)
            ->whereRaw("DATE(`created_at`) + INTERVAL {$investment_start_at->value} DAY <= '{$earningPendingActivePackagesDate}'")
            ->whereDoesntHave('earnings', fn($query) => $query->whereDate('created_at', $earningPendingActivePackagesDate))
            //        ->toSql();
            ->count();
    }
    return $earningPendingActivePackages;
}
