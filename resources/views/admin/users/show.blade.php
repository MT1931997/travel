@extends('layouts.admin')

@section('title')
    {{ __('messages.View') }} {{ __('messages.user') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('users.index') }}"> {{ __('messages.users') }} </a>
@endsection

@section('contentheaderactive')
    {{ __('messages.View') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> {{ __('messages.View') }} {{ __('messages.user') }} </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>{{ __('messages.Name') }}</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.Email') }}</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.Phone') }}</th>
                    <td>{{ $user->phone }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.Address') }}</th>
                    <td>{{ $user->address }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.date_of_birth') }}</th>
                    <td>{{ $user->date_of_birth }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.Date of passport end') }}</th>
                    <td>{{ $user->date_of_passport_end }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.Budget') }}</th>
                    <td>{{ $user->budget }}</td>
                </tr>
                <tr>
                    <th>{{ __('messages.Months That Love To Travel') }}</th>
                    <td>
                        @if ($user->months_that_love_to_travel)
                            {{ implode(', ', array_map('ucfirst', explode(',', $user->months_that_love_to_travel))) }}
                        @else
                            {{ __('messages.Not Available') }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>{{ __('messages.Selected Countries') }}</th>
                    <td>
                        @if ($user->countries)
                            @foreach ($user->countries as $country)
                                <span class="badge badge-primary">{{ $country->name }}</span>
                            @endforeach
                        @else
                            {{ __('messages.Not Available') }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>{{ __('messages.Photo') }}</th>
                    <td>
                        @if ($user->photo)
                            <img src="{{ asset('assets/admin/uploads/' . $user->photo) }}" alt="User Photo" height="100">
                        @else
                            {{ __('messages.No Image') }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>{{ __('messages.Photo of passport') }}</th>
                    <td>
                        @if ($user->photo_of_passport)
                            <img src="{{ asset('assets/admin/uploads/' . $user->photo_of_passport) }}" alt="Passport Photo" height="100">
                        @else
                            {{ __('messages.No Image') }}
                        @endif
                    </td>
                </tr>
            </table>
            <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">{{ __('messages.Back') }}</a>
        </div>
    </div>
@endsection
