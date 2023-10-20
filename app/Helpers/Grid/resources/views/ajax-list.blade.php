<div class="row">
    <div class="col col-auto pt-1">リスト表示行数</div>
    <div class="col col-auto">
        <x-select
                :list="@config('params.perPageOptions')"
                :data="@request($id . '__search_perPage')"
                class="form-select form-select-sm w-120px" style="margin-bottom: 1rem;"
                onchange="common.grid.simpleAjaxSearch(this, '{{$id}}', '{{ request()->fullUrl() }}', true)"
                id="{{ $id . '__search_perPage' }}"
                name="{{ $id . '__search_perPage' }}"/>
    </div>
    <div class="col col-auto">
        {!! $pagination->withQueryString()->onEachSide(0)->links('grid::pagination') !!}
    </div>
</div>

<div class="table-responsive">
    <table class='table table-list table-striped table-hover table-bordered align-middle' >
        <thead>
        {!! @$beforeTHeader !!}
        @if (@$tHeader)
            {!! $tHeader !!}
        @else
            <tr>
                @foreach($columns() as $col)
                    <th nowrap="nowrap" {!! @$col['attrTh'] !!}>{!! $col['header'] !!}</th>
                @endforeach
            </tr>
        @endif
        </thead>
        <tbody>
        @foreach($dataCollection() as $item)
            <tr>
                @foreach($columns() as $key => $col)
                    {!! $renderTd($item, $key, $loop->parent) !!}
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>