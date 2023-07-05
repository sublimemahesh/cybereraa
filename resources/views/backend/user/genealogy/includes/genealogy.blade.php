
<div class="row">
    <div class="col-sm-12 ">
        @if (!empty($user->parent_id) && Auth::user()->id !== $user->id)
            <div class="d-flex justify-content-center mb-md-2 mb-sm-5">
                <a href="{{ route('user.genealogy', $user->parent) }}" class="next-genealogy head-arrow">
                    <i class="fas fa-arrow-up fs-2"></i>
                </a>
            </div>
        @endif
    </div>
</div>
<div>
    <div class="col-sm-12 add-tree">
        <br><br>
        <div class="tree">
            <ul>
                <li>
                    <a href="javascript:void(0)" class="add-tree-2">
                        @include('backend.user.genealogy.includes.genealogy-card', compact('user'))
                    </a>
                    <ul>
                        <div class="swiper swiper-container">
                            <div class="swiper-wrapper add-tree-3">
                                @for ($i = 1; $i <= 5; $i++)
                                    <li class="position-{{ $i }}">
                                        @if (isset($descendants[$i]))
                                            @php
                                                $descendant = $descendants[$i];
                                            @endphp
                                            <div class="swiper-slide">
                                                <a href="{{ route('user.genealogy', $descendant) }}" class="next-genealogy">
                                                    @include('backend.user.genealogy.includes.genealogy-card', ['user' => $descendant])
                                                </a>
                                            </div>
                                        @else
                                                <a href="{{ URL::signedRoute('user.genealogy.position.manage', ['parent' => $user, 'position' => $i]) }}">
                                                    <div class="genealogy item">
                                                        <div class="card">
                                                            <div class="card-img-empty"><img class="card-img2  card-img2-mob" src="{{ asset('assets/backend/images/user-icon.jpg') }}"  alt=""></div>
                                                            <div class="card-info info-empty">
                                                                <h5 class="text-title">Empty    </h5><br>
                                                                <p class="text-body-name">Add your new member</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                        @endif
                                    </li>
                                @endfor
                            </div>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

