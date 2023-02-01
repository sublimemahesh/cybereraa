<?php

namespace App\Traits;

use Carbon;

trait NextPaymentDate
{
    public function getNextPaymentDateAttribute(): string
    {
        $today = Carbon::parse(date('Y-m-d') . ' ' . $this->created_at->format('H:i:s'));
        $firstPayDate = $this->created_at->addDays(5);

        $nextPayDay = $firstPayDate;
        if ($firstPayDate->isPast()) {
            $nextPayDay = $today;
        }
        if ($firstPayDate->isPast() && Carbon::parse($this->last_earned_at)->isToday()) {
            $nextPayDay = $today->addDay();
        }
        if ($nextPayDay->isSaturday() || $nextPayDay->isSunday()) {
            $nextPayDay = $nextPayDay->nextWeekday();
        }
        return $nextPayDay->format('Y-m-d H:i:s');
    }
}