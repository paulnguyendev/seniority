<!DOCTYPE html>
<html lang="en">
<head>
    @include('authen::elements.head')
</head>
<body class="account-page">
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <div class="login-logo logo-normal">
                            <img src="{{ asset('themes') }}/logo.png" alt="img">
                        </div>
                        <a href="index.html" class="login-logo logo-white">
                            <img src="{{ asset('themes') }}/logo.png" alt="">
                        </a>
                        @yield('content')
                    </div>
                </div>
                <div class="login-img">
                    <img src="{{ asset('themes/dashboard') }}/img/login.jpg" alt="img">
                </div>
            </div>
        </div>
    </div>
    <div class="loading-wrap">
        <div class="loading-inner">
            <div class="bounce-loading">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('themes/dashboard') }}/js/jquery-3.6.0.min.js"></script>
    <!-- Feather Icon JS -->
    <script src="{{ asset('themes/dashboard') }}/js/feather.min.js"></script>
    <!-- Bootstrap Core JS -->
    <script src="{{ asset('themes/dashboard') }}/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('themes/dashboard') }}/js/script.js"></script>
    <script src="{{ asset('obn') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('obn') }}/js/plugin.js"></script>
    <script src="{{ asset('obn') }}/js/notice.js"></script>
    <script src="{{ asset('obn') }}/js/wb.form.js"></script>
    <script src="{{ asset('obn') }}/js/functions.js?ver={{ time() }}"></script>
</body>
</html>
