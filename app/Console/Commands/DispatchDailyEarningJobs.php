<?php

namespace App\Console\Commands;

use App\Jobs\GenerateUserDailyEarning;
use App\Models\PurchasedPackage;
use App\Models\Strategy;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Validator;

class DispatchDailyEarningJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:profit {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch the jobs for, Calculate the daily profit for the purchased active packages to all users!';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $date = $this->argument('date');
        $this->info($date);
        $validator = Validator::make(compact('date'), [
            'date' => ['nullable', 'date', 'date_format:Y-m-d'],
        ]);
        if ($validator->fails()) {
            $this->warn('Given date is not valid');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return CommandAlias::FAILURE;
        }

        Log::channel('daily')->notice("calculate:profit started for ({$date}) at: " . Carbon::now());

        // Retrieve all users with purchased packages
//        $today = Carbon::today();
        if ($date === null) {
            $date = date('Y-m-d');
        }

        $execute_date = Carbon::parse($date);

//        $this->info("{$date} {$execute_date}");
//        return CommandAlias::SUCCESS;

        if (!$execute_date->isWeekend()) {
            $investment_start_at = Strategy::where('name', 'investment_start_at')->firstOr(fn() => new Strategy(['value' => 2]));
//            Log::channel('daily')->notice("calculate:profit package earning starts at: `created_at` + INTERVAL {$investment_start_at->value} DAY <= NOW()");
            $activePackages = PurchasedPackage::with('user')
                ->where('status', 'ACTIVE')
                ->where('is_free_package', 0)
                ->whereRaw("DATE(`created_at`) + INTERVAL {$investment_start_at->value} DAY <= '{$date}'")  // after 5 days from package purchase
//                ->where(function (Builder $query) {
//                    $query->whereRaw(
//                        "(WEEKDAY(`created_at`) IN (1,2,3,4) AND DATE(`created_at`) + INTERVAL 6 DAY <= DATE('" . Carbon::now() . "')) OR
//                            (WEEKDAY(`created_at`) = 5 AND DATE(`created_at`) + INTERVAL 5 DAY <= DATE('" . Carbon::now() . "')) OR
//	                        (WEEKDAY(`created_at`) IN (0,6) AND DATE(`created_at`) + INTERVAL 4 DAY <= DATE('" . Carbon::now() . "'))"
//                    ) // after 5 days from package purchase
//                    ->orWhereDate('created_at', '<', '2023-02-01');
//                })
                //->where('expired_at', '>=', Carbon::now())
                ->whereDoesntHave('earnings', fn($query) => $query->whereDate('created_at', $date)->where('type', 'PACKAGE'))
                ->chunkById(100, function ($activePackages) use ($date) {
                    // Loop over each  active packages and calculate their profit
                    foreach ($activePackages as $package) {
                        // Set the desired execution time for the job
                        $executionTime = Carbon::parse($date . ' ' . $package->created_at->format('H:i:s'));

                        $this->info("{$executionTime} | Package: {$package->id} | User: {$package->user->username}");


                        if ($executionTime->isWeekend()) {
                            continue;
                        }
                        Log::channel('daily')->notice(
                            "calculate:profit jobs dispatching ({$date}). | " .
                            "Package: {$package->id} Purchased Date: {$package->created_at} | " .
                            "User: {$package->user->username}-{$package->user_id}");

                        GenerateUserDailyEarning::dispatch(purchase: $package, date: $date, execution_time: $executionTime)->afterCommit();

                        // TODO: uncomment if need to run exact time they purchased enable this
                        //GenerateUserDailyEarning::dispatch($package, $executionTime)->delay($executionTime)->afterCommit();
                    }
                });

            Log::channel('daily')->notice("calculate:profit Finished | Successfully dispatched GenerateUserDailyEarning jobs | END TIME: " . Carbon::now());
            $this->info('Successfully dispatched GenerateUserDailyEarning jobs.');
            return CommandAlias::SUCCESS;
        }
        Log::channel('daily')->notice("calculate:profit Finished | Today is not a week day | END TIME: " . Carbon::now());
        $this->warn('Today is not a week day.');
        return CommandAlias::FAILURE;
    }


}
