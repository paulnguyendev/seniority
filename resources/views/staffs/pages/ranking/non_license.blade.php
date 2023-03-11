@php
    use App\Helpers\Level;
@endphp
@if (count($items) > 0)
    @foreach ($items as $key => $item)
        @php
            $index = $key + 1;
            $id = $item['id'];
            $unit = isset($unit) ? $unit : "";
            $condition = $item->conditionLevel()->first();
            $direct_level_id = $condition['direct_level_id'] ?? "";
            $number_product = $condition['number_product'] ?? "";
            $number_product = $number_product ? " + " . $number_product . " loans" : "";
            $number_agent = $condition['number_agent'] ?? 0;
            $direct_level_name = Level::getLevelInfo($direct_level_id,'name','non_license');
            $condition_name = $condition  ?  "( {$number_agent} {$direct_level_name}  {$number_product}  )" : "";
            $route_edit = route("{$routeName}/form",['id' => $id]);
        @endphp
        <tr>
            <td class="text-center"> {{$index}} </td>
            <td>{!! $item['name'] ?? '' !!}</td>
            <td class="text-center">{!! $item['personal_payout'] ?? 0 !!} {{$unit}} </td>
            <td class="text-center"> {{$item['team_overrides'] ?? 0 }} % {{$condition_name}} </td>
            <td>
                <div class="button-items text-right">
                    <a href="{{$route_edit}}" class="btn btn-info waves-effect waves-light btn-sm">
                        <i class="fas fa-pencil-alt mr-2"></i>
                        Edit</a>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="7" class="text-center">No data</td>
    </tr>
@endif
