<x-backend.layouts.app>
    @section('title', 'My Genealogy')
    @section('header-title', 'My Genealogy' )
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/genealogy.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/clipboard.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">Genealogy</li>
    @endsection

    <div class="row">
        <div class="col-sm-12 d-flex justify-content-center">
            <div class="input-group mb-3 w-75 input-primary">
                <input type="text" readonly class="form-control" id="clipboard-input" value="{{ Auth::user()->referral_link }}">
                <span class="input-group-text border-0 clipboard-tooltip" onclick="myFunction()" onmouseout="outFunc()">
                    <span class="tooltip-text" id="clipboard-tooltip">Copy to clipboard</span>
                    Copy Link
                </span>
            </div>
        </div>
        <div class="col-sm-12">
            @if(!is_null($user->parent))
                <div class="d-flex justify-content-center">
                    <a href="{{ route('user.genealogy', !is_null($user->parent->parent_id) ? $user->parent : null) }}">
                        <i class="fas fa-arrow-up fs-2"></i>
                    </a>
                </div>
            @endif
            <div class="tree">
                <ul>
                    <li>
                        <a href="javascript:void(0)">
                            <img class="rounded-circle" width="35" src="{{ $user->profile_photo_url }}" alt="">
                            <div class="mt-2">{{ $user->username }}</div>
                        </a>
                        <ul>
                            @for($i = 1; $i <= 5; $i++)
                                <li class="position-{{ $i }}">
                                    @if(isset($descendants[$i]))
                                        @php
                                            $descendant = $descendants[$i];
                                        @endphp
                                        <a href="{{ route('user.genealogy', $descendant) }}">
                                            <img class="rounded-circle" width="35" src="{{ $descendant->profile_photo_url }}" alt="">
                                            <div class="mt-2">{{ $descendant->username }}</div>
                                        </a>
                                    @else
                                        <a href="{{ URL::signedRoute('user.genealogy.position.manage', ['parent' => $user, 'position' => $i]) }}">
                                            <i class="fa fa-plus"></i>
                                            Empty
                                        </a>
                                    @endif
                                </li>
                            @endfor
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @push('scripts')

        <script>
            function myFunction() {
                var copyText = document.getElementById("clipboard-input");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.value);

                var tooltip = document.getElementById("clipboard-tooltip");
                tooltip.innerHTML = "Copied: " + copyText.value;
            }

            function outFunc() {
                var tooltip = document.getElementById("clipboard-tooltip");
                tooltip.innerHTML = "Copy to clipboard";
            }
        </script>
    @endpush
</x-backend.layouts.app>