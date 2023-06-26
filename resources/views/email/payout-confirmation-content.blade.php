<p>Dear {{ $user->username }}, </p>
<p>
    I am pleased to inform you that your recent withdrawal request has been approved by the administration team.
    The amount you requested will be transferred to your account within {{ Carbon\Carbon::now() }}.
</p>

<p>
    <b>
        Please find below the details of your transaction:
    </b>
</p>
<p>
    Transaction Amount: USDT {{ number_format($withdraw->amount,2) }} <br>
    Transaction Date: {{ Carbon\Carbon::parse($withdraw->approved_at)->format('Y-m-d H:i:s') }} <br>
    Transaction ID: #{{ str_pad($withdraw->id, 4, 0, STR_PAD_LEFT) }}
</p>

<p>
    If you have any questions or concerns regarding this transaction, please do not hesitate to contact us.
    We will be happy to assist you in any way we can.
</p>

<p>
    Thank you for choosing our service.
</p>

Best regards, <br>
owara3m.com
