@extends('staff.master')
@section('content')
    <!-- Page-Title -->
    @include('staff.templates.page_title')
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="icon-contain">
                                <div class="row">
                                    <div class="col-2 align-self-center">
                                        <i class="fas fa-users text-gradient-warning"></i>
                                    </div>
                                    <div class="col-10 text-right">
                                        <h5 class="mt-0 mb-1">14</h5>
                                        <p class="mb-0 font-12 text-muted">Agents</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card ">
                        <div class="card-body">
                            <div class="icon-contain">
                                <div class="row">
                                    <div class="col-2 align-self-center">
                                        <i class="fas fa-database text-gradient-primary"></i>
                                    </div>
                                    <div class="col-10 text-right">
                                        <h5 class="mt-0 mb-1">0</h5>
                                        <p class="mb-0 font-12 text-muted">Applications</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="icon-contain">
                                <div class="row">
                                    <div class="col-2 align-self-center">
                                        <i class="fas fa-tasks text-gradient-success"></i>
                                    </div>
                                    <div class="col-10 text-right">
                                        <h5 class="mt-0 mb-1">190</h5>
                                        <p class="mb-0 font-12 text-muted">Loans</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
