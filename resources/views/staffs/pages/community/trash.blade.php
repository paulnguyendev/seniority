@extends('core.dashboard')
@section('title', 'Application List in trash')
@section('page_title', 'Application List in trash')
@section('custom_style')
    <link href="{{ asset('obn') }}/css/plugin.css" rel="stylesheet">
@endsection
@section('content')
    @include('share.page_title', [])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-xlg datatable-ajax"
                        data-source="{{ route("{$routeName}/data", ['is_trash' => '1']) }}"
                        data-destroymulti="{{ route("{$routeName}/trashDestroy") }}">
                        <thead>
                            <tr>
                                <th class="text-center" width="50"><input type="checkbox" bs-type="checkbox" value="all"
                                        id="inputCheckAll"></th>
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
        WBDatatables.updateActive();
        WBDatatables.showAction();
    </script>
@endsection
