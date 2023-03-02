@php
     $applicationStatus = config('obn.application');
@endphp
<select class="select2 form-control mb-3 custom-select" name="status" style="width: 300px!important; height:36px;">
    <option value="" selected="selected"> All Status</option>
    <option value="complete" >Complete</option>
    <option value="active" >Active</option>
</select>
