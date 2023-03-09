@php
    use App\Helpers\Setting;
@endphp
<div class="row">
    <div class="col-sm-12">
        <div class="d-flex align-items-center justify-content-between">
            <div class="page-title-box">
                <h4 class="page-title">@yield('page_title', 'Dashboard')</h4>
                <div class="btn-group mt-2">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ get_url('dashboard') }}">{{ get_site_name() }}</a>
                        </li>
                        @if (isset($parent))
                            @php
                                $parent_name = $parent['name'] ?? 'empty';
                                $parent_url = $parent['url'] ?? '#';
                            @endphp
                            <li class="breadcrumb-item"><a href="{{ $parent_url }}">{{ $parent_name }}</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active">@yield('page_title', 'Dashboard')</li>
                    </ol>
                </div>
            </div>
            @if (isset($showCheckbox))
                <div class="checkbox-table" data-url="{{ isset($showCheckboxUrl) ? $showCheckboxUrl : '' }}">
                    <div class="checkbox-group">
                        <label for="" class="pull-left">
                            Mortgage Ambassador

                        </label>
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionDefault" name="show_mortgage_ambassador" class="settingShowList"
                                type="checkbox"
                                {{ Setting::getValue('show_mortgage_ambassador') == '1' ? 'checked' : '' }}>
                            <label for="someSwitchOptionDefault" class="label-success"></label>
                        </div>
                    </div>
                    <div class="checkbox-group">
                        <label for="" class="pull-left">Community Ambassador</label>
                        <div class="material-switch pull-right ">
                            <input id="someSwitchOption002" name="show_community_ambassador" class="settingShowList"
                                type="checkbox"
                                {{ Setting::getValue('show_community_ambassador') == '1' ? 'checked' : '' }}>
                            <label for="someSwitchOption002" class="label-success"></label>
                        </div>
                    </div>
                </div>
            @endif
            @if (isset($showCheckboxRanking))
                <div class="checkbox-table" data-url="{{ isset($showCheckboxUrl) ? $showCheckboxUrl : '' }}">
                    <div class="checkbox-group">
                        <label for="" class="pull-left">
                            Mortgage Ambassador

                        </label>
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionDefault" name="show_ranking_mortgage_ambassador" class="settingShowList"
                                type="checkbox"
                                {{ Setting::getValue('show_ranking_mortgage_ambassador') == '1' ? 'checked' : '' }}>
                            <label for="someSwitchOptionDefault" class="label-success"></label>
                        </div>
                    </div>
                    <div class="checkbox-group">
                        <label for="" class="pull-left">Community Ambassador</label>
                        <div class="material-switch pull-right ">
                            <input id="someSwitchOption002" name="show_ranking_community_ambassador" class="settingShowList"
                                type="checkbox"
                                {{ Setting::getValue('show_ranking_community_ambassador') == '1' ? 'checked' : '' }}>
                            <label for="someSwitchOption002" class="label-success"></label>
                        </div>
                    </div>
                </div>
            @endif
            @if (isset($showButton))
                <div class="buttons">
                    @if (isset($backUrl))
                        <a href="{{ $backUrl ?? '#' }}" class="btn btn-danger">Back</a>
                    @endif
                    @if (isset($btnUrl))
                        <a href="{{ $btnUrl ?? '#' }}" class="btn btn-primary">Add new</a>
                    @endif

                </div>
            @endif
            @if (isset($showSelect))
                @php
                    $showAmbassadorType = isset($showAmbassadorType) ? $showAmbassadorType : '';
                @endphp
                <div class="buttons">
                    <div class="form-group">
                        <select name="showAmbassadorType" id="" class="form-control">
                            <option value="">Choose Ambassador</option>
                            <option value="mortgage" {{ $showAmbassadorType == 'mortgage' ? 'selected' : '' }}>Mortgage
                                Ambassador</option>
                            <option value="community" {{ $showAmbassadorType == 'community' ? 'selected' : '' }}>
                                Community Ambassador</option>
                        </select>
                    </div>
                </div>
            @endif


        </div>
    </div>
</div>
@push('scripts')
    <script>
        const settingShowList = $(".settingShowList");
        settingShowList.change(function() {
            let settingShowName = $(this).attr('name');
            let settingShowValue;
            if ($(this).is(":checked")) {
                settingShowValue = 1;
            } else {
                settingShowValue = 0;
            }
            let url = $(".checkbox-table").data('url');
            let data = {
                meta_key: settingShowName,
                meta_value: settingShowValue
            }
            $.ajax({
                type: "post",
                url: url,
                data: data,
                dataType: "json",
                beforeSend: function() {
                    showLoading();
                },
                success: function(response) {
                    console.log(response);
                    location.reload();
                },
                complete: function() {
                    hideLoading();
                }
            });
            console.log(data);


        })
    </script>
@endpush
