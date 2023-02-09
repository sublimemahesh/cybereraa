<?php

namespace App\Console\Commands;

use App\Jobs\SendPaymentReminderEmailJob;
use App\Mail\PaymentReminderMail;
use App\Models\User;
use Carbon;
use Illuminate\Console\Command;
use Mail;
use Symfony\Component\Console\Command\Command as CommandAlias;

class PaymentReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Sending email notifications to unpaid users after 1 day of registration";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        logger()->notice("remind:payment started");
        $this->info('Sending email notifications to unpaid users after 1 day of registration');

        $weekStartDate = Carbon::now()->subDays(8)->format('Y-m-d 00:00:00');
        $weekEndDate = Carbon::now()->subDays(2)->format('Y-m-d 23:59:59');

        logger()->notice("Follow up mail date period: " . $weekStartDate . ' - ' . $weekEndDate);

        User::whereBetween('created_at', [$weekStartDate, $weekEndDate])
            ->doesntHave('purchasedPackages', callback: function ($q) {
                $q->whereIn('status', ['ACTIVE', 'EXPIRED']);
            })->chunk(100, function ($users) {
                foreach ($users as $user) {
                    $this->info("Sending notification to: " . $user->email . "...");
                    Mail::to($user->email)->send(new PaymentReminderMail(user: $user, title: 'Hellow Dear ' . $user->username));
                }
            });
        logger()->notice("remind:payment finished");
        $this->info('Sending email notifications finished..');
        return CommandAlias::SUCCESS;
    }
}
