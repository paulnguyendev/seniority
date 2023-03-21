@php
    use App\Helpers\License;
    use App\Helpers\Level;
    $title = config('title.portal_license_downline_ambassador');
@endphp
@extends('core.dashboard')
@section('title', $title)
@section('content')
    @php
        use App\Helpers\Agent;
        $prefix = config('prefix.portal_license');
    @endphp
    <div class="list-level">
        @foreach ($levels as $itemLevel)
            @php
                $totalAmbassador = Level::countAmbassadorstByLevel($ambassadorId,$itemLevel['id']);
            @endphp
            <div class="level-item {{ $slug == $itemLevel['slug'] ? 'active' : '' }}">
                <a href="{{ route("{$prefix}/downlineAmbassadors", ['slug' => $itemLevel['slug']]) }}">
                    {{ $itemLevel['name'] ?? '' }}
                    ({{$totalAmbassador}})
                </a>
            </div>
        @endforeach

    </div>
    <div class="card mt-3">

        <div class="card-body">
            <table class="table table-xlg non-license-data obn-table" id="licences">
                <thead>
                    <tr>
                        <th class="text-center no-padding-right" width="100">Avatar</th>
                        <th>ID </th>
                        <th>Ambassador </th>
                        <th>Ranking</th>
                       
                        <th>Sponsor</th>
                        <th class="text-center"> Incomplete Loans</th>
                        <th class="text-center"> Complete Loans</th>

                        <th class="text-center">Status</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($items) > 0)
                        @foreach ($items as $item)
                            @php
                                $id = $item['id'];
                                $parent_id = $item['parent_id'];
                                $status = $item['status'];
                                $created_at = $item['created_at'];
                                $showInfo = License::showInfo($id);
                                $parentInfo = License::showInfo($parent_id);
                                $fullname = License::getInfo($id, 'fullname');
                                $mobile = show_phone($item['mobile']) ?? '';
                                $email = $item['email'] ?? '';
                                $code = $item['code'] ?? '';
                                $status = show_status($status);
                                $level_id = $item['level_id'] ?? '';
                                
                                $created_at = date('H:i:s d-m-Y', strtotime($created_at));
                                $totalLoans = License::totalLoans($id) ?? [];
                                $ranking = Level::getLevelInfo($level_id,'name');
                            @endphp
                            <tr>
                                <td class=" text-center no-padding-right">
                                    <img class="thumb-sm  rounded-circle "
                                        src="http://localhost/seniority/public/uploads/images/default.png">
                                </td>
                                <td> {{ $code }} </td>
                                <td> {!! $showInfo !!} </td>
                                <td> {{$ranking}} </td>
                               
                                <td>{!! $parentInfo !!}</td>
                                <td class="text-center"> {{$totalLoans['totalMyIncomplete'] ?? 0 }} </td>
                                <td class="text-center"> {{$totalLoans['totalMyComplete'] ?? 0 }}</td>


                                <td class=" text-center"> {!! $status !!} </td>
                                <td>{!! $created_at !!} </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">No data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
