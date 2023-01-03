<?php

namespace App\Jobs;

use App\Models\Commission;
use App\Models\PurchasedPackage;
use App\Models\Strategy;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use JsonException;

class SaleLevelCommissionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private PurchasedPackage $package;

    private User $purchasedUser;

    private mixed $strategies;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $purchasedUser, PurchasedPackage $package)
    {
        $this->purchasedUser = $purchasedUser;
        $this->package = $package;
        $this->strategies = Strategy::whereIn('name', ['commissions', 'commission_level_count', 'max_withdraw_limit'])->get();
    }

    public function middleware()
    {
        return [(new WithoutOverlapping($this->package->id))->releaseAfter(60)];
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws JsonException
     */
    public function handle()
    {
        $purchasedUser = $this->purchasedUser;
        $package = $this->package;
        $strategies = $this->strategies;

        $commissions = $strategies->where('name', 'commissions')->first(null, new Strategy(['value' => '{"1":25,"2":20,"3":15,"4":10,"5":5,"6":5,"7":5}']));
        $commissions = json_decode($commissions->value, true, 512, JSON_THROW_ON_ERROR);

        $commission_start_at = 1;
        if ($purchasedUser->super_parent_id !== null) {
            Commission::forceCreate([
                'user_id' => $purchasedUser->super_parent_id,
                'purchased_package_id' => $package->id,
                'amount' => ($package->invested_amount * $commissions[$commission_start_at]) / 100,
                'paid' => 0,
                'type' => 'DIRECT',
                'status' => $purchasedUser->sponsor->is_active ? 'QUALIFIED' : 'DISQUALIFIED'
            ]);
            //TODO: Send EMAIL Notification
        }

        if ($purchasedUser->parent_id !== null) {
            $commission_level_strategy = $strategies->where('name', 'commission_level_count')->first(null, new Strategy(['value' => 7]));
            $commission_level = (int)$commission_level_strategy->value;
            $commission_start_at = 2;

            $commission_level_user = $purchasedUser->parent;
            for ($i = $commission_start_at; $i <= $commission_level; $i++) {
                Commission::forceCreate([
                    'user_id' => $commission_level_user->id,
                    'purchased_package_id' => $package->id,
                    'amount' => ($package->invested_amount * $commissions[$i]) / 100,
                    'paid' => 0,
                    'type' => 'INDIRECT',
                    'status' => $commission_level_user->is_active ? 'QUALIFIED' : 'DISQUALIFIED'
                ]);
                if ($commission_level_user->parent_id === null) {
                    break;
                }
                $commission_level_user = $commission_level_user->parent;
            }
        }

        $package->update(['commission_issued_at' => now()]);

    }
}
