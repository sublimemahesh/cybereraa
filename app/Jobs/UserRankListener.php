<?php

namespace App\Jobs;

use App\Models\Rank;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserRankListener implements ShouldQueue
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
     * @throws \JsonException
     */
    public function handle()
    {
        \Log::channel('daily')->info("UserRankListener JOB Started");

        $user = $this->user;

        $rank = Rank::firstOrCreate([
            'user_id' => $user->id,
            'rank' => 1
        ]);

        $investment = $user->purchasedPackages()->sum('invested_amount');

        $directSales = $user->directSales()->pluck('id')->toArray();

        $countUsersInRange1 = User::whereIn('id', $directSales)
            ->whereHas('purchasedPackages', function ($query) {
                $query->where('invested_amount', '>=', 5000)
                    ->where('invested_amount', '<', 10000);
            })
            ->count();

        // Count of users who purchased packages with an amount of 10000 or higher
        $countUsersInRange2 = User::whereIn('id', $directSales)
            ->whereHas('purchasedPackages', function ($query) {
                $query->where('invested_amount', '>=', 10000);
            })
            ->count();

        $completed_requirements = [
            'investment' => $investment,
            '5000_sales' => $countUsersInRange1,
            '10000_sales' => $countUsersInRange2,
        ];

        \Log::channel('daily')->info("UserRankListener JOB | Requirements: {$user->username}", $this->requirements);
        \Log::channel('daily')->info("UserRankListener JOB | Achieved Requirements: {$user->username}", $completed_requirements);

        if ($investment >= $this->requirements['r1']['investment']) {
            if ($countUsersInRange1 >= $this->requirements['r1']['team']['5000'] || $countUsersInRange2 >= $this->requirements['r1']['team']['5000']) {
                $rank->update(['activated_at' => Carbon::now()]);
            }
        }
        $rank->update(['completed_requirements' => json_encode($completed_requirements, JSON_THROW_ON_ERROR)]);

        \Log::channel('daily')->info("UserRankListener JOB Finished: {$user->username}", $rank->toArray());
    }
}
