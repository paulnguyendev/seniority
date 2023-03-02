<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Core dashboard')</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="{{ asset('themes/dashboard_v2') }}/assets/images/favicon.ico">
    <link href="{{ asset('themes/dashboard_v2') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('themes/dashboard_v2') }}/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('themes/dashboard_v2') }}/assets/css/style.css" rel="stylesheet" type="text/css">
    <!-- Sweet Alert -->
    <link href="{{ asset('themes/dashboard_v2') }}/assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('themes/dashboard_v2') }}/assets/obn/app.css?ver={{time()}}" rel="stylesheet" type="text/css">
</head>
<body class="@yield('body_class','default-dashboard')">
    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">
        @yield('content')
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
    <!-- jQuery  -->
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/jquery.min.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/popper.min.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/bootstrap.min.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/modernizr.min.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/waves.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/jquery.slimscroll.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/jquery.nicescroll.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/jquery.scrollTo.min.js"></script>
     <!-- Bootstrap inputmask js -->
     <script src="{{ asset('themes/dashboard_v2') }}/assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
     <script src="{{ asset('themes/dashboard_v2') }}/assets/pages/form-mask.init.js"></script>
    <!-- KNOB JS -->
    <script src="{{ asset('themes/dashboard_v2') }}/assets/plugins/jquery-knob/excanvas.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/plugins/jquery-knob/jquery.knob.js"></script>
    <!-- Sweet-Alert  -->
    <script src="{{ asset('themes/dashboard_v2') }}/assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
    <!-- App js -->
    <script src="{{ asset('themes/dashboard_v2') }}/assets/obn/js/core/obn.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/obn/js/core/form.js?ver={{time()}}"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/app.js"></script>
    @yield('custom_script')
</body>
</html>
