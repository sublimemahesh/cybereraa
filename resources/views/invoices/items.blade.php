<tr>
    <td class="pl-0">
        {{ $invoice->title }}

        @if($invoice->description)
            <div class="cool-gray mb-0">{!! $invoice->description !!}</div>
        @endif
    </td>
    <td class="text-right">
        @if(in_array($invoice->method, ['P2P', 'MANUAL', 'BINANCE'], true))
            USDT {{ $invoice->amount + $invoice->fee }}
        @else
            USDT {{ $invoice->amount }}
        @endif
    </td>
    <td class="text-right">
        @if(!empty($invoice->fee))
            USDT {{ $invoice->fee }}
        @endif
    </td>
    <td class="text-right">
        @if(in_array($invoice->method, ['P2P', 'MANUAL', 'BINANCE'], true))
            USDT {{ $invoice->amount }}
        @else
            USDT {{ $invoice->amount + $invoice->fee }}
        @endif
    </td>
</tr>

{{-- Summary --}}
<tr>
    <td colspan="3" class="text-right pl-0">Total amount</td>
    <td class="text-right total-amount">
        @if(in_array($invoice->method, ['P2P', 'MANUAL', 'BINANCE'], true))
            USDT {{ $invoice->amount }}
        @else
            USDT {{ $invoice->amount + $invoice->fee }}
        @endif
    </td>
</tr>
