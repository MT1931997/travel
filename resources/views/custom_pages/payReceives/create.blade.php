@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Create Invoice</h2>

    <!-- Tabs for Pay and Receive -->
    <ul class="nav nav-tabs" id="payReceiveTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="pay-tab" data-bs-toggle="tab" href="#pay" role="tab" aria-controls="pay" aria-selected="true">{{ __('messages.Pay') }}</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="receive-tab" data-bs-toggle="tab" href="#receive" role="tab" aria-controls="receive" aria-selected="false">{{ __('messages.Receive') }}</a>
        </li>
    </ul>
    <div class="tab-content" id="payReceiveTabsContent">
        <div class="tab-pane fade show active" id="pay" role="tabpanel" aria-labelledby="pay-tab"></div>
        <div class="tab-pane fade" id="receive" role="tabpanel" aria-labelledby="receive-tab"></div>
    </div>

    <form action="{{ route('payReceives.store') }}" method="POST">
        @csrf

        <input type="hidden" name="redirect_to" id="redirect_to" value="index">
        <input type="hidden" name="journal_id" id="journal_id" value="3">
        <input type="hidden" name="type" id="type" value="1">

        <button type="submit" class="btn btn-primary" onclick="setRedirect('index')">{{ __('messages.Submit') }}</button>
        <button type="submit" class="btn btn-primary" onclick="setRedirect('show')">{{ __('messages.Save_Print') }}</button>

        <div class="col-md-6">
            <div class="form-group">
                <label for="date_pay_receive">{{ __('messages.Date') }}</label>
                <input type="date" name="date_pay_receive" class="form-control" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="number">{{ __('messages.Number') }}</label>
                <input type="number" name="number" class="form-control" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="amount">{{ __('messages.amount') }}</label>
                <input type="amount" name="amount" class="form-control">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="currency">{{ __('messages.currency_id') }}</label>
                <select name="currency" class="form-control" required>
                    @foreach ($currencies as $currency)
                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="branch">{{ __('messages.branch') }}</label>
                <select name="branch" class="form-control" required>
                    @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="customer">{{ __('messages.customer') }}</label>
                @include('inputs.search_select', [
                'name' => 'user',
                'required' => null,
                ])
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="account">{{ __('messages.account') }}</label>
                @include('inputs.search_select2', [
                'name' => 'account',
                'required' => null,
                ])
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="in_date_currency_rate">{{ __('messages.in_date_currency_rate') }}</label>
                <input type="in_date_currency_rate" name="in_date_currency_rate" class="form-control">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="note">{{ __('messages.note') }}</label>
                <textarea name="note" class="form-control"></textarea>
            </div>
        </div>
    </form>
</div>
@endsection

@section('js')
<script type="text/javascript">
    function setRedirect(value) {
        document.getElementById('redirect_to').value = value;
    }

    // JavaScript to handle tab selection
    document.getElementById('pay-tab').addEventListener('click', function() {
        document.getElementById('journal_id').value = 3;
        document.getElementById('type').value = 1;
    });

    document.getElementById('receive-tab').addEventListener('click', function() {
        document.getElementById('journal_id').value = 2;
        document.getElementById('type').value = 2;
    });
</script>
@endsection
