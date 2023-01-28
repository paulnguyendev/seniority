@extends('admin.master')
@section('title', 'List level of ' . $mlmType['name'] ?? '')
@section('page_title', 'List level of ' . $mlmType['name'] ?? '')
@section('custom_style')
    <link href="{{ asset('obn') }}/css/plugin.css" rel="stylesheet">
@endsection
@section('content')
    @include('admin.templates.page_title', [
        'showButton' => '1',
        'btnUrl' => route("{$moduleName}_admin/formLevel", ['slug' => $slug]),
    ])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-xlg datatable-ajax"
                        data-source="{{ route("{$moduleName}_admin/dataLevel", ['type_id' => $mlmType['id']]) }}"
                        data-destroymulti="{{ route('user_admin/trashDestroy') }}">
                        <thead>
                            <tr>
                            <tr>
                                <th class="text-center" width="50"><input type="checkbox" bs-type="checkbox"
                                        value="all" id="inputCheckAll"></th>
                                <th>Name </th>
                                <th class="text-center">Short Name </th>

                                @if ($slug == 'licensed')
                                    <th class="text-center">Number Loans</th>
                                @else
                                    <th class="text-center">Number Lead</th>
                                @endif

                                <th class="text-center">Child Info</th>
                                <th class="text-center">Total User</th>

                                <th class="text-center">Date</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                            </tr>
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
                    return (data.name) ? data.name : 'empty';
                },
                orderable: false,
                searchable: false
            },
            {
                data: null,
                render: function(data) {
                    return (data.short_name) ? data.short_name : '';
                },
                class: "text-center no-padding-right",
                orderable: false,
                searchable: false
            },
            {
                data: null,
                render: function(data) {
                    return data.number_show ?? 0;
                },
                class: "text-center no-padding-right",
                orderable: false,
                searchable: false
            },
            
            {
                data: null,
                render: function(data) {
                    return (data.child_info) ? data.child_info : '-';
                },
                class: "text-center no-padding-right",
                orderable: false,
                searchable: false
            },
            {
                data: null,
                render: function(data) {
                    return data.total_user ?? 0;
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
        var status = `@include('user::pages.admin.filter_status')`;


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


        WBDatatables.updateActive();
        WBDatatables.showAction();
    </script>
@endsection
