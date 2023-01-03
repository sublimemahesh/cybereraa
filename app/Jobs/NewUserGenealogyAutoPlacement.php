<?php

namespace App\Jobs;

use App\Models\User;
use Arr;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class NewUserGenealogyAutoPlacement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private User $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function middleware()
    {
        return [(new WithoutOverlapping($this->user->id))->releaseAfter(60)];
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
                if ($this->user->position !== null) {
                    logger()->warning("NewUserGenealogyAutoPlacement::class : user: " . $this->user->id . " | Position is already assigned");
                    return;
                }
                if ($this->user->super_parent_id === null) {
                    logger()->warning("NewUserGenealogyAutoPlacement::class : user: " . $this->user->id . " | Super Parent is not exist");
                    return;
                }
                $available_parent_id = User::findAvailableSubLevel($this->user->super_parent_id);
                if (empty($available_parent_id->id)) {
                    logger()->warning("NewUserGenealogyAutoPlacement::class : user: " . $this->user->id . " | No parent found with available nodes");
                    return;
                }
                $parent = User::find($available_parent_id->id);
                $filled__position = $parent->children->pluck('position')->toArray();
                $available__position = array_diff([1, 2, 3, 4, 5], $filled__position);
                sort($available__position);
                $available__position = Arr::first($available__position);

                $this->user->update(['parent_id' => $available_parent_id->id, 'position' => $available__position]);
                User::upgradeAncestorsRank($parent, 1);

                $pending_commission_purchased_packages = $this->user->activePackages()->whereNull('commission_issued_at')->get();
                foreach ($pending_commission_purchased_packages as $package) {
                    SaleLevelCommissionJob::dispatch($this->user, $package)->afterCommit();
                }

                logger()->notice("NewUserGenealogyAutoPlacement::class : user: " . $this->user->id . " | Position placement successful");
            });
        } catch (\Throwable $e) {
            logger()->error("NewUserGenealogyAutoPlacement::class : user: " . $this->user->id . " | " . $e->getMessage());
        }
    }
}
