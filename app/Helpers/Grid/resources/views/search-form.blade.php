<div class="u-left-sidebar">
    <form {!! $attributes !!}>
        @csrf

        {!! @$topslot !!}

        @unless($skipPerPage)
        <div class="u-box u-box-flex">
            <div class="u-box-heading">{{ __('site.components.search-form.perPage', [], @$locale) }}</div>
            <div class="u-box-body">
                <x-select
                        :list="$options('perPage')"
                        :data="$dataRequest('perPage')"
                        class="form-select form-select-sm grid-submit"
                        name="{{ $dataRequestName() . '[perPage]' }}"/>
            </div>
        </div>
        <div class="u-line"></div>
        @endunless
        @unless($skipOrderBy)
        <div class="u-box">
            <div class="u-box-heading">{{ __('site.components.search-form.orderBy', [], @$locale) }}</div>
            <div class="u-box-body">
                <x-select
                        :list="$options('OrderBy')"
                        :data="$dataRequest('orderBy')"
                        name="{{ $dataRequestName() . '[orderBy]' }}"
                        class="form-select form-select-sm grid-submit">
                </x-select>
            </div>
        </div>
        @endunless
        {!! $slot !!}
    </form>
</div>

@push('js')
    <script>
        $(function() {
          common.grid.searchByChangeInputDataInit('{{$attributes->get('id')}}');
        })
    </script>
@endpush
