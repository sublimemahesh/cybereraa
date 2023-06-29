<div class="genealogy">
    <div class="card  {{ $user->active_packages_count > 0 ? 'card-active' : 'inactive' }}   ">
        <div class="card-img">
            <img class="card-img2  card-img2-mob" src="{{ $user->profile_photo_url }}"  alt="">
        </div>
        <div class="card-info">
            <h5 class="text-title">{{ $user->username }}</h5>
            <p class="text-body-name">{{ $user->name }}</p>
            <p class="text-body">
                <i class="fa fa-bolt" aria-hidden="true"></i> {{ $user->active_packages_count > 0 ? 'Active' : 'Inactive' }}
            </p>
            <div class="row text-nowrap g-icon mbo-g-icon" >
                <div class="col-sm-4 col-4" title="ST No">
                    <label style="background: #1fa6ff;width: 48px">
                    <div style="text-align: center;padding: 4px 8px 4px 10px;">
                        <i class="fa fa-flag" aria-hidden="true" style="font-size: 15px"></i>
                        <span style="font-size: 15px">#{{ $user->id }}</span>
                    </div>
                </label>
                </div>

                <div class="col-sm-4 col-4" title="Rank">
                    <label style="background: #1fa6ff;width: 48px">
                    <div style="text-align: center; padding: 4px 8px 4px 10px;">
                        <i class="fa fa-certificate" aria-hidden="true" style="font-size: 15px"></i>
                        <span style="font-size: 15px">{{ $user->currentRank->rank }}</span>
                    </div>
                </label>
                </div>


                <div class="col-sm-4 col-4" title="Members">
                    <label style="background: #1fa6ff;width: 48px">
                    <div style="text-align: center; padding: 4px 8px 4px 8px;">
                        <i class="fa fa-street-view" aria-hidden="true" style="font-size: 15px"></i>
                        <span style="font-size: 15px">{{ $user->descendants->count() }}</span>
                    </div>
                </label>
                </div>

            </div>
        </div>
    </div>
</div>
