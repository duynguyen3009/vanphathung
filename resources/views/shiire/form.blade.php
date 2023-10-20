@extends('layouts.app');
@section('main')
  @php
    $fields = include app_path('Helpers/Grid/config/PG501.php');
    $fields = $fields['form']['fieldForm'];

    foreach ($dataCombobox as $key => $value) {
        $fields[$key]['options'] = $value;
    }

    foreach ($data as $key => $value) {
        if (array_key_exists($key, $fields) && $fields[$key]['type'] == 'textbox') {
            $fields[$key]['value'] = $value;
        } elseif (array_key_exists($key, $fields) && $fields[$key]['type'] == 'selectbox') {
            $fields[$key]['selected'] = $value;
        }
    }
  @endphp

  <style>
    .class_label {
      position: relative;
    }

    .require::before {
      content: "*";
      color: red;
      font-size: 22px;
      text-align: center;
      line-height: 50px;
      position: absolute;
      left: -2%;
      top: -6%;
    }

    .content-wrapper {
      background: #fff;
    }
  </style>

  <form class="row " method="POST" action="{{ $mode == 'create' ? route('shiire.store') : route('shiire.update') }}"
    id="shiireForm" name="shiireForm">
    @csrf
    <input type="hidden" name="mode" value="{{ $mode }}">
    <input type="hidden" name="transform_search" id="grid_transform_search"
      value="{{ old('transform_search', json_encode($request['GridSearchForm'])) }}">
    <div class="col-md-12 d-flex justify-content-between align-items-center my-4">
      <a class="btn btn-secondary btn-back grid-transform-link"
        data-transform_search="{{ old('transform_search', json_encode($request['GridSearchForm'])) }}"
        data-href="{{ route('shiire.index') }}">戻る</a>
      <button class="btn btn-primary">{{ $mode == 'edit' ? '更新' : '登録' }}</button>
      @if ($mode == 'edit')
        <button class="btn btn-danger btn-fw btn-clear">削除</button>
      @endif
    </div>

    <div>
      @if (Session::has('errorInsert'))
        <div class="alert alert-danger">
          {{ Session::get('errorInsert') }}
        </div>
      @endif
    </div>

    <div class="row col-md-12">
      <div class="col-md-6">
        @php
          $halfFields = array_chunk($fields, ceil(count($fields) / 2), true);
        @endphp

        @foreach ($halfFields[0] as $key => $field)
          @php
            $fieldName = $field['label'];
            $isRequired = $field['require'];
            $isDisable = $mode == 'edit' && $key == 'shiire_cd' ? 'readonly' : '';
            $isSelectBox = isset($field['type']) ? $field['type'] : '';
            $options = isset($field['options']) ? $field['options'] : [];
            $isSelected = isset($field['selected']) ? $field['selected'] : '';
            $isChildren = isset($field['children']) ? $field['children']['name'] : false;
            $value = isset($field['value']) ? $field['value'] : '';
          @endphp

          @include('shiire.input', [
              'filed' => $fieldName,
              'name' => $key,
              'attr_input' => "maxlength='50'",
              'class_custom' => 'row',
              'require' => $isRequired ? 'require' : '',
              'attr_input' => $isDisable ? $isDisable : '',
              'type' => $isSelectBox,
              'options' => $options,
              'selected' => $isSelected,
              'children' => $isChildren,
              'type_children' => $isChildren ? $field['children']['type'] : 'text',
              'class_label' => 'col-sm-3 mx-3 class_label',
              'class_input' => $isChildren ? 'col-sm-3 mr-1' : 'col-sm-8',
              'value_input' => $value,
          ])
        @endforeach
      </div>

      <div class="col-md-6">
        @foreach ($halfFields[1] as $key => $field)
          @php
            $fieldName = $field['label'];
            $isRequired = $field['require'];
            $isDisable = $mode == 'edit' && $key == 'shiire_cd' ? 'readonly' : '';
            $isSelectBox = isset($field['type']) ? $field['type'] : '';
            $options = isset($field['options']) ? $field['options'] : [];
            $isSelected = isset($field['selected']) ? $field['selected'] : '';
            $isChildren = isset($field['children']) ? $field['children']['name'] : '';
            $value = isset($field['value']) ? $field['value'] : '';
          @endphp

          @include('shiire.input', [
              'filed' => $fieldName,
              'name' => $key,
              'attr_input' => "maxlength='50'",
              'class_custom' => 'row',
              'require' => $isRequired ? 'require' : '',
              'attr_input' => $isDisable ? $isDisable : '',
              'type' => $isSelectBox,
              'options' => $options,
              'selected' => $isSelected,
              'children' => $isChildren,
              'type_children' => $isChildren ? $field['children']['type'] : 'text',
              'class_label' => 'col-sm-3 mx-3 class_label',
              'class_input' => $isChildren ? 'col-sm-3 mr-1' : 'col-sm-8',
              'value_input' => $value,
          ])
        @endforeach
      </div>
    </div>

  </form>
@endsection

@push('js')
  <script>
    common.grid.changeLinkToSubmitInit('shiireForm');
    let data = @json($data);
    let msg_err_020 = @json(trans('messages.MSG_ERR_020'));
    let msg_inf_001 = @json(trans('messages.MSG_INF_001'));
    let msg_inf_002 = @json(trans('messages.MSG_INF_002'));
    let mode = @json($mode);

    if (data.length == 0 && mode == 'edit') {
      alert(msg_err_020);
      $('.btn.btn-back').click();
    }

    $('.btn.btn-primary').on('click', function(e) {
      e.preventDefault();
      if (confirm(msg_inf_001)) {
        $('#shiireForm').submit();
      }
    });

    $('.btn-fw.btn-clear').on('click', function(e) {
      e.preventDefault();
      if (confirm(msg_inf_002)) {
        let urlDelete = '{{ route('shiire.delete') }}';
        $('#shiireForm').attr('action', urlDelete);
        $('#shiireForm').submit();
      }
    });


    $('#juusho').on('click', function(e) {
      e.preventDefault();
      let adrKen = $('input[name="adr_ken"]');
      let adrSi = $('input[name="adr_si"]');
      let adrTyo = $('input[name="adr_tyo"]');
      adrKen.replaceWith('<input class="col-sm-3 form-control" name="adr_ken" readonly="">');
      adrSi.replaceWith('<input class="col-sm-3 form-control" name="adr_si" readonly="">');
      adrTyo.replaceWith('<input class="col-sm-3 form-control" name="adr_tyo" readonly="">');
      AjaxZip3.zip2addr('yubin_no', '', 'adr_ken', 'adr_si', 'adr_tyo');

      setTimeout(function() {
        let adrKen = $('input[name="adr_ken"]');
        let adrSi = $('input[name="adr_si"]');
        let adrTyo = $('input[name="adr_tyo"]');
        if (adrKen.val() == '' || adrKen.val() == undefined || adrSi.val() == '' || adrSi.val() == undefined ||
          adrTyo.val() == '' || adrTyo.val() == undefined) {
          adrKen.replaceWith('<input type="text" name="adr_ken" class="form-control col-sm-3">');
          adrSi.replaceWith('<input type="text" name="adr_si" class="form-control col-sm-3">');
          adrTyo.replaceWith('<input type="text" name="adr_tyo" class="form-control col-sm-3">');
        }
      }, 300);
    });

    $('select[name=saimu_keijo_saki_shiire_cd]').on('change', function() {
      let saimuKeijoSakiShiireCd = $(this).val();
      $.get('{{ route('shiire.shiire_ajax') }}', {
        saimuKeijoSakiShiireCd,
          key: 'saimu_keijo_saki_shiire_cd'
        },
        function(response) {
          options = ``;
          response.data.map((item) => {
            $('input[id=saimu_keijo_saki_shiire_cd_nm]').val(item.shiire_nm)
            $('input[name=saimu_keijo_saki_shiire_cd2]').val(item.shiire_cd2)
            $('input[id=saimu_keijo_saki_shiire_c2_nm]').val(item.shiire_nm2)
          })
        });
    });

    $('select[name=m_koza_id]').on('change', function() {
      let m_koza_id = $(this).val();
      $.get('{{ route('shiire.shiire_ajax') }}', {
          m_koza_id,
          key: 'm_koza_id'
        },
        function(response) {
          response.data.map((item) => {
            $('select[name=koza_type]').val(item.koza_type)
            $('input[name=koza_meigi]').val(item.koza_meigi)
            $('input[name=kinyu_siten_nm]').val(item.kinyu_siten_nm)
            $('input[name=koza_no]').val(item.koza_no)
          })
        });
    });

    function handleSelect(selectName, inputName, params, set) {
      $(`select[name=${selectName}]`).on('change', function() {
        let valueSelect = $(this).val()
        $.get('{{ route('shiire.shiire_ajax') }}', {
            [params]: valueSelect,
            key: params
          },
          function(response) {
            response.data.map((item) => {
              $(`input[id=${inputName}]`).val(item[`${set}`])
            })
          });
      });
    }

    handleSelect('uke_busho_cd', 'uke_busho_nm', 'busho_cd', 'busho_nm');
    handleSelect('eig_busho_cd', 'eig_busho_nm', 'busho_cd', 'busho_nm');
    handleSelect('uke_tan_cd', 'uke_tan_cd_nm', 'user_id', 'user_nm');
    handleSelect('eig_tan_cd', 'eig_tan_cd_nm', 'user_id', 'user_nm');
  </script>
@endpush
