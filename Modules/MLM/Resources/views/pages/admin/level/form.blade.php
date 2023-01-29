@extends('admin.master')
@section('title', $title)
@section('page_title', $title)
@section('content')
    @include('admin.templates.page_title', [
        'showButton' => '1',
        'parent' => [
            'name' => "List Level of {$mlmType['name']}",
            'url' => route("{$controllerName}/index", ['slug' => $slug]),
        ],
        'backUrl' => route("{$controllerName}/index", ['slug' => $slug]),
    ])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form
                        action="{{ !$id ? route("{$controllerName}/save") : route("{$controllerName}/save", ['id' => $id]) }}"
                        method="post" id="form-save" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name (*)</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ $item['name'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="short_name">Short Name (*)</label>
                                    <input type="text" class="form-control" name="short_name" id="short_name"
                                        value="{{ $item['short_name'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @php
                                $child_id = $item['child_id'] ?? '';
                            @endphp
                            @if ($slug == 'non-licensed')
                                <div class="col-md-6" id="numberLead">
                                    <div class="form-group">
                                        <label for="number_lead">Number Leads (*)</label>
                                        <input type="text" class="form-control" name="number_lead" id="number_lead"
                                            value="{{ $item['number_lead'] ?? '' }}">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Child Level (*)</label>
                                        <select name="child_id" id="levelNonlicence" class="form-control"
                                            {{ $slug == 'licensed' ? 'style = display:none; ' : '' }}>
                                            <option value="">Select Child Level</option>
                                            @if (count($mlmLevelsNonLicence) > 0)
                                                @foreach ($mlmLevelsNonLicence as $value)
                                                    <option value="{{ $value['id'] }}"
                                                        {{ $child_id == $value['id'] ? 'selected' : '' }}>
                                                        {{ $value['name'] ?? '-' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6" id="numberLoan">
                                    <div class="form-group">
                                        <label for="number_order">Number Loans (*)</label>
                                        <input type="text" class="form-control" name="number_order" id="number_order"
                                            value="{{ $item['number_order'] ?? '' }}">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="name">Child Level (*)</label>
                                    <select name="child_id" id="levelLicence" class="form-control">
                                        <option value="">Select Child Level</option>
                                        @if (count($mlmLevelsLicence) > 0)
                                            @foreach ($mlmLevelsLicence as $value)
                                                <option value="{{ $value['id'] }}"
                                                    {{ $child_id == $value['id'] ? 'selected' : '' }}>
                                                    {{ $value['name'] ?? '-' }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            @endif
                        </div>
                        <div class="buttons">
                            <input type="hidden" name="id" value="{{ $item['id'] ?? '' }}">
                            <input type="hidden" name="mlm_type_id" value="{{ $mlm_type_id  ?? '' }}">
                            <input type="hidden" name="slug" value="{{ $slug ?? '' }}">
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
        let mlmType = $(`select[name='mlm_type_id']`);
        let numberLead = $(`#numberLead`);
        let numberLoan = $(`#numberLoan`);
        let levelLicence = $(`#levelLicence`);
        let levelNonLicence = $(`#levelNonlicence`);
        mlmType.change(function() {
            let mlm_type_id = $(this).val();
            let slug = mlmType.find('option:selected').data('slug');
            if (slug == 'licensed') {
                numberLoan.show();
                numberLead.hide();
                levelLicence.show();
                levelNonLicence.val('');
                levelNonLicence.hide();
            } else {
                numberLead.show();
                numberLoan.hide();
                levelNonLicence.show();
                levelLicence.hide();
                levelLicence.val('');
            }
        })
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
