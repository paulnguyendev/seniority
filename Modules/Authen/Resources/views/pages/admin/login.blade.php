@extends("{$moduleName}::layouts.master")
@section('title', 'Admin Login')
@section('content')
    <div class="login-userheading">
        <h3>Đăng nhập hệ thống admin
        </h3>
    </div>
    <div class="form-login">
        <label>Email</label>
        <div class="form-addons">
            <input type="text" placeholder="Nhập email đăng nhập">
            <img src="{{ asset('themes/dashboard') }}/img/icons/mail.svg" alt="img">
        </div>
    </div>
    <div class="form-login">
        <label>Mật khẩu</label>
        <div class="pass-group">
            <input type="password" class="pass-input" placeholder="Nhập mật khẩu của bạn">
            <span class="fas toggle-password fa-eye-slash"></span>
        </div>
    </div>
    <div class="form-login">
        <a class="btn btn-login" href="index.html">Đăng nhập</a>
    </div>
@endsection
