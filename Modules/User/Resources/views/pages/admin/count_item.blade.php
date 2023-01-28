@php
    $currentUrl = url()->current();
    $allUrl = $all['url'] ?? '#';
    $trashUrl = $trash['url'] ?? '#';
@endphp
<div class="count-item">
    <li class="{{ $currentUrl == $allUrl ? "active" : "" }}"><a href="{{ $allUrl }}">
            All
            <span class="badge badge-pill badge-outline-primary">{{$all['total'] ?? 0}}</span>
        </a></li>
    <li class="{{ $currentUrl == $trashUrl ? "active" : "" }}"><a href="{{ $trashUrl }}">
        Trash
        <span class="badge badge-pill badge-outline-danger">{{$trash['total'] ?? 0}}</span>
    </a></li>
</div>