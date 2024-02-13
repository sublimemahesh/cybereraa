<?php

namespace App\Jobs;

use App\Actions\ActivateTransaction;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Throwable;

class CoinpaymentListener implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transaction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @param ActivateTransaction $activateTransaction
     * @return void
     * @throws Throwable
     */
    public function handle(ActivateTransaction $activateTransaction): void
    {

        /**
         * Handle your transaction here
         * the parameter is :
         *
         * address
         * amount
         * amountf
         * coin
         * confirms_needed
         * payment_address
         * qrcode_url
         * received
         * receivedf
         * recv_confirms
         * status
         * status_text
         * status_url
         * timeout
         * txn_id
         * type
         * payload
         * transaction_type --> value: new | old
         *
         * ----------------- PAYMENT STATUS -------------------
         * 0   : Waiting for buyer funds
         * 1   : Funds received and confirmed, sending to you shortly
         * 100 : Complete,
         * -1  : Cancelled / Timed Out
         *
         * ----------------------------------------------------
         *  You can use transaction_type to distinguish new transactions or old transactions
         * ----------------------------------------------------
         * Example
         *  $this->transaction['transaction_type']
         *  // out: new / old
         */
        Log::channel('daily')->info('CoinpaymentListener: ', $this->transaction);

        \DB::transaction(function () use ($activateTransaction) {
            $transaction = Transaction::withTrashed()->find($this->transaction['order_id']);

            if ($transaction->trashed()) {
                Log::channel('daily')->info("Transaction is trashed: {$transaction->id}");
                // Restore the soft deleted transaction
                $transaction->restore();
                Log::channel('daily')->info("Transaction {$transaction->id} has been restored.");
            }

            $res_data = json_decode($transaction->status_response ?? [], true, 512, JSON_THROW_ON_ERROR);

            if ((int)$this->transaction['status'] === 100 && $transaction->status === 'PENDING' && $transaction->pay_method === 'COIN_PAYMENT') {
                Log::channel('daily')->info("Transaction {$transaction->id} has been Approved.");

                $activateTransaction->execute($transaction);

                $res_data['bizStatus'] = 'PAY_SUCCESS';

                $transaction->update([
                    'status' => 'PAID',
                    'status_response' => json_encode($res_data, JSON_THROW_ON_ERROR),
                ]);
            }

            if ((int)$this->transaction['status'] === -1 && $transaction->status === 'PENDING' && $transaction->pay_method === 'COIN_PAYMENT') {
                Log::channel('daily')->warning("Transaction {$transaction->id} has been Declined.");

                $res_data['bizStatus'] = 'PAY_CLOSED';

                $transaction->update([
                    'status' => 'EXPIRED',
                    'status_response' => json_encode($res_data, JSON_THROW_ON_ERROR),
                ]);
            }
        });
    }
}
