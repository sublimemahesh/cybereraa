<x-backend.layouts.app>
    @section('title', 'My Genealogy')
    @section('header-title', 'My Genealogy')
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/genealogy.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/clipboard.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/main.css') }}">

    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">Genealogy</li>
    @endsection

    <div class="row">
        <div class="col-sm-12 d-flex justify-content-center">
            <div class="input-group mb-3 w-75 input-primary">
                <input type="text" readonly class="form-control" id="clipboard-input"
                    value="{{ Auth::user()->referral_link }}">
                <span class="input-group-text border-0 clipboard-tooltip" onclick="myFunction()" onmouseout="outFunc()">
                    <span class="tooltip-text" id="clipboard-tooltip">Copy to clipboard</span>
                    Copy Link
                </span>
            </div>
        </div>
        <div class="col-sm-12">
            @if (!is_null($user->parent))
                <div class="d-flex justify-content-center">
                    <a href="{{ route('user.genealogy', !is_null($user->parent->parent_id) ? $user->parent : null) }}">
                        <i class="fas fa-arrow-up fs-2"></i>
                    </a>
                </div>
            @endif
            <div class="tree">
                <ul>
                    <li>
                        {{-- <a href="javascript:void(0)">
                            <img class="rounded-circle" width="35" src="{{ $user->profile_photo_url }}"
                                alt="">
                            <div class="mt-2">{{ $user->username }}</div>
                        </a> --}}

                        <div class="genealogy">
                            <div class="card">
                                <div class="card-img"><img class="rounded-circle img-center1"  src="{{ $user->profile_photo_url }}"  width="100%"></div>
                                  <div class="card-info">
                                    <h5 class="text-title">{{ $user->username }}</h5><br>
                                    <p class="text-body">{{ $user->name }}</p>
                                    <p class="text-body"><i class="fa fa-bolt" aria-hidden="true"></i>Active</p>
                                    <div class="row">
                                        <div class="col-sm-4" ><center><i class="fa fa-star" aria-hidden="true" style="font-size: 15px"></i></center><span style="font-size: 15px">343</span></div>
                                        <div class="col-sm-4"><center><i class="fa fa-users" aria-hidden="true" style="font-size: 15px"></i></center><span style="font-size: 15px">343</span></div>
                                        <div class="col-sm-4"><center><i class="fa fa-usd" aria-hidden="true" style="font-size: 15px"></i></center><span style="font-size: 15px">343</span></div>
                                    </div>

                                  </div>
                                </div>
                            </div>

                        <ul>
                            @for ($i = 1; $i <= 5; $i++)
                                <li class="position-{{ $i }}">
                                    @if (isset($descendants[$i]))
                                        @php
                                            $descendant = $descendants[$i];
                                        @endphp
                                        <a href="{{ route('user.genealogy', $descendant) }}">
                                            <img class="rounded-circle" width="35"
                                                src="{{ $descendant->profile_photo_url }}" alt="">
                                            <div class="mt-2">{{ $descendant->username }}</div>
                                        </a>
                                    @else
                                        <a
                                            href="{{ URL::signedRoute('user.genealogy.position.manage', ['parent' => $user, 'position' => $i]) }}">
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
















{{-- <div id='genealogy'>
    <div class="card">
        <div class="card-info">
            <div class="card-avatar"><img class="rounded-circle" src="{{ $user->profile_photo_url }}" alt=""></div>
            <div class="card-title gold" > {{ $user->username }}</div>
            <div class="card-subtitle">{{ $user->name }}</div>
        </div>
        <ul class="card-social">
            <li class="card-social__item">
                <i class="fa fa-star gold" aria-hidden="true" > 754 |</i>
            </li>
            <li class="card-social__item">
                <i class="fa fa-users gold" aria-hidden="true" > 74 |</i>
            </li>
            <li class="card-social__item">
                <i class="fa fa-bolt gold" aria-hidden="true" > <span style="font-size:10px">active</span></i>
            </li>
        </ul>
    </div>
</div> --}}





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
