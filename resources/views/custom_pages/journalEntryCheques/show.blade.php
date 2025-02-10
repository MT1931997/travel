@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>{{ __('messages.journalEntryCheque') }}</h2>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>{{ __('messages.Date') }}:</strong> {{ $journalEntryCheque->date_journal_entry_cheque }}
            </div>
            <div class="col-md-6">
                <strong>{{ __('messages.Number') }}:</strong> {{ $journalEntryCheque->number }}
            </div>
            <div class="col-md-6">
                <strong>{{ __('messages.branch') }}:</strong> {{ $journalEntryCheque->branch->name }}
            </div>
            <div class="col-md-6">
                <strong>{{ __('messages.customer') }}:</strong> {{ $journalEntryCheque->user->name ?? __('messages.no_customer') }}
            </div>
            <div class="col-md-12">
                <strong>{{ __('messages.note') }}:</strong> {{ $journalEntryCheque->note ?? null }}
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('messages.Number') }}</th>
                    <th>{{ __('messages.amount') }}</th>
                    <th>{{ __('messages.date_collection') }}</th>
                    <th>{{ __('messages.cheque_collection_type') }}</th>
                    <th>{{ __('messages.bank_name') }}</th>
                    <th>{{ __('messages.bank_branch') }}</th>
                    <th>{{ __('messages.costCenter') }}</th>
                    <th>{{ __('messages.note') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($journalEntryCheque->cheques as $cheque)
                    <tr>
                        <td>{{ $cheque->number }}</td>
                        <td>{{ $cheque->amount }}</td>
                        <td>{{ $cheque->date_collection }}</td>
                        <td>{{ $cheque->cheque_collection_type == 1 ? __('messages.Co') : __('messages.Mujir') }}</td>
                        <td>{{ $cheque->bank_name }}</td>
                        <td>{{ $cheque->bank_branch }}</td>
                        <td>{{ $cheque->costCenter->name }}</td>
                        <td>{{ $cheque->note ?? null }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('journalEntryCheques.index') }}" class="btn btn-secondary">{{ __('messages.back') }}</a>
    </div>
@endsection
