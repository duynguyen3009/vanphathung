@extends('layouts/app')
@section('main')
  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          @php
            $form = $GridSearch->gridSearchForm;
          @endphp
          <form method="post" name="{{ $form['name'] }}" id="{{ $form['name'] }}">
            @csrf
            <input type="hidden" name="transform_search" id="grid_transform_search" />
            <div class="row mb-3">
              <div class="col-md-12 form-group d-flex align-items-center justify-content-end">
                <a class="btn min-wid-110 btn-warning grid-transform-link"
                  data-transform_search="{{ json_encode($form['data']) }}"
                  data-href="{{ route('haigo_key.create') }}">新規追加</a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">配合キー</label>
                  <div class="col-sm-9">
                    <input type="text" name="{{ $form['name'] }}[haigo_key]" maxlength="5"
                      value="{{ data_get($form['data'], 'haigo_key', '') }}" class="form-control">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">名称</label>
                  <div class="col-sm-9">
                    <input type="text" name="{{ $form['name'] }}[haigo_key_nm]" maxlength="50"
                      value="{{ data_get($form['data'], 'haigo_key_nm', '') }}" class="form-control">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group ">
                  <div class="row">
                    <label class="col-sm-3 col-form-label">製品区分</label>
                    <div class="col-sm-9">
                      <x-select2 :list="$listSeihinKbn" :data="data_get($form['data'], 'name', '')" name="{{ $form['name'] }}[name]" id="name"
                        class="form-control">
                        <option value="">全て</option>
                      </x-select2>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 form-group d-flex align-items-center justify-content-end">
                <button type="submit" class="btn min-wid-110 btn-primary mr-2">
                  <i class="icon-search"></i>検索</button>
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
              <x-grid-result-table :grid-search="$GridSearch" formId="listSearchTemp" />
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
        $('form[name={!! $form['name'] !!}] select').val('').trigger('change');
      })
      common.grid.changeLinkToSubmitInit('{!! $form['name'] !!}');
    });
  </script>
@endpush
