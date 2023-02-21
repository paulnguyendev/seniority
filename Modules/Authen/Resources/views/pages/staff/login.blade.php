@extends("{$moduleName}::layouts.master2")
@section('title', 'Staff Login')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="text-center m-b-15">
                <a href="#" class="logo logo-admin"><img src="{{ asset('themes/dashboard_v2') }}/assets/obn/logo.png"
                        height="100" alt="logo"></a>
            </div>
            <h1 class="text-center title-auth">Staff Login</h1>
            <div class="p-3">
                <form class="form-horizontal m-t-20" id="form-login" action="{{ route("{$controllerName}/postLogin") }}"
                    method="post">
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="text" placeholder="Username" name="username">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="password" placeholder="Password" name="password">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log
                                In</button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
@endsection
@section('custom_script')
    <script>
        const formLogin = $("#form-login");
        formLogin.submit(function(e) {
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
                    let status = response.status ?? 400;
                    let msg = response.msg ?? " ";
                    if (status == 400) {
                        showError(msg);
                    } else {
                        formLogin.removeClass('has-error');
                        window.location.href = response.redirect;
                    }
                },
                complete: function() {
                    hideLoading();
                }
            });
        })
    </script>
@endsection
