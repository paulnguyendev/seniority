@php
    use App\Helpers\Agent;
@endphp
<div class="table-header" style="overflow:auto">
    <div class="table-header-left">
        <div class="dataTables_action_item">
            <select class="action_datatable form-control" name="option_apply" style="max-width: 150px">
                <option value="">Choose action</option>
                <option value="delete_selected">Delete</option>
            </select>
        </div>
        <div class="dataTables_action_item">
            <button type="button" class="btn btn-default button_apply">Apply</button>
        </div>
    </div>
    <div class="table-header-right">
        <div class="dataTables_action_item">
            <select class="select2 form-control mb-3 custom-select table-filter"
                data-url="{{ route("{$routeName}/showData") }}" data-table="{{$table}}" data-column="parent_id"
                style="width: 300px!important; height:36px;">
                <option value="" selected="selected"> All Ambassador</option>
                @foreach ($items as $key => $item)
                    @php
                        $fullname = $table == 'non-licences' ?  Agent::getNonLicenseAgentInfo($item['id'], 'fullname') :  Agent::getLicenseAgentInfo($item['id'], 'fullname');
                    @endphp
                    <option value="{{ $item['id'] }}"> {{ $fullname ?? '' }} </option>
                @endforeach
            </select>
        </div>
        <div class="dataTables_action_item">
            <select class="select2 form-control mb-3 custom-select table-filter"
                data-url="{{ route("{$routeName}/showData") }}" data-table="{{$table}}" data-column="status"
                style="width: 300px!important; height:36px;">
                <option value="" selected="selected"> All Status</option>
                @foreach (config('obn.ambassador') as $key => $item)
                    <option value="{{ $key }}"> {{ $item['name'] ?? '' }} </option>
                @endforeach
            </select>
        </div>
        <div class="dataTables_action_item">
            <input type="text" class="form-control table-search" placeholder="Enter your Keyword"
                data-url="{{ route("{$routeName}/showData") }}" data-table="{{$table}}">
        </div>
    </div>
</div>