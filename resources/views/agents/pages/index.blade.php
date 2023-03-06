@extends('core.auth')
@section('title','Ambassador')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="text-center m-b-15">
            <a href="#" class="logo logo-admin"><img src="{{ asset('themes/dashboard_v2') }}/assets/obn/logo.png"
                    height="100" alt="logo"></a>
        </div>
        <h1 class="text-center title-auth">Ambassador</h1>
        <div class="buttons text-center mt-3">
            <a href="{{get_url('license_login')}}" class="btn btn-primary">Mortgage Ambassador</a>
            <a href="" class="btn btn-outline-primary">Community Ambassador</a>
        </div>
    </div>
</div>
@endsection