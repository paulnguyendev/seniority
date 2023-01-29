@extends('admin.master')
@section('title', $title)
@section('page_title', $title)
@section('content')
    @include('admin.templates.page_title', [
        'showButton' => '1',
        'parent' => [
            'name' => "Setting List of {$mlmLevel['name']}",
            'url' => route("{$controllerName}/index", ['level_id' => $level_id]),
        ],
        'backUrl' => route("{$controllerName}/index", ['level_id' => $level_id]),
    ])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form
                        action="{{ !$id ? route("{$controllerName}/save") : route("{$controllerName}/save", ['id' => $id]) }}"
                        method="post" id="form-save" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">Name (*)</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ $item['name'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="commission">Commission (*)</label>
                                    <input type="text" class="form-control" name="commission" id="commission"
                                        value="{{ $item['commission'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">Commission Type (*)</label>
                                    @php
                                        $commission_type = $item['commission_type'] ?? "";
                                    @endphp
                                    <select name="commission_type" id="" class="form-control">
                                        <option value="percentage" {{$commission_type == 'percentage' ? "selected" : ""}}>Percent (%)</option>
                                        <option value="number" {{$commission_type == 'number' ? "selected" : ""}}>Money ($)</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">Commission Group (*)</label>
                                    @php
                                        $commission_group = $item['commission_group'] ?? 'direct';
                                    @endphp
                                    <select name="commission_group" id="commission_group" class="form-control">
                                        <option value="direct" {{ $commission_group == 'direct' ? 'selected' : '' }}>Direct
                                        </option>
                                        <option value="indirect" {{ $commission_group == 'indirect' ? 'selected' : '' }}>
                                            Indirect</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                       
                        <div class="row {{ $commission_group == 'direct' ? 'd-none' : 'd-block' }} " id="mlm-levels">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Level</label>
                                    @php
                                        $mlm_indirect_level_id = $item['mlm_indirect_level_id'] ?? "";
                                    @endphp
                                    <select name="mlm_indirect_level_id" id="mlm_indirect_level_id"
                                        class="form-control select2">
                                        
                                        @if (count($levels) > 0)
                                            @foreach ($levels as $level)
                                                <option value="{{ $level['id'] }}"
                                                    {{ $mlm_indirect_level_id == $level['id'] ? 'selected' : '' }}>
                                                    {{ $level['name'] ?? '' }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="buttons">
                            <input type="hidden" name="mlm_level_id" value="{{ $level_id }}">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_script')
    <script>
        let mlmLevels = $("#mlm-levels");
        let commission_group = $(`select[name='commission_group']`);
        commission_group.change(function() {
            let commission_group = $(this).val();
            if (commission_group == 'indirect') {
                mlmLevels.removeClass('d-none');
                mlmLevels.addClass('d-block');
            } else {
                mlmLevels.removeClass('d-block');
                mlmLevels.addClass('d-none');
            }
        })
        let form = $("#form-save");
        form.submit(function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            let data = getFormData($(this));
            let commission_group_val = commission_group.val();
            console.log(commission_group_val);
            if(commission_group_val == 'direct') {
                data['mlm_indirect_level_id'] = '';
            }
            console.log(data);
            $.ajax({
                type: "post",
                url: url,
                data: data,
                dataType: "json",
                beforeSend: function() {
                    showLoading();
                },
                success: function(response) {
                    let status = response.status;
                    let msg = response.msg;
                    let redirect = response.redirect;
                    console.log(redirect)
                    if (status == 200) {
                        swal("Notification", msg, "success").then(() => {
                            if (redirect) {
                                window.location.href = redirect
                            } else {
                                location.reload();
                            }
                        })
                    } else {
                        showError(msg);
                    }
                },
                error: function(error) {
                    swal("Oops", "Something went wrong", "error");
                    console.log(error);
                },
                complete: function() {
                    hideLoading();
                }
            });
        })
    </script>
@endsection
