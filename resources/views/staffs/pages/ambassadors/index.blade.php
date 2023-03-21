@php
    use App\Helpers\Setting;
    use App\Helpers\Agent;
@endphp
@extends('core.dashboard')
@section('title', 'List of Ambassadors')
@section('page_title', 'List of Ambassadors')
@section('custom_style')
    <link href="{{ asset('obn') }}/css/plugin.css" rel="stylesheet">
    <link href="{{ asset('themes/dashboard_v2') }}/assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('themes/dashboard_v2') }}/assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css">
@endsection
@section('content')
    <!-- Page-Title -->
    @include('share.page_title', [
        'btnUrl' => route("{$routeName}/form"),
        'showCheckbox' => '1',
        'showCheckboxUrl' => route("{$routeName}/setting"),
    ])
    <div class="row">
        <div class="col-md-12">
            @if (Setting::getValue('show_mortgage_ambassador') == '1')
                <div class="card">
                    <div class="d-flex align-items-center justify-content-between card-header-obn">
                        <h4 class="card-title font-20 obn-card-title mt-0">List of Mortgage Ambassador
                        </h4>
                        <a href="{{ route("{$routeLicense}/form") }}" class="btn btn-primary">Add new</a>
                    </div>
                    <div class="card-body">
                        @include("{$pathViewController}/table_header", [
                            'routeName' => $routeLicense,
                            'table' => 'licences',
                            'items' => $licenses,
                        ])
                        <table class="table table-xlg non-license-data obn-table"
                            id="licences">
                            <thead>
                                <tr>
                                    <th class="text-center" width="50"><input type="checkbox" bs-type="checkbox"
                                            value="all" id="inputCheckAllObn" onclick="clickAll('#non-licences')"></th>
                                    <th class="text-center no-padding-right" width="100">Avatar</th>
                                    <th style="width:20%">Ambassador Info </th>
                                    <th style="width:20%">Sponsor Info </th>
                                    <th class="text-center">Status</th>
                                    <th style="width:15%">Timestamp</th>
                                    <th style="width:40%"></th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @include("{$pathViewController}/license", [
                                    'items' => $licenses,
                                    'routeName' => $routeLicense,
                                    ])
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            @if (Setting::getValue('show_community_ambassador') == '1')
                <div class="card">
                    <div class="d-flex align-items-center justify-content-between card-header-obn">
                        <h4 class="card-title font-20 obn-card-title mt-0">List of Community Ambassador
                        </h4>
                        <a href="{{ route("{$routeNonLicense}/form") }}" class="btn btn-primary">Add new</a>
                    </div>
                    <div class="card-body">
                        @include("{$pathViewController}/table_header", [
                            'routeName' => $routeNonLicense,
                            'table' => 'non-licences',
                            'items' => $nonLicenses,
                        ])
                        <table class="table table-xlg non-license-data" data-source="{{ route("{$routeNonLicense}/data") }}"
                            data-destroymulti="{{ route("{$routeNonLicense}/trashDestroy") }}" id="non-licences">
                            <thead>
                                <tr>
                                    <th class="text-center" width="50"><input type="checkbox" bs-type="checkbox"
                                            value="all" id="inputCheckAllObn" onclick="clickAll('#non-licences')">
                                    </th>
                                    <th class="text-center no-padding-right" width="100">Avatar</th>
                                    <th style="width:20%">Ambassador Info </th>
                                    <th style="width:20%">Sponsor Info </th>
                                    <th class="text-center">Status</th>
                                    <th style="width:15%">Timestamp</th>
                                    <th style="width:30%"></th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @include("{$pathViewController}/non_license", [
                                    'items' => $nonLicenses,
                                    'routeName' => $routeNonLicense,
                                ])
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('custom_script')
    <script src="{{ asset('obn') }}/js/plugin.js"></script>
    <script src="{{ asset('obn') }}/js/notice.js"></script>
    <script src="{{ asset('obn') }}/js/wb.datatables.js"></script>
    <script src="{{ asset('obn') }}/js/wb.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('themes/dashboard_v2') }}/assets/pages/datatables.init.js"></script>
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
        let linceseData = WBDatatables.init('.license-data', columnDatas, option);
        var status = `@include("{$pathViewController}.filter_status")`;
        var statusNonLicense = `@include("{$pathViewController}.filter_status_nonLicense")`;
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
        // WBDatatables.addFilterCustom("non-licences_filter",parent, 'select[name=status]');
        WBDatatables.updateActive();
        WBDatatables.showAction();
    </script>
    <script>
        const tableFilter = $(".table-filter");
        const tableSearch = $(".table-search");
        tableFilter.change(function() {
            let url = $(this).data('url');
            let column = $(this).data('column');
            let value = $(this).val();
            let tableId = $(this).data('table');

            $.ajax({
                type: "get",
                url: url,
                data: {
                    column: column,
                    value: value
                },
                dataType: "json",
                beforeSend: function() {
                    showLoading();
                },
                success: function(response) {
                    let xthml = response.xthml ? response.xthml : "";
                    $(`#${tableId} tbody`).html(xthml);
                    suspendButton();
                },
                complete: function() {
                    hideLoading();
                },
            });
        })
        tableSearch.keyup(function() {
            let url = $(this).data('url');
            let value = $(this).val();
            let tableId = $(this).data('table');

            $.ajax({
                type: "get",
                url: url,
                data: {
                    type: "search",
                    value: value
                },
                dataType: "json",
                beforeSend: function() {
                    showLoading();
                },
                success: function(response) {
                    let xthml = response.xthml ? response.xthml : "";
                    $(`#${tableId} tbody`).html(xthml);
                    suspendButton();
                },
                complete: function() {
                    hideLoading();
                },
            });
        })
    </script>
    <script>
        function suspendButton() {
            const suspendButton = $(".suspend-button");
            suspendButton.click(function() {
                var url = $(this).attr('href');
                var data = $(this).data();
                let urlSplit = url.split('/');
                let suspend = urlSplit[urlSplit.length - 1];
                let msg = suspend == '1' ? "UnSuspended" : "Suspended";
                let text = suspend == '0' ? "Ambassador will not be able to log into the system" :
                    "Ambassador will be able to log into the system";
                swal({
                    showLoaderOnConfirm: true,
                    closeOnConfirm: false,
                    title: data.title ? data.title : `Do you want to ${msg} this Ambassador?`,
                    text: data.message ? data.message : text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#FF7043",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                }, function() {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: data,

                        success: function(response) {
                            if (response.success == false) {
                                warningNotice(response.message);
                            } else {
                                if (response.hasOwnProperty('message')) {
                                    successNotice(response.message);
                                    location.reload();
                                }
                            }
                            swal.close();
                        },
                        error: function() {
                            swal.close();
                        }
                    });
                });
                return false;
            })
        }
        suspendButton();
    </script>
@endsection
