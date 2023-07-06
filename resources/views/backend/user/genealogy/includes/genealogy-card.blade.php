<div class="genealogy">
    <div class="card  {{ $user->active_packages_count > 0 ? 'card-active' : 'inactive' }}   ">


                <div class="card-img">
                    <img class="card-img2  card-img2-mob" src="{{ $user->profile_photo_url }}" alt="">
                </div>

                <div class="row text-nowrap g-icon mbo-g-icon new-stl">
                    <div class="col-sm-12 col-12" title="ST No : {{ $user->id }}">
                        <label style="background: #1fcde8 ;width: 50px;border-radius: 10%;">
                            <div style="text-align:left;padding: 4px 6px 4px 6px;">
                                <i  aria-hidden="true" style="font-size:10px"></i>
                                <span style="font-size: 12px">{{ $user->id }}</span>
                            </div>
                        </label>
                    </div>

                    <div class="col-sm-12 col-12" title="Rank : {{ $user->currentRank->rank }}">
                        <label style="background: #1fcde8;width: 50px;border-radius:10%;">
                            <div style="text-align:left; padding: 4px 6px 4px 6px;">
                                <i class="fa fa-certificate" aria-hidden="true" style="font-size:10px"></i>
                                <span style="font-size: 12px ;margin-left:-3px;">{{ $user->currentRank->rank }}</span>
                            </div>
                        </label>
                    </div>


                    <div class="col-sm-12 col-12" title="Members : {{ $user->descendants->count() }}">
                        <label style="background: #1fcde8;width:50px;;border-radius:10%;">
                            <div style="text-align:left; padding: 4px 6px 4px 6px">
                                <i class="fa fa-street-view" aria-hidden="true" style="font-size:10px"></i>
                                <span style="font-size: 12px;margin-left:-3px;">{{ $user->descendants->count() }}</span>
                            </div>
                        </label>
                    </div>
                </div>


        <div class="card-info">
            <h5 class="text-title">{{ $user->username }}</h5>
            <p class="text-body-name">{{ $user->name }}</p>
            <p class="text-body">
                <i class="fa fa-bolt" aria-hidden="true"></i> {{ $user->active_packages_count > 0 ? 'Active' :
                'Inactive' }}
            </p>



        </div>
    </div>
</div>
