<div class="dataTables_wrapper">
  <div class="row">
    @php
      $sorting = data_get($GridSearch->gridResultTable, 'sorting', []);
    @endphp

    <table {{ $attributes->merge(['class' => 'table table-striped table-bordered'])->except(['formId']) }}>
      <thead>
        {!! $hiddenHtml() !!}
        {!! @$beforeTHeader !!}
        @if (@$tHeader)
          {!! $tHeader !!}
        @else
          <tr>
            @foreach ($columns() as $k => $col)
              @if (data_get($col, 'skipOrderBy', false) || $mode == 'create' || $dataCollection->isEmpty())
                <th nowrap="nowrap" {!! @$col['grid']['attrTh'] !!}>
                @else
                  @php
                    $sortingAttrs = 'aria-sort=""';
                    $dataHref = '';
                    if ($k == $sorting['col']) {
                        $sortingAttrs = 'aria-sort="sorting_' . $sorting['direction'] . '"';
                    }
                  @endphp
                <th nowrap="nowrap" {!! @$col['grid']['attrTh'] !!} {!! $sortingAttrs !!}
                  data-order_by="{{ $k . ':' . ($sorting['direction'] != 'asc' ? 'asc' : 'desc') }}">
              @endif
              {!! $col['grid']['header'] !!}
              </th>
            @endforeach
          </tr>
        @endif
      </thead>
      @if ($dataCollection->isEmpty())
        <tr>
          <td colspan="12">{{ __('messages.MSG_ERR_021') }}</td>
        </tr>
      @else
        <tbody>
          @foreach ($dataCollection as $item)
            @php
              $item = (object) $item;
            @endphp
            <tr @if ($item->del_flg == 1) class="bg-gray" @endif>
              @foreach ($columns() as $key => $col)
                {!! $renderTd($item, $key, $loop->parent) !!}
              @endforeach
              <input type="hidden" name="edit_flg-{!! $item->key !!}" value="{{ $item->edit_flg }}">
              <input type="hidden" name="del_flg-{!! $item->key !!}" value={{ $item->del_flg }}>
            </tr>
          @endforeach
        </tbody>
      @endif
    </table>
  </div>
</div>
@push('js')
  <script>
    $(function() {
      common.grid.changeLinkToSubmitInit("{{ $attributes->get('formId') }}");
      common.grid.changeThOrderByToSubmitInit("{{ $attributes->get('formId') }}", '{{ url()->current() }}');
    });

    function setEditFlg(key) {
      let editFlg = $("input[name='edit_flg-" + key + "']");
      let del_flg = $("input[name='del_flg-" + key + "']");
      let btn = $('#btn-set-delete-flg-' + key);
      let btnEdit = $('#btn-edit-tok-kanren-' + key);
      if (del_flg.val() == 0) {
        editFlg.val(1);
        del_flg.val(1);
        btn.text('復活');
        btn.closest('tr').addClass('bg-gray');
        btnEdit.addClass('d-none');
      } else {
        del_flg.val(0);
        btn.text('削除');
        btn.closest('tr').removeClass('bg-gray');
        btnEdit.removeClass('d-none');
      }
    }

    function editTokKanren(key) {
      let editFlg = $("input[name='edit_flg-" + key + "']");
      let btn = $('#btn-set-delete-flg-' + key);
      let selects = btn.closest('tr').children('td').find('select');
      let error = $('#errorsousai_flg-' + key);
      error.text('');
      if (btn.hasClass('d-none')) {
        if ($(selects[0]).find('option:selected').val() == '') {
          error.removeClass('d-none');
          error.text("{{ __('messages.MSG_ERR_001', ['attribute' => '相殺対象フラグ']) }}");
          return 
        }
        btn.removeClass('d-none');
        selects.addClass('d-none');
        btn.closest('tr').find('span').removeClass('d-none');
        $('#' + $(selects[0]).attr('name')).text($(selects[0]).find('option:selected').text());
        editFlg.val(1);
      } else {
        btn.addClass('d-none');
        selects.removeClass('d-none');
        btn.closest('tr').find('span').addClass('d-none');
      }
    }
  </script>
@endpush
