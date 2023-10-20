@props(['list' => [], 'data' => ''])

<select {!! $attributes !!}>
    {!! $slot !!}
    @foreach($list as $k => $v)
        <option value="{{ $k }}"
            {!! strval($data) === strval($k) ? 'selected=selected' : '' !!}>{!! $v !!}</option>
    @endforeach
</select>
