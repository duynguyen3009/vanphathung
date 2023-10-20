@extends('layouts.app')
@section('main')
  @php
    $form = $GridSearch->gridSearchForm;
  @endphp
  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <form method="post" name="{{ $form['name'] }}" id="{{ $form['name'] }}">
            @csrf
            <input type="hidden" name="transform_search" id="grid_transform_search"/>
            <div class="row mb-3">
              <div class="col-md-12 form-group d-flex align-items-center justify-content-end">
                <a class="btn min-wid-110 btn-warning grid-transform-link"
                   data-transform_search="{{ json_encode($form['data']) }}"
                   data-href="{{ route('shiire.create') }}"
                >新規追加</a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">仕入先コード</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="{{ $form['name'] }}[shiire_cd]"
                           value="{{ data_get($form['data'], 'shiire_cd', '') }}"/>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">仕入先名称</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="{{ $form['name'] }}[shiire_nm]"
                           value="{{ data_get($form['data'], 'shiire_nm', '') }}"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 form-group d-flex align-items-center justify-content-end">
                <button type="submit" class="btn min-wid-110 btn-primary mr-2 search"><i class="icon-search"></i> 検索
                </button>
                <button class="btn min-wid-110 btn-secondary btn-clear" type="button">クリア</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <x-grid-result-table :grid-search="$GridSearch" formId="listSearchTemp"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(function() {
      $('button.btn-clear').click(function() {
        $('form[name={!! $form['name'] !!}] input[type=text]').val('');
      });
      common.grid.changeLinkToSubmitInit('{!! $form['name'] !!}');
    });
  </script>
@endpush
