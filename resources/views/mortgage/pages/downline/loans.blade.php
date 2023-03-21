@php
    use App\Helpers\License;
    use App\Helpers\Level;
    use App\Helpers\Agent;
    $prefix = config('prefix.portal_license');
    $title = config('title.portal_license_downline_loans');
@endphp
@extends('core.dashboard')
@section('title', $title)
@section('content')
    <div class="list-level">
        @foreach ($levels as $itemLevel)
            @php
                $total = Level::countLoanstByLevel($ambassadorId, $itemLevel['id']);
            @endphp
            <div class="level-item {{ $slug == $itemLevel['slug'] ? 'active' : '' }}">
                <a href="{{ route("{$prefix}/downlineLoans", ['slug' => $itemLevel['slug']]) }}">
                    {{ $itemLevel['name'] ?? '' }}
                    ({{ $total }})
                </a>
            </div>
        @endforeach
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#incomplete" role="tab"
                        aria-selected="true">Incomplete Loans ({{count($applications)}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#complete" role="tab" aria-selected="false">Complete
                        Loans ({{count($loans)}})</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane p-3 active" id="incomplete" role="tabpanel">
                    <table class="table table-xlg non-license-data obn-table" id="licences">
                        <thead>
                            <tr>
                                <th>ID </th>
                                <th>Name </th>
                                <th>Mobile </th>
                                <th>Email </th>
                                <th>Ambassador Info</th>
                                <th class="text-center">Status</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($applications) > 0)
                                @foreach ($applications as $application)
                                    @php
                                        $agent_id = $application['agent_id'];
                                        $status = $application['status'] ?? '';
                                        $created_at = $application['created_at'];
                                        $fullname = " {$application['first_name']}  {$application['middle_name']} {$application['last_name']} ";
                                        $mobile = show_phone($application['mobile']) ?? '';
                                        $email = $application['email'] ?? '';
                                        $code = $application['code'] ?? '';
                                        $status = show_status($status);
                                        $created_at = date('H:i:s d-m-Y', strtotime($created_at));
                                        $ambassadorInfo = License::showInfo($agent_id);
                                    @endphp
                                    <tr>
                                        <td> {{ $code }} </td>
                                        <td> {{ $fullname }} </td>
                                        <td>{{ $mobile }}</td>
                                        <td>{{ $email }}</td>
                                        <td>{!! $ambassadorInfo !!}</td>
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
                <div class="tab-pane p-3" id="complete" role="tabpanel">
                    <table class="table table-xlg non-license-data obn-table" id="licences">
                        <thead>
                            <tr>
                                <th>ID </th>
                                <th>Name </th>
                                <th>Mobile </th>
                                <th>Email </th>
                                <th>Ambassador Info</th>
                                <th class="text-center">Status</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($loans) > 0)
                                @foreach ($loans as $loan)
                                    @php
                                        $agent_id = $loan['agent_id'];
                                        $status = $loan['status'] ?? '';
                                        $created_at = $loan['created_at'];
                                        $fullname = " {$loan['first_name']}  {$loan['middle_name']} {$loan['last_name']} ";
                                        $mobile = show_phone($loan['mobile']) ?? '';
                                        $email = $loan['email'] ?? '';
                                        $code = $loan['code'] ?? '';
                                        $status = show_status($status);
                                        $created_at = date('H:i:s d-m-Y', strtotime($created_at));
                                        $ambassadorInfo = License::showInfo($agent_id);
                                    @endphp
                                    <tr>
                                        <td> {{ $code }} </td>
                                        <td> {{ $fullname }} </td>
                                        <td>{{ $mobile }}</td>
                                        <td>{{ $email }}</td>
                                        <td>{!! $ambassadorInfo !!}</td>
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
        </div>
    </div>
@endsection
