<?php

namespace App\Listeners;

use App\Events\RankEligibilityCheck;
use App\Models\TeamBonus;
use App\Models\User;

class CreateSpecialBonus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param RankEligibilityCheck $event
     * @return void
     */
    public function handle(RankEligibilityCheck $event)
    {
        if ($event->user instanceof User) {
            $this->createSpecialBonus($event->user);
        }
    }

    private function createSpecialBonus(User $user): void
    {
        if (!$user->hasRole('user') || $user->sponsor->specialBonuses->count() === 3) {
            return;
        }

        if ($user->sponsor->children()->count() >= 10) {
            TeamBonus::updateOrCreate([
                'user_id' => $user->super_parent_id,
                'bonus' => '10_DIRECT_SALE',
                'status' => 'DISQUALIFIED',
                'type' => 'SPECIAL_BONUS'
            ]);
        }
        if ($user->sponsor->children()->count() >= 20) {
            TeamBonus::updateOrCreate([
                'user_id' => $user->super_parent_id,
                'bonus' => '20_DIRECT_SALE',
                'status' => 'DISQUALIFIED',
                'type' => 'SPECIAL_BONUS'
            ]);
        }
        if ($user->sponsor->children()->count() >= 30) {
            TeamBonus::updateOrCreate([
                'user_id' => $user->super_parent_id,
                'bonus' => '30_DIRECT_SALE',
                'status' => 'DISQUALIFIED',
                'type' => 'SPECIAL_BONUS'
            ]);
        }
    }
}
