@extends('core.dashboard')
@section('page_title', 'List of Application')
@section('custom_style')
    <link href="{{ asset('obn') }}/css/plugin.css" rel="stylesheet">
@endsection
@section('content')
    <!-- Page-Title -->
    @include('share.page_title', [
        'showButton' => '1',
        'btnUrl' => route("{$routeName}/form"),
    ])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-xlg datatable-ajax" data-source="{{ route("{$routeName}/data") }}"
                        data-destroymulti="{{ route("{$routeName}/trashDestroy") }}">
                        <thead>
                            <tr>
                                <th class="text-center" width="50"><input type="checkbox" bs-type="checkbox" value="all"
                                        id="inputCheckAll"></th>
                                <th>Application ID</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Ambassador Info</th>
                                <th class="text-center">Status</th>
                                <th>Timestamp</th>
                                <th class="text-right"></th>
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
                    return (data.code) ? data.code : '';
                },
                orderable: false,
                searchable: false
            },
            {
                data: null,
                render: function(data) {
                    return (data.fullname) ? data.fullname : 'empty';
                },
                orderable: false,
                searchable: false
            },
            {
                data: null,
                render: function(data) {
                    return (data.email) ? data.email : 'empty';
                },
                orderable: false,
                searchable: false
            },
            {
                data: null,
                render: function(data) {
                    return (data.mobile) ? data.mobile : '-';
                },
                orderable: false,
                searchable: false
            },
            {
                data: null,
                render: function(data) {
                    return (data.agentInfo) ? data.agentInfo : '-';
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
                className: "",
                orderable: false,
                searchable: false
            },
            {
                data: null,
                class: 'option-actions text-right no-padding-right',
                render: function(data) {
                    let xhtml = "";
                    xhtml += `<div class="button-items text-right">`;
                    xhtml += `  <a href="${data.route_edit}" class="btn btn-info waves-effect waves-light btn-sm">
                            <i class="fas fa-pencil-alt mr-2"></i> Edit
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
        var status = `@include("{$pathViewController}.filter_status")`;
        var count = `@include("{$pathViewController}.count_item", [
            'all' => [
                'url' => route("{$routeName}/index"),
                'total' => $totalAll,
            ],
            'trash' => [
                'url' => route("{$routeName}/trashIndex"),
                'total' => $totalTrash,
            ],
        ])`;
        WBDatatables.addFilter(count, '');
        WBDatatables.addFilter(status, 'select[name=status]');
        // WBDatatables.addFilter(parent, 'select[name=parent_id]');
        WBDatatables.updateActive();
        WBDatatables.showAction();
    </script>
@endsection