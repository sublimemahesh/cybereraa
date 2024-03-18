<?php

namespace App\Jobs;

use App\Models\PurchasedPackage;
use App\Models\Rank;
use App\Models\User;
use Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserRankFourListener implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $user;

    private array $requirements;

    public bool $ignoreActivatedStates;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, array $requirements, bool $ignoreActivatedStates = true)
    {
        $this->user = $user;
        $this->requirements = $requirements;
        $this->ignoreActivatedStates = $ignoreActivatedStates;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user_descendants = $this->user->descendants()->where('depth', "<=", 4)->pluck('id')->toArray();

        $rank_three_rankers = Rank::whereIn('user_id', $user_descendants)
            ->where('rank', 3)
            ->whereNotNull('activated_at')
            ->count();

        $third_rankers = Rank::whereIn('user_id', $user_descendants)
            ->where('rank', 3)
            ->whereNotNull('activated_at')
            ->oldest()
            ->limit(5)
            ->get();

        // $first_rankers_user_id = $third_rankers->pluck('user_id')->toArray();

        $investments_of_third_rankers = PurchasedPackage::whereIn('user_id', $third_rankers->pluck('user_id')->toArray())
            ->pluck('invested_amount', 'user_id')
            ->toArray();

        $rank_unlocked_investments_of_third_rankers = $third_rankers->mapWithKeys(
            function ($rank) {
                return [$rank->user_id => array_sum($rank->completed_requirements['rank_unlocked']['cumulative_investments_of_rank_two_descendants'])];
            });

        $completed_requirements = [
            'rank_three_rankers_count' => $rank_three_rankers,
            'cumulative_investments_of_rank_three_descendants' => $investments_of_third_rankers,
            'rank_unlocked' => [
                'descendants_count' => count($third_rankers),
                'cumulative_investments_of_rank_three_descendants' => $rank_unlocked_investments_of_third_rankers
            ],
        ];

        $rank = Rank::firstOrCreate([
            'user_id' => $this->user->id,
            'rank' => 4
        ]);


        if ($this->ignoreActivatedStates && $rank->is_active) {
            return;
        }

        $qualified = false;

        if ($rank_three_rankers >= 5) {
            $rank->update(['activated_at' => Carbon::now()]);
            $qualified = true;
        }

        if (!$qualified) {
            $rank->update(['activated_at' => null]);
        }

        $rank->update(compact('completed_requirements'));

    }
}
