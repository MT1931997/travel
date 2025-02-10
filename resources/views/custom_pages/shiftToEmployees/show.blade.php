@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>{{ __('messages.priceOffer') }}</h2>

        <!-- Display the header -->
        @if($priceOffer->header_before_product)
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        {!! $priceOffer->header_before_product !!}
                    </div>
                </div>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>{{ __('messages.Date') }}:</strong> {{ $priceOffer->date_price_offer }}
            </div>
            <div class="col-md-6">
                <strong>{{ __('messages.Number') }}:</strong> {{ $priceOffer->number }}
            </div>
            <div class="col-md-6">
                <strong>{{ __('messages.branch') }}:</strong> {{ $priceOffer->branch->name }}
            </div>
            <div class="col-md-6">
                <strong>{{ __('messages.customer') }}:</strong> {{ $priceOffer->user->name ?? null}}
            </div>
            <div class="col-md-12">
                <strong>{{ __('messages.note') }}:</strong> {{ $priceOffer->note ?? null }}
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('messages.product') }}</th>
                    <th>{{ __('messages.unit') }}</th>
                    <th>{{ __('messages.quantity') }}</th>
                    <th>{{ __('messages.selling_price_without_tax') }}</th>
                    <th>{{ __('messages.selling_price_with_tax') }}</th>
                    <th>{{ __('messages.tax') }}</th>
                    <th>{{ __('messages.note') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($priceOffer->priceOfferProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>
                            @php
                                $unit = $product->units->where('id', $product->pivot->unit_id)->first();
                            @endphp
                            {{ $unit ? $unit->name : $product->unit->name }}
                        </td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>{{ $product->pivot->selling_price_without_tax }}</td>
                        <td>{{ $product->pivot->selling_price_with_tax }}</td>
                        <td>{{ $product->pivot->tax }}</td>

                        <td>{{ $product->pivot->note }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Display the footer -->
        @if($priceOffer->header_after_product)
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="alert alert-secondary">
                        {{ $priceOffer->header_after_product ?? null}}
                    </div>
                </div>
            </div>
        @endif

        <a href="{{ route('priceOffers.index') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection
