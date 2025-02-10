@extends('layouts.superAdmin')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('messages.endSubscriptions') }}</h3>
    </div>
    <div class="card-body">
        <!-- Display subscriptions in a table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('messages.Name') }}</th>
                    <th>{{ __('messages.from_date') }}</th>
                    <th>{{ __('messages.to_date') }}</th>
                    <th>{{ __('messages.price_of_subscription') }}</th>
                    <th>{{ __('messages.whatsapp') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subsucriptions as $subscription)
                <tr>
                    <td>{{ $subscription->client->name }}</td>
                    <td>{{ $subscription->from_date }}</td>
                    <td>{{ $subscription->to_date }}</td>
                    <td>{{ $subscription->price_of_subscription }}</td>
                    <td>
                        <a href="https://wa.me/{{ ltrim($subscription->client->phone, '0') }}" target="_blank">
                            <i class="fab fa-whatsapp"></i> {{ $subscription->client->phone }}
                        </a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
