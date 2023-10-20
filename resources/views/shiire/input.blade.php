<div class="form-group">
  <div class="{!! isset($class_custom) ? $class_custom : '' !!}">
    <label class="{!! isset($class_label) ? $class_label : '' !!} col-form-label {!! isset($require) ? $require : '' !!}" for="{!! $name !!}">
      {{ trans(@$prefix . $filed) }}
    </label>
    @if ($type === 'selectbox')
      <select id="{!! $name !!}" name="{!! $name !!}" {!! isset($attr_input) ? $attr_input : '' !!}
        class='form-control {!! isset($class_input) ? $class_input : '' !!}'>
        @foreach ($options as $k => $v)
          @if ($k == $selected)
            <option value="{{ $k }}" selected>{{ $v }}</option>
          @else
            <option value="{{ $k }}">{{ $v }}</option>
          @endif
        @endforeach
      </select>
    @elseif ($type === 'label')
      <input class="col-sm-3 form-control mr-1" name="{!! $name !!}" readonly>
    @else
      <input type="{!! isset($type) ? $type : 'text' !!}" id="{!! $name !!}" name="{!! $name !!}"
        {!! isset($attr_input) ? $attr_input : '' !!} class='form-control {!! isset($class_input) ? $class_input : '' !!}' value="{!! isset($value_input) ? $value_input : '' !!}">
    @endif
    @if ($children && $type_children == 'input')
      <input type="text" class="col-sm-4 form-control ml-5" id="{{ $children }}" readonly>
    @elseif ($children && $type_children == 'button')
      <button type="{{ $type_children }}" class="col-sm-4 form-control btn btn-secondary ml-2"
        id="{{ $children }}">〒 → 住所</button>
    @endif
    @error($name)
      <span class="text-danger f12 text-nowrap ml-3 {!! isset($class_input) ? $class_input : '' !!}">{{ $message }}</span>
    @enderror
  </div>
</div>
