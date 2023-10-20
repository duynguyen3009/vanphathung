@props(['list' => [], 'data' => ''])

<select data-select="select2" {!! $attributes !!}>
    {!! $slot !!}
    @foreach($list as $k => $v)
        <option value="{{ $k }}"
            {!! strval($data) === strval($k) ? 'selected=selected' : '' !!}>{!! $v !!}</option>
    @endforeach
</select>
