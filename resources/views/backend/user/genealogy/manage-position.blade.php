<x-backend.layouts.app>
    @section('title', 'Manage Genealogy')
    @section('header-title', 'Manage Genealogy' )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/genealogy.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('user.genealogy', $parent) }}">Genealogy</a>
        </li>
        <li class="breadcrumb-item active">Manage New Position</li>
    @endsection

    <div class="row">
        <div class="col-xl-4  col-lg-6 col-sm-6">
            <div class="widget-stat card">
                <div class="card-body p-3 d-flex">
                    <div class="media ai-icon">
                        <span class="me-3 bgl-primary text-primary">
                            <i class="ti-user"></i>
                        </span>
                        <div class="media-body">
                            <p class="mb-1">Your Total Direct Users ({{ Auth::user()->username }})</p>
                            <h4 class="mb-0">{{ $loggedUser->direct_sales_count }}</h4>
                            <span><code>Pending: {{ $loggedUser->pending_direct_sales_count }} </code> </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4  col-lg-6 col-sm-6">
            <div class="widget-stat card">
                <div class="card-body p-3 d-flex">
                    <div class="media ai-icon">
                        <span class="me-3 bgl-warning text-warning">
                            <i class="ti-plug"></i>
                        </span>
                        <div class="media-body">
                            <p class="mb-1">Selected Position Number</p>
                            <h4 class="mb-0">{{ $position }}</h4>
                            <span><code>Tree Depth: {{ $parent->depth }}</code> </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4  col-lg-6 col-sm-6">
            <div class="widget-stat card bg-secondary">
                <div class="card-body p-3 d-flex">
                    <div class="media">
                        <span class="me-3">
                            <i class="la la-graduation-cap"></i>
                        </span>
                        <div class="media-body text-white">
                            <p class="mb-1">Available Spaces ({{ $parent->username }})</p>
                            <h3 class="text-white">{{ $available_spaces }}</h3>
                            <div class="progress mb-2 bg-primary">
                                <div class="progress-bar progress-animated bg-white" style="width: {{ $available_percentage }}%"></div>
                            </div>
                            <small>{{ $available_spaces }} spaces are available (<code>Used:</code> {{ 100 - $available_percentage }}%)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">Assign position</h4>
                        <p>
                            Select User to assign position <code>{{ $position }}</code> of user
                            <code>{{ $parent->username }} - {{ $parent->name }}</code>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <form>
                                <div class="mb-3 mt-2">
                                    <label for="assign-position">Pending Users</label>
                                    <select class="single-select-placeholder js-states select2-hidden-accessible" id="assign-position">
                                        <option></option>
                                        @foreach($pendingUsers as $dUser)
                                            <option value="{{ $dUser->id }}">{{ $dUser->username }} - {{ $dUser->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" id="confirm-assign" class="btn btn-sm btn-success mb-2">Confirm & Assign</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/genealogy/assign-position.js') }}"></script>
    @endpush
</x-backend.layouts.app>