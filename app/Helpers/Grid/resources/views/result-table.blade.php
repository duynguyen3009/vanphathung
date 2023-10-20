<form id="{{ $attributes->get('formId') }}" method="post" {!! $attributes->get('formAttr') !!}>
  {{ @$formBegin }}
  <input type="hidden" id="grid_transform_search" name="transform_search"
         value={{ empty($GridSearch->gridSearchForm['data'])?'{}': json_encode($GridSearch->gridSearchForm['data']) }}
  />
  <input type="hidden" id="grid_action" name="action" value=""/>
  @csrf

  <div class="table-responsive">
    @if($dataCollection->isEmpty())
      <div class="d-flex flex-column p-5 text-center">
        <h5>{{ trans('messages.MSG_ERR_015') }}</h5>
        <h6>{{ trans('messages.MSG_INF_006') }}</h6>
      </div>
    @else
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
                @foreach($columns() as $k =>$col)
                  @if(data_get($col, 'skipOrderBy', false))
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
                        data-order_by="{{ $k . ':' . ($sorting['direction'] != 'asc' ? 'asc' : 'desc') }}"
                    >
                      @endif
                      {!! $col['grid']['header'] !!}
                    </th>
                    @endforeach
              </tr>
            @endif
            </thead>
            <tbody>
            @foreach($dataCollection as $item)
              <tr>
                @foreach($columns() as $key => $col)
                  {!! $renderTd($item, $key, $loop->parent) !!}
                @endforeach
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

        @if(@$pagination)
          {!! $pagination !!}
        @elseif ($GridSearch->pagination)
          <input type="hidden" id="grid_page" name="page" value="{{ $GridSearch->pagination->currentPage() }}"/>
          {!! $GridSearch->pagination->onEachSide(1)->links('grid::pagination') !!}
          @push('js')
            <script>
              $(function() {
                common.grid.changePageToSubmitInit("{{ $attributes->get('formId') }}", '{{ url()->current() }}');
              });
            </script>
          @endpush
        @endif
      </div>
    @endif
  </div>
</form>

@push('js')
  <script>
    $(function() {
      common.grid.changeLinkToSubmitInit("{{ $attributes->get('formId') }}");
      common.grid.changeThOrderByToSubmitInit("{{ $attributes->get('formId') }}", '{{ url()->current() }}');
    });
  </script>
@endpush
