<?php

namespace App\Jobs;

use App\Models\Earning;
use App\Models\PurchasedPackage;
use App\Models\Wallet;
use Carbon\Carbon;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class GenerateUserDailyEarning implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private PurchasedPackage $purchase;
    private ?Carbon $execution_time;

    public function __construct(PurchasedPackage $purchase, $execution_time = null)
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
        $this->calculateProfit($this->purchase);
    }

    private function calculateProfit(PurchasedPackage $purchase): void
    {

        try {
            DB::transaction(function () use ($purchase) {
                $earned = $purchase->earnings()->whereDate('created_at', date('Y-m-d'))->doesntExist();
                // $earned = Earning::where('purchased_package_id', $purchase->id)->whereDate('created_at', date('Y-m-d'))->doesntExist();
                if ($earned) {
                    $purchase->loadSum('earnings', 'amount');
                    $already_earned_amount = $purchase->earnings_sum_amount;

                    $earned_amount = $purchase->invested_amount * ($purchase->payable_percentage / 100);

                    $allowed_amount = ($purchase->invested_amount * 300) / 100;

                    if ($allowed_amount < ($already_earned_amount + $earned_amount)) {
                        $earned_amount = $allowed_amount - $already_earned_amount;
                        $purchase->update(['status' => 'EXPIRED']);
                        logger()->info("Package {$purchase->id} | COMPLETED {$earned_amount}");
                    }

                    if ($earned_amount > 0) {
                        $purchase->earnings()->save(Earning::forceCreate([
                            'user_id' => $purchase->user_id,
                            'amount' => $earned_amount,
                            'type' => 'PACKAGE',
                            'status' => 'RECEIVED', // TODO: check eligibility for the gain profit
                            'created_at' => $this->execution_time,
                            'updated_at' => $this->execution_time
                        ]));

                        $purchase->update(['last_earned_at' => $this->execution_time]);

                        $wallet = Wallet::firstOrCreate(
                            ['user_id' => $purchase->user_id],
                            ['balance' => 0]
                        );

                        $wallet->increment('balance', $earned_amount);

                    }
                    //Wallet::updateOrCreate(['user_id' => $purchase->user_id]);
                    logger()->notice("Purchased Package Earning saved (" . date('Y-m-d') . ")");
                } else {
                    logger()->warning("Purchased Package Already earned! (" . date('Y-m-d') . ")");
                }
            });
        } catch (\Throwable $e) {
            logger()->error($e->getMessage());
        }

    }
}
