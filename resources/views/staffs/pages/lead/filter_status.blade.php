@php
     $applicationStatus = config('obn.lead');
@endphp
<select class="select2 form-control mb-3 custom-select" name="status" style="width: 300px!important; height:36px;">
    <option value="" selected="selected"> All Status</option>
    @foreach ($applicationStatus as $keyStatus => $itemStatus)
        @php
            $itemStatusName = $itemStatus['name'] ?? '';
        @endphp
        <option value="{{ $keyStatus }}" >{{ $itemStatusName }}
        </option>
    @endforeach
</select>
