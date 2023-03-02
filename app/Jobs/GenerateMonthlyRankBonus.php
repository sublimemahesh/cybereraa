<?php

namespace App\Jobs;

use App\Models\Rank;
use App\Models\RankBenefit;
use App\Models\Wallet;
use Carbon\Carbon;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class GenerateMonthlyRankBonus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Rank $rank;
    private float $amount;

    public function __construct(Rank $rank, float $amount)
    {
        $this->rank = $rank;
        $this->amount = $amount;
    }

    public function middleware(): array
    {
        return [(new WithoutOverlapping($this->rank->id))->releaseAfter(60)];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            DB::transaction(function () {
                $earned = $this->rank->benefits()
                    ->whereMonth('bonus_date', Carbon::now()->subMonth()->format('m'))
                    ->whereYear('bonus_date', Carbon::now()->subMonth()->format('Y'))
                    ->doesntExist();
                if ($earned) {
                    $benefit = RankBenefit::forceCreate([
                        'user_id' => $this->rank->user_id,
                        'rank_id' => $this->rank->id,
                        'amount' => $this->amount,
                        'paid' => 0,
                        'type' => 'RANK_BONUS',
                        'status' => 'QUALIFIED',
                        'bonus_date' => Carbon::now()->subMonth()->format('Y-m-d')
                    ]);

                    $wallet = Wallet::firstOrCreate(
                        ['user_id' => $benefit->user_id],
                        ['balance' => 0]
                    );
                    $wallet->increment('topup_balance', $benefit->amount);
                    $benefit->update(['paid' => $benefit->amount]);

                    logger()->notice("Rank: {$this->rank->id} | Rank Bonus saved (" . date('Y-m-d') . ")");
                } else {
                    logger()->warning("Rank: {$this->rank->id} | Rank Bonus Already earned! (" . date('Y-m-d') . ")");
                }
            });
        } catch (\Throwable $e) {
            logger()->error("Rank: {$this->rank->id} | " . $e->getMessage());
        }
    }
}
