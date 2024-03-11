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
use JsonException;

class UserRankTwoListener implements ShouldQueue
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
     * @throws JsonException
     */
    public function handle()
    {
        $user_descendants = $this->user->descendants()->where('depth', "<=", 4)->pluck('id')->toArray();

        $rank_one_rankers = Rank::whereIn('user_id', $user_descendants)
            ->where('rank', 1)
            ->whereNotNull('activated_at')
            ->count();

        $first_rankers = Rank::whereIn('user_id', $user_descendants)
            ->where('rank', 1)
            ->whereNotNull('activated_at')
            ->oldest()
            ->limit(5)
            ->get();

        $first_rankers_user_id = $first_rankers->pluck('user_id')->toArray();

        $investments_of_first_rankers = PurchasedPackage::whereIn('user_id', $first_rankers_user_id)
            ->pluck('invested_amount', 'user_id')
            ->toArray();

        $rank_unlocked_investments_of_first_rankers = $first_rankers->mapWithKeys(
            function ($rank) {
                return [$rank->user_id => $rank->completed_requirements['rank_unlocked']['cumulative_investment_of_direct_sales']];
            });

        $completed_requirements = [
            'rank_one_rankers_count' => $rank_one_rankers,
            'cumulative_investments_of_rank_one_descendants' => $investments_of_first_rankers,
            'rank_unlocked' => [
                'descendants_count' => count($first_rankers),
                'cumulative_investments_of_rank_one_descendants' => $rank_unlocked_investments_of_first_rankers
            ],
        ];

        $rank = Rank::firstOrCreate([
            'user_id' => $this->user->id,
            'rank' => 2
        ]);

        $qualified = false;
        if ($rank_one_rankers >= 5) {
            $rank->update(['activated_at' => Carbon::now()]);
            $qualified = true;
        }

        if (!$qualified) {
            $rank->update(['activated_at' => null]);
        }

        $rank->update(compact('completed_requirements'));

        if ($qualified) {
            $rank_two_user = $this->user;
            for ($i = 1; $i <= 4; $i++) {
                $parent_user = $rank_two_user->sponsor;
                if ($parent_user->id === null) {
                    break;
                }
                UserRankThreeListener::dispatch($parent_user, $this->requirements)->onConnection('sync');
                $rank_two_user = $parent_user;
            }
        }
    }
}
