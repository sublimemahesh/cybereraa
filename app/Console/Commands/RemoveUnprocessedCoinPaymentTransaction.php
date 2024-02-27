<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Carbon;
use DB;
use Illuminate\Console\Command;
use Log;
use Symfony\Component\Console\Command\Command as CommandAlias;

class RemoveUnprocessedCoinPaymentTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinpayment:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove unprocessed coin payment transaction';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting coinpayment transaction remove check');

        $timestampThreshold = Carbon::now()->subHours(2)->subMinutes(30);

        Log::channel('coinpayment')->notice("coinpayment:remove started | timestampThreshold: {$timestampThreshold}");

        Transaction::where('pay_method', 'COIN_PAYMENT')
            ->where('status', 'PENDING')
            ->where('created_at', '<', $timestampThreshold)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('coinpayment_transactions')
                    ->whereColumn('coinpayment_transactions.order_id', 'transactions.id');
            })
            ->chunkById(100, function ($transactions) {
                foreach ($transactions as $transaction) {

                    Log::channel('coinpayment')->notice("Deleting transactions: {$transaction->id}");
                    $this->info("Deleting transactions: {$transaction->id}");

                    $transaction->delete();
                }
            });

        Log::channel('coinpayment')->notice('Finished coinpayment transaction remove check');

        $this->info('Finished coinpayment transaction remove check');
        return CommandAlias::SUCCESS;
    }
}
