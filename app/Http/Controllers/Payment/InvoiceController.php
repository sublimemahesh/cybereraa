<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdraw;
use App\Traits\HasInvoice;
use Auth;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{
    use HasInvoice;

    public function showPurchaseInvoice(Transaction $transaction)
    {
        $loggedUser = Auth::user();
        abort_if($loggedUser->id !== $transaction->user_id && $loggedUser->id !== $transaction->purchaser_id, 404);
        return view('backend.user.transactions.invoice', compact('transaction'));
    }

    public function streamPurchaseInvoice(Transaction $transaction): Response
    {
        $invoice = $this->getPurchaseInvoice($transaction);
        $filename = 'invoice-' . $transaction->type . '-' . $transaction->id . '.pdf';
        $output = $this->render($invoice);
        return $this->stream($output, $filename);
    }

    public function showPayoutInvoice(Withdraw $withdraw)
    {
        return view('backend.user.withdrawals.invoice', compact('withdraw'));
    }

    public function streamPayoutInvoice(Withdraw $withdraw): Response
    {
        $invoice = $this->getPayoutInvoice($withdraw);
        $filename = 'invoice-' . $withdraw->type . '-' . $withdraw->id . '.pdf';
        $output = $this->render($invoice);
        return $this->stream($output, $filename);
    }

    private function getPurchaseInvoice(Transaction $trx): object
    {
        $loggedUser = Auth::user();
        $user = $trx->user;

        abort_if($loggedUser->id !== $trx->user_id && $loggedUser->id !== $trx->purchaser_id, 404);

        $invoice = [];

        $invoice['id'] = $trx->id;
        $invoice['status'] = $trx->status;
        $invoice['created_at'] = $trx->created_at;
        $invoice['title'] = $trx->create_order_request_info->goods->goodsName ?? '-';
        $invoice['amount'] = $trx->amount;
        $invoice['fee'] = $trx->tax;
        $invoice['method'] = $trx->type;
        if ($trx->type === 'crypto') {
            $invoice['serial'] = "#TRXC" . str_pad($trx->merchant_trade_no, 5, '0', STR_PAD_LEFT);
            $invoice['description'] = "Pay via Binance pay. BTRX: " . ($trx->transaction_id ?? '-');
        }
        if ($trx->type === 'wallet') {
            $invoice['serial'] = "#TRXW" . str_pad($trx->id, 5, '0', STR_PAD_LEFT);
            $invoice['description'] = "Pay via wallet";
        }

        $invoice['sender'] = (object)[
            'name' => 'SafestTrades.com',
            'registration_number' => 'XXXXXXXX',
            'vat_number' => 'XXXXXXXX',
            'address' => 'info@safesttrades.com',
            'email' => 'info@safesttrades.com',
            'postal_code' => '',
            'phone' => '+88 0123 4567 890',
        ];
        $invoice['receiver'] = (object)[
            'name' => $user->name,
            'address' => $user->email,
            'email' => $user->email,
            'postal_code' => '',
            'phone' => $user->phone,
        ];


        $invoice['note'] = 'Invested money back guarantee';
        $invoice['logo'] = $this->getLogo();

        return (object)$invoice;

    }

    private function getPayoutInvoice(Withdraw $withdraw): object
    {
        $loggedUser = Auth::user();
        $user = $withdraw->user;
        $receiver = $withdraw->receiver;
        $sender = new User;

        abort_if($loggedUser->id !== $user->id && $loggedUser->id !== $receiver->id, 404);

        $invoice = [];

        $invoice['id'] = $withdraw->id;
        $invoice['status'] = $withdraw->status;
        $invoice['created_at'] = $withdraw->created_at;
        $invoice['title'] = $withdraw->package_info_json->name;
        $invoice['amount'] = $withdraw->amount;
        $invoice['fee'] = $withdraw->transaction_fee;
        $invoice['serial'] = "#TRX" . str_pad($withdraw->id, 5, '0', STR_PAD_LEFT);

        if ($withdraw->type === 'P2P') {
            $sender = $user;

            $invoice['description'] = "TO {$receiver->username}";
            $invoice['sender'] = (object)[
                'name' => $sender->name,
                'address' => $sender->email,
                'email' => $sender->email,
                'postal_code' => '',
                'phone' => $sender->phone,
            ];
        }

        if ($withdraw->type === 'binance') {

            $receiver = $user;

            $invoice['description'] = "TO {$receiver->username}";
            $invoice['sender'] = (object)[
                'name' => 'SafestTrades.com',
                'registration_number' => 'XXXXXXXX',
                'vat_number' => 'XXXXXXXX',
                'address' => 'info@safesttrades.com',
                'email' => 'info@safesttrades.com',
                'postal_code' => '',
                'phone' => '+88 0123 4567 890',
            ];

        }

        $invoice['receiver'] = (object)[
            'name' => $receiver->name,
            'address' => $receiver->email,
            'email' => $receiver->email,
            'postal_code' => '',
            'phone' => $receiver->phone,
        ];


        $invoice['note'] = 'Payments are none refundable';
        $invoice['logo'] = $this->getLogo();

        return (object)$invoice;

    }

}
