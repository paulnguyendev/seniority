@extends('admin.master')
@section('title', 'Level List of ' . $mlmType['name'] . " in trash" ?? '')
@section('page_title', 'Level List of ' . $mlmType['name'] . " in trash" ?? '')
@section('custom_style')
    <link href="{{ asset('obn') }}/css/plugin.css" rel="stylesheet">
@endsection
@section('content')
    @include('admin.templates.page_title', [
        'showButton' => '1',
        'btnUrl' => route("{$controllerName}/form", ['slug' => $slug]),
    ])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-xlg datatable-ajax"
                        data-source="{{ route("{$controllerName}/data", ['type_id' => $mlmType['id'],'is_trash' => '1']) }}"
                        data-destroymulti="{{ route("{$controllerName}/destroy") }}">
                        <thead>
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
                    xhtml += `  <a href="${data.route_restore}" class="btn btn-primary waves-effect waves-light btn-sm restore-item">
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
                    return WBDatatables.showRemoveIcon(data.route_delete);
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
       
        var count = `@include("admin.templates.count_item", [
            'all' => [
                'url' => route("{$controllerName}/index",['slug' => $slug]),
                'total' => $totalAll,
            ],
            'trash' => [
                'url' => route("{$controllerName}/trashIndex", ['slug' => $slug]),
                'total' => $totalTrash,
            ],
        ])`;
        WBDatatables.addFilter(count, '');
        WBDatatables.updateActive();
        WBDatatables.showAction();
    </script>
@endsection
