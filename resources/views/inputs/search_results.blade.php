@if($results->isEmpty())
    <div class="search-item not-found">Not found</div>
@else
    @foreach($results as $result)
        <div class="search-item" data-value="{{ $result->id }}">{{ $result->name }}</div>
    @endforeach
@endif

