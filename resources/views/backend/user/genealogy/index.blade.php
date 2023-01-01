<x-backend.layouts.app>
    @section('title', 'My Genealogy')
    @section('header-title', 'My Genealogy')
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/genealogy.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/clipboard.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/main.css') }}">

        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />



        {{--
        <style>
            .swiper-pagination-bullets {
                position: static;
                display: flex;
                justify-content: center;
                margin-top: 10px;
            }

            .swiper-pagination-bullets .swiper-pagination-bullet {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                width: auto;
                height: auto;
                background: transparent;
                opacity: 0.5;
                margin: 0 8px;
                border-radius: 0;
                transition: opacity 0.3s;
            }

            .swiper-pagination-bullets .swiper-pagination-bullet .line {
                width: 3px;
                height: 3px;
                background: black;
                transition: transform 0.3s;
            }

            .swiper-pagination-bullets .swiper-pagination-bullet .number {
                opacity: 0;
                transform: translateY(-7px);
                transition: all 0.3s;
            }

            .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active {
                opacity: 1;
            }

            .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active .line {
                transform: scaleX(8);
            }

            .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active .number {
                opacity: 1;
                transform: none;
            }

            .swiper-pagination-bullet {
                width: var(--swiper-pagination-bullet-width, var(--swiper-pagination-bullet-size, 8px)) !important;
                height: var(--swiper-pagination-bullet-height, var(--swiper-pagination-bullet-size, 8px)) !important;
                display: inline-block !important;
                border-radius: 50% !important;
                background: var(--swiper-pagination-bullet-inactive-color, #000)!important;
                opacity: var(--swiper-pagination-bullet-inactive-opacity, .2)!important;
            }
        </style> --}}

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
    </div>


    {{-- ///////////////////////// Desktop version ///////////////////////////////// --}}



    <div class="row dv">
        <div class="col-sm-12 ">
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
                        <a href="javascript:void(0)">

                            <div class="genealogy">
                                <div class="card">
                                    <div class="card-img"><img class="rounded-circle img-center1"
                                            src="{{ $user->profile_photo_url }}" width="100%"></div>
                                    <div class="card-info">
                                        <h5 class="text-title">{{ $user->username }}</h5><br>
                                        <p class="text-body">{{ $user->name }}</p>
                                        <p class="text-body"><i class="fa fa-bolt" aria-hidden="true"></i>Active</p>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <center><i class="fa fa-star" aria-hidden="true"
                                                        style="font-size: 15px"></i></center><span
                                                    style="font-size: 15px">343</span>
                                            </div>
                                            <div class="col-sm-4">
                                                <center><i class="fa fa-users" aria-hidden="true"
                                                        style="font-size: 15px"></i></center><span
                                                    style="font-size: 15px">343</span>
                                            </div>
                                            <div class="col-sm-4">
                                                <center><i class="fa fa-usd" aria-hidden="true"
                                                        style="font-size: 15px"></i></center><span
                                                    style="font-size: 15px">343</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </a>
                        <ul>
                            @for ($i = 1; $i <= 5; $i++)
                                <li class="position-{{ $i }}">
                                    @if (isset($descendants[$i]))
                                        @php
                                            $descendant = $descendants[$i];
                                        @endphp
                                        <a href="{{ route('user.genealogy', $descendant) }}">


                                            <div class="genealogy">
                                                <div class="card">
                                                    <div class="card-img"><img class="rounded-circle img-center1"
                                                            src="{{ $descendant->profile_photo_url }}" width="100%">
                                                    </div>
                                                    <div class="card-info">
                                                        <h5 class="text-title">{{ $descendant->username }}</h5><br>
                                                        <p class="text-body">{{ $descendant->name }}</p>
                                                        <p class="text-body"><i class="fa fa-bolt"
                                                                aria-hidden="true"></i>Active</p>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <center><i class="fa fa-star" aria-hidden="true"
                                                                        style="font-size: 15px"></i></center><span
                                                                    style="font-size: 15px">343</span>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <center><i class="fa fa-users" aria-hidden="true"
                                                                        style="font-size: 15px"></i></center><span
                                                                    style="font-size: 15px">343</span>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <center><i class="fa fa-usd" aria-hidden="true"
                                                                        style="font-size: 15px"></i></center><span
                                                                    style="font-size: 15px">343</span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        <a
                                            href="{{ URL::signedRoute('user.genealogy.position.manage', ['parent' => $user, 'position' => $i]) }}">
                                            <div class="genealogy item">
                                                <div class="card">
                                                    <div class="card-img"></div>
                                                    <div class="card-info">
                                                        <h5 class="text-title">Empty</h5><br>
                                                        <p class="text-body">Please add your new member</p>
                                                    </div>
                                                </div>
                                            </div>
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



    {{-- ////////////////////////////   Mobile View       ///////////////////////// --}}


    <div class="row mbv">
        <div class="col-sm-12">

            @if (!is_null($user->parent))
                <div class="d-flex justify-content-center arrow-margin">
                    <a href="{{ route('user.genealogy', !is_null($user->parent->parent_id) ? $user->parent : null) }}">
                        <i class="fas fa-arrow-up fs-2"></i>
                    </a>
                </div>
            @endif

            <a href="javascript:void(0)">
                <div class="genealogy">
                    <div class="card">
                        <div class="card-img"><img class="rounded-circle img-center1"
                                src="{{ $user->profile_photo_url }}" width="100%"></div>
                        <div class="card-info">
                            <h5 class="text-title">{{ $user->username }}</h5><br>
                            <p class="text-body">{{ $user->name }}</p>
                            <p class="text-body"><i class="fa fa-bolt" aria-hidden="true"></i>Active</p>
                            <div class="row">
                                <div class="col-sm-4  col-4">
                                    <center><i class="fa fa-star" aria-hidden="true" style="font-size: 15px"></i>
                                    </center><span style="font-size: 15px">343</span>
                                </div>
                                <div class="col-sm-4  col-4">
                                    <center><i class="fa fa-users" aria-hidden="true" style="font-size: 15px"></i>
                                    </center><span style="font-size: 15px">343</span>
                                </div>
                                <div class="col-sm-4  col-4">
                                    <center><i class="fa fa-usd" aria-hidden="true" style="font-size: 15px"></i>
                                    </center><span style="font-size: 15px">343</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <div class="swiper  swiper-container  ">
                <div class="swiper-wrapper">
                    @for ($i = 1; $i <= 5; $i++)
                        @if (isset($descendants[$i]))
                            @php
                                $descendant = $descendants[$i];
                            @endphp

                            <div class="swiper-slide">
                                <a href="{{ route('user.genealogy', $descendant) }}">
                                    <div class="genealogy">
                                        <div class="card">
                                            <div class="card-img"><img class="rounded-circle img-center1"
                                                    src="{{  $descendant->profile_photo_url}}" width="100%"></div>
                                            <div class="card-info">
                                                <h5 class="text-title">{{ $descendant->username }}</h5><br>
                                                <p class="text-body">{{ $descendant->name }}</p>
                                                <p class="text-body"><i class="fa fa-bolt"
                                                        aria-hidden="true"></i>Active
                                                </p>
                                                <div class="row">
                                                    <div class="col-sm-4  col-4">
                                                        <center><i class="fa fa-star" aria-hidden="true"
                                                                style="font-size: 15px"></i></center><span
                                                            style="font-size: 15px">343</span>
                                                    </div>
                                                    <div class="col-sm-4 col-4">
                                                        <center><i class="fa fa-users" aria-hidden="true"
                                                                style="font-size: 15px"></i></center><span
                                                            style="font-size: 15px">343</span>
                                                    </div>
                                                    <div class="col-sm-4  col-4">
                                                        <center><i class="fa fa-usd" aria-hidden="true"
                                                                style="font-size: 15px"></i></center><span
                                                            style="font-size: 15px">343</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @else
                            <div class="swiper-slide">
                                <a
                                    href="{{ URL::signedRoute('user.genealogy.position.manage', ['parent' => $user, 'position' => $i]) }}">
                                    <div class="genealogy">
                                        <div class="card">
                                            <div class="card-img"></div>
                                            <div class="card-info">
                                                <h5 class="text-title">EMPTY</h5><br>
                                                <p class="text-body">Please add your new member</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endfor
                </div>
                <div class="swiper-pagination " slot="pagination" id='swiper-pagination-set'></div>
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

        {{-- <script src="{{ asset('assets/backend/js/dashboard/dashboard.js') }}"></script> --}}

        <script>
            const swiper = new Swiper('.swiper', {
                // Default parameters
                slidesPerView: 1,
                spaceBetween: 10,
                // Responsive breakpoints
                breakpoints: {

                    769: {
                        slidesPerView: 4,
                        spaceBetween: 40
                    }
                },

                pagination: {
                    el: ".swiper-pagination",
                },


            })
        </script>
    @endpush
</x-backend.layouts.app>
