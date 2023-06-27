<div class="genealogy">
    <div class="card  {{ $user->active_packages_count > 0 ? 'card-active' : 'inactive' }}   ">
        <div class="card-img">
            <img class="card-img2  card-img2-mob" src="{{ $user->profile_photo_url }}"  alt="">
        </div>
        <div class="card-info">
            <h5 class="text-title">{{ $user->username }}</h5>
            <p class="text-body">{{ $user->name }}</p>
            <p class="text-body">
                <i class="fa fa-bolt" aria-hidden="true"></i>{{ $user->active_packages_count > 0 ? 'Active' : 'Inactive' }}
            </p>
            <div class="row text-nowrap">
                <div class="col-sm-4 col-4" title="ST No">
                    <div style="text-align: center;">
                        <i class="fa fa-id-card" aria-hidden="true" style="font-size: 15px"></i>
                    </div>
                    <span style="font-size: 15px">#{{ $user->id }}</span>
                </div>
                <div class="col-sm-4 col-4" title="Rank">
                    <div style="text-align: center;">
                        <i class="fa fa-star" aria-hidden="true" style="font-size: 15px"></i>
                    </div>
                    <span style="font-size: 15px">{{ $user->currentRank->rank }}</span>
                </div>
                <div class="col-sm-4 col-4" title="Members">
                    <div style="text-align: center;">
                        <i class="fa fa-users" aria-hidden="true" style="font-size: 15px"></i>
                    </div>
                    <span style="font-size: 15px">{{ $user->descendants->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
