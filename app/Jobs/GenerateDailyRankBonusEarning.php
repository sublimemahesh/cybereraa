<?php

namespace App\Jobs;

use App\Models\Earning;
use App\Models\RankBenefit;
use App\Models\Strategy;
use App\Models\Wallet;
use Carbon\Carbon;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class GenerateDailyRankBonusEarning implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private RankBenefit $benefit;
    private Carbon|null $execution_time;

    public function __construct(RankBenefit $benefit, $execution_time = null)
    {
        $this->benefit = $benefit;
        $this->execution_time = $execution_time ?? now();
    }

    public function middleware(): array
    {
        return [(new WithoutOverlapping($this->benefit->id))->releaseAfter(60)];
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
                $earned = $this->benefit->earnings()->whereDate('created_at', date('Y-m-d'))->doesntExist();

                if ($earned) {
                    $commission_type = strtolower($this->benefit->type);
                    $payable_percentages = Strategy::where('name', "payable_percentages")->firstOr(fn() => new Strategy(['value' => '{"direct":0.332,"indirect":0.332,"rank_bonus":0.332}']));
                    $payable_percentages = json_decode($payable_percentages->value, true, 512, JSON_THROW_ON_ERROR);
                    $payable_percentage = $payable_percentages[$commission_type] ?? (1 / 300) * 100;

                    $this->benefit->loadSum('earnings', 'amount');
                    $already_earned_amount = $this->benefit->earnings_sum_amount;

                    $today_amount = $this->benefit->amount * ($payable_percentage / 100);

                    if ($this->benefit->amount < ($already_earned_amount + $today_amount)) {
                        $today_amount = $this->benefit->amount - $already_earned_amount;
                        $this->benefit->update(['status' => 'COMPLETED']);
                        logger()->info("Benefit: {$this->benefit->id} | COMPLETED {$today_amount}");
                    }

                    if ($today_amount > 0) {
                        $this->benefit->earnings()->save(Earning::forceCreate([
                            'user_id' => $this->benefit->user_id,
                            'amount' => $today_amount,
                            'type' => $this->benefit->type,
                            'status' => $this->benefit->status === 'QUALIFIED' ? 'RECEIVED' : 'CANCELED', // TODO: check eligibility for the gain profit
                            'created_at' => $this->execution_time,
                            'updated_at' => $this->execution_time
                        ]));

                        $this->benefit->update(['last_earned_at' => $this->execution_time]);
                        $this->benefit->increment('paid', $today_amount);

                        $wallet = Wallet::firstOrCreate(
                            ['user_id' => $this->benefit->user_id],
                            ['balance' => 0]
                        );

                        $wallet->increment('balance', $today_amount);
                    }

                    logger()->notice("Benefit: {$this->benefit->id} | Earning saved (" . date('Y-m-d') . ")");
                } else {
                    logger()->warning("Benefit: {$this->benefit->id} | Already earned! (" . date('Y-m-d') . ")");
                }
            });
        } catch (\Throwable $e) {
            logger()->error("Benefit: {$this->benefit->id} | " . $e->getMessage());
        }
    }
}
