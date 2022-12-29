<x-backend.layouts.app>
    @section('styles')
        @vite(['resources/css/app-jetstream.css'])
    @endsection
    @section('title', __('Account Settings'))
    @section('header-title', __('Account Settings'))

    @section('breadcrumb-items')
        <li class="breadcrumb-item active">Account Settings</li>
    @endsection

    <div class="row">

        <div class="col-xl-3 col-lg-4">
            <div class="clearfix">
                <div class="card card-bx profile-card author-profile m-b30">
                    <div class="card-body">
                        <div class="p-5">
                            <div class="author-profile">
                                <div class="author-media">
                                    <img src="{{ auth()->user()->profile_photo_url }}" alt="" class="profile-image2">
                                    <div class="upload-link" title="" data-toggle="tooltip" data-placement="right"
                                        data-original-title="update">
                                        <input type="file" class="update-flie">
                                        <i class="fa fa-camera"></i>
                                    </div>
                                </div>
                                <div class="author-info">
                                    <h6 class="title">{{ auth()->user()->name }}</h6>
                                    <span>{{ auth()->user()->username }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="info-list">
                            <ul>
                                <li><a href="app-profile.html">Models</a><span>36</span></li>
                                <li><a href="uc-lightgallery.html">Gallery</a><span>3</span></li>
                                <li><a href="app-profile.html">Lessons</a><span>1</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="input-group mb-3">
                            <div class="form-control rounded text-center bg-white">Portfolio</div>
                        </div>
                        <div class="input-group">
                            <a href="https://www.dexignzone.com/"
                                class="form-control text-primary rounded text-start bg-white">https://www.dexignzone.com/</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-lg-8">

            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif

        </div>
    </div>

</x-backend.layouts.app>
