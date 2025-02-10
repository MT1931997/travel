@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Create Journal Entry Cheque</h2>
    <form action="{{ route('journalEntryCheques.store') }}" method="POST">
        @csrf

        <input type="hidden" name="redirect_to" id="redirect_to" value="index">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" onclick="setRedirect('index')">{{ __('messages.Submit') }}</button>
                    <button type="submit" class="btn btn-primary" onclick="setRedirect('show')">{{ __('messages.Save_Print') }}</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date_journal_entry_cheque">{{ __('messages.Date') }}</label>
                    <input type="date" name="date_journal_entry_cheque" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="number">{{ __('messages.Number') }}</label>
                    <input type="number" name="number" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="row">
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
        </div>

        <div class="row">
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
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="checkPortfolio">{{ __('messages.checkPortfolios') }}</label>
                    <select name="checkPortfolio" class="form-control" required>
                        @foreach ($checkPortfolios as $checkPortfolio)
                        <option value="{{ $checkPortfolio->id }}">{{ $checkPortfolio->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="journal_entry_type">{{ __('messages.journal_entry_type') }}</label>
                    <select name="journal_entry_type" class="form-control" required>
                        <option value="1">{{ __('messages.Pay') }}</option>
                        <option value="2">{{ __('messages.Receive') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="cheque_collection_type">{{ __('messages.cheque_collection_type') }}</label>
                    <select name="cheque_collection_type" class="form-control" required>
                        <option value="1">{{ __('messages.Portfolio') }}</option>
                        <option value="2">{{ __('messages.Cash') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="customer">{{ __('messages.customer') }}</label>
                    @include('inputs.search_select', [
                        'name' => 'user',
                        'required' => null,
                    ])
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="account">{{ __('messages.cash_check_account') }}</label>
                    @include('inputs.search_select2', [
                        'name' => 'account',
                        'required' => null,
                    ])
                </div>
            </div>
        </div>

        <br>
        <table class="table table-bordered" id="products_table">
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
                    <th>{{ __('messages.Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" class="form-control number" name="cheques[0][number]" /></td>
                    <td><input type="amount" class="form-control amount" name="cheques[0][amount]" /></td>
                    <td><input type="date" class="form-control date_collection" name="cheques[0][date_collection]" /></td>
                    <td>
                        <select class="form-control cheque_collection_type" name="cheques[0][cheque_collection_type]">
                            <option value="1">{{ __('messages.Co') }}</option>
                            <option value="2">{{ __('messages.Mujir') }}</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control bank_name" name="cheques[0][bank_name]" /></td>
                    <td><input type="text" class="form-control bank_branch" name="cheques[0][bank_branch]" /></td>
                    <td>
                        <select name="cheques[0][costCenter]" class="form-control costCenter">
                            @foreach ($costCenters as $costCenter)
                            <option value="{{ $costCenter->id }}">{{ $costCenter->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="cheques[0][note]" /></td>
                    <td><button type="button" class="btn btn-danger remove-row">{{ __('messages.Delete') }}</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-primary" id="add_row">{{ __('messages.Add_Row') }}</button>
    </form>
</div>
@endsection

@section('js')
<script type="text/javascript">
    function setRedirect(value) {
        document.getElementById('redirect_to').value = value;
    }

    $(document).ready(function() {
        let rowIdx = 1;

        $('#add_row').on('click', function() {
            $('#products_table tbody').append(`
                <tr>
                    <td><input type="text" class="form-control number" name="cheques[${rowIdx}][number]" /></td>
                    <td><input type="amount" class="form-control amount" name="cheques[${rowIdx}][amount]" /></td>
                    <td><input type="date" class="form-control date_collection" name="cheques[${rowIdx}][date_collection]" /></td>
                    <td>
                        <select class="form-control cheque_collection_type" name="cheques[${rowIdx}][cheque_collection_type]">
                            <option value="1">{{ __('messages.Co') }}</option>
                            <option value="2">{{ __('messages.Mujir') }}</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control bank_name" name="cheques[${rowIdx}][bank_name]" /></td>
                    <td><input type="text" class="form-control bank_branch" name="cheques[${rowIdx}][bank_branch]" /></td>
                    <td>
                        <select name="cheques[${rowIdx}][costCenter]" class="form-control costCenter">
                            @foreach ($costCenters as $costCenter)
                            <option value="{{ $costCenter->id }}">{{ $costCenter->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="cheques[${rowIdx}][note]" /></td>
                    <td><button type="button" class="btn btn-danger remove-row">{{ __('messages.Delete') }}</button></td>
                </tr>
            `);
            rowIdx++;
        });

        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
@endsection
