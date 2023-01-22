<x-backend.layouts.app>
    @section('title', 'Rank Gift Issue')
    @section('header-title', 'Confirmation of Gift Issue')
    @section('plugin-styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Issue Gift</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form class="theme-form" enctype="multipart/form-data" id="issue-gift-form">
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
                                <br/>
                                <hr/>
                                User ID: <code>{{ $gift->user_id }}</code> | Username:
                                <code>{{ $gift->user->username }}</code>
                                <br/>
                                <hr/>
                                Please note this <code class="text-uppercase">process cannot be reversed</code>.
                                <hr/>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group row mb-2">
                                    <label class="col-sm-3 col-form-label" for="issued-gift">Gift Image</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="file" name='issued-gift' id='issued-gift'>
                                        <input type="hidden" name="gift" id="gift" value="{{ $gift->id }}>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="issue" wire:loading.remove>Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script !src="">
            const GIFT = "{{ $gift->id }}";
        </script>
        <script src="{{ asset('assets/backend/js/admin/ranks/gift-issue.js') }}"></script>
    @endpush
</x-backend.layouts.app>
