<x-backend.layouts.app>
    @section('title', 'My Genealogy')
    @section('header-title', 'My Genealogy' )
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/genealogy.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">Genealogy</li>
    @endsection

    <div class="row">
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
    @endpush
</x-backend.layouts.app>