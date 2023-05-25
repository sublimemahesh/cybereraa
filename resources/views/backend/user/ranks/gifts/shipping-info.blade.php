<x-backend.layouts.app>
    @section('title', 'Rank Gift Shipping')
    @section('header-title', 'Collect Shipping Info')
    @section('plugin-styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Shipping Info</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form class="theme-form" enctype="multipart/form-data" id="shipping-form">
                        <div class="mb-4">
                            <h4 class="card-title">RANK: {{ $gift->rank->rank }}</h4>
                            <div class="mb-2">
                                Required Investment:<code>{{$gift->gift_requirement->total_investment}}</code>
                                <br/>
                                Required Team Investment:<code>{{$gift->gift_requirement->total_team_investment}}</code>
                                <br/>
                                <hr/>
                                Achieved Total Investment:<code>{{ number_format($gift->total_investment, 2) }}</code>
                                <br/>
                                Achieved total Team Investment:<code>{{ number_format($gift->total_team_investment, 2) }}</code>
                                <hr/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group row mb-2">
                                    <label class="col-sm-3 col-form-label" for="name">Name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" value="{{ $shippingInfo->name }}" type="text" name='name' id='name' placeholder="Enter Contact Name">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-sm-3 col-form-label" for="mobile_number">Mobile Number</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" value="{{ $shippingInfo->mobile_number }}" type="text" name='mobile_number' id='mobile_number' placeholder="Enter Contact Number">
                                    </div>
                                </div>
                                @if($gift->rank->rank === 1)
                                    <div class="form-group row mb-2">
                                        <label class="col-sm-3 col-form-label" for="shirt_size">Shirt Size</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="shirt_size" id="shirt_size">
                                                <option value="">Select Shirt Size</option>
                                                <option value="small" {{ $shippingInfo->shirt_size === 'small' ? 'selected' : '' }}>Small</option>
                                                <option value="medium" {{ $shippingInfo->shirt_size === 'medium' ? 'selected' : '' }}>Medium</option>
                                                <option value="large" {{ $shippingInfo->shirt_size === 'large' ? 'selected' : '' }}>Large</option>
                                                <option value="extra-large" {{ $shippingInfo->shirt_size === 'extra-large' ? 'selected' : '' }}>Extra Large</option>
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group row mb-2">
                                    <label class="col-sm-3 col-form-label" for="address">Shipping Address</label>
                                    <div class="col-sm-9">
                                        <textarea rows="3" placeholder="Enter Shipping Address" class="form-control h-auto" type="text" name='address' id='address'>{{ $shippingInfo->address }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="save" wire:loading.remove>Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/user/ranks/shipping-info.js') }}"></script>
    @endpush
</x-backend.layouts.app>
