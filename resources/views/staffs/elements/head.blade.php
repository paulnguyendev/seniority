<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<title>@yield('title','Dashboard')</title>
<meta content="Admin Dashboard" name="description" />
<meta content="Mannatthemes" name="author" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="base_domain" content="{{env('APP_URL')}}">
<meta name="assets_url" content="{{env('ASSET_URL')}}">
<meta name="storage_url" content="{{asset('uploads/images')}}/">
<link rel="shortcut icon" href="{{asset('themes/dashboard_v2')}}/assets/images/favicon.ico">
<link href="{{asset('themes/dashboard_v2')}}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="{{asset('themes/dashboard_v2')}}/assets/css/icons.css" rel="stylesheet" type="text/css">
<link href="{{asset('themes/dashboard_v2')}}/assets/css/style.css" rel="stylesheet" type="text/css">
<link href="{{asset('themes/dashboard_v2')}}/assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
@stack('css')
@yield('custom_style')
 <!-- Sweet Alert -->
 <link href="{{ asset('themes/dashboard_v2') }}/assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet"
 type="text/css">
<link href="{{asset('themes/dashboard_v2')}}/assets/obn/app.css?ver={{time()}}" rel="stylesheet" type="text/css">