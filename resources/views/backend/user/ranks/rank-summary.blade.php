<x-backend.layouts.app>
    @section('title', 'My Rank Summary')
    @section('header-title', 'My Rank Summary' )
    @section('plugin-styles')
        <!-- Datatable -->
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/rank-timeline.css') }}">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Rank</li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        <div class="col-sm-12">
            <div class="card rounded-3">
                <div class="card-body">
                    <div class="timeline">
                        <div class="rank {{ $highestRank >= 1 ? 'unlocked' : 'locked'  }}">
                            <div class="rank-name">Rank 1</div>
                            <div class="status">{{ $highestRank >= 1 ? 'Unlocked' : 'Locked'  }}</div>
                        </div>
                        <div class="rank {{ $highestRank >= 2 ? 'unlocked' : 'locked'  }}">
                            <div class="rank-name">Rank 2</div>
                            <div class="status">{{ $highestRank >= 2 ? 'Unlocked' : 'Locked'  }}</div>
                        </div>
                        <div class="line"></div>
                        <div class="rank {{ $highestRank >= 3 ? 'unlocked' : 'locked'  }}">
                            <div class="rank-name">Rank 3</div>
                            <div class="status">{{ $highestRank >= 3 ? 'Unlocked' : 'Locked'  }}</div>
                        </div>
                        <div class="line"></div>
                        <div class="rank {{ $highestRank >= 4 ? 'unlocked' : 'locked'  }}">
                            <div class="rank-name">Rank 4</div>
                            <div class="status">{{ $highestRank >= 4 ? 'Unlocked' : 'Locked'  }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @for($i = 1; $i<=4;$i++)
            @php
                $rank_info = \App\Enums\RankEnum::info()[$i];
            @endphp
            <div class="col-sm-12">
                <div class="rounded-3">
                    {{--<div class="card-body">--}}
                    <div class="bg-white d-flex rank-container {{ $highestRank >= $i ? "unlocked" : "locked"}}" style="">
                        @if($highestRank >= $i)
                            <div class="ribbon unlocked">Unlocked</div>
                        @else
                            <div class="ribbon locked">Locked</div>
                        @endif
                        <img src="{{ $rank_info['logo'] }}" alt="logo" class="rank-logo">
                        <main class="content-area">
                            <h2 class="text-white text-uppercase">01. {{ $rank_info['name'] }}</h2>
                            <div class="investment-details">

                                <p class="">{{ $rank_info['requirement'] }}</p>

                                <div class="benefit-highlights mt-4">
                                    <span class="fs-18 fw-bold mb-1">Benefits</span>
                                    @if(!is_array($rank_info['benefits']))
                                        <div class="ml-1">{{ $rank_info['benefits'] }}</div>
                                    @else
                                        @foreach($rank_info['benefits'] as $benefit)
                                            <div class="mt-2 ml-1">{{ $benefit }}</div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                        </main>
                    </div>
                    {{--</div>--}}
                </div>
            </div>
        @endfor
    </div>

    @push('scripts')
    @endpush
</x-backend.layouts.app>
