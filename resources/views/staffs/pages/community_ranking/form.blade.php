@php
    use App\Helpers\Agent;
@endphp
@extends('core.dashboard')
@section('title', $title)
@section('page_title', $title)
@section('content')
    @include('share.page_title', [
        'showButton' => '1',
        'parent' => [
            'name' => 'Mortgage Ranking List',
            'url' => route('admin/ranking/index'),
        ],
        'backUrl' => route('admin/ranking/index'),
    ])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ !$id ? route("{$routeName}/save") : route("{$routeName}/save", ['id' => $id]) }}"
                        method="post" id="form-save" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Ranking Name (*)</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ $item['name'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="personal_payout">Personal Payout (*)</label>
                                    <input type="number" class="form-control" name="personal_payout" id="personal_payout"
                                        value="{{ $item['personal_payout'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="team_overrides">Team Overrides(*)</label>
                                    <input type="number" class="form-control" name="team_overrides" id="team_overrides"
                                        value="{{ $item['team_overrides'] ?? '' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="team_overrides">Direct Ranking</label>
                                    @php
                                        $direct_level_id  = $itemCondition['direct_level_id'] ?? '';
                                    @endphp
                                    <select name="condition_license_levels[direct_level_id]" id="" class="form-control">
                                        <option value="">No ranking select</option>
                                        @foreach ($rankings as $ranking)
                                            <option value="{{$ranking['id']}}" {{$direct_level_id == $ranking['id'] ? "selected" : ""}}>{{$ranking['name']}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="number_products">Number Loans(*)</label>
                                    <input type="number" class="form-control" name="condition_license_levels[number_product]" id="number_product"
                                        value="{{ $itemCondition['number_product'] ?? 0 }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="team_overrides">Is Break Out</label>
                                    @php
                                        $is_break = $item['is_break'] ?? '';
                                    @endphp
                                    <select name="is_break" id="" class="form-control">
                                        <option value="1" {{ $is_break == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ $is_break == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                           
                        </div>
                        <div class="buttons">
                            <input type="hidden" name="id" value="{{ $item['id'] ?? '' }}">
                            <input type="hidden" name="condition_id" value="{{ $itemCondition['id'] ?? '' }}">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_script')
    <script>
        let mlmType = $(`select[name="mlm_type_id"]`);
        let mlmLevel = $(`select[name="mlm_level_id"]`);
        mlmType.change(function() {
            let optionSelected = mlmType.find('option:selected');
            let mlm_type_id = $(this).val();
            let url = optionSelected.data('url');
            $.ajax({
                type: "get",
                url: url,
                data: {
                    'mlm_type_id': mlm_type_id,
                    'start': 0
                },
                dataType: "json",
                success: function(response) {
                    let data = response.data;
                    let xhtml = '';
                    data.forEach((item, key) => {
                        xhtml += `<option value = '${item.id}'>${item.name}</option>`;
                    });
                    mlmLevel.html(xhtml);
                    console.log(data);
                    console.log(xhtml);
                }
            });
        })
        let form = $("#form-save");
        form.submit(function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            let data = getFormData($(this));
            $.ajax({
                type: "post",
                url: url,
                data: data,
                dataType: "json",
                beforeSend: function() {
                    showLoading();
                },
                success: function(response) {
                    let status = response.status;
                    let msg = response.msg;
                    let redirect = response.redirect;
                    console.log(redirect)
                    if (status == 200) {
                        swal("Notification", msg, "success").then(() => {
                            if (redirect) {
                                window.location.href = redirect
                            } else {
                                location.reload();
                            }
                        })
                    } else if (status == 500) {
                        deleteError();
                        swal("Warning", msg, "warning");
                    } else {
                        swal("Oops", "Please check the information again", "error").then(() => {
                            showError(msg);
                        })
                    }
                },
                error: function(error) {
                    swal("Oops", "Something went wrong", "error");
                    console.log(error);
                },
                complete: function() {
                    hideLoading();
                }
            });
        })
    </script>
@endsection
