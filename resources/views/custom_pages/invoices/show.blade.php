@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>{{ $invoice->invoice_type->name }}</h2>

        <!-- Display the header -->
        @if($invoice->invoice_type->header)
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        {!! $invoice->invoice_type->header !!}
                    </div>
                </div>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>{{ __('messages.Date') }}:</strong> {{ $invoice->date_invoice }}
            </div>
            <div class="col-md-6">
                <strong>{{ __('messages.Number') }}:</strong> {{ $invoice->number }}
            </div>
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <strong>{{ __('messages.branch') }}:</strong> {{ $invoice->branch->name }}
            </div>
            <div class="col-md-6">
                <strong>{{ __('messages.customer') }}:</strong> {{ $invoice->user->name ?? null}}
            </div>
            <div class="col-md-12">
                <strong>{{ __('messages.note') }}:</strong> {{ $invoice->note ?? null }}
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
                    <th>{{ __('messages.discount_fixed') }}</th>
                    <th>{{ __('messages.discount_percentage') }}</th>
                    <th>{{ __('messages.note') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->invoiceProducts as $product)
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
                        <td>{{ $product->pivot->discount_fixed }}</td>
                        <td>{{ $product->pivot->discount_percentage }}</td>

                        <td>{{ $product->pivot->note }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Display the footer -->
        @if($invoice->invoice_type->footer)
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="alert alert-secondary">
                        {{ $invoice->invoice_type->footer ?? null}}
                    </div>
                </div>
            </div>
        @endif

        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection
