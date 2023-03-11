@php
    use App\Helpers\Agent;
@endphp
@extends('core.dashboard')
@section('title', $title)
@section('page_title', $title)
@section('content')
    @include('staff.templates.page_title', [
        'showButton' => '1',
        'parent' => [
            'name' => 'Application List',
            'url' => route("{$routeName}/index"),
        ],
        'backUrl' => route("{$routeName}/index"),
    ])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ !$id ? route("{$routeName}/save") : route("{$routeName}/save", ['id' => $id]) }}"
                        method="post" id="form-save" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="code">Application ID (*)</label>
                                    <input type="text" class="form-control" name="code" id="code"
                                        value="{{ $item['code'] ?? application_random_code() }}" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="first_name">First Name (*)</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name"
                                        value="{{ $item['first_name'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="middle_name">Middle Name </label>
                                    <input type="text" class="form-control" name="middle_name" id="middle_name"
                                        value="{{ $item['middle_name'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="last_name">Last Name (*)</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name"
                                        value="{{ $item['last_name'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email (*)</label>
                                    <input type="text" class="form-control" name="email" id="email"
                                        value="{{ $item['email'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile">Mobile (*)</label>
                                    <input type="text" class="form-control" data-mask="(999) 999-9999" name="mobile"
                                        id="mobile"
                                        value="{{ isset($item['mobile']) ? show_phone($item['mobile']) : '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    @php
                                        $status = $item['status'] ?? '';
                                        $applicationStatus = config('obn.application');
                                    @endphp
                                    <label for="text">Status (*)</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="">Choose Status</option>
                                        @foreach ($applicationStatus as $keyStatus => $itemStatus)
                                            @php
                                                
                                                $itemStatusName = $itemStatus['name'] ?? '';
                                            @endphp
                                            <option value="{{ $keyStatus }}"
                                                {{ $status == $keyStatus ? 'selected' : '' }}>{{ $itemStatusName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    @php
                                        $agent_id = $item['agent_id'] ?? '';
                                       
                                    @endphp
                                    <label for="text">Ambassador (*)</label>
                                    <select name="agent_id" id="" class="form-control select2">
                                        <option value="">Choose Ambassador</option>
                                        @foreach ($agents as $agent)
                                            <option value="{{ $agent['id'] }}" {{$agent_id == $agent['id'] ? "selected" : ""}}>
                                                {{ Agent::getLicenseAgentInfo($agent['id'], 'fullname') }}</option>
                                        @endforeach
                                    </select>
                                   
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="buttons">
                            <input type="hidden" name="id" value="{{ $item['id'] ?? '' }}">
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
        let form = $("#form-save");
        form.submit(function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            let data = getFormData($(this));
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
                    } else if (status == 500) {
                        deleteError();
                        swal("Warning", msg, "warning");
                    } else {
                        swal("Oops", "Please check the information again", "error").then(() => {
                            showError(msg);
                        })
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
