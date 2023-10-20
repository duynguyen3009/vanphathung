<div class="u-box">
    <div class="u-box-body m-0">
        <x-radios
                :list="$parent->options('whereBoolean')"
                :data="$parent->dataRequest('whereBoolean', 'AND')"
                name="{{ $parent->dataRequestName() . '[whereBoolean]' }}"
                label-class="form-check-label"
                contain-class="form-check form-check-inline"
                class="form-check-input"
        />
    </div>
</div>
@for($i = 1; $i <= ($number ?? 3); $i++)
    <div class="u-box">
        <div class="u-box-heading">絞込み項目</div>
        <div class="u-box-body">
            <x-select
                    :list="$parent->options('Where')"
                    :data="$parent->dataRequest('where.' . $i . '.name')"
                    name="{{ $parent->dataRequestName() . '[where]['.$i.'][name]' }}"
                    class="form-select form-select-sm grid-option-where-reset">
                <option value=""></option>
            </x-select>
            <div class="mb-2"></div>
            <input type="text"
                   value="{{ $parent->dataRequest('where.' . $i . '.value') }}"
                   name="{{ $parent->dataRequestName() . "[where][$i][value]" }}"
                   class="form-control form-control-sm grid-option-where-reset grid-submit" placeholder=""/>
        </div>
    </div>
@endfor

@if(auth()->user()->checkRoles([\App\Models\MUser::DOM_ROLE]))
    <div class="u-box">
        <button type="button" class="btn btn-primary btn-block"
                onclick="common.grid.resetSearchFormBtn('#{{ $parent->attributes->get('id')}}')">search clear</button>
    </div>
@else
    <div class="u-box">
        <button type="button" class="btn btn-primary btn-block"
                onclick="common.grid.resetSearchFormBtn('#{{ $parent->attributes->get('id')}}')">絞込みクリア</button>
    </div>
@endif


