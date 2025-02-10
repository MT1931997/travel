<div class="radio-list-tree">
    @foreach($optionsTree as $option)
        <label class="parent">
            <input type="radio" name="{{ $name }}" value="{{ $option->id }}" @if($loop->first) checked @endif> {{ $option->name }}
        </label>
        <!-- Include child nodes if any -->
        @if($option->children->isNotEmpty())
            <div class="children hidden">
                @include('inputs.radio_list', ['name' => $name, 'optionsTree' => $option->children])
            </div>
        @endif
    @endforeach
</div>
