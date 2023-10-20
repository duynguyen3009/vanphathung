@props([
    'class_custom' => 'col-md-8',
    'type' => 'text',
    'field' => '',
    'attr_input' => '',
    'value' => '',
    'label' => '',
    'required' => 'required',
    'list' => [],
])

<div class="form-group row">
    <div class="col-sm-4">
        <label class="{!! $required !!} col-form-label" for="{!! $field !!}">
            {{ $label }}
        </label>
    </div>
    <div class="{!! $class_custom !!}">
        @if($type == 'select') 
            <x-select :data="$value" :list="$list" id="{!! $field !!}" name="{!! $field !!}" class="form-control" onchange="{!! $attr_input !!}">
                <option value="">選択</option>
            </x-select>
        @else
        <input type="{!! $type !!}" id="{!! $field !!}" name="{!! $field !!}"
        {!! $attr_input !!} value="{!! $value !!}" class='form-control'>
        @endif
        <span id="error{!! $field !!}" class="text-danger"></span>
    </div>
    {!! $slot !!}
</div>
