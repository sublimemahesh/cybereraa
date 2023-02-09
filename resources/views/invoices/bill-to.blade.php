<td class="px-0">
    <p class="buyer-name">
        <strong>{{ $invoice->receiver->name }}</strong>
    </p>
    <p class="buyer-address">
        Email: {{ $invoice->receiver->address }}
    </p>
    <p class="buyer-code">
        Address: {{ $invoice->receiver->postal_code }}
    </p>
    <p class="buyer-phone">
        Phone: {{ $invoice->receiver->phone }}
    </p>
    {{-- <p class="buyer-custom-field">
    {{ ucfirst($key) }}: {{ $value }}
 </p> --}}
</td>
