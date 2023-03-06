@extends('core.dashboard')
@section('page_title', 'List of Community Ambassador')
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
                                <th class="text-center" width="50"><input type="checkbox" bs-type="checkbox"
                                        value="all" id="inputCheckAll"></th>
                                <th width="100">Avatar</th>
                                <th style="width:20%">Ambassador Info </th>
                                <th style="width:20%">Sponsor Info </th>
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
                    // xhtml += `<a href="${data.route_quickLogin}" target = "_blank" class="btn btn-primary waves-effect waves-light btn-sm">
                    //         <i class="fas fa-link mr-2"></i> Login
                    //     </a>`;
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
        var status = `@include("{$pathViewController}.filter_status")`;
        var parent = `@include("{$pathViewController}.filter_parent",['agents' => $agents])`;
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
        WBDatatables.addFilter(parent, 'select[name=parent_id]');
        WBDatatables.updateActive();
        WBDatatables.showAction();
    </script>
@endsection