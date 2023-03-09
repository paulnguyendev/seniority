@php
    use App\Helpers\Agent;
@endphp
<select class="select2 form-control mb-3 custom-select" name="parent_id" style="width: 300px!important; height:36px;">
    <option value="" selected="selected"> All Sponsor</option>
    @if (count($agents) > 0)
        @foreach ($agents as $agent)
            @php
                $id = $agent['id'] ?? "";
                $fullname = Agent::getLicenseAgentInfo($id,'fullname');
            @endphp
            <option value="{{$id}}">{{ $fullname }}</option>
        @endforeach
    @endif
</select>
