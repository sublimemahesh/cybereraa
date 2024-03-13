<?php

namespace App\Jobs;

use App\Models\PurchasedPackage;
use App\Models\Rank;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserRankThreeListener implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $user;

    private array $requirements;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, array $requirements)
    {
        $this->user = $user;
        $this->requirements = $requirements;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user_descendants = $this->user->descendants()->where('depth', "<=", 4)->pluck('id')->toArray();

        $rank_two_rankers = Rank::whereIn('user_id', $user_descendants)
            ->where('rank', 2)
            ->whereNotNull('activated_at')
            ->count();

        $second_rankers = Rank::whereIn('user_id', $user_descendants)
            ->where('rank', 2)
            ->whereNotNull('activated_at')
            ->oldest()
            ->limit(5)
            ->get();

        // $first_rankers_user_id = $second_rankers->pluck('user_id')->toArray();

        $investments_of_second_rankers = PurchasedPackage::whereIn('user_id', $second_rankers->pluck('user_id')->toArray())
            ->pluck('invested_amount', 'user_id')
            ->toArray();

        $rank_unlocked_investments_of_second_rankers = $second_rankers->mapWithKeys(
            function ($rank) {
                return [$rank->user_id => array_sum($rank->completed_requirements['rank_unlocked']['cumulative_investments_of_rank_one_descendants'])];
            });

        $completed_requirements = [
            'rank_two_rankers_count' => $rank_two_rankers,
            'cumulative_investments_of_rank_two_descendants' => $investments_of_second_rankers,
            'rank_unlocked' => [
                'descendants_count' => count($second_rankers),
                'cumulative_investments_of_rank_two_descendants' => $rank_unlocked_investments_of_second_rankers
            ],
        ];

        $rank = Rank::firstOrCreate([
            'user_id' => $this->user->id,
            'rank' => 3
        ]);

        $qualified = false;

        if ($rank_two_rankers >= 5) {
            $rank->update(['activated_at' => Carbon::now()]);
            $qualified = true;
        }

        if (!$qualified) {
            $rank->update(['activated_at' => null]);
        }

        $rank->update(compact('completed_requirements'));

        if ($qualified) {
            $rank_three_user = $this->user;
            for ($i = 1; $i <= 4; $i++) {
                $parent_user = $rank_three_user->sponsor;
                if ($parent_user->id === null) {
                    break;
                }
                UserRankFourListener::dispatch($parent_user, $this->requirements)->onConnection('sync');
                $rank_three_user = $parent_user;
            }
        }
    }
}
