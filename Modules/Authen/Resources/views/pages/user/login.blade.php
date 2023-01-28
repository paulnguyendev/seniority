@extends("{$moduleName}::layouts.master2")
@section('title', 'Admin Login')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="text-center m-b-15">
                <a href="{{ route('admin') }}" class="logo logo-admin"><img
                        src="{{ asset('themes/dashboard_v2') }}/assets/obn/logo.png" height="100" alt="logo"></a>
            </div>
            <div class="p-3">
                <form class="form-horizontal m-t-20" id="form-login" action="index.html">
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="text" required="" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="password" required="" placeholder="Password">
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
