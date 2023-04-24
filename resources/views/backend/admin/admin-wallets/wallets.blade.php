<x-backend.layouts.app>
    @section('title', 'Admin Wallets')
    @section('header-title', 'Admin Wallets' )
    @section('plugin-styles')
        <!-- Datatable -->
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Wallets</li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table display mb-1 table-responsive-my dt-responsive" style="table-layout: fixed">
                            <thead>
                            <tr>
                                <th class="fs-14"><strong>WALLET</strong></th>
                                <th class="fs-14"><strong>BALANCE</strong></th>
                                <th class="fs-14"><strong>UPDATED</strong></th>
                                <th class="fs-14"><strong>ACTIONS</strong></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admin_wallets as $wallet)
                                <tr>
                                    <td>{{ str_replace("_"," ",$wallet->wallet_type) }}</td>
                                    <td>USDT {{ number_format($wallet->balance,2) }}</td>
                                    <td>{{ $wallet->updated_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('admin.admin-wallet-withdraw',$wallet) }}" class="btn btn-xs btn-success sharp my-1 mr-1 shadow">
                                            <i class="fa fa-arrow-right-to-file"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-backend.layouts.app>
