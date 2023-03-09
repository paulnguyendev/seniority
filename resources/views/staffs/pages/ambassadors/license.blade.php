@php
    use App\Helpers\Agent;
@endphp
@if (count($items) > 0)
    @foreach ($items as $item)
        @php
            $id = $item['id'];
            $parent_id = $item['parent_id'];
            $status = $item['status'];
            $created_at = $item['created_at'];
            $showInfo = Agent::showInfo($id);
            $parentInfo = Agent::showInfo($parent_id);
            $status = show_status($status);
            $created_at = date('H:i:s d-m-Y', strtotime($created_at));
            $verify_code = $item['verify_code'] ?? '';
            $route_verify = route("{$routeName}/sendMailVerify", ['email' => $item['email'], 'token' => $item['token'], 'verify_code' => $verify_code]);
            
            $route_trash = route("{$routeName}/trash", ['id' => $item['id']]);
            $route_restore = route("{$routeName}/updateField", ['id' => $item['id'], 'task' => 'restore']);
        @endphp
        <tr>
            <td>
                <input class="check_single_row" type="checkbox" bs-type="checkbox" name="select_data"
                    value="{{ $item['id'] }}">
            </td>
            <td class=" text-center no-padding-right">
                <img class="thumb-sm  rounded-circle " src="http://localhost/seniority/public/uploads/images/default.png">
            </td>
            <td>{!! $showInfo !!}</td>
            <td> {!! $parentInfo !!} </td>
            <td class=" text-center"> {!! $status !!} </td>
            <td>{!! $created_at !!} </td>
            <td class=" option-actions text-right no-padding-right">
                <div class="button-items text-right">
                    <a href="{{ route("{$routeName}/form", ['id' => $id]) }}"
                        class="btn btn-info waves-effect waves-light btn-sm">
                        <i class="fas fa-pencil-alt mr-2"></i> Edit
                    </a>
                    <a href="{{ isset($routeName) ? route("{$routeName}/suspend", ['id' => $id, 'suspend' => $item['is_suppend']]) : '#' }}"
                        class="btn  {{ $item['is_suppend'] == '0' ? 'btn-danger' : 'btn-success' }} waves-effect waves-light btn-sm suspend-button">
                        <i class="fas fa-ban mr-2"></i> {{ $item['is_suppend'] == '1' ? 'UnSuspend' : 'Suspend' }}
                    </a>
                    <a href="{{ $route_verify }}"
                        class="btn btn-warning waves-effect waves-light btn-sm send-mail-verify">
                        <i class="far fa-envelope mr-2"></i> Send Mail Verify
                    </a>
                </div>
            </td>
            <td>
                @if ($item['status'] == 'trash')
                    <a href="{{ $route_restore }}" class="restore-item text-success-600" data-title="null"
                        data-message="null" title="Restore">
                        <i class="mdi mdi-backup-restore"></i></a>
                @else
                    <a href="{{ $route_trash }}" class="trash_item text-danger-600" data-title="null"
                        data-message="null" title="Trash"><i class="icon-trash"></i></a>
                @endif
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="7" class="text-center">No data</td>
    </tr>
@endif
