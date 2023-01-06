<tr>
    <td class="pl-0">
        {{ $invoice->title }}

        @if($invoice->description)
            <p class="cool-gray">{{ $invoice->description }}</p>
        @endif
    </td>
    <td class="text-right">
        USDT {{ $invoice->amount }}
    </td>
    <td class="text-right">
        @if(!empty($invoice->fee))
            USDT {{ $invoice->fee }}
        @endif
    </td>
    <td class="text-right">
        USDT {{ $invoice->amount + $invoice->fee }}
    </td>
</tr>

{{-- Summary --}}
<tr>
    <td colspan="3" class="text-right pl-0">Total amount</td>
    <td class="text-right total-amount">
        USDT {{ $invoice->amount + $invoice->fee }}
    </td>
</tr>