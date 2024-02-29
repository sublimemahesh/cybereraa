<?php

namespace App\Listeners;

use App\Events\RankEligibilityCheck;
use App\Jobs\UserRankListener;
use App\Models\User;

class CreateUserRank
{

    private array $requirements = [
        'r1' => [
            'investment' => 1000,
            'team' => [
                '5000' => 10,
                '10000' => 5,
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
            dispatch(new UserRankListener($event->user, $this->requirements));
        }
    }
}
