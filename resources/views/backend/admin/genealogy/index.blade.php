<x-backend.layouts.app>
    @section('title', $user->username . ' | Admin | Super User Genealogy')
    @section('header-title', 'Users Genealogy')
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

    <div id="genealogy" class="genealogy-scrooling">
        @include('backend.admin.genealogy.includes.genealogy', compact('user','descendants'))
    </div>

    @push('scripts')
        <script>
            const x = window.matchMedia("(max-width: 700px)");
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);

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

            $(document).on('click', '.next-genealogy', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                loadGenealogy(url)
            })

            function loadGenealogy(url) {
                loader('');
                axios.post(url).then(function (response) {
                    if (response.data.status) {
                        $('#genealogy').html(response.data.genealogy)
                        history.replaceState({}, "", url);
                        document.title = response.data.username + " | Admin | Super User Genealogy"
                    }

                    Swal.close()
                }).catch(function (error) {
                    Toast.fire({
                        icon: 'error', title: error.response.data.message || "Something went wrong!",
                    })
                })
            }




            window.addEventListener('DOMContentLoaded', () => {
                const divs = document.getElementsByClassName('myDiv');
                const fontSize = 20; // Initial font size

                const resizeText = () => {

                    for (let i = 0; i < divs.length; i++) {
                        const div = divs[i];
                        const divWidth = div.offsetWidth;
                        const textWidth = div.scrollWidth;

                        if (textWidth > divWidth) {
                            const newFontSize = (divWidth / textWidth) * fontSize;

                            //div.style.fontSize = newFontSize + 'px';
                            $(".c-font").css({
                                fontSize: newFontSize -6 + 'px'
                            });
                            //alert('qq');
                        } else {
                            $(".c-font").css({
                                fontSize: 13 + 'px'
                            });
                        }
                    }
                };

                resizeText();

                window.addEventListener('resize', resizeText);
            });





        </script>
    @endpush
</x-backend.layouts.app>







