@extends('layouts.superAdmin')
@section('title')
    {{ __('messages.Subscriptions for') }} {{ $client->name }}
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('messages.Subscriptions for') }} {{ $client->name }}</h3>
    </div>
    <div class="card-body">
        <!-- Display existing subscriptions -->
        <h4>{{ __('messages.Existing Subscriptions') }}</h4>
        @foreach($subscriptions as $subscription)
            <div class="form-group">
                <label>{{ __('messages.from_date') }}</label>
                <input type="date" class="form-control" value="{{ $subscription->from_date }}" readonly>
            </div>

            <div class="form-group">
                <label>{{ __('messages.to_date') }}</label>
                <input type="date" class="form-control" value="{{ $subscription->to_date }}" readonly>
            </div>

            <div class="form-group">
                <label>{{ __('messages.price_of_subscription') }}</label>
                <input type="text" class="form-control" value="{{ $subscription->price_of_subscription }}" readonly>
            </div>
        @endforeach

        <!-- Add new subscription if the last one is expired -->
        @if(!$latestSubscription || $latestSubscription->to_date < now())
            <h4>{{ __('messages.Add New Subscription') }}</h4>
            <form action="{{ route('clients.storeSubscription', $client->id) }}" method="post">
                @csrf
                <div class="form-group">
                    <label>{{ __('messages.from_date') }}</label>
                    <input type="date" name="from_date" class="form-control" value="{{ old('from_date') }}">
                    @error('from_date')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('messages.to_date') }}</label>
                    <input type="date" name="to_date" class="form-control" value="{{ old('to_date') }}">
                    @error('to_date')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('messages.price_of_subscription') }}</label>
                    <input type="text" name="price_of_subscription" class="form-control" value="{{ old('price_of_subscription') }}">
                    @error('price_of_subscription')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">{{ __('messages.Add Subscription') }}</button>
                </div>
            </form>
        @else
            <p>{{ __('messages.Current subscription is still active.') }}</p>
        @endif
    </div>
</div>
@endsection
