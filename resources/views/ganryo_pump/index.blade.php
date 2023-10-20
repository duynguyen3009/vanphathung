@extends('layouts.app')
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
            <input type="hidden" name="transform_search" id="grid_transform_search" value='@json($form['data'])'/>
            <input type="hidden" name="ktn_cd" value="">
            <input type="hidden" name="hin_cd" value="">
            <input type="hidden" name="kikaku_cd" value="">
            <input type="hidden" name="dispenser_kbn" value="">
            <div class="row mb-3">
              <div class="col-md-12 form-group d-flex align-items-center justify-content-end">
                <a class="btn min-wid-110 btn-primary grid-transform-link"
                   data-transform_search="{{ json_encode($form['data']) }}"
                   data-href="{{ route('ganryo_pump.create') }}"
                >新規追加</a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">品目コード</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control"
                           name="{{ $form['name'] }}[hin_cd]"
                           value="{{ data_get($form['data'], 'hin_cd', '') }}"
                           maxlength="8"
                    />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">品目名称</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control"
                           name="{{ $form['name'] }}[hin_nm]"
                           value="{{ data_get($form['data'], 'hin_nm', '') }}"
                           maxlength="30"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">拠点</label>
                  <div class="col-sm-9">
                    <x-select2
                        :list="$listKskyoten"
                        :data="data_get($form['data'], 'ktn_cd', '')"
                        name="{{ $form['name'] }}[ktn_cd]"
                        id="ktn_cd"
                        class="form-control">
                        <option value=""> 全て</option>
                    </x-select2>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">規格コード</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control"
                           name="{{ $form['name'] }}[kikaku_cd]"
                           value="{{ data_get($form['data'], 'kikaku_cd', '') }}"
                           maxlength="20"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 form-group d-flex align-items-center justify-content-end">
                <button type="submit" class="btn min-wid-110 btn-primary mr-2"><i class="icon-search"></i> 検索</button>
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
        $('form[name={!! $form['name'] !!}] select').val('').trigger('change');;
      })
      common.grid.changeLinkToSubmitInit('{!! $form['name'] !!}');
    });

    function redirect(el)
    {
      let idForm = 'form#GridSearchForm';
      let record = $(el).data('record');

      if (record != undefined) {
        $(idForm + ' input[name=ktn_cd]').val(record.ktn_cd);
        $(idForm + ' input[name=hin_cd]').val(record.hin_cd);
        $(idForm + ' input[name=kikaku_cd]').val(record.kikaku_cd);
        $(idForm + ' input[name=dispenser_kbn]').val(record.dispenser_kbn);
      }
     
      $(idForm).attr('action', $(el).data('href')).submit();
    }
  </script>
@endpush
