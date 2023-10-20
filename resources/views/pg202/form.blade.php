@php
    $hinCd = request()->route('hinCd');
    $hinNm = request()->route('hinNm');
@endphp
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
            {{-- <input type="hidden" name="ktn_cd" value="">
            <input type="hidden" name="hin_cd" value="">
            <input type="hidden" name="kikaku_cd" value="">
            <input type="hidden" name="dispenser_kbn" value=""> --}}
            {{-- <div class="row mb-3">
              <div class="col-md-12 form-group d-flex align-items-center justify-content-end">
                <a class="btn min-wid-110 btn-primary grid-transform-link"
                   data-transform_search="{{ json_encode($form['data']) }}"
                   data-href="{{ route('ganryo_pump.create') }}"
                >新規追加</a>
              </div>
            </div> --}}
            <div class="row mb-3">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">品目コード</label>
                  <label class="col-sm-3 col-form-label bg-secondary">{{ $hinCd }}</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">品目名称</label>
                  <label class="col-sm-3 col-form-label bg-secondary">{{ $hinNm }}</label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="d-flex justify-content-between" style="width: 100%">
                <a class="btn min-wid-110 btn-secondary grid-transform-link"
                     data-transform_search="{{ json_encode($form['data']) }}"
                     data-href="{{ route('haigo_key.index') }}"
                  >戻る
                </a>
                <div class="d-flex" style="width: 300px">
                  <label class="col-sm-3 col-form-label">元</label>
                  <label class="col-sm-12 col-form-label bg-secondary">
                    {{ $hinCd }}　{{ $hinNm }}
                  </label>
                </div>
                @if (!empty($hinCd))
                  <button type="button" 
                          class="btn btn-primary min-wid-110"
                          data-href="{{ route('haigo_key.save') }}"
                          onclick="savePG402(this)">
                    元データの明細を複写
                  </button>
                @endif
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
            <label class="col-sm-1 col-form-label">拠点コード</label>
            <div class="col-12 col-md-2">
              <select class="form-control" name="ktn_cd_from">
                <option value="">{{ trans('site.init_selection.option') }}</option>
                  @foreach($listKskyoten as $cd => $v)
                    <option value="{{$cd}}" 
                            data-name="{{ $v }}" 
                            {!! strval(@$record->ktn_cd) === strval($cd) ? 'selected=selected' : '' !!}
                    >
                      {{ $v }}
                    </option>
                  @endforeach
              </select>
            </div>
            →
            <div class="col-12 col-md-2">
              <x-select
                :list="@$listKskyoten"
                :data="@$record->ktn_cd"
                name="ktn_cd_to"
                id="ktn_cd_to"
                class="form-control">
                <option value="">{{ trans('site.init_selection.option') }}</option>
              </x-select>
            </div>
            <button type="button" 
                  class="btn btn-warning min-wid-110"
                  data-href="{{ route('haigo_key.save') }}"
                  onclick="savePG402(this)">
                  工場へ明細を複写
            </button>
            <div class="col-12 col-md-3">
              <button type="button" 
                    class="btn btn-warning min-wid-110"
                    data-href="{{ route('haigo_key.save') }}"
                    onclick="savePG402(this)">
                    新規追加
              </button>
            </div>
          </div>
          <br />
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
        $('form[name={!! $form['name'] !!}] select').val('');
      })
      common.grid.changeLinkToSubmitInit('{!! $form['name'] !!}');
    });

    function saveHanbaiKojo(el)
    {
      if (!confirm("{{ __('messages.MSG_INF_001') }}")) {
        return;
      }

      let idForm = 'form#listSearchTemp';

      let jyuEntryFukaFlg = 'jyu_entry_fuka_flg__' + $(el).data('key_row');

      let dataSend = {
        hin_cd    : $(el).data('hin_cd'),
        kikaku_cd : $(el).data('kikaku_cd'),
        ktn_cd    : $(el).data('ktn_cd'),
      };

      dataSend[jyuEntryFukaFlg] = $('select[name=jyu_entry_fuka_flg__'+ $(el).data('key_row')+']').val();

      $.ajax({
        url: $(el).data('href'),
        method: 'POST',
        data: dataSend,
        success: function(res) {
          if (res.success) {
            // $(idForm).attr('action', res.url).submit();
            // return;
          } else { // error in case exception
            // let divShowError = 'div[name=error_exception]';
            // $(divShowError).removeClass('d-none');
            // $(divShowError).addClass('alert-danger');
            // $(divShowError).text(res.msg)
            // return;
          }
        },
        error: function(xhr, textStatus, res) {
          $('input, select').removeClass('error');
          $('label.msg-error').text('');
          console.log(xhr.responseJSON.errors);
          switch (xhr.status) {
            case 422:
              $.each(xhr.responseJSON.errors, function (fieldName, msg){
                // var fieldNameNew = convertDotToSquareBrackets(fieldName);
                var fieldNameNew = (fieldName);
                $('[name="' + fieldNameNew +'"]').addClass('error');
                $('label[for="' + fieldNameNew +'"]').text(msg);
              });
              return;
            default:
              alert(xhr.responseJSON.message);
          }
        },
      });
    }

    
  </script>
@endpush
