@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Create Journal Entry</h2>
    <form action="{{ route('journalEntries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="redirect_to" id="redirect_to" value="index">

        <button type="submit" class="btn btn-primary" onclick="setRedirect('index')">{{ __('messages.Submit')
            }}</button>
        <button type="submit" class="btn btn-primary" onclick="setRedirect('show')">{{ __('messages.Save_Print')
            }}</button>


        <div class="col-md-6">
            <div class="form-group">
                <label for="date_journal">{{ __('messages.Date') }}</label>
                <input type="date" name="date_journal" class="form-control" required>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group">
                <label for="number">{{ __('messages.Number') }}</label>
                <input type="number" name="number" class="form-control" required>
            </div>
        </div>



        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="journal">{{ __('messages.journals') }}</label>
                <select name="journal" class="form-control" required>
                    @foreach ($journals as $journal)
                    <option value="{{ $journal->id }}">{{ $journal->name }}</option>
                    @endforeach
                </select>
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


        <div class="col-md-6">
            <div class="form-group">
                <label for="photo">{{ __('messages.photo') }}</label>
                <input type="file" name="photo" class="form-control">
            </div>
        </div>


        <br>
        <table class="table table-bordered" id="accounts_table">
            <thead>
                <tr>
                    <th>{{ __('messages.account') }}</th>
                    <th>{{ __('messages.costCenter') }}</th>
                    <th>{{ __('messages.depit') }}</th>
                    <th>{{ __('messages.credit') }}</th>
                    <th>{{ __('messages.note') }}</th>
                    <th>{{ __('messages.Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" class="form-control account-search" name="accounts[0][name]" /></td>
                    <td>
                        <select name="accounts[0][cost_center]" class="form-control">
                            <option value="">Select cost center</option>
                            @foreach ($cost_centers as $cost_center)
                                <option value="{{ $cost_center->id }}">{{ $cost_center->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" class="form-control depit" name="accounts[0][depit]" /></td>

                    <td><input type="number" class="form-control credit"
                            name="accounts[0][credit]" step="0.01" /></td>

                    <td><input type="text" class="form-control" name="accounts[0][note]" /></td>
                    <td><button type="button" class="btn btn-danger remove-row">{{ __('messages.Delete') }}</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-primary" id="add_row">{{ __('messages.Add_Row') }}</button>

        <!-- Summary Table -->
        <div class="mt-5">
            <h4>Summary</h4>
            <table class="table table-bordered" id="summary_table">
                <tbody>
                    <tr>
                        <td>{{ __('messages.credit') }}</td>
                        <td><span id="credit">0.00</span></td>
                    </tr>
                    <tr>
                        <td>{{ __('messages.depit') }}</td>
                        <td><span id="depit">0.00</span></td>
                    </tr>

                </tbody>
            </table>
        </div>
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
$('#accounts_table tbody').append(`
    <tr>
        <td><input type="text" class="form-control account-search" name="accounts[${rowIdx}][name]" /></td>
        <td>
         <select class="form-control account-cost_center" name="accounts[${rowIdx}][cost_center]">
                    <option value="">Select cost center</option>
                    @foreach ($cost_centers as $cost_center)
                        <option value="{{ $cost_center->id }}">{{ $cost_center->name }}</option>
                    @endforeach
         </select>
        </td>
        <td><input type="number" class="form-control depit" name="accounts[${rowIdx}][depit]" /></td>
        <td><input type="number" class="form-control credit" name="accounts[${rowIdx}][credit]" step="0.01" /></td>
        <td><input type="text" class="form-control" name="accounts[${rowIdx}][note]" /></td>
        <td><button type="button" class="btn btn-danger remove-row">{{ __('messages.Delete') }}</button></td>
    </tr>
    `);
    rowIdx++;
    initializeAccountSearch();
    });

    $(document).on('click', '.remove-row', function() {
    $(this).closest('tr').remove();
    updateSummary();
    });

function initializeAccountSearch() {
$('.account-search').autocomplete({
    source: function(request, response) {
        $.ajax({
            url: '{{ route("accounts.search") }}',
            dataType: 'json',
            data: {
                term: request.term
            },
            success: function(data) {
                if (data.length === 0) {
                    response([{ label: 'Not Found', value: '' }]);
                } else {
                    response($.map(data, function(item) {
                        return {
                            label: item.name,
                            value: item.name,
                            id: item.id,
                        };
                    }));
                }
            }
        });
    },
    minLength: 2,
    select: function(event, ui) {
        if (ui.item.value === '') {
            event.preventDefault();
        } else {
            const selectedRow = $(this).closest('tr');


            updateSummary();
        }
    }
});
}

    $(document).on('change', '.depit, .credit', function() {
    updateSummary();
    });

    function updateSummary() {
    let depitTotal = 0;
    let creditTotal = 0;


    $('#accounts_table tbody tr').each(function() {
        const depit = parseFloat($(this).find('.depit').val()) || 0;
        const credit = parseFloat($(this).find('.credit').val()) || 0;



        depitTotal += depit;
        creditTotal += credit;
    });

    $('#depit').text(depitTotal.toFixed(2));
    $('#credit').text(creditTotal.toFixed(2));

}
    initializeAccountSearch();
    });
    </script>
@endsection
