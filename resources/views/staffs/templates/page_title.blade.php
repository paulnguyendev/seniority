<div class="row">
    <div class="col-sm-12">
        <div class="d-flex align-items-center justify-content-between">
            <div class="page-title-box">
                <h4 class="page-title">@yield('page_title', 'Dashboard')</h4>
                <div class="btn-group mt-2">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ route('agents/license/dashboard/index') }}">{{ get_site_name() }}</a>
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
        </div>
    </div>
</div>
