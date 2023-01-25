<div class="row">
    <div class="col-sm-12 ">
        @if (!empty($user->parent_id) && config('fortify.super_parent_id') !== $user->id)
            <div class="d-flex justify-content-center mb-md-2 mb-sm-5">
                <a href="{{ route('admin.genealogy', $user->parent) }}" class="next-genealogy">
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
                    <a href="javascript:void(0)" class="add-tree-2" class="next-genealogy">
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
                                                <a href="{{ route('admin.genealogy', $descendant) }}" class="next-genealogy">
                                                    @include('backend.user.genealogy.includes.genealogy-card', ['user' => $descendant])
                                                </a>
                                            </div>
                                        @else
                                            <div class="swiper-slide">
                                                <a href="javascript:void(0)">
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