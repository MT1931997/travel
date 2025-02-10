<select name="{{ $name }}" class="form-control" @if($required == 'required') required @endif>
    @foreach($options as $value => $option)
        <option value="{{ $value }}">{{ $option }}</option>
    @endforeach
</select>
