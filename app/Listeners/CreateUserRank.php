<?php

namespace App\Listeners;

use App\Events\RankEligibilityCheck;
use App\Jobs\UserRankOneListener;
use App\Models\User;

class CreateUserRank
{

    private array $requirements = [
        'r1' => [
            'investment' => 1000,
            'team' => [
                // 5 => 10000,
                10 => 5000,
            ]
        ],
    ];

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
    public function handle(RankEligibilityCheck $event): void
    {
        if ($event->user instanceof User) {
            \Log::channel('daily')->info("CreateUserRank Dispatching UserRankListener JOB: {$event->user->username}");
            dispatch(new UserRankOneListener($event->user, $this->requirements, $event->ignoreActivatedStates))->onConnection('sync');
        }
    }
}
