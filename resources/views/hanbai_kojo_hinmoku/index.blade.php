@extends('layouts.app')
@section('main')
  @php
    $form = $GridSearch->gridSearchForm;
  @endphp
  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <form method="post" action="{{ route('hanbai_kojo_hinmoku.index') }}" name="{{ $form['name'] }}" id="{{ $form['name'] }}">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">品目コード</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control"
                           name="{{ $form['name'] }}[hin_cd]"
                           value="{{ data_get($form['data'], 'hin_cd', '') }}"
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
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">品目区分</label>
                  <div class="col-sm-9">
                    <x-select2 :list="$hin_kbn_all" :data="data_get($form['data'], 'hin_kbn', '')"
                              name="{{ $form['name'] }}[hin_kbn]"
                              class="form-control">
                      <option value="">全て</option>
                    </x-select2>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">拠点</label>
                  <div class="col-sm-9">
                    <x-select2 :list="$ktn_cd_all" :data="data_get($form['data'], 'ktn_cd_all', '')"
                              name="{{ $form['name'] }}[ktn_cd_all]"
                              class="form-control">
                      <option value="">全て</option>
                    </x-select2>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row mb-0">
                  <div class="col-sm-3 text-right">
                    <span class="btn btn-sm w-100 bg-primary text-light" style="pointer-events: none; border-radius: 0">元</span>
                  </div>
                  <span class="col-sm-9 col-form-label hin_current"></span>
                </div>
              </div>
              <div class="col-md-6 form-group d-flex align-items-center justify-content-end">
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
              <x-grid-result-table :grid-search="$GridSearch" formId="listSearchTemp">
                <x-slot:form-begin>
                  <input type="hidden" name="org_hin_cd"/>
                  <input type="hidden" name="org_hin_nm"/>
                  </x-slot>
              </x-grid-result-table>
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
        $('form[name={!! $form['name'] !!}] select').prop('selectedIndex', 0).trigger('change');
      });
      common.grid.changeLinkToSubmitInit('{!! $form['name'] !!}');
    });
    $('button.moto').click(function() {
      $('.hin_current').text($(this).data('hin_cd') + '　' + $(this).data('hin_nm'));
      $('#listSearchTemp input[name=org_hin_cd]').val($(this).data('hin_cd'));
      $('#listSearchTemp input[name=org_hin_nm]').val($(this).data('hin_nm'));
    });
  </script>
@endpush
