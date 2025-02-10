@extends('layouts.admin')

@section('content')
<div class="row  mb-3">
    <div class="col-md-3">
        <form action="{{ route($routeName . '.index') }}" method="GET" class="form-inline">
            <input type="text" name="search" class="form-control mr-2" placeholder="{{__('messages.Search')}}">
        </form>
    </div>
</div>
<div class="container">
    <div class="row justify-content-end mb-3">
        <div class="col-md-6">
            @if($routeName == 'note_vouchers')
            <a class="btn btn-sm btn-primary" href="{{ route('note_vouchers.create', ['id' => 1]) }}">{{__('messages.Create')}}</a>
            @elseif($routeName == 'invoices')
            <a class="btn btn-sm btn-primary" href="{{ route('invoices.create', ['id' => 1]) }}">{{__('messages.Create')}}</a>
            @else
            <a href="{{ route($routeName . '.create') }}" class="btn btn-sm btn-primary">{{__('messages.Create')}}</a>
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        @can($index_var)
                        @if (@isset($data) && !@empty($data) && count($data) > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    @foreach($columnsIndex as $column)
                                    @if ($column !== 'id')
                                    <th>{{ __('messages.' . $column) }}</th>
                                    @endif
                                    @endforeach
                                    <th>{{ __('messages.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                <tr>
                                    @foreach($columnsIndex as $column)
                                    @if($column !== 'id')
                                    <td>{{ $item->$column }}</td>
                                    @endif
                                    @endforeach
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route($routeName . '.show', $item->id) }}" class="btn btn-sm btn-primary">{{__('messages.Show')}}</a>
                                            @can($edit_var)
                                            <a href="{{ route($routeName . '.edit', $item->id) }}" class="btn btn-sm btn-warning">{{__('messages.Edit')}}</a>
                                            @endcan
                                            @can($delete_var)
                                            <form action="{{ route($routeName . '.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">{{__('messages.Delete')}}</button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $data->links() }}
                        </div>
                        @else
                        <div class="alert alert-danger">
                            {{ __('messages.No_data') }} </div>
                        @endif
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
