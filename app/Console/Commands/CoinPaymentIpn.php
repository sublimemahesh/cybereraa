<?php

namespace App\Console\Commands;

use Hexters\CoinPayment\CoinPayment;
use Illuminate\Console\Command;
use Log;
use Symfony\Component\Console\Command\Command as CommandAlias;

class CoinPaymentIpn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinpayment:ipn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute coinpayment orders without having to wait for the process from IPN';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::channel('daily')->notice('coinpayment:ipn Starting coinpayment check');
        $this->info('Starting coinpayment check');

        CoinPayment::gettransactions()->whereIn('status', [0, 1])
            ->chunkById(100, function ($transactions) {
                foreach ($transactions as $transaction) {

                    Log::channel('daily')->notice("coinpayment check: {$transaction->txn_id}");
                    $this->info("coinpayment check: {$transaction->txn_id}");

                    CoinPayment::getstatusbytxnid($transaction->txn_id);
                }
            });

        Log::channel('daily')->notice('Finished coinpayment check');
        $this->info('Finished coinpayment check');
        return CommandAlias::SUCCESS;
    }
}
