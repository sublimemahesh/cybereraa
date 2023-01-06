<x-backend.layouts.app>
    @section('title', 'My Genealogy')
    @section('header-title', 'My Genealogy')
    @section('plugin-styles')
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    @endsection
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/genealogy.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/clipboard.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/main.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">Genealogy</li>
    @endsection
    @if(Auth::user()->id === config('fortify.super_parent_id') || (Auth::user()->parent_id !== null && Auth::user()->position !== null))
        <div class="row">
            <div class="col-xl-12 col-sm-12 ">
                <div class="bg-secondary card d-flex email-susb justify-content-center m-auto w-75">
                    <div class="card-body text-center">
                        <div class="">
                            <img src="{{ asset('assets/backend/images/metaverse.png') }}" alt="">
                        </div>
                        <div class="toatal-email">
                            <p> Via Referral Link </p>
                        </div>
                        <div class="input-group mb-3 input-primary">
                            <input type="text" readonly class="form-control" id="clipboard-input" value="{{ Auth::user()->referral_link }}">
                            <span class="input-group-text border-0 clipboard-tooltip" onclick="copyToClipBoard()" onmouseout="outFunc()">
                            <span class="tooltip-text" id="clipboard-tooltip">Copy to clipboard</span>
                            Copy Link
                        </span>
                        </div>
                        <div class="toatal-email">
                            <p>Via Register a new user now </p>
                        </div>
                        <a href="{{ route('user.genealogy.position.register') }}" class="btn btn-sm btn-primary email-btn">Register now</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            Your genealogy position is still not available. Please contact your up link user,
            or you will automatically place after 1 day. Please note that genealogy placement required to have an active package.
            when you have purchased a package only you will be able to get position in genealogy.
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12 ">
            @if (!empty($user->parent_id) && Auth::user()->id !== $user->id)
                <div class="d-flex justify-content-center mb-md-2 mb-sm-5">
                    <a href="{{ route('user.genealogy', $user->parent) }}">
                        <i class="fas fa-arrow-up fs-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="row mobile-margine">
        <div class="col-sm-12 add-tree">
            <div class="tree remove-mobile">
                <ul class="remove-mobile">
                    <li class="remove-mobile">
                        <a href="javascript:void(0)" class="add-tree-2">
                            @include('backend.user.genealogy.includes.genealogy-card', compact('user'))
                        </a>
                        <ul class="remove-mobile ">
                            <div class="swiper swiper-container">
                                <div class="swiper-wrapper add-tree-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <li class="position-{{ $i }} remove-mobile">
                                            @if (isset($descendants[$i]))
                                                @php
                                                    $descendant = $descendants[$i];
                                                @endphp
                                                <div class="swiper-slide">
                                                    <a href="{{ route('user.genealogy', $descendant) }}">
                                                        @include('backend.user.genealogy.includes.genealogy-card', ['user' => $descendant])
                                                    </a>
                                                </div>
                                            @else
                                                <div class="swiper-slide" >
                                                    <a href="{{ URL::signedRoute('user.genealogy.position.manage', ['parent' => $user, 'position' => $i]) }}">
                                                        <div class="genealogy item">
                                                            <div class="card">
                                                                <div class="card-img"></div>
                                                                <div class="card-info">
                                                                    <h5 class="text-title">Empty</h5><br>
                                                                    <p class="text-body">Add your new member</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        </li>
                                    @endfor
                                </div>
                                <div class="swiper-pagination " slot="pagination" id='swiper-pagination-set'></div>
                            </div>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            function copyToClipBoard() {
                const copyText = document.getElementById("clipboard-input");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.value);

                const tooltip = document.getElementById("clipboard-tooltip");
                tooltip.innerHTML = "Copied: " + copyText.value;
            }

            function outFunc() {
                const tooltip = document.getElementById("clipboard-tooltip");
                tooltip.innerHTML = "Copy to clipboard";
            }

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

            let des = 0;

            function responsive(x) {
                if (x.matches) {
                    // If media query matches
                    $('.remove-mobile').contents().unwrap();
                    des = des + 1;
                } else {
                    if (des > 0) {
                        location.reload();
                    }
                }
            }

            const x = window.matchMedia("(max-width: 700px)");
            responsive(x) // Call listener function at run time
            x.addListener(responsive) // Attach listener function on state changes

        </script>
    @endpush
</x-backend.layouts.app>







