<?php

namespace App\Console\Commands;

use App\Mail\InactiveUserDeleted;
use App\Models\User;
use Illuminate\Console\Command;
use Log;
use Mail;
use Symfony\Component\Console\Command\Command as CommandAlias;

class RemoveInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:inactive-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove users who have not purchased any packages within 3 days after registration.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cutoffDate = now()->subDays(30);
        Log::channel('daily')->notice("remove:inactive-users cutoff date: {$cutoffDate}");

        // Use chunking to process a large number of records in smaller batches
        User::whereRelation('roles', 'name', 'user')
            ->whereDoesntHave('purchasedPackages')
            ->where('created_at', '<', $cutoffDate)
            ->chunk(200, function ($users) {
                $this->info('Inactive users remove starts.');
                foreach ($users as $user) {

                    Log::channel('daily')->info("User #{$user->id} removed due to inactivity.", $user->toArray());

                    // Send an email notification
                    Mail::to($user->email)->send(new InactiveUserDeleted($user->toArray()));

                    $user->teams()->detach();
                    $user->deleteProfilePhoto();
                    $user->tokens->each->delete();
                    $user->profile()->forceDelete();
                    $user->forceDelete();

                    $this->info("User #{$user->id} removed due to inactivity.");
                }

                $this->info('Inactive users remove finished.');
            });

        $this->info('Inactive users removed successfully.');
        return CommandAlias::SUCCESS;
    }

}
