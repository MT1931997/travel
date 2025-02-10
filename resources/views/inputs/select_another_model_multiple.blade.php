<select name="{{ $name }}[]" @if($required) required  class="form-control" @endif multiple>
    @foreach($optionsFromTable as $value => $label)
        <option value="{{ $label['id']}}">{{ $label['name'] }}</option>
    @endforeach
</select>
