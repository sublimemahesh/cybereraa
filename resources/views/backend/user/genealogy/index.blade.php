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

    <div id="genealogy">
        @include('backend.user.genealogy.includes.genealogy', compact('user','descendants'))
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

            let swiper = null;
            const x = window.matchMedia("(max-width: 700px)");
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);

            $(document).on('click', '.next-genealogy', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                loadGenealogy(url)
            })

            function loadGenealogy(url) {
                loader('');
                axios.get(url).then(function (response) {
                    if (response.data.status) {
                        $('#genealogy').html(response.data.genealogy)
                        history.replaceState({}, "", url);
                    }
                    try {
                        responsive(x)
                    } catch (e) {
                        console.log(e)
                    }

                    Swal.close()
                }).catch(function (error) {
                    Toast.fire({
                        icon: 'error', title: error.response.data.message || "Something went wrong!",
                    })
                })
            }

            const initSwiper = function () {
                if (swiper !== null) {
                    swiper.destroy()
                }
                return new Swiper('.swiper', {
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
            }

            if (x.matches) {
                swiper = initSwiper()
            }

            let des = 0;

            function responsive(x) {
                if (x.matches) {
                    // If media query matches
                    $('.remove-mobile').contents().unwrap();
                    des = des + 1;
                    swiper = initSwiper()
                } else {
                    if (des > 0) {
                        location.reload();
                    }
                }
            }

            responsive(x) // Call listener function at run time
            x.addListener(responsive) // Attach listener function on state changes

        </script>
    @endpush
</x-backend.layouts.app>







