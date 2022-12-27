<?php

namespace App\Jobs;

use App\Models\Earning;
use App\Models\PurchasedPackage;
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
                    $purchase->update(['last_earned_at' => $this->execution_time]);
                    $earnings = $purchase->earnings()->save(Earning::forceCreate([
                        'user_id' => $purchase->user_id,
                        'amount' => $purchase->invested_amount * ($purchase->payable_percentage / 100),
                        'type' => 'PACKAGE',
                        'status' => 'RECEIVED', // TODO: check eligibility for the gain profit
                        'created_at' => $this->execution_time,
                        'updated_at' => $this->execution_time
                    ]));
                    logger()->info("Earning saved");
                } else {
                    logger()->error("Already earned!");
                }
            });
        } catch (\Throwable $e) {
            logger()->error($e->getMessage());
        }

    }
}
