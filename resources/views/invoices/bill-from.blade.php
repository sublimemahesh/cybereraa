<td class="px-0">
    <p class="seller-name">
        <strong>{{ $invoice->sender->name }}</strong>
    </p>
    <p class="seller-address">
        Email: {{ $invoice->sender->address }}
    </p>
    @if(isset($invoice->sender->postal_code))
        <p class="seller-code">
            Address: {{ $invoice->sender->postal_code }}
        </p>
    @endif
    {{--<p class="seller-phone">
        Phone: {{ $invoice->sender->phone }}
    </p>
    @if(isset($invoice->sender->registration_number))
        <p class="seller-vat">
            Registration number: {{ $invoice->sender->registration_number }}
        </p>
    @endif
    @if(isset($invoice->sender->vat_number))
        <p class="seller-vat">
            VAT number: {{ $invoice->sender->vat_number }}
        </p>
    @endif--}}

</td>
