@extends('admin.master')
@section('title', $title)
@section('page_title', $title)
@section('content')
    @include('admin.templates.page_title', [
        'parent' => [
            'name' => $mlmType['name'] ?? "Undified",
            'url' => route("{$moduleName}_admin/index",['slug' => $slug]),
        ],
    ])
      <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    add item
                </div>
            </div>
        </div>
      </div>
@endsection
