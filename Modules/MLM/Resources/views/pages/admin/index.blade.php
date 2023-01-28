@extends('admin.master')
@section('title', "List income setting of " . $mlmType['name'] ?? "")
@section('page_title',  "List income setting of " .   $mlmType['name'] ?? "")
@section('custom_style')
    <link href="{{ asset('obn') }}/css/plugin.css" rel="stylesheet">
@endsection
@section('content')
    @include('admin.templates.page_title',['showButton' => '1','btnUrl' => route("{$moduleName}_admin/form",['slug' => $slug])])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-xlg datatable-ajax" data-source="{{ route('user_admin/data') }}"
                        data-destroymulti="{{ route('user_admin/trashDestroy') }}">
                        <thead>
                            <tr>
                                <th class="text-center" width="50"><input type="checkbox" bs-type="checkbox"
                                        value="all" id="inputCheckAll"></th>
                                <th>Name </th>
                                <th>Short Name </th>
                                <th class="text-center">Number Order</th>
                                <th class="text-center">Number Lead</th>
                                <th class="text-center">Number Child</th>
                                <th class="text-center">Child Info</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Date</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_script')
    <script src="{{ asset('obn') }}/js/plugin.js"></script>
    <script src="{{ asset('obn') }}/js/notice.js"></script>
    <script src="{{ asset('obn') }}/js/wb.datatables.js"></script>
    <script src="{{ asset('obn') }}/js/wb.js"></script>
    <script>
        var columnDatas = [{
                data: null,
                render: function(data) {
                    return WBDatatables.showSelect(data.id);
                },
                orderable: false,
                searchable: false
            },
            {
                data: null,
                render: function(data) {
                    console.log(data);
                    return WBDatatables.showThumbnail(data.thumbnail);
                },
                class: "text-center no-padding-right",
                orderable: false,
                searchable: false
            },
            {
                data: null,
                render: function(data) {
                    return (data.user_info) ? data.user_info : 'empty';
                },
                orderable: false,
                searchable: false
            },
            {
                data: null,
                render: function(data) {
                    return (data.sponsor_info) ? data.sponsor_info : '';
                },
                orderable: false,
                searchable: false
            },
            {
                data: null,
                render: function(data) {
                    return (data.status) ? data.status : '';
                },
                class: "text-center no-padding-right",
                orderable: false,
                searchable: false
            },
            {
                data: null,
                name: "published_at",
                render: function(data) {
                    return (!data.created_at) ? '' : data.created_at;
                },
                className: "text-center",
                orderable: false,
                searchable: false
            },
            {
                data: null,
                class: 'option-actions text-center no-padding-right',
                render: function(data) {
                    let xhtml = "";
                    xhtml += `<div class="button-items text-center">`;
                    xhtml += `<a href="" class="btn btn-primary waves-effect waves-light btn-sm">
                            <i class="fas fa-link mr-2"></i> Login
                        </a>`;
                    xhtml += `  <a href="${data.route_edit}" class="btn btn-info waves-effect waves-light btn-sm">
                            <i class="fas fa-pencil-alt mr-2"></i> Edit
                        </a>`;
                    if (data.is_suppend == '1') {
                        xhtml += ` <a href="${data.route_suppend}" class="btn btn-success waves-effect waves-light btn-sm suspend-user">
                            <i class="fas fa-ban mr-2"></i> UnSuspend
                        </a>`;
                    } else {
                        xhtml += ` <a href="${data.route_suppend}" class="btn btn-danger waves-effect waves-light btn-sm suspend-user">
                            <i class="fas fa-ban mr-2"></i> Suppend
                        </a>`;
                    }
                    xhtml += ` <a href="${data.route_verify}" class="btn btn-warning waves-effect waves-light btn-sm send-mail-verify">
                            <i class="far fa-envelope mr-2"></i> Send Mail Verify
                        </a>`;
                    xhtml += `</div>`;
                    return xhtml;
                },
                orderable: false,
                searchable: false
            },
            {
                data: null,
                render: function(data) {
                    return WBDatatables.showRemoveIcon(data.route_remove);
                },
                orderable: false,
                searchable: false
            },
        ];
        var option = {
            // fnInitComplete: renderChangeStatusPopupAfterReload,
            fnDrawCallback: function() {
                // WBForm.init();
                // WBForm.uniform();
                WBDatatables.updatePublisedDate();
                WBDatatables.hideSortBtnAtLastAndFirstRow();
            },
        };
        let productDatatables = WBDatatables.init('.datatable-ajax', columnDatas, option);
        var status = `@include('user::pages.admin.filter_status')`;
        var parent = `@include('user::pages.admin.filter_parent')`;
        var count = `@include('user::pages.admin.count_item', [
            'all' => [
                'url' => route("{$moduleName}_admin/index"),
                'total' => 0,
            ],
            'trash' => [
                'url' => route("{$moduleName}_admin/trashIndex"),
                'total' => 1,
            ],
        ])`;
        WBDatatables.addFilter(count, '');
        WBDatatables.addFilter(status, 'select[name=status]');
        WBDatatables.addFilter(parent, 'select[name=parent_id]');
        WBDatatables.updateActive();
        WBDatatables.showAction();
    </script>
@endsection
