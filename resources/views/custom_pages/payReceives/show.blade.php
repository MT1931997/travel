@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>{{ $payReceives->type == 1 ? __('messages.Pay') : __('messages.Receive') }}</h2>

        <!-- Display the header -->
        @if($payReceives->journal->header)
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        {!! $payReceives->journal->header !!}
                    </div>
                </div>
            </div>
        @endif


        <div class="row mb-3">
            <div class="col-md-6">
                <strong>{{ __('messages.Date') }}:</strong> {{ $payReceives->date_pay_receive }}
            </div>
            <div class="col-md-6">
                <strong>{{ __('messages.Number') }}:</strong> {{ $payReceives->number }}
            </div>
            <div class="col-md-6">
                <strong>{{ __('messages.branch') }}:</strong> {{ $payReceives->branch->name }}
            </div>
            <div class="col-md-6">
                <strong>{{ __('messages.customer') }}:</strong> {{ $payReceives->user->name ?? null}}
            </div>

        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('messages.amount') }}</th>
                    <th>{{ __('messages.note') }}</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td>{{ $payReceives->amount }}</td>
                        <td>{{ $payReceives->note }}</td>

                    </tr>
            </tbody>
        </table>

        <!-- Display the footer -->
        @if($payReceives->journal->footer)
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="alert alert-secondary">
                        {{ $payReceives->journal->footer ?? null}}
                    </div>
                </div>
            </div>
        @endif

        <a href="{{ route('payReceives.index') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection
