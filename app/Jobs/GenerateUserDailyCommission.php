<?php

namespace App\Jobs;

use App\Models\Commission;
use App\Models\Earning;
use Carbon\Carbon;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class GenerateUserDailyCommission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Commission $commission;
    private ?Carbon $execution_time;

    public function __construct(Commission $commission, $execution_time = null)
    {
        $this->commission = $commission;
        $this->execution_time = $execution_time ?? now();
    }

    public function middleware(): array
    {
        return [(new WithoutOverlapping($this->commission->id))->releaseAfter(60)];
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
                $earned = $this->commission->earnings()->whereDate('created_at', date('Y-m-d'))->doesntExist();

                if ($earned) {
                    $this->commission->loadSum('earnings', 'amount');
                    $already_earned_amount = $this->commission->earnings_sum_amount;

                    $today_amount = $this->commission->amount * (optional($this->commission->purchasedPackage)->payable_percentage / 100);

                    if ($this->commission->amount < ($already_earned_amount + $today_amount)) {
                        $today_amount = $this->commission->amount - $already_earned_amount;
                        $this->commission->update(['status' => 'COMPLETED']);
                        logger()->info("Commission COMPLETED $today_amount");
                    }

                    if ($today_amount > 0) {
                        $earnings = $this->commission->earnings()->save(Earning::forceCreate([
                            'user_id' => $this->commission->user_id,
                            'amount' => $today_amount,
                            'type' => $this->commission->type,
                            'status' => $this->commission->status === 'QUALIFIED' ? 'RECEIVED' : 'CANCELED', // TODO: check eligibility for the gain profit
                            'created_at' => $this->execution_time,
                            'updated_at' => $this->execution_time
                        ]));

                        $this->commission->update(['last_earned_at' => $this->execution_time]);
                        $this->commission->increment('paid', $today_amount);
                    }

                    logger()->info("Commission Earning saved");
                } else {
                    logger()->error("Commission Already earned!");
                }
            });
        } catch (\Throwable $e) {
            logger()->error($e->getMessage());
        }
    }
}
