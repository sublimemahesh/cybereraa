<x-backend.layouts.app>
    @section('title', 'My Genealogy')
    @section('header-title', 'My Genealogy')
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/genealogy.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/clipboard.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/main.css') }}">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">Genealogy</li>
    @endsection

    <div class="row">
        <div class="col-sm-12 d-flex justify-content-center">
            <div class="input-group mb-3 w-75 input-primary">
                <input type="text" readonly class="form-control" id="clipboard-input" value="{{ Auth::user()->referral_link }}">
                <span class="input-group-text border-0 clipboard-tooltip" onclick="copyToClipBoard()" onmouseout="outFunc()">
                    <span class="tooltip-text" id="clipboard-tooltip">Copy to clipboard</span>
                    Copy Link
                </span>
            </div>
        </div>
    </div>

    {{-- ///////////////////////// Desktop version ///////////////////////////////// --}}

    <div class="row">
        <div class="col-sm-12 ">
            @if (Auth::user()->id !== $user->id)
                <div class="d-flex justify-content-center mb-md-2 mb-sm-5">
                    <a href="{{ route('user.genealogy', $user->parent->parent_id ?? $user->parent ) }}">
                        <i class="fas fa-arrow-up fs-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="row dv">
        <div class="col-sm-12 ">
            <div class="tree">
                <ul>
                    <li>
                        <a href="javascript:void(0)">
                            @include('backend.user.genealogy.includes.genealogy-card', compact('user'))
                        </a>
                        <ul>
                            @for ($i = 1; $i <= 5; $i++)
                                <li class="position-{{ $i }}">
                                    @if (isset($descendants[$i]))
                                        @php
                                            $descendant = $descendants[$i];
                                        @endphp
                                        <a href="{{ route('user.genealogy', $descendant) }}">
                                            @include('backend.user.genealogy.includes.genealogy-card', ['user' => $descendant])
                                        </a>
                                    @else
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
            <a href="javascript:void(0)">
                @include('backend.user.genealogy.includes.genealogy-card', compact('user'))
            </a>
            <div class="swiper swiper-container">
                <div class="swiper-wrapper">
                    @for ($i = 1; $i <= 5; $i++)
                        @if (isset($descendants[$i]))
                            @php
                                $descendant = $descendants[$i];
                            @endphp
                            <div class="swiper-slide">
                                <a href="{{ route('user.genealogy', $descendant) }}">
                                    @include('backend.user.genealogy.includes.genealogy-card',['user' => $descendant])
                                </a>
                            </div>
                        @else
                            <div class="swiper-slide">
                                <a href="{{ URL::signedRoute('user.genealogy.position.manage', ['parent' => $user, 'position' => $i]) }}">
                                    <div class="genealogy">
                                        <div class="card">
                                            <div class="card-img"></div>
                                            <div class="card-info">
                                                <h5 class="text-title">EMPTY</h5><br>
                                                <p class="text-body">Add your new member</p>
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
            function copyToClipBoard() {
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
