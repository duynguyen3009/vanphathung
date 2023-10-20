@foreach($list as $column => $item)
    @php
        $itemList = config('params.' . ($item['paramKey'] ?? '-'), $item['list'] ?? []);
    @endphp
    <div class="u-box u-box-flex pt-1 pb-1">
        <div class="u-box-heading">{{ @$item['label'] }}</div>
        <div class="u-box-body">
            <x-select
                :list="$itemList"
                :data="$parent->dataRequest($column)"
                name="{{ $parent->dataRequestName() . '['.$column.']' }}"
                class="form-select form-select-sm grid-submit w-120px">
                <option value=""></option>
            </x-select>
        </div>
    </div>
@endforeach
