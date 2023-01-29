@extends('admin.master')
@section('title', 'Setting List')
@section('page_title', 'Setting List')
@section('custom_style')
    <link href="{{ asset('obn') }}/css/plugin.css" rel="stylesheet">
@endsection
@section('content')
    @include('admin.templates.page_title', [
        'showButton' => '1',
        'btnUrl' => route("{$controllerName}/form", ['level_id' => $level_id]),
        'parent' => [
            'name' => $mlmLevel['name'],
            'url' => route('mlm_admin_level/index',['slug' => $mlmType['slug']]),
        ],
        'backUrl' => route('mlm_admin_level/index',['slug' => $mlmType['slug']]) ,
    ])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-xlg datatable-ajax"
                        data-source="{{ route("{$controllerName}/data", ['level_id' => $level_id]) }}"
                        data-destroymulti="{{ route("{$controllerName}/trashDestroy") }}">
                        <thead>
                            <tr>
                                <th class="text-center" width="50"><input type="checkbox" bs-type="checkbox"
                                        value="all" id="inputCheckAll"></th>
                                <th>Name </th>
                                <th class="text-center">Commission </th>
                                <th class="text-center">Commission Group</th>
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
                    return data.commission_show ?? 0;
                },
                class: "text-center no-padding-right",
                orderable: false,
                searchable: false
            },
            {
                data: null,
                render: function(data) {
                    return data.commission_group_show ?? '';
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
        var count = `@include("admin.templates.count_item", [
            'all' => [
                'url' => route("{$controllerName}/index",['level_id' => $level_id]),
                'total' => $totalAll,
            ],
            'trash' => [
                'url' => route("{$controllerName}/trashIndex", ['level_id' => $level_id]),
                'total' => $totalTrash,
            ],
        ])`;
        WBDatatables.addFilter(count, '');
        WBDatatables.updateActive();
        WBDatatables.showAction();
    </script>
@endsection
