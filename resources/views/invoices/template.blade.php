<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $invoice->title }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style media="screen">
        .body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
            font-size: 12px;
            margin: 36pt;
        }

        h4 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        strong {
            font-weight: bolder;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        table {
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
        }

        h4,
        .h4 {
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
        }

        h4,
        .h4 {
            font-size: 1.5rem;
        }

        .invoice-container {
            width: 75%;
            margin: auto;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
        }

        .table.table-items td {
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .pr-0,
        .px-0 {
            padding-right: 0 !important;
        }

        .pl-0,
        .px-0 {
            padding-left: 0 !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        .party-header {
            font-size: 1.5rem;
            font-weight: 400;
        }

        .total-amount {
            font-size: 12px;
            font-weight: 700;
        }

        .border-0 {
            border: none !important;
        }

        .cool-gray {
            color: #6B7280;
        }
    </style>
</head>

<body>
@if (!empty($invoice->id))
    <div class="body invoice-container" style="width:100%">
        {{-- Header --}}
        <table class="table ">
            <tbody>
            <tr>
                <td>
                    <img src="{{ $invoice->logo }}" alt="logo" height="50">
                </td>
                <td>
                    <div style="width:100%; display:flex;justify-content: end;align-items: end">
                        <img style="float:right" src="{{ $invoice->site_qr }}" height="50" alt="https://www.cybereraa.com">
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="table mt-5">
            <tbody>
            <tr>
                <td class="border-0 pl-0" width="52%">
                    <h4 class="text-uppercase">
                        <strong>INVOICE</strong>
                    </h4>
                </td>
                <td class="border-0 pl-0">
                    <h4 class="text-uppercase cool-gray">
                        <strong>STATUS: {{ $invoice->status }}</strong>
                    </h4>
                    <p>Invoice number: #<strong>{{ str_pad($invoice->id, 5, 0, STR_PAD_LEFT) }}</strong></p>
                    <p>Serial number: <strong>{{ $invoice->serial }}</strong></p>
                    <p>Pay Method: <strong>{{ strtoupper($invoice->method) ?? '-' }}</strong></p>
                    @if(isset($invoice->product_type))
                        <p>Product Type: <strong>{{ $invoice->product_type }}</strong></p>
                    @endif
                    <p>Date: <strong>{{ $invoice->created_at }}</strong></p>
                </td>
            </tr>
            </tbody>
        </table>
        {{-- Seller - Buyer --}}
        <table class="table">
            <thead>
            <tr>
                <th class="border-0 pl-0 party-header" width="48.5%">
                    Bill From
                </th>
                <th class="border-0" width="3%"></th>
                <th class="border-0 pl-0 party-header">
                    Bill To
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                @include('invoices.bill-from')
                <td class="border-0"></td>
                @include('invoices.bill-to')
            </tr>
            </tbody>
        </table>
        {{-- Table --}}
        <table class="table table-items">
            <thead>
            <tr>
                <th scope="col" class="border-0 pl-0">Description</th>
                <th scope="col" class="text-right border-0">Amount</th>
                <th scope="col" class="text-right border-0">
                    @if(!empty($invoice->fee))
                        {{ !in_array($invoice->method, ['P2P', 'MANUAL', 'BINANCE'], true) ? 'Gas' : '' }} Fee
                    @endif
                </th>
                <th scope="col" class="text-right border-0">Sub total</th>
            </tr>
            </thead>
            <tbody>
            {{-- Items --}}
            @include('invoices.items')
            </tbody>
        </table>
        @if($invoice?->note)
            <p> NOTES: {{ $invoice->note }}</p>
        @endif
        @if(isset($invoice->terms))
            {!! $invoice?->terms !!}
        @endif
    </div>
@else
    <div class="body invoice-container">
        Invoice not found.
    </div>
@endif
</body>
</html>
