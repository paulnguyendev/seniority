@php
    use App\Helpers\Agent;
@endphp
@extends('core.dashboard')
@section('custom_style')
    <style>
        #applicationInfo {
            display: none;
        }
    </style>
@endsection
@section('title', $title)
@section('page_title', $title)
@section('content')
    @include('staff.templates.page_title', [
        'showButton' => '1',
        'parent' => [
            'name' => 'Loans List',
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
                                    <label for="code">Loans ID(*)</label>
                                    <input type="text" class="form-control"
                                       name="code" id="code" value="{{ $item['code'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="total">Amount(*)</label>
                                    <input type="number" class="form-control"
                                        name="total" id="total" value="{{ $item['total'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    @php
                                        $application_id = $item['application_id'] ?? '';
                                    @endphp
                                    <label for="text">Application (*)</label>
                                    <select name="application_id" id=""
                                        data-url="{{ route("{$routeName}/application") }}" class="form-control select2">
                                        <option value="">Choose Application</option>
                                        @if (count($applications) > 0)
                                            @foreach ($applications as $application)
                                                @php
                                                    $applicationId = $application['id'];
                                                    $applicationCode = $application['code'] ?? '';
                                                    $applicationFirstName = $application['first_name'] ?? '';
                                                    $applicationMiddleName = $application['middle_name'] ?? '';
                                                    $applicationLastName = $application['last_name'] ?? '';
                                                    $applicationEmail = $application['email'] ?? '';
                                                    $applicationName = "{$applicationCode} - {$applicationFirstName} {$applicationMiddleName} {$applicationLastName} - {$applicationEmail}";
                                                @endphp
                                                <option value="{{ $applicationId }}">{{ $applicationName }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>


                        </div>

                        <div class="row" id="applicationInfo">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="first_name">First Name (*)</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name"
                                        value="{{ $item['first_name'] ?? '' }}" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="middle_name">Middle Name </label>
                                    <input type="text" class="form-control" name="middle_name" id="middle_name"
                                        value="{{ $item['middle_name'] ?? '' }}" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="last_name">Last Name (*)</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name"
                                        value="{{ $item['last_name'] ?? '' }}" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email (*)</label>
                                    <input type="text" class="form-control" name="email" id="email"
                                        value="{{ $item['email'] ?? '' }}" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile">Mobile (*)</label>
                                    <input type="text" class="form-control" data-mask="(999) 999-9999" name="mobile"
                                        id="mobile"
                                        value="{{ isset($item['mobile']) ? show_phone($item['mobile']) : '' }}" readonly>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>


                        <div class="buttons">
                            <input type="hidden" name="agent_id">
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
        let applications = $(`select[name="application_id"]`);
        let applicationInfo = $("#applicationInfo");
        applications.change(function() {
            let applicationId = $(this).val();
            let url = $(this).data('url');

            if (applicationId) {

                $.ajax({
                    type: "get",
                    url: url,
                    data: {
                        applicationId: applicationId
                    },
                    dataType: "json",
                    beforeSend: function() {
                        showLoading();
                    },
                    success: function(response) {
                        let first_name = response.first_name ? response.first_name : "";
                        let middle_name = response.middle_name ? response.middle_name : "";
                        let last_name = response.last_name ? response.last_name : "";
                        let email = response.email ? response.email : "";
                        let mobile = response.mobile ? response.mobile : "";
                        let agent_id = response.agent_id ? response.agent_id : "";
                        applicationInfo.css('display', 'flex');
                        $(`input[name="first_name"]`).val(first_name);
                        $(`input[name="middle_name"]`).val(middle_name);
                        $(`input[name="last_name"]`).val(last_name);
                        $(`input[name="email"]`).val(email);
                        $(`input[name="mobile"]`).val(mobile);
                        $(`input[name="agent_id"]`).val(agent_id);
                        console.log(response);
                    },
                    complete: function() {
                        hideLoading();
                    }
                });
            } else {
                applicationInfo.hide();
            }
        });
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
