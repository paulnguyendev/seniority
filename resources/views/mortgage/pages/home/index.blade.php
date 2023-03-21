@php
    use App\Helpers\License;
    use App\Helpers\Level;
    $title = config('title.portal_license_dashboard');
@endphp
@extends('core.dashboard')
@section('title', $title)
@section('content')
    <div class="row mt-5 card-equal">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header-obn">
                    <span>Your Sponsor</span>
                </div>
                <div class="card-body text-center">
                    @php
                        $parent_id = $ambassadorInfo['parent_id'] ?? '';
                        $parentInfo = License::getInfo($parent_id);
                    @endphp
                    @if ($parentInfo)
                        @php
                            $parentFullname = License::getInfo($parent_id, 'fullname');
                            $parentThumbnail = License::getInfo($parent_id, 'thumbnail');
                            $parentEmail = $parentInfo['email'] ?? '';
                            $parentMobile = $parentInfo['mobile'] ?? '';
                        @endphp
                        <img src="{{ $parentThumbnail }}" alt="user" class="rounded-circle img-fluid sponsor-avatar">
                        <h3 class="font-20 mb-0">{{ $parentFullname }}</h3>
                        <p class="mb-0">{{ $parentEmail }}</p>
                    @else
                        <p>-</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="info-avatar">
                        @php
                            $thumbnail_url = License::getInfo('', 'thumbnail');
                        @endphp
                        <img src="{{ $thumbnail_url }}" alt="user" class="rounded-circle img-fluid">
                    </div>
                    <h3 class="font-20 mb-0">
                        {{ License::getInfo('', 'fullname') }}
                    </h3>
                    <p class="mb-0"> Your ID: {{ $ambassadorInfo['code'] ?? '' }}</p>
                    <p class="mb-0">
                        @php
                            $level_id = $ambassadorInfo['level_id'] ?? '';
                            $level_name = Level::getLevelInfo($level_id, 'name') ?? '-';
                        @endphp
                        @if ($level_name)
                            Ranking: {{ $level_name }}
                        @endif

                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header-obn">
                    <span>Latest 5 Ambassadors
                    </span>
                </div>
                <div class="card-body card-body-limit-height">
                    <ul class="ml-0 pl-0 list-latest">
                        @if (count($childs) > 0)
                            @foreach ($childs as $child)
                                @php
                                    $childId = $child['id'];
                                    $childName = License::getInfo($childId, 'fullname');
                                    $childInfo = License::getInfo($childId);
                                @endphp
                                <li class="media ml-0">
                                    <img class="d-flex rounded align-self-start mr-3"
                                        src="http://localhost/seniority/public/uploads/images/default.png"
                                        alt="Generic placeholder image" height="64">
                                    <div class="media-body">
                                        <span> {{ $childName }} </span> <br>
                                        <span> {{ $childInfo['email'] ?? '' }} </span> <br>
                                        <span>Joined In:
                                            {{ date('H:i:s Y-m-d', strtotime($childInfo['created_at'])) ?? '-' }} </span>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <p class="text-center">No data</p>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5>Total Loans</h5>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-header-obn">
                    <span>My Incomplete Loans</span>
                </div>
                <div class="card-body">
                    <span class="font-20"> {{ $totalLoans['totalMyIncomplete'] ?? 0 }} </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-header-obn">
                    <span>My Complete Loans </span>
                </div>
                <div class="card-body">
                    <span class="font-20"> {{ $totalLoans['totalMyComplete'] ?? 0 }} </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-header-obn">
                    <span>Downline Incomplete Loans</span>
                </div>
                <div class="card-body">
                    <span class="font-20"> {{ $totalLoans['totalDownlineIncomplete'] ?? 0 }} </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-header-obn">
                    <span>Downline Complete Loans</span>
                </div>
                <div class="card-body">
                    <span class="font-20"> {{ $totalLoans['totalDownlineComplete'] ?? 0 }} </span>
                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-md-12">
            <h5>Total Commission</h5>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header-obn">
                    <span>Current Commission</span>
                </div>
                <div class="card-body">
                    <span class="font-20"> {{ show_price($commissionThisMonth) ?? 0 }} </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">

            <div class="card text-center">
                <div class="card-header-obn">
                    <span>Year to Date Commission
                    </span>
                </div>
                <div class="card-body">
                    <span class="font-20"> {{ show_price($commissionAll) ?? 0 }} </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header-obn">
                    <span>Commission Paid</span>
                </div>
                <div class="card-body">
                    <span class="font-20"> {{ show_price($commissionPaid) ?? 0 }} </span>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <h5>Downline Information</h5>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header-obn d-flex justify-content-between align-items-center obn-badge">
                    <span>Downline Ambassadors</span>
                    <span class="badge badge-primary">{{ $totalChilds ?? 0 }}</span>

                </div>
                <div class="card-body card-list">
                    <ul>
                        @foreach ($levels as $level)
                            @php
                                $slug = $level['slug'] ?? '';
                                $totalAmbassador = Level::countAmbassadorstByLevel($ambassadorId, $level['id']);
                            @endphp
                            <li>
                                <a
                                    href="{{ route("{$prefix}/downlineAmbassadors", ['slug' => $slug]) }}">{{ $level['name'] ?? '' }}</a>
                                <span class="badge badge-primary"> {{ $totalAmbassador }} </span>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header-obn d-flex justify-content-between align-items-center obn-badge">
                    <span>Downline Loans</span>
                    <span class="badge badge-primary">{{$totalDownlineLoans}}</span>
                </div>
                <div class="card-body card-list">
                    <ul>
                        @foreach ($levels as $level)
                            @php
                                $slug = $level['slug'];
                                 $totalLoans = Level::countLoanstByLevel($ambassadorId,$level['id']);
                            @endphp
                            <li>
                                <a href="{{ route("{$prefix}/downlineLoans", ['slug' => $slug]) }}">{{ $level['name'] ?? '' }}</a>
                                <span class="badge badge-primary">{{$totalLoans}}</span>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
