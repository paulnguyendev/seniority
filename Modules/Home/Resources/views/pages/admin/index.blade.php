@extends('admin.master')
@section('content')
    <!-- Page-Title -->
    @include('admin.templates.page_title')
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body justify-content-center">
                            <div class="icon-contain">
                                <div class="row">
                                    <div class="col-2 align-self-center">
                                        <i class="far fa-gem text-gradient-danger"></i>
                                    </div>
                                    <div class="col-10 text-right">
                                        <h5 class="mt-0 mb-1">62</h5>
                                        <p class="mb-0 font-12 text-muted">Loans</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="icon-contain">
                                <div class="row">
                                    <div class="col-2 align-self-center">
                                        <i class="fas fa-users text-gradient-warning"></i>
                                    </div>
                                    <div class="col-10 text-right">
                                        <h5 class="mt-0 mb-1">14</h5>
                                        <p class="mb-0 font-12 text-muted">Users</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             
                <div class="col-lg-3">
                    <div class="card ">
                        <div class="card-body">
                            <div class="icon-contain">
                                <div class="row">
                                    <div class="col-2 align-self-center">
                                        <i class="fas fa-database text-gradient-primary"></i>
                                    </div>
                                    <div class="col-10 text-right">
                                        <h5 class="mt-0 mb-1">0</h5>
                                        <p class="mb-0 font-12 text-muted">Leads</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="icon-contain">
                                <div class="row">
                                    <div class="col-2 align-self-center">
                                        <i class="fas fa-tasks text-gradient-success"></i>
                                    </div>
                                    <div class="col-10 text-right">
                                        <h5 class="mt-0 mb-1">190</h5>
                                        <p class="mb-0 font-12 text-muted">Orders</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <h5 class="header-title pb-3 mt-0">List of User</h5>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter Name or Agent ID or Mobile">
                        </div>
                    </div>
                  @include('admin.templates.list_user')
                    <!--end table-responsive-->
                    <div class="pt-3 border-top text-right">
                        <a href="#" class="text-primary">View all <i class="mdi mdi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
