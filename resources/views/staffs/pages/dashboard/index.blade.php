@php
    use App\Helpers\Setting;
    $showAmbassadorType = Setting::getValue('show_ambassador_type') ?? 'mortgage';
@endphp
@extends('core.dashboard')
@section('content')

    @if ($showAmbassadorType == 'mortgage')
        @section('page_title', 'List of Mortgage Ambassador')
        @include('share.page_title', ['showSelect' => '1', 'showAmbassadorType' => $showAmbassadorType])
        @include('staffs.templates.ambassador_list', [
            'routeName' => 'staffs/mortgage',
            'pathViewController' => 'staffs.pages.mortgage',
            'agents' => [],
            'totalAll' => 0,
            'totalTrash' => 0,
        ])
    @elseif($showAmbassadorType == 'community')
    @section('page_title', 'List of Community Ambassador')
    @include('share.page_title', ['showSelect' => '1', 'showAmbassadorType' => $showAmbassadorType])
    @include('staffs.templates.ambassador_list', [
        'routeName' => 'staffs/community',
        'pathViewController' => 'staffs.pages.community',
        'agents' => [],
        'totalAll' => 0,
        'totalTrash' => 0,
    ])
@else
    {{-- @include('staffs.templates.ambassador_list', [
            'routeName' => 'staffs/community',
            'pathViewController' => 'staffs.pages.community',
            'agents' => [],
            'totalAll' => 0,
            'totalTrash' => 0,
        ])
        @include('staffs.templates.ambassador_list', [
            'routeName' => 'staffs/community',
            'pathViewController' => 'staffs.pages.community',
            'agents' => [],
            'totalAll' => 0,
            'totalTrash' => 0,
        ]) --}}
@endif
@endsection
@push('scripts')
<script>
    const url = "{{ route('staffs/dashboard/updateSetting') }}";
    const showAmbassadorType = $(`select[name="showAmbassadorType"]`);
    showAmbassadorType.change(function() {
        let type = $(this).val();
        if (!type) {
            swal("Oops", "Please Choose Ambassador", "error");
            return false;
        }
        $.ajax({
            type: "post",
            url: url,
            data: {
                meta_key: "show_ambassador_type",
                meta_value: type
            },
            dataType: "json",
            beforeSend: function() {
                showLoading();
            },
            success: function(response) {
                location.reload();
            },
            complete: function() {
                hideLoading();
            }
        });
    })
</script>
@endpush
