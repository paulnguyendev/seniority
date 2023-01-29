@extends('admin.master')
@section('title', $title)
@section('page_title', $title)
@section('content')
    @include('admin.templates.page_title', [
        'showButton' => '1',
        'parent' => [
            'name' => 'User List',
            'url' => route("{$controllerName}/index"),
        ],
        'backUrl' => route("{$controllerName}/index"),
    ])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form
                        action="{{ !$id ? route("{$controllerName}/save") : route("{$controllerName}/save", ['id' => $id]) }}"
                        method="post" id="form-save" enctype="multipart/form-data">
                        <div class="row">
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
                                    <label for="phone">Mobile (*)</label>
                                    <input type="text" class="form-control" data-mask="(999) 999-9999" name="phone"
                                        id="phone" value="{{ $item['phone'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username (*)</label>
                                    <input type="text" class="form-control" name="username" id="username"
                                        value="{{ $item['username'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password (*)</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        value="{{ isset($item['password']) ? md5($item['password']) : '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="text">User ID (*)</label>
                                    <input type="text" class="form-control" name="code" id="code"
                                        value="{{ $item['code'] ?? random_code() }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="text">Sponsor</label>
                                    <select name="parent_id" id="" class="form-control select2">
                                        @foreach ($users as $user)
                                            <option value="{{ $user['id'] }}">
                                                {{ UserHelper::getUserInfo($user['id'], 'fullname') }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            @php
                                $mlm_type_id = $item['mlm_type_id'] ?? '';
                                $mlmLevels = $mlmlLevelModel->listItems(['mlm_type_id' => $mlm_type_id], ['task' => 'list']);
                            @endphp
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text">MLM Type (*)</label>
                                    <select name="mlm_type_id" id="" class="form-control">
                                        <option value="">Choose MLM Type</option>
                                        @foreach ($mlmTypes as $mlmType)
                                            <option data-slug="{{ $mlmType['slug'] }}"
                                                {{ $mlm_type_id == $mlmType['id'] ? 'selected' : '' }}
                                                data-url="{{ route('mlm_admin_level/data', ['slug' => $mlmType['slug']]) }}"
                                                value="{{ $mlmType['id'] }}">{{ $mlmType['name'] ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text">MLM Level (*)</label>
                                    <select name="mlm_level_id" id="" class="form-control select2">
                                        @foreach ($mlmLevels as $mlmLevel)
                                            <option value="{{ $mlmLevel['id'] }}">{{ $mlmLevel['name'] ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    @php
                                        $status = $item['status'] ?? '';
                                    @endphp
                                    <label for="text">Status (*)</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="">Choose Status</option>
                                        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>


                        </div>
                        <div class="buttons">
                            <input type="hidden" name="id" value="{{$item['id'] ?? ""}}">
                            <input type="hidden" name="type" value="{{$item['type'] ?? "user"}}">
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
        let mlmType = $(`select[name="mlm_type_id"]`);
        let mlmLevel = $(`select[name="mlm_level_id"]`);
        mlmType.change(function() {
            let optionSelected = mlmType.find('option:selected');
            let mlm_type_id = $(this).val();
            let url = optionSelected.data('url');
            $.ajax({
                type: "get",
                url: url,
                data: {
                    'mlm_type_id': mlm_type_id,
                    'start': 0
                },
                dataType: "json",
                success: function(response) {
                    let data = response.data;
                    let xhtml = '';
                    data.forEach((item, key) => {
                        xhtml += `<option value = '${item.id}'>${item.name}</option>`;


                    });
                    mlmLevel.html(xhtml);
                    console.log(data);
                    console.log(xhtml);
                }
            });
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
