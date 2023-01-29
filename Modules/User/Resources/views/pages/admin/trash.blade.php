@extends('admin.master')
@section('title', 'User List in trash')
@section('page_title', 'User List in trash')
@section('custom_style')
    <link href="{{ asset('obn') }}/css/plugin.css" rel="stylesheet">
@endsection
@section('content')
    @include('admin.templates.page_title', [])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-xlg datatable-ajax"
                        data-source="{{ route('user_admin/data', ['is_trash' => '1']) }}"
                        data-destroymulti="{{ route('user_admin/trashDestroy') }}">
                        <thead>
                            <tr>
                                <th class="text-center" width="50"><input type="checkbox" bs-type="checkbox"
                                        value="all" id="inputCheckAll"></th>
                                <th width="100">Avatar</th>
                                <th>User Info </th>
                                <th>Sponsor Info </th>
                                <th class="text-center">Status</th>
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
                    xhtml += `  <a href="${data.route_restore ?? "#"}" class="btn btn-primary waves-effect waves-light btn-sm restore-item">
                            <i class="far fa-window-restore mr-2"></i> Restore
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
                'total' => $totalAll,
            ],
            'trash' => [
                'url' => route("{$moduleName}_admin/trashIndex"),
                'total' => $totalTrash,
            ],
        ])`;
        WBDatatables.addFilter(count, '');
        WBDatatables.updateActive();
        WBDatatables.showAction();
    </script>
@endsection
