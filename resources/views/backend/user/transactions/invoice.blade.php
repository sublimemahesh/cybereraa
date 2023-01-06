<x-backend.layouts.app>
    @section('title', 'Package Purchase Invoice')
    @section('header-title', 'Package Purchase | Invoice' )
    @section('plugin-styles')
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item active">View Invoice</li>
    @endsection
    <div class="row">
        <div class="col-sm-12">
            <iframe src="{{ URL::signedRoute('user.transactions.invoice.stream', $transaction) }}" style="border:0;width: 100%; height:100vh"></iframe>
        </div>
    </div>
</x-backend.layouts.app>