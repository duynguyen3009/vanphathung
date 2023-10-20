@php
  if(old('transform_search')) {
    $GridSearch->gridSearchForm['data'] = json_decode(old('transform_search'));
  }
@endphp
<form id="{{ $attributes->get('formId') }}" method="post" {!! $attributes->get('formAttr') !!}>
    <input type="hidden" id="grid_transform_search" name="transform_search"
           value={{ empty($GridSearch->gridSearchForm['data'])?'{}': json_encode($GridSearch->gridSearchForm['data']) }}
    />
    <input type="hidden" id="grid_action" name="action" value=""/>
    @csrf
    <div class="table-responsive">
        <div class="dataTables_wrapper">
          <div class="row">
            @php
              $sorting  = data_get($GridSearch->gridResultTable, 'sorting', []);
              $mode     = data_get($GridSearch->gridResultTable, 'mode', []);
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
                    @if(data_get($col, 'skipOrderBy', false)
                        || $mode == 'create'
                        || $dataCollection->isEmpty()
                    )
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
              @if ($mode == 'create' || $dataCollection->isEmpty())
                  <tr><td colspan="12">{{ __('messages.MSG_ERR_021')}}</td></tr>
              @else
                <tbody>
                @foreach($dataCollection as $item)
                  <tr>
                    @foreach($columns() as $key => $col)
                      {!! $renderTd($item, $key, $loop->parent) !!}
                    @endforeach
                  </tr>
                @endforeach
                </tbody>
              @endif
            </table>
          </div>
          @if ($mode != 'create' && !$dataCollection->isEmpty())
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
          @endif
        </div>
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