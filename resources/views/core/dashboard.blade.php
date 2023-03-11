<!DOCTYPE html>
<html lang="en">
<head>
    @include('share.head')
</head>
<body>
    <!-- Navigation Bar-->
    @php
        $area = get_area();
    @endphp
    @include("share.navigation_{$area}")
    <!-- End Navigation Bar-->
    <div class="wrapper">
        <div class="container-fluid">
            @yield('content')
        </div> <!-- end container -->
    </div>
    <!-- end wrapper -->
    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    © 2022 {{ get_site_name() }}.
                </div>
            </div>
        </div>
    </footer>
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
    <!-- End Footer -->
    <!-- jQuery  -->
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/jquery.min.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/popper.min.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/bootstrap.min.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/modernizr.min.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/waves.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/jquery.slimscroll.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/jquery.nicescroll.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/jquery.scrollTo.min.js"></script>
    <!-- KNOB JS -->
    <script src="{{ asset('themes/dashboard_v2') }}/assets/plugins/jquery-knob/excanvas.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/plugins/jquery-knob/jquery.knob.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/plugins/chart.js/chart.min.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/pages/dashboard.js"></script>
    <!-- Bootstrap inputmask js -->
    <script src="{{ asset('themes/dashboard_v2') }}/assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js">
    </script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/pages/form-mask.init.js"></script>
    <!-- Sweet-Alert  -->
    <script src="{{ asset('themes/dashboard_v2') }}/assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
    {{-- DropZone --}}
    <script src="{{ asset('themes/dashboard_v2') }}/assets/plugins/dropify/js/dropify.min.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/pages/dropify.init.js"></script>
    {{-- Select2 --}}
    <script src="{{ asset('themes/dashboard_v2') }}/assets/plugins/select2/select2.min.js"></script>
    <!-- App js -->
    <script src="{{ asset('obn') }}/js/media.js?ver={{ time() }}"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/obn/js/core/obn.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/obn/js/core/form.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/js/app.js"></script>
    @stack('scripts')
    @yield('custom_script')
</body>
</html>
