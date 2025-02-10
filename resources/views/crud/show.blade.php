@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">{{__('messages.Show')}} </h1>
    <div class="card">
        <div class="card-body">
            @foreach($columns_view as $index => $column_view)
            @if ($columns_table_name[$index] !== 'password')
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <strong>{{ $column_view }}:</strong>
                    </div>
                    <div class="col-sm-8">
                        {{ $data->{$columns_table_name[$index]} }}
                    </div>
                </div>
            @endif
        @endforeach
        </div>
    </div>
</div>
@endsection
