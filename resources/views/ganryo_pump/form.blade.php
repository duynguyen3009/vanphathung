@extends('layouts.app')
@section('main')
<style>
  .relative {
    position: relative !important;
  }
  #table_kikaku th {
    padding: 5px 10px;
  }
  #table_kikaku td {
    background: #e9ecef;
    padding: 5px 10px;
  }
  .error {
    outline: 1px solid #FF4747 !important;
  }
</style>
<div class="alert d-none" name="error_exception"></div>
<form method="post" action="" id="ganryoPumpForm"> 
  {{ csrf_field() }}
  <input type="hidden" name="mode" value="{{ $mode }}">
  <input type="hidden" name="haigo_key_mei" value="">
  <input type="hidden" name="transform_search" value='@json($transformSearch)'>

  {{-- start check exist record PG302Request --}}
  <input type="hidden" name="ganryo_pump">
  <label class="alert-danger text-danger text-nowrap msg-error" for="ganryo_pump"></label>
  {{-- end check exist record PG302Request --}}

  <div class="row " id="part2">
    <div class="col-12 grid-margin stretch-card f14 relative">
      <div class="card relative">
        <div class="card-body relative">

          <div class="row">
            <div class="col-12 col-md-4">
              <div class="form-group">
                <div class="row">
                  <label class="col-12 col-md-5 col-form-label text-nowrap mb-0 required">{{ trans('attributes.m_ganryo_pump.ktn_cd') }}</label>
                  <div class="col-12 col-md-7">
                    <x-select
                        :list="@$listKskyoten"
                        :data="@$record->ktn_cd"
                        :disabled="$mode == 'edit' ? 'disabled' : null"
                        name="ktn_cd"
                        id="ktn_cd"
                        class="form-control"
                        onchange="setDispenserKbn(this, 'ktn_cd')"
                        >
                        <option value="">{{ trans('site.init_selection.option') }}</option>
                    </x-select>
                    @if(!empty($record) && $mode == 'edit')
                      <input type="hidden" name="ktn_cd" readonly="" value="{{ @$record->ktn_cd }}" class="form-control">
                    @endif
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-5"></div>
                  <div class="col-12 col-md-7">
                    <label class="text-danger text-nowrap msg-error" for="ktn_cd"></label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-4">
              <div class="form-group">
                <div class="row">
                  <label class="col-12 col-md-5 col-form-label text-nowrap mb-0 required">{{ trans('attributes.m_ganryo_pump.dispenser_kbn') }}</label>
                  <div class="col-12 col-md-7">
                    <x-select
                        :list="@$listKojoCode"
                        :data="@$record->dispenser_kbn"
                        :disabled="$mode == 'edit' ? 'disabled' : null"
                        name="dispenser_kbn"
                        id="dispenser_kbn"
                        class="form-control">
                        <option value="">{{ trans('site.init_selection.option') }}</option>
                    </x-select>
                    @if(!empty($record) && $mode == 'edit')
                      <input type="hidden" name="dispenser_kbn" readonly="" value="{{ @$record->dispenser_kbn }}" class="form-control">
                    @endif
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-5"></div>
                  <div class="col-12 col-md-7">
                    <label class="text-danger text-nowrap msg-error" for="dispenser_kbn"></label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-md-4">
              <div class="form-group">
                <div class="row">
                  <label class="col-12 col-md-5 col-form-label text-nowrap mb-0 required">{{ trans('attributes.m_ganryo_pump.hin_cd') }}</label>
                  <div class="col-12 col-md-7">
                    <select class="form-control" name="hin_cd" onChange="setHinnm(this, 'hin_cd')" {{ $mode == 'edit' ? 'disabled' : null}}>
                      <option value="">{{ trans('site.init_selection.option') }}</option>
                        @foreach($listHinmoku as $v)
                          <option value="{{$v->hin_cd}}" 
                                  data-name="{{ $v->hin_nm }}" 
                                  {!! strval(@$record->hin_cd) === strval($v->hin_cd) ? 'selected=selected' : '' !!}
                          >
                            {{ $v->hin_cd }}
                          </option>
                        @endforeach
                    </select>
                    @if(!empty($record) && ($mode == 'edit'))
                      <input type="hidden" name="hin_cd" readonly="" value="{{ @$record->hin_cd }}" class="form-control">
                    @endif
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-5"></div>
                  <div class="col-12 col-md-7">
                    <label class="text-danger text-nowrap msg-error" for="hin_cd"></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-5">
              <input type="text" readonly="" name="hin_nm" class="form-control" value="{{ ($mode == 'edit' || $mode == 'copy') ? @$record->hin_nm : null }}">
            </div>
          </div>

          <div class="row d-flex align-items-end ">
            <div class="col-12 col-md-4">
              <div class="form-group">
                <div class="row">
                  <label class="col-12 col-md-5 col-form-label text-nowrap mb-0 required">{{ trans('attributes.m_ganryo_pump.kikaku_cd') }}</label>
                  <div class="col-12 col-md-7">
                    <select class="form-control" name="kikaku_cd" id="kikaku_cd" onchange="showInfoKikaku(this)" {{ $mode == 'edit' ? 'disabled' : null}}>
                      <option value="">{{ trans('site.init_selection.option') }}</option>
                      @if (!empty($listKikaku))
                        @foreach($listKikaku as $v)
                          <option value="{{$v->kikaku_cd}}" 
                                  data-K17="{{$v->K17}}" 
                                  data-K19="{{$v->K19}}" 
                                  data-C112="{{$v->C112}}" 
                                  data-C113="{{$v->C113}}" 
                                  data-C114="{{$v->C114}}" 
                                  data-C115="{{$v->C115}}"
                                  {!! strval(@$record->kikaku_cd) === strval($v->kikaku_cd) ? 'selected=selected' : '' !!}
                          >
                            {{ $v->kikaku_cd }}
                          </option>
                        @endforeach
                      @endif
                    </select>
                    @if(!empty($record) && $mode == 'edit')
                      <input type="hidden" name="kikaku_cd" readonly="" value="{{ @$record->kikaku_cd }}" class="form-control">
                    @endif
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-5"></div>
                  <div class="col-12 col-md-7">
                    <label class="text-danger text-nowrap msg-error" for="kikaku_cd"></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-8">
              <div id="show-info-kikaku" style="margin-bottom: 34px;"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-4">
              <div class="form-group">
                <div class="row">
                  <label class="col-12 col-md-5 col-form-label text-nowrap mb-0 required">{{ trans('attributes.m_ganryo_pump.lot_no') }}</label>
                  <div class="col-12 col-md-7">
                    <input type="text" name="lot_no" value="{{ @$record->lot_no }}" class="form-control">
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-5"></div>
                  <div class="col-12 col-md-7">
                    <label class="text-danger text-nowrap msg-error" for="lot_no"></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="form-group">
                <div class="row">
                  <label class="col-12 col-md-5 col-form-label text-nowrap mb-0 required">{{ trans('attributes.m_ganryo_pump.keisu') }}</label>
                  <div class="col-12 col-md-7">
                    <input type="text" name="keisu" value="{{ @$record->keisu }}" class="form-control">
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-5"></div>
                  <div class="col-12 col-md-7">
                    <label class="text-danger text-nowrap msg-error" for="keisu"></label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- last --}}
          <div class="row">
            <div class="col-12 col-md-12">
              <div class="form-group">
                <div class="row" style="margin-bottom: -24px;">
                  <label class="col-12 col-md-1 col-form-label text-nowrap font-weight-bold">ポンプ7 </label>
                  <label class="col-12 col-md-1 col-form-label text-nowrap font-weight-bold">容量 ml </label>
                  <label class="col-12 col-md-2 col-form-label text-nowrap font-weight-bold text-center">1 </label>
                  <label class="col-12 col-md-2 col-form-label text-nowrap font-weight-bold text-center">2 </label>
                  <label class="col-12 col-md-2 col-form-label text-nowrap font-weight-bold text-center">3 </label>
                  <label class="col-12 col-md-2 col-form-label text-nowrap font-weight-bold text-center">重量</label>
                  <label class="col-12 col-md-2 col-form-label text-nowrap font-weight-bold text-center">登録済重量</label>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-12">
              <div class="form-group">
                <div class="row mb-3">
                  <label class="col-12 col-md-1 col-form-label text-nowrap required">生大 </label>
                  <div class="col-12 col-md-1 col-form-label text-nowrap">40.0 </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row1[1]" value="" class="form-control" onfocusout="calcWeight(this, 1)">
                    <label class="text-danger msg-error" for="row1[1]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row1[2]" value="" class="form-control" onfocusout="calcWeight(this, 1)">
                    <label class="text-danger msg-error" for="row1[2]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row1[3]" value="" class="form-control" onfocusout="calcWeight(this, 1)">
                    <label class="text-danger msg-error" for="row1[3]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row1[average]" value="" class="form-control" readonly>
                    <label class="text-danger msg-error" for="row1[average]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row1[hakidasu_ryo_nama_dai]" value="{{ @$record->hakidasu_ryo_nama_dai }}" class="form-control" readonly>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-12 col-md-1 col-form-label text-nowrap required">生小 </label>
                  <div class="col-12 col-md-1 col-form-label text-nowrap">4.0 </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row2[1]" value="" class="form-control" onfocusout="calcWeight(this, 2)">
                    <label class="text-danger msg-error" for="row2[1]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row2[2]" value="" class="form-control" onfocusout="calcWeight(this, 2)">
                    <label class="text-danger msg-error" for="row2[2]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row2[3]" value="" class="form-control" onfocusout="calcWeight(this, 2)">
                    <label class="text-danger msg-error" for="row2[3]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row2[average]" value="" class="form-control" readonly>
                    <label class="text-danger msg-error" for="row2[average]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row2[hakidasu_ryo_nama_sho]" value="{{ @$record->hakidasu_ryo_nama_sho }}" class="form-control" readonly>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-12 col-md-1 col-form-label text-nowrap required">薄大 </label>
                  <div class="col-12 col-md-1 col-form-label text-nowrap">40.0 </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row3[1]" value="" class="form-control" onfocusout="calcWeight(this, 3)">
                    <label class="text-danger msg-error" for="row3[1]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row3[2]" value="" class="form-control" onfocusout="calcWeight(this, 3)">
                    <label class="text-danger msg-error" for="row3[2]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row3[3]" value="" class="form-control" onfocusout="calcWeight(this, 3)">
                    <label class="text-danger msg-error" for="row3[3]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row3[average]" value="" class="form-control" readonly>
                    <label class="text-danger msg-error" for="row3[average]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row3[hakidasu_ryo_usu_dai]" value="{{ @$record->hakidasu_ryo_usu_dai }}" class="form-control" readonly>
                  </div>
                </div>

                <div class="row" style="margin-bottom: -22px;">
                  <label class="col-12 col-md-1 col-form-label text-nowrap required">薄小 </label>
                  <div class="col-12 col-md-1 col-form-label text-nowrap">4.0 </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row4[1]" value="" class="form-control" onfocusout="calcWeight(this, 4)">
                    <label class="text-danger msg-error" for="row4[1]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row4[2]" value="" class="form-control" onfocusout="calcWeight(this, 4)">
                    <label class="text-danger msg-error" for="row4[2]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row4[3]" value="" class="form-control" onfocusout="calcWeight(this, 4)">
                    <label class="text-danger msg-error" for="row4[3]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row4[average]" value="" class="form-control" readonly>
                    <label class="text-danger msg-error" for="row4[average]"></label>
                  </div>
                  <div class="col-12 col-md-2">
                    <input type="text" name="row4[hakidasu_ryo_usu_sho]" value="{{ @$record->hakidasu_ryo_usu_sho }}" class="form-control" readonly>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12 col-md-1 col-form-label text-nowrap"></div>
                  <div class="col-12 col-md-1 col-form-label text-nowrap"></div>
                  <div class="col-12 col-md-2 text-right">
                    g
                  </div>
                  <div class="col-12 col-md-2 text-right">
                    g
                  </div>
                  <div class="col-12 col-md-2 text-right">
                    g
                  </div>
                  <div class="col-12 col-md-2 text-right">
                    g/1目盛り
                  </div>
                  <div class="col-12 col-md-2 text-right">
                    g/1目盛り
                  </div>
                </div>

              </div>
            </div>
          </div>
          {{-- end last --}}
          
          @if($mode == 'edit') 
            <div style="position: absolute; top: 1.25rem; right: 1.25rem" >
              <button class="btn btn-danger min-wid-110" 
                      type="button" 
                      data-href="{{ route('ganryo_pump.delete') }}"
                      onclick="deletePG302(this)">
                削除
              </button>
            </div>
          @endif
          <div class="d-flex justify-content-between">
            <a class="btn min-wid-110 btn-secondary grid-transform-link"
                   data-transform_search='@json($transformSearch)'
                   data-href="{{ route('ganryo_pump.index') }}"
                >戻る</a>
            <div>
              <button class="btn btn-primary min-wid-110" 
                      type="button" 
                      data-href="{{ route('ganryo_pump.store') }}"
                      onclick="savePG302(this)">
                {{ $mode == 'edit' ? '更新' : '登録'}}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</form>

@endsection

@push('js')
  <script>
  $(document).ready(function() 
  {
    common.grid.changeLinkToSubmitInit('ganryoPumpForm'); // button back

    if($('select[name="kikaku_cd"]').val()) {
      $('select[name="kikaku_cd"]').trigger('change'); // case edit show info kikaku
    }
  });

  function savePG302(el)
  {
    if (!confirm("{{ __('messages.MSG_INF_001') }}")) {
      return;
    }

    handle(el, 'post');
  }
  
  function deletePG302(el)
  {
    if (!confirm("{{ __('messages.MSG_INF_002') }}")) {
      return;
    }

    handle(el, 'delete');
  }

  function handle(el, method)
  {
    let idForm = 'form#ganryoPumpForm';

    $.ajax({
      url: $(el).data('href'),
      method: method,
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
        $('input, select').removeClass('error');
        $('label.msg-error').text('');
        switch (xhr.status) {
          case 422:
            $.each(xhr.responseJSON.errors, function (fieldName, msg){
              var fieldNameNew = convertDotToSquareBrackets(fieldName);
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

  function setDispenserKbn(e, type) 
  {
    var value = $(e).val();
    $.ajax({ 
      url: '{{route('ganryo_pump.ajax_ganryo_pump')}}',
      type: 'POST',
      data: {          
        type: type,
        value: value,
      },
      success: function(res) {
        let data = res.data;
        let idSelectbox = '#dispenser_kbn';

        $(idSelectbox).find('option').not(':first').remove();

        if (Object.keys(data).length > 0) {
          $.each(data, function (key, val) {
            $(idSelectbox).append($('<option>', { 
                value: key,
                text : val 
            }));
          });
        }
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
      }
    })
  }

  function setHinnm(e, type)
  {
    var value = $(e).val();
    var _active = $('select[name="hin_cd"]').find('option[value="'+value+'"]');
    $('#ganryoPumpForm input[name=hin_nm]').val(_active.data('name'));

    setKikaku(e, value, type);
  }

  function setKikaku(e, hinCd, type)
  {
    $.ajax({ 
      url: '{{route('ganryo_pump.ajax_ganryo_pump')}}',
      type: 'POST',
      data: {          
        type: type,
        value: hinCd,
      },
      success: function(res) {
        let data = res.data;
        let idSelectbox = '#kikaku_cd';
        var html = `<option value="">{{ trans('site.init_selection.option') }}</option>`;

        data.forEach(function(item) {
          html = `${html} <option value="${item.kikaku_cd}" data-K19="${item.K19}" data-K17="${item.K17}" data-C112="${item.C112}" data-C113="${item.C113}" data-C114="${item.C114}" data-C115="${item.C115}">${item.kikaku_cd}</option>`;
        });
        $(idSelectbox).html(html);
        $(idSelectbox).trigger('change');
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
      }
    })
  }

  function showInfoKikaku(e) 
  {
    var value = $(e).val();
    var html = '';
    if(value) {
      var _active = $('select[name="kikaku_cd"]').find('option[value="'+value+'"]');
      var k19 = _active.data('k19') != null ? _active.data('k19'): '';
      var k17 = _active.data('k17') != null ? _active.data('k17'): '';
      var c112 = _active.data('c112') != null ? _active.data('c112'): '';
      var c113 = _active.data('c113') != null ? _active.data('c113'): '';
      var c114 = _active.data('c114') != null ? _active.data('c114'): '';
      var c115 = _active.data('c115') != null ? _active.data('c115'): '';
      html = `<table id="table_kikaku" style="width: 100%">
            <thead>
              <th>{{trans('attributes.m_haigo_key_mei.k19')}}</th>
              <th>{{trans('attributes.m_haigo_key_mei.c112')}}</th>
              <th>{{trans('attributes.m_haigo_key_mei.k17')}}</th>
              <th>{{trans('attributes.m_haigo_key_mei.c113')}}</th>
              <th>{{trans('attributes.m_haigo_key_mei.c114')}}</th>
              <th>{{trans('attributes.m_haigo_key_mei.c115')}}</th>
            </thead>
            <tbody>
              <tr>
                <td>${k19}<input type="hidden" value="${k19}" /></td>
                <td>${c112}<input type="hidden" value="${c112}" /></td>
                <td>${k17}<input type="hidden" value="${k17}" /></td>
                <td>${c113}<input type="hidden" value="${c113}" /></td>
                <td>${c114}<input type="hidden" value="${c114}" /></td>
                <td>${c115}<input type="hidden" value="${c115}" /></td>
              </tr>
            </tbody>
          </table>`;
    }
    $('#show-info-kikaku').html(html);
  }

  function calcWeight(e, row)
  {
    var value   = $(e).val();
    var divisor = 3; // because the row has 3 inputs.

    if (isDecimal(value)) {
      var num1 = parseFloat($('input[name="row'+row+'[1]"]').val());
      var num2 = parseFloat($('input[name="row'+row+'[2]"]').val());
      var num3 = parseFloat($('input[name="row'+row+'[3]"]').val());

      var numbers = [num1, num2, num3].filter(function(num) {
        return !isNaN(num);
      });

      var total = numbers.reduce(function(sum, num) {
          return sum + num;
      }, 0);

      var average = total / divisor;

      $('input[name="row'+row+'[average]"]').val(average.toFixed(4));
    }
  }

  function isDecimal(value) 
  {
    var decimalPattern = /^[-+]?(\d{1,3}(\.\d{0,4})?|\.\d{1,4})$/; // decimal(7,4)
    return decimalPattern.test(value);
  }

  function convertDotToSquareBrackets(str)
  {
    var splittedStr = str.split('.');
    return splittedStr.length == 1 ? str : (splittedStr[0] + '[' + splittedStr.splice(1).join('][') + ']');
  }
  </script>
@endpush