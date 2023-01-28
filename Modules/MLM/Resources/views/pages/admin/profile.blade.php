@extends('admin.master')
@section('page_title', 'Profile')
@section('custom_style')
    <link href="{{ asset('obn') }}/css/plugin.css" rel="stylesheet">
@endsection
@section('content')
    @include('admin.templates.page_title', [
        'parent' => ['name' => 'User', 'url' => route('user_admin/index')],
    ])
    @php
        $user = UserHelper::getUserInfo();
        $userThumbUrl = UserHelper::getUserInfo('', 'thumbnail');
    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user_admin/profileSave') }}" method="post" id="form-profile"
                        enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Avatar</label>
                                    <input id="thumbnail" name="thumbnail" type="hidden"
                                        value="{{ $user['thumbnail'] ?? '' }}">
                                    <div class="media-item">
                                        <img class="img-thumbnail"
                                            data-no-image="{{ asset('themes/dashboard_v2') }}/assets/images/users/avatar-1.jpg"
                                            width="150px" height="120px" id="holder_thumbnail" style="max-height: 100%"
                                            src="{{ $userThumbUrl ?? asset('themes/dashboard_v2/assets/images/users/avatar-1.jpg') }}">
                                    </div>
                                    <div class="clearfix"></div>
                                    <a style="margin-top: 5px;margin-bottom: 3px" data-input="thumbnail" data-type="single"
                                        data-preview="holder_thumbnail" id="lfm_thumbnail" class="btn ;btn-sm btn-default"
                                        bs-type="filemanager">
                                        Upload Avatar
                                    </a>


                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="first_name">First Name (*)</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name"
                                        value="{{ $user['first_name'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control" name="middle_name" id="middle_name"
                                        value="{{ $user['middle_name'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="last_name">Last Name (*)</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name"
                                        value="{{ $user['last_name'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Email (*)</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{ $user['email'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="phone">Mobile (*)</label>
                                    <input type="text" data-mask="(999) 999-9999" class="form-control" name="phone"
                                        id="phone" value="{{ $user['phone'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="buttons">
                            <input type="hidden" name="id" value="{{ $user['id'] ?? '' }}">
                            <button class="btn btn-primary mr-2">Save</button>
                            <a href="{{ route('home_admin/index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_script')
    <script>
        $('#lfm_thumbnail').mlibready({
            returnto: '#thumbnail',
            maxselect: 1,
            runfunction: 'fillImage',
            maxFilesize: 5
        });
        let form = $("#form-profile");
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
                    if (status == 200) {
                        swal("Notification", msg, "success").then(() => {
                            location.reload();
                        })
                    }
                    else {
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
