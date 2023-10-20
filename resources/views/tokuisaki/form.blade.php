@extends('layouts.app')
@section('main')
  @php
    $prefix = 'attributes.m_tokuisaki.';
    if ($mode == 'edit') {
        $route = route('tokuisaki.update', ['tokCd' => $item->tok_cd, 'tokCd2' => $item->tok_cd2]);
        $labelButton = '更新';
        $method = 'put';
    } else {
        $route = route('tokuisaki.store');
        $labelButton = '登録';
        $method = 'post';
    }
  @endphp
  <div class="alert d-none" id="error_exception"></div>
  <form method="post" id="fmPG601">
    @csrf
    <input type="hidden" name="transform_search" value="{{ $request->transform_search }}" />
    <input type="hidden" name="mode" value="{{ $mode }}" />
    <input type="hidden" name="action" />
    <div class="card-inverse-primary-light p-4">
      <div class="row">
        <div class="col-md-12 d-flex align-items-center justify-content-between">
          <a class="btn min-wid-110 btn-secondary grid-transform-link btn-back"
            data-href="{{ route('tokuisaki.index') }}">戻る</a>
          <button type="button" class="btn btn-primary min-wid-110" data-href="{{ $route }}"
            onclick="saveData(this)">
            {{ $labelButton }}
          </button>
          @if ($mode == 'edit' && !empty($item))
            <button type="button" class="btn min-wid-110 btn-danger"
              data-href="{{ route('tokuisaki.delete', ['tokCd' => $item->tok_cd, 'tokCd2' => $item->tok_cd2]) }}"
              onclick="deleteData(this)">削除</button>
          @else
            <div></div>
          @endif
        </div>
      </div>
    </div>
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row ml-1 align-items-center">
            @foreach ($configForm as $key => $col)
              @if ($key == 'active')
                @continue
              @elseif($key == 'saiken_keijo_saki_tok_cd')
                <div class="col-md-6">
                  <div class="form-group row">
                    <div class="col-sm-4">
                      <label class="col-form-label" for="saiken_keijo_saki_tok_cd">
                        {{ trans('attributes.m_tokuisaki.saiken_keijo_saki_tok_cd') }}
                      </label>
                    </div>
                    <div class="col-sm-4">
                      <select name="saiken_keijo_saki_tok_cd" class="form-control" id="saiken_keijo_saki_tok_cd"
                        onchange="setSaiken()">
                        <option value="" data-options="">選択</option>
                        @foreach ($listCustomer as $k => $v)
                          <option value="{{ $v->tok_cd }}" {!! strval($v->tok_cd) === strval($item->saiken_keijo_saki_tok_cd) ? 'selected=selected' : '' !!}
                            data-options="{{ $v->tok_cd . ':' . $v->tok_cd2 . ':' . $v->tok_nm . ':' . $v->tok_nm2 }}">
                            {!! $v->tok_nm !!}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class='col-sm-4 form-group'>
                      <label class='label-secondary' id='label-saiken_keijo_saki_tok_cd'></label>
                    </div>
                  </div>
                </div>
                @continue
              @endif
              <div class="col-md-6">
                @if (!isset($col['active']))
                  <x-label-input :field="$key" :attr_input="$col['attrInput']" :label="trans($prefix . $key)" :required="isset($col['required']) ? 'required' : ''" :type="isset($col['type']) ? $col['type'] : 'text'"
                    :class_custom="$col['classCustom']" :value="is_bool(old($key, data_get($item, $key, $col['default'])))
                        ? (int) old($key, data_get($item, $key, $col['default']))
                        : old($key, data_get($item, $key, $col['default']))" :list="isset($col['type']) && $col['type']=='select' ? $col['list'] : []">
                    {!! isset($col['slot']) ? $col['slot'] : '' !!}
                  </x-label-input>
                @endif
              </div>
            @endforeach
            <input type="hidden" name="tok_cd2" value={{ data_get($item, 'tok_cd2', '') }}>
          </div>
          <div class="gird">
            <hr style="height:4px;background-color:rgb(142,169,219)">
            <div class="row ml-1">
              <div class="col-md-6">
                <div class="form-group row">
                  <div class="col-sm-4">
                    <label class="col-form-label" for="user_tok_cd">
                      {{ trans('attributes.m_tok_kanren.user_tok_cd') }}
                    </label>
                  </div>
                  <div class="col-sm-8">
                    <select class="form-control" onchange="setUserTokCd(this)">
                      <option value="">選択</option>
                      @foreach ($listCustomer3 as $k => $v)
                        <option value="{{ $v->tok_cd . ':' . $v->tok_cd2 . ':' . $v->tok_nm }}" {!! strval($v->tok_cd) === strval(old('user_tok_cd')) ? 'selected=selected' : '' !!}>
                          {!! $v->tok_nm !!}
                        </option>
                      @endforeach
                    </select>
                    <input type="hidden" name="user_tok_cd" id="user_tok_cd">
                    <input type="hidden" name="user_tok_cd2" id="user_tok_cd2">
                    <input type="hidden" name="user_tok_nm" id="user_tok_nm">
                    <span id="erroruser_tok_cd" class="text-danger"></span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-4"><label class="col-form-label" for="sousai_flg">
                      {{ trans('attributes.m_tok_kanren.sousai_flg') }}
                    </label></div>
                  <div class="col-md-4">
                    <x-select :list="config('params.options.m_tok_kanren.sousai_flg')" :data="1" name="sousai_flg" id="sousai_flg" class="form-control">
                      <option value="">選択</option>
                    </x-select>
                    <span id="errorsousai_flg" class="text-danger"></span>
                  </div>
                  <div class="col-md-4">
                    <button class="btn btn-warning" type="button" data-href="{{ route('tokuisaki.addItemGird') }}"
                      onclick="addItem(this)">追加</button>
                  </div>
                </div>
              </div>
            </div>
            <hr style="height:4px;background-color:rgb(142,169,219)">
            <div class="p-4">
              <div class="row">
                <div class="col-md-8">
                  @php
                    if (old('pagination')) {
                        $GridSearch->pagination = old('pagination');
                    }
                  @endphp
                  <div id="page-hidden" class="d-none"></div>
                  <input type="hidden" name="gridSearchItems"
                    value="{{ json_encode($GridSearch->pagination->items()) }}">
                  <x-grid-result-table :grid-search="$GridSearch" formId="listSearchTemp" template="tokuisaki.result-table" />
                </div>
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
    $(function() {
      common.grid.changeLinkToSubmitInit('fmPG601');
      @if ($mode == 'edit')
        $('#tok_cd').attr('readonly', true);
        setSaiken();
        @if (empty($item))
          let mes = "{{ json_encode(__('messages.MSG_ERR_020')) }}";
          alert(mes.replace(/&quot;/g, ''));
          $('.btn-back').click();
        @endif
      @endif
    });


    function saveData(el) {
      if (!confirm("{{ __('messages.MSG_INF_001') }}")) {
        return;
      }
      handle(el, 'save');
    }

    function handle(el, action) {
      let idForm = 'form#fmPG601';
      let mesAlert = $('#error_exception');
      mesAlert.addClass('d-none');
      $('input.is-invalid').removeClass('is-invalid');
      $('span.error').text('');
      $(idForm + ' input[name=action]').val(action);
      $.ajax({
        url: $(el).data('href'),
        method: "{{ $method }}",
        data: $(idForm).serialize(),
        success: function(res) {
          if (res.success) {
            $('.btn-back').click();
            return;
          } else { // error in case exception
            mesAlert.removeClass('d-none');
            mesAlert.addClass('alert-danger');
            mesAlert.text(res.msg)
            return;
          }
        },
        error: function(xhr, textStatus, res) {
          switch (xhr.status) {
            case 422:
              let errors = xhr.responseJSON.errors;
              $.each(xhr.responseJSON.errors, function(fieldName, msg) {
                $('input[name=' + fieldName + ']').addClass('is-invalid');
                $('span#error' + fieldName).text(msg);
                $('span#error' + fieldName).addClass('error');
              });
              $('input#' + Object.keys(errors)[0]).focus();
              return;
            default:
              alert(xhr.responseJSON.message);
          }
        },
      });
    }

    function deleteData(el) {
      let mesAlert = $('#error_exception');
      mesAlert.addClass('d-none');
      if (!confirm("{{ __('messages.MSG_INF_002') }}")) {
        return;
      }
      $.ajax({
        url: $(el).data('href'),
        method: 'delete',
        data: [],
        success: function(res) {
          if (res.success) {
            $('.btn-back').click();
            return;
          } else {
            mesAlert.removeClass('d-none');
            mesAlert.addClass('alert-danger');
            mesAlert.text(res.msg)
            return;
          }
        },
      });
    }

    function setUserTokCd(el) {
      let value = typeof $(el).val().split(':') === undefined ? '' : $(el).val().split(':');
      $('#user_tok_cd').val(value[0]);
      $('#user_tok_cd2').val(value[1]);
      $('#user_tok_nm').val(value[2]);
    }

    function setSaiken() {
      let value = $("#saiken_keijo_saki_tok_cd option:selected").data('options');
      value = value == '' ? ['', '', '', ''] : value.split(':');
      $('#saiken_keijo_saki_tok_cd2').val(value[1]);
      $('#label-saiken_keijo_saki_tok_cd').text(value[2]);
      $('#label-saiken_keijo_saki_tok_cd2').text(value[3]);
    }

    function addItem(el) {
      let idForm = 'form#fmPG601';
      $('input.is-invalid').removeClass('is-invalid');
      $('span.error').text('');
      $.ajax({
        url: $(el).data('href'),
        method: 'post',
        data: $(idForm).serialize(),
        success: function(res) {
          $('#page-hidden').html(res);
          $('.gird').eq(0).html($('.gird').eq(1).html());
          return;
        },
        error: function(xhr, textStatus, res) {
          switch (xhr.status) {
            case 422:
              let errors = xhr.responseJSON.errors;
              $.each(xhr.responseJSON.errors, function(fieldName, msg) {
                $('input[name=' + fieldName + ']').addClass('is-invalid');
                $('span#error' + fieldName).text(msg);
                $('span#error' + fieldName).addClass('error');
              });
              $('input#' + Object.keys(errors)[0]).focus();
              return;
            default:
              alert(xhr.responseJSON.message);
          }
        },
      });
    }

    function setFieldNm(el) {
      $('#label-' + $(el).attr('id')).text($(el).find('option:selected').text());
    }

    function setValueAdr(el) {
      $('input.is-invalid').removeClass('is-invalid');
      $('span.error').text('');
      let yubinNo = $('input[name=yubin_no]');
      let adrKen = $('input[name="adr_ken"]');
      let adrSi = $('input[name="adr_si"]');
      if (yubinNo.val() == '') {
        yubinNo.addClass('is-invalid');
        $('span#erroryubin_no').text("{{ __('messages.MSG_ERR_001', ['attribute' => '郵便番号']) }}");
        $('span#erroryubin_no').addClass('error');
      } else {
        AjaxZip3.zip2addr('yubin_no', '', 'adr_ken', 'adr_si', 'adr_tyo', '');
        adrKen.prop('readonly', true);
        adrSi.prop('readonly', true);
        if (AjaxZip3.nzip.length < 7) {
          adrKen.val('').removeAttr('readonly');
          adrSi.val('').removeAttr('readonly');
        }
      }
    }

    function $yubin(a) {
      AjaxZip3.callback(a);
      let adrKen = $('input[name="adr_ken"]');
      let adrSi = $('input[name="adr_si"]');
      var m = a[AjaxZip3.nzip];
      var e = (AjaxZip3.nzip - 0 + 4278190080) + "";
      if (!m && a[e]) {
        m = a[e]
      }
      if (!m) {
        adrKen.val('').removeAttr('readonly');
        adrSi.val('').removeAttr('readonly');
      }
    }
  </script>
@endpush
