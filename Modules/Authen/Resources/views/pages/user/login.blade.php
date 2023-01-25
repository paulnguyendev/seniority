@extends("{$moduleName}::layouts.master")
@section('content')
    <div class="login-userheading">
        <h3>Đăng nhập hệ thống thành viên
        </h3>
    </div>
    <form id="form-login" method="post" action="{{ route('auth_api/login') }}">
        <div class="form-login">
            <label>Email</label>
            <div class="form-addons">
                <input type="text" placeholder="Nhập email đăng nhập">
                <img src="{{ asset('themes/dashboard') }}/img/icons/mail.svg" alt="img">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-login">
            <label>Mật khẩu</label>
            <div class="pass-group">
                <input type="password" class="pass-input" placeholder="Nhập mật khẩu của bạn">
                <span class="fas toggle-password fa-eye-slash"></span>
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-login">
            <div class="alreadyuser">
                <h4><a href="{{ route('auth_user/forget') }}" class="hover-a">Quên mật khẩu</a></h4>
            </div>
        </div>
        <div class="form-login">
            <button type="button" class="btn btn-login"
                onclick="nav_submit_form(this)" data-form="form-login">Đăng nhập</button>
        </div>
        <div class="signinform text-center">
            <h4>Bạn chưa có tài khoản? <a href="{{ route('auth_user/register') }}" class="hover-a">Đăng ký ngay</a></h4>
        </div>
    </form>
    
@endsection
