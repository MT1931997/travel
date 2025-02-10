<select name="{{ $name }}" @if($required) required  class="form-control" @endif>
    @foreach($optionsFromTable2 as $value => $label)
        <option value="{{ $label['id']}}">{{ $label['name'] }}</option>
    @endforeach
</select>
