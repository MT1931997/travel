@extends('layouts.admin')

@section('title', __('messages.User Report'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('messages.User Report') }}</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reports.users') }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('messages.Creation Date') }}</label>
                        <input type="date" name="created_at" class="form-control" value="{{ request('created_at') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('messages.Status') }}</label>
                        <select name="activate" class="form-control">
                            <option value="">{{ __('messages.All Statuses') }}</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('messages.Active') }}</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('messages.Inactive') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('messages.Generate Report') }}</button>
        </form>
        <hr>
        @if($users->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('messages.User ID') }}</th>
                            <th>{{ __('messages.Name') }}</th>
                            <th>{{ __('messages.Email') }}</th>
                            <th>{{ __('messages.Created At') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-warning">{{ __('messages.No records found') }}</div>
        @endif
    </div>
</div>
@endsection
