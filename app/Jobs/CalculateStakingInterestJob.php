<?php

namespace App\Jobs;

use App\Models\Earning;
use App\Models\PurchasedStakingPlan;
use App\Models\Wallet;
use Carbon\Carbon;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class CalculateStakingInterestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private PurchasedStakingPlan $purchase;
    private Carbon $execution_time;

    public function __construct(PurchasedStakingPlan $purchase, Carbon|null $execution_time)
    {
        $this->purchase = $purchase;
        $this->execution_time = $execution_time ?? now();
    }

    public function middleware()
    {
        return [(new WithoutOverlapping($this->purchase->id))->releaseAfter(60)];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->calculateInterest($this->purchase);
    }

    private function calculateInterest(PurchasedStakingPlan $purchase): void
    {

        try {
            DB::transaction(function () use ($purchase) {
                $earned = $purchase->earnings()
                    ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                    ->doesntExist();

                if ($earned) {

                    $interest = $purchase->invested_amount * ($purchase->interest_rate / 100);
                    $total_amount = $purchase->invested_amount + $interest;

                    if ($total_amount > 0) {
                        $purchase->earnings()->save(Earning::forceCreate([
                            'user_id' => $purchase->user_id,
                            'amount' => $total_amount,
                            'type' => 'STAKING',
                            'status' => 'RECEIVED', // TODO: check eligibility for the gain profit
                            'created_at' => $this->execution_time,
                            'updated_at' => $this->execution_time
                        ]));

                        $wallet = Wallet::firstOrCreate(
                            ['user_id' => $purchase->user_id],
                            ['staking_balance' => 0]
                        );

                        $wallet->increment('balance', $total_amount);

                        $purchase->update([
                            'status' => 'EXPIRED'
                        ]);

                        // TODO: send notification
                    }

                    logger()?->info("PURCHASED STAKING PLAN {$purchase->id} | COMPLETED {$total_amount}. | Purchased Date: " . $purchase->created_at . " | User: " . $purchase->user->username . "-" . $purchase->user_id);

                } else {
                    logger()?->warning("PURCHASED STAKING PLAN Already earned! (" . date('Y-m-d') . "). | Package: " . $purchase->id . " Purchased Date: " . $purchase->created_at . " | User: " . $purchase->user->username . "-" . $purchase->user_id);
                }
            });
        } catch (\Throwable $e) {
            logger()?->error($e->getMessage() . " | Package: " . $purchase->id . " Purchased Date: " . $purchase->created_at . " | User: " . $purchase->user->username . "-" . $purchase->user_id);
        }

    }
}
