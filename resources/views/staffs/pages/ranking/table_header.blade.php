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
            <input type="text" class="form-control table-search" placeholder="Enter your Keyword"
                data-url="{{ route("{$routeName}/showData") }}" data-table="{{$table}}">
        </div>
    </div>
</div>