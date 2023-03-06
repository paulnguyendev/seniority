@extends("agents.master.auth")
@section('title', 'Mortgage Ambassador Sign Up')
@section('body_class', 'page-register')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="text-center m-b-15">
                <a href="#" class="logo logo-admin"><img src="{{ asset('themes/dashboard_v2') }}/assets/obn/logo.png"
                        height="100" alt="logo"></a>
            </div>
            <h1 class="text-center title-auth">Mortgage Ambassador Sign Up</h1>
            <div class="p-3">
                <form class="form-horizontal m-t-20" id="form-submit" action="{{ route("{$routeName}/postRegister") }}"
                    method="post">
                    <div class="form-group row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="first_name">First Name (*)</label>
                                <input class="form-control" type="text" placeholder="First Name" name="first_name"
                                    id="first_name">
                                <span class="help-block"></span>
                            </div>

                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="middle_name">Middle Name</label>
                                <input class="form-control" type="text" placeholder="Middle Name" name="middle_name"
                                    id="middle_name">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input class="form-control" type="text" placeholder="Last Name" name="last_name"
                                    id="last_name">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Email (*)</label>
                                <input class="form-control" type="text" placeholder="Email" name="email"
                                    id="email">
                                <span class="help-block"></span>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="mobile">Mobile (*)</label>
                                <input class="form-control" type="text" placeholder="Mobile" name="mobile"
                                    id="mobile" data-mask="(999) 999-9999">
                                <span class="help-block"></span>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="username">Username (*)</label>
                                <input class="form-control" type="text" placeholder="Username" name="username"
                                    id="username">
                                <span class="help-block"></span>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="password">Password (*)</label>
                                <input class="form-control" type="password" placeholder="Password" name="password"
                                    id="password">
                                <span class="help-block"></span>
                            </div>

                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="password">Sponsor ID (*)</label>
                                <input class="form-control" type="text" placeholder="Sponsor ID" id="sponsor_id"
                                    id="sponsor_id" data-url="{{ route("{$routeName}/agentCheckParent") }}" name="sponsor_id">
                                <span class="help-block"></span>
                                <input type="hidden" name="parent_id">
                                <div class="agent-info"></div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Sign
                                Up</button>
                        </div>
                    </div>
                    <div class="form-group m-t-10 mb-0 text-center">
                        Already have account? <a class="text-info" href="{{route("{$routeName}/login")}}"> Sign In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('custom_script')
    <script>
        const sponsor_id = $("#sponsor_id");
        const agentInfo = $(".agent-info");
        sponsor_id.keyup(function() {
            let code = $(this).val();
            let url = $(this).data('url');
            $.ajax({
                type: "post",
                url: url,
                data: {
                    code: code
                },
                dataType: "json",
                beforeSend: function() {
                    showLoading();
                },
                success: function(response) {
                    let status = response.status;
                    let msg = response.msg;
                    console.log(status);
                    agentInfo.html('');
                    agentInfo.removeClass('active');
                    $(`input[name='parent_id']`).val('');
                    if (status == 200) {
                        let id = response.id;
                        let thumbnail = response.thumbnail;
                        let fullname = response.fullname;
                        $(`input[name='parent_id']`).val(id);
                        let html = `<img src = "${thumbnail}" ></img> <span>${fullname}</span> `;
                        agentInfo.addClass('active');
                        agentInfo.html(html);

                    }
                  
                },
                complete: function() {
                    hideLoading();
                }
            });
        })
        const formSubmit = $("#form-submit");
        formSubmit.submit(function(e) {
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
                    console.log(response);
                    let status = response.status ?? 400;
                    let msg = response.msg ?? " ";
                    if (status == 400) {
                        showError(msg);
                    } else {
                        formSubmit.removeClass('has-error');
                        swal("Notification", msg, "success").then(() => {
                            window.location.href = response.redirect;
                        });
                    }
                },
                complete: function() {
                    hideLoading();
                }
            });
        })
    </script>
@endsection
