<?php

namespace App\Traits;

use Carbon;

trait NextPaymentDate
{
    public function getNextPaymentDateAttribute(): string
    {
        $today = Carbon::parse(date('Y-m-d') . ' ' . $this->created_at->format('H:i:s'));

        $day = strtolower(Carbon::parse($this->created_at)->format('l'));

        if (in_array($day, ['tuesday', 'wednesday', 'thursday', 'friday'])) {
            $firstPayDate = $this->created_at->addDays(6);
        } elseif ($day === 'saturday') {
            $firstPayDate = $this->created_at->addDays(5);
        } elseif (in_array($day, ['sunday', 'monday'])) {
            $firstPayDate = $this->created_at->addDays(4);
        }

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
        //return $nextPayDay->format('Y-m-d h:i A');
        return $nextPayDay->format('Y-m-d') . " 12:00 AM";
    }
}
