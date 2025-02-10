@extends('layouts.superAdmin')
@section('title')
{{ __('messages.clients') }}
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title card_title_center"> {{ __('messages.clients') }} </h3>
        <input type="hidden" id="token_search" value="{{csrf_token() }}">
        <a href="{{ route('clients.create') }}" class="btn btn-sm btn-success">{{ __('messages.New') }} {{ __('messages.clients') }}</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4"></div>
        </div>
        <div class="clearfix"></div>
        <div id="ajax_responce_serarchDiv" class="col-md-12">
            @can('order-table')
            @if (isset($data) && !$data->isEmpty())
            <table id="example2" class="table table-bordered table-hover">
                <thead class="custom_thead">
                    <th>{{ __('messages.Name') }}</th>
                    <th>{{ __('messages.Phone') }}</th>
                    <th>Subdomain</th>
                    <th>{{ __('messages.Action') }}</th>
                </thead>
                <tbody>
                    @foreach ($data as $info)
                    <tr>
                        <td>{{ $info->name }}</td>
                        <td>{{ $info->phone }}</td>
                        <td>{{ $info->subdomain }}</td>
                        <td>
                             @if(auth()->user()->is_super == 1)
                            @can('client-edit')
                            <a href="{{ route('clients.edit', $info->id) }}" class="btn btn-sm btn-primary">{{ __('messages.Edit') }}</a>
                            @endcan
                            @can('client-delete')
                            <form action="{{ route('clients.destroy', $info->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('messages.Delete') }}</button>
                            </form>
                            @endcan
                            <!-- New Subscription Button -->
                            <a href="{{ route('clients.subscriptions', $info->id) }}" class="btn btn-sm btn-info">{{ __('messages.Subscription') }}</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            {{ $data->links() }}
            @else
            <div class="alert alert-danger">{{ __('messages.No_data') }}</div>
            @endif
            @endcan
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/admin/js/clientss.js') }}"></script>
@endsection
