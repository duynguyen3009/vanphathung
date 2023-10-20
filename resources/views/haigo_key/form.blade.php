@php
  $mode = data_get($GridSearch->gridResultTable, 'mode', []);
  $form = $GridSearch->gridSearchForm;
  if(old('transform_search')) {
    $form['data'] = json_decode(old('transform_search'));
  }

  $haigoKeyMei = head($GridSearch->pagination->items());
@endphp
@extends('layouts.app')
@section('main')
<style>
  .f14 {
    font-size: 14px;
  }
  .relative {
    position: relative !important;
  }
  .pd-20 {
    padding: 10px 20px;
  }
</style>
  <div class="alert d-none" name="error_exception"></div>
  <form method="post" id="pg402Form" action="">
    @csrf
    <input type="hidden" name="action" value="">
    <input type="hidden" name="mode" value="{{ $mode }}">
    <input type="hidden" name="hin_cd" value="{{ @$haigoKeyMei->hin_cd }}">
    <input type="hidden" name="kikaku_cd" value="{{ @$haigoKeyMei->kikaku_cd }}">
    <input type="hidden" name="ganryo_kbn" value="{{ @$haigoKeyMei->haigo_key_mei__ganryo_kbn }}">
    <input type="hidden" name="bihikuru_keisu" value="{{ @$haigoKeyMei->bihikuru_keisu }}">
    <input type="hidden" name="tonyu_group_no" value="{{ @$haigoKeyMei->tonyu_group_no }}">
    <input type="hidden" name="disp_jun" value="{{ @$haigoKeyMei->disp_jun }}">
    <input type="hidden" id="grid_transform_search" name="transform_search" value='@json($form['data'])'/>

    <div class="col-md-12 required mt-0 mb-2 text-danger text-small">
      {{ __('messages.MSG_INF_007') }}
    </div>
    
    <div class="row">
      <div class="col-12 grid-margin stretch-card f14 relative">
        <div class="card relative">
          <div class="card-body relative">
            <div class="row mb-3">
              <div class="col-12 col-md-12">
                <div class="row">
                  <div class="col-12 col-md-2 d-flex align-items-center text-nowrap required">{{ trans('attributes.m_haigo_key.haigo_key') }}</div>
                  <div class="col-12 col-md-10">
                    <input type="text"
                          name="haigo_key"
                          value="{{ @$recordHaigoKey->haigo_key }}"
                          class="form-control"
                          {{ $mode == 'edit' ? 'readonly' : null}}
                    >
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-2"></div>
                  <div class="col-12 col-md-10">
                    <label class="text-danger text-nowrap msg-error" for="haigo_key"></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12 col-md-12">
                <div class="row">
                  <div class="col-12 col-md-2 d-flex align-items-center text-nowrap ">{{ trans('attributes.m_haigo_key.haigo_key_nm') }}</div>
                  <div class="col-12 col-md-10">
                    <input type="text" name="haigo_key_nm" value="{{ old('haigo_key_nm', @$recordHaigoKey->haigo_key_nm) }}" class="form-control @error('haigo_key_nm') is-invalid @enderror">
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-2"></div>
                  <div class="col-12 col-md-10">
                    <label class="text-danger text-nowrap msg-error" for="haigo_key_nm"></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12 col-md-12">
                <div class="row mb-3">
                  <div class="col-12 col-md-2 d-flex align-items-center text-nowrap ">{{ trans('attributes.m_haigo_key.seihin_kbn') }}</div>
                  <div class="col-12 col-md-10">
                    <x-select2
                        :list="$listSeihinKbn"
                        :data="old('seihin_kbn', @$recordHaigoKey->seihin_kbn)"
                        name="seihin_kbn"
                        id="seihin_kbn"
                        class="form-control">
                      <option value="">名称</option>
                    </x-select2>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12 col-md-12">
                <div class="row">
                  <div class="col-12 col-md-2 d-flex align-items-center text-nowrap ">{{ trans('attributes.m_haigo_key.flat_base_keisu') }}</div>
                  <div class="col-12 col-md-10">
                    <input type="text" name="flat_base_keisu" value="{{ old('flat_base_keisu', @$recordHaigoKey->flat_base_keisu) }}" class="form-control @error('flat_base_keisu') is-invalid @enderror">
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-2"></div>
                  <div class="col-12 col-md-10">
                    <label class="text-danger text-nowrap msg-error" for="flat_base_keisu"></label>
                  </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-between row-btn-page">
              <a class="btn min-wid-110 btn-secondary grid-transform-link"
                   data-transform_search="{{ json_encode($form['data']) }}"
                   data-href="{{ route('haigo_key.index') }}"
                >戻る</a>
              <div>
                @if ($mode == 'edit')
                  <button class="btn btn-danger min-wid-110" 
                          data-href="{{ route('haigo_key.delete') }}"
                          onclick="deletePG402(this)"
                          type="button">
                    削除
                  </button>
                @endif
                <button type="button"
                        class="btn btn-primary min-wid-110"
                        data-href="{{ route('haigo_key.save') }}"
                        onclick="savePG402(this)">
                  {{ $mode == 'edit' ? '更新' : '登録'}}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  @if ($mode == 'edit' || $mode == 'copy')
    <div class="row mb-5">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              @if ($mode == 'edit')
                <div class="col-12 mb-3">
                  <a class="btn min-wid-110 btn-warning"
                      data-transform_search="{{ json_encode($form['data']) }}"
                      data-href="{{ route('haigo_key_mei.create', ['haigoKey' => request()->route('haigoKey')]) }}"
                      onclick="redirect(this, 'create')">
                      新規追加
                  </a>
                </div>
              @endif
            </div>
            <div class="row">
              <div class="col-12">
                <x-grid-result-table :grid-search="$GridSearch" formId="listSearchTemp" template="haigo_key.haigo-key-result-table"/>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection
@push('js')
  <script>
    $(document).ready(function () {
      common.grid.changeLinkToSubmitInit('pg402Form'); // button back
      // check exist recordHaigoKey
      let idForm = 'form#pg402Form';
      @if(session('error') && session('url'))
        alert(@json(session('error')))
        $(idForm).attr('action', @json(session('url'))).submit();
      @endif
    });
    function savePG402(el)
    {
      if (!confirm("{{ __('messages.MSG_INF_001') }}")) {
        return;
      }
      handle(el, 'save');
    }
    function deletePG402(el)
    {
      if (!confirm("{{ __('messages.MSG_INF_002') }}")) {
        return;
      }
      handle(el, 'delete');
    }
    function handle(el, action)
    {
      let idForm = 'form#pg402Form';

      $(idForm + ' input[name=action]').val(action);

      $.ajax({
        url: $(el).data('href'),
        method: 'post',
        data: $(idForm).serialize(),
        success: function(res) {
          if (res.success) {
            $(idForm).attr('action', res.url).submit();
            return;
          } else { // error in case exception
            let divShowError = 'div[name=error_exception]';
            $(divShowError).removeClass('d-none');
            $(divShowError).addClass('alert-danger');
            $(divShowError).text(res.msg)
            return;
          }
        },
        error: function(xhr, textStatus, res) {
          $('input').removeClass('is-invalid');
          $('label.msg-error').text('');
          switch (xhr.status) {
            case 422:
              $.each(xhr.responseJSON.errors, function (fieldName, msg){
                $('input[name=' + fieldName +']').addClass('is-invalid');
                $('label[for=' + fieldName +']').text(msg);
              });
              return;
            default:
              alert(xhr.responseJSON.message);
          }
        },
      });
    }
    function redirect(el, mode)
    {
      let idForm = 'form#pg402Form';
      let record = $(el).data('record');
      if (record != undefined) {
        $(idForm + ' input[name=hin_cd]').val(record.hin_cd);
        $(idForm + ' input[name=kikaku_cd]').val(record.kikaku_cd);
      }
      $(idForm + ' input[name=mode]').val(mode);
      $(idForm).attr('action', $(el).data('href')).submit();
    }
  </script>

@endpush
