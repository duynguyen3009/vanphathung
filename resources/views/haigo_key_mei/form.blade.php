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
  .has-danger select.form-control-danger {
    outline: 1px solid #FF4747
  }
</style>
@error('haigo_key_mei')
  <div class="alert alert-danger">
    {{ $message }}
  </div>
@enderror
@error('messageError')
  <div class="alert alert-danger">
    {{ $message }}
  </div>
@enderror
<form method="post" action="{{ $mode == 'create' ? route('haigo_key_mei.store', ['haigoKey' => $haigoKeyCd]) : '' }}" id="haigoKeymei"> 
  {{ csrf_field() }}
  <input type="hidden" name="mode" value="{{$oldForm->mode??old('mode')}}">
  @if(!empty($haigoKeyMei) || $mode == 'edit') 
    @method('put')
  @endif
  <input type="hidden" name="haigo_key_mei" value="">
  <input type="hidden" name="transform_search"  value="{{ $oldForm->transform_search ?? old('transform_search') }}">
  
  <div class="row f14">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <div class="row">
                  <label class="col-12 col-md-4 col-form-label text-nowrap ">{{ trans('attributes.m_haigo_key_mei.haigo_key') }}</label>
                  <div class="col-12 col-md-3">
                    <input type="text" name="haigo_key" class="form-control" value="{{ old('haigo_key', $haigoKey->haigo_key ?? '') }}" readonly>
                    @error('haigo_key')
                      <div class="text-danger f12 text-nowrap" style="width: 100%;">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row ">
                  <label class="col-12 col-md-4 col-form-label text-nowrap ">{{ trans('attributes.m_haigo_key_mei.haigo_nm') }}</label>
                  <div class="col-12 col-md-8">
                    <input type="text" name="haigo_key_nm" class="form-control" value="{{ old('haigo_key_nm', $haigoKey->haigo_key_nm?? '') }}" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <div class="row">
                  <label class="col-12 col-md-4 col-form-label text-nowrap ">{{ trans('attributes.m_haigo_key_mei.seihin_kbn') }}</label>
                  <div class="col-12 col-md-3">
                    <input type="text" name="haigo_key_seihin_kbn" class="form-control" value="{{ old('haigo_key_seihin_kbn', $haigoKey->seihin_kbn??'') }}" readonly>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row ">
                  <label class="col-12 col-md-4 col-form-label text-nowrap ">{{ trans('attributes.m_haigo_key_mei.flat_base_keisu') }}</label>
                  <div class="col-12 col-md-3">
                    <input type="text" name="flat_base_keisu" class="form-control" value="{{ old('flat_base_keisu', $haigoKey->flat_base_keisu??'') }}" readonly>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-5" id="part2" >
    <div class="col-12 grid-margin stretch-card f14 relative">
      <div class="card relative">
        <div class="card-body relative">
          <div class="row">
            <div class="col-12 col-md-4">
              <div class="form-group @error('hin_cd') has-danger @enderror">
                <div class="row">
                  <label class="col-12 col-md-5 col-form-label text-nowrap required">{{ trans('attributes.m_haigo_key_mei.hin_cd') }} </label>
                  <div class="col-12 col-md-7">
                    
                    <select data-select="select2" class="form-control @error('hin_cd') form-control-danger @enderror" name="hin_cd" onchange="onChangeCallAjax(this, 'hin_cd')" @if(!empty($haigoKeyMei) && $mode == 'edit') {{ 'disabled' }} @endif>
                      <option value="">選択</option>
                      @foreach($mHinmokus as $hinmoku)
                      <option value="{{$hinmoku->hin_cd}}" @selected(old('hin_cd', $haigoKeyMei->hin_cd??'') == $hinmoku->hin_cd) >{{ $hinmoku->hin_cd }}</option>
                      @endforeach
                    </select>
                    @if(!empty($haigoKeyMei) && $mode == 'edit')
                      <input type="hidden" name="hin_cd" readonly="" value="{{$hinCd}}" class="form-control">
                    @endif

                    @error('hin_cd')
                      <div class="text-danger f12 text-nowrap">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-5">
              <input type="" readonly="" name="hin_nm" class="form-control" value="{{ old('hin_nm') }}">
            </div>
          </div>
           
          <div class="row d-flex align-items-end ">
            <div class="col-12 col-md-4">
              <div class="form-group @error('kikaku_cd') has-danger @enderror">
                <div class="row">
                  <label class="col-12 col-md-5 col-form-label text-nowrap required">{{ trans('attributes.m_haigo_key_mei.kikaku_cd') }}</label>
                  <div class="col-12 col-md-7">
                    <select data-select="select2" class="form-control @error('kikaku_cd') form-control-danger @enderror " name="kikaku_cd" onchange="onchangeKikaku(this)" @if(!empty($haigoKeyMei) && $mode == 'edit') {{ 'disabled' }} @endif>
                      <option value="">選択</option>
                    </select>
                    @if(!empty($haigoKeyMei) && $mode == 'edit')
                      <input type="hidden" name="kikaku_cd" readonly="" value="{{$kikakuCd}}" class="form-control">
                    @endif
                    @error('kikaku_cd')
                      <div class="text-danger f12 text-nowrap">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-8">
              <div id="show-info-kikaku" style="margin-bottom: 15px;"></div>
              @error('kikaku_cd')
                <div>&nbsp;</div>
              @enderror
            </div>
          </div>

          <div class="row ">
            <div class="col-12 col-md-4">
              <div class="form-group @error('ganryo_kbn') has-danger @enderror">
                <div class="row">
                  <label class="col-12 col-md-5 col-form-label text-nowrap ">{{ trans('attributes.m_haigo_key_mei.ganryo_kbn') }}</label>
                  <div class="col-12 col-md-7">
                    <select data-select="select2" class="form-control @error('ganryo_kbn') form-control-danger @enderror" name="ganryo_kbn" >
                      <option value="">選択</option>
                      @foreach($mCodes as $code)
                      <option value="{{ $code->kbn }}" @selected(old('ganryo_kbn', $haigoKeyMei->ganryo_kbn??'') == $code->kbn)>{{$code->name}}</option>
                      @endforeach
                    </select>
                    @error('ganryo_kbn')
                      <div class="text-danger f12 text-nowrap">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row  ">
            <div class="col-12 col-md-4">
              <div class="form-group @error('bihikuru_keisu') has-danger @enderror">
                <div class="row">
                  <label class="col-12 col-md-5 col-form-label text-nowrap ">{{ trans('attributes.m_haigo_key_mei.bihikuru_keisu') }}</label>
                  <div class="col-12 col-md-7">
                    <input type="text" name="bihikuru_keisu" class="form-control @error('bihikuru_keisu') form-control-danger @enderror" value="{{ old('bihikuru_keisu', $haigoKeyMei ? number_format($haigoKeyMei->bihikuru_keisu, 4) :'') }}">
                    @error('bihikuru_keisu')
                      <div class="text-danger f12 text-nowrap">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row  ">
            <div class="col-12 col-md-4">
              <div class="form-group @error('tonyu_group_no') has-danger @enderror">
                <div class="row">
                  <label class="col-12 col-md-5 col-form-label text-nowrap ">{{ trans('attributes.m_haigo_key_mei.tonyu_group_no') }}</label>
                  <div class="col-12 col-md-7">
                    <input type="text" name="tonyu_group_no" class="form-control @error('tonyu_group_no') form-control-danger @enderror" value="{{ old('tonyu_group_no', $haigoKeyMei->tonyu_group_no??'') }}">
                    @error('tonyu_group_no')
                      <div class="text-danger f12 text-nowrap">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row  ">
            <div class="col-12 col-md-4">
              <div class="form-group @error('disp_jun') has-danger @enderror">
                <div class="row">
                  <label class="col-12 col-md-5 col-form-label text-nowrap ">{{ trans('attributes.m_haigo_key_mei.disp_jun') }}</label>
                  <div class="col-12 col-md-7">
                    <input type="text" name="disp_jun" class="form-control @error('disp_jun') form-control-danger @enderror" value="{{ old('disp_jun', $haigoKeyMei->disp_jun??'') }}">
                    @error('disp_jun')
                      <div class="text-danger f12 text-nowrap">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-between row-btn-page bg-inverse-primary">
            <button class="btn btn-secondary min-wid-110" type="button" onclick="backForm()">戻る</button>
            <div>
              @if(!empty($haigoKeyMei) || $mode == 'edit') 
              <button class="btn btn-danger min-wid-110" onclick="deleteForm(this, event)">削除</button>
              @endif
              <button class="btn btn-warning min-wid-110" type="button">ルール追加</button>
              <button class="btn btn-primary min-wid-110" onclick="submitForm(this, event)">登録</button>
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
  var urlBack =  "{{ route('haigo_key.edit', ['haigoKey' => !empty($haigoKey) ? $haigoKey->haigo_key : $haigoKeyCd]) }}";
  var kikaku_cd = "{{$kikakuCd ?? old('kikaku_cd')}}"
  function onChangeCallAjax(e, key) {
    var value = $(e).val();
    if(value) {
      $.ajax({ 
        url: '{{route('haigo_key_mei.ajax_m_haigo_key_mei')}}',
        type: 'POST',
        data: {          
          id: value,
          key: key
        },
        success: function(data) {
          if(key == 'hin_cd') {
            $('input[name="hin_nm"]').val(data.hin_cd.hin_nm);
            $('#show-info-kikaku').html('');
            if(data.kikaku_cd) {
              var html = '<option value="">規格</option>';
              data.kikaku_cd.forEach(function(item) {
                html = `${html} <option value="${item.kikaku_cd}" data-K19="${item.K19}" data-K17="${item.K17}" data-C112="${item.C112}" data-C113="${item.C113}" data-C114="${item.C114}" data-C115="${item.C115}">${item.kikaku_cd}</option>`;
              });
              $('select[name="kikaku_cd"]').html(html);
              if(kikaku_cd!= "" && kikaku_cd != null && kikaku_cd) {
                $('select[name="kikaku_cd"]').val(kikaku_cd);
                $('select[name="kikaku_cd"]').trigger('change');
                kikaku_cd = '';
              }
            }
          }
        },
        error: function(xhr, status, error) {
          console.error('Error:', error);
        }
      })
    } else {
      if(key == 'hin_cd') {
        $('select[name="kikaku_cd"]').html('<option value="">規格</option>');
        $('#show-info-kikaku').html('');
        $('input[name="hin_nm"]').val('');
      }
    }
  }
  function onchangeKikaku(e) {
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

  function submitForm(e, event) {
    event.preventDefault();
    var confirmS = confirm('{{ trans('messages.MSG_INF_001') }}');
    if(confirmS) {
      $(e).parents('form').submit();
    }
  }
  @if($mode == 'edit')
    function deleteForm(e, event) {
      event.preventDefault();
      var confirmS = confirm('{{ trans('messages.MSG_INF_002') }}');
      if(confirmS) {
        var elementDelete = '@method('DELETE')';
        var urlDelete = '{{ route('haigo_key_mei.delete', ['haigoKey' => $haigoKeyCd, 'kikakuCd' => $kikakuCd, 'hinCd' => $hinCd]) }}'
        $(e).parents('form').find('input[name="_method"]').remove();
        $(e).parents('form').attr('action', urlDelete);
        $(e).parents('form').append(elementDelete);
        $(e).parents('form').submit();
      }
    }
  @endif
  function backForm() {
    $('form#haigoKeymei').attr('action', urlBack);
    $('form#haigoKeymei').submit();
  }
  $(document).ready(function() {
    if($('select[name="hin_cd"]').val()) {
      $('select[name="hin_cd"]').trigger('change');
    }
  });
</script>

@if((empty($haigoKeyMei) && $mode == 'edit') || empty($haigoKey)) 
  @php
    $message = trans('messages.MSG_ERR_020');
  @endphp
  <script>
    var message = <?php echo json_encode($message); ?>;
    alert(message);
    backForm();
  </script>
@endif
@endpush