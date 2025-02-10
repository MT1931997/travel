@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Create Invoice</h2>
    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf

        <input type="hidden" name="redirect_to" id="redirect_to" value="index">

        <button type="submit" class="btn btn-primary" onclick="setRedirect('index')">{{ __('messages.Submit')
            }}</button>
        <button type="submit" class="btn btn-primary" onclick="setRedirect('show')">{{ __('messages.Save_Print')
            }}</button>

        <input type="hidden" name="invoice_type_id" value="{{ $invoice_type_id }}" class="form-control" required>

        <div class="col-md-6">
            <div class="form-group">
                <label for="date_invoice">{{ __('messages.Date') }}</label>
                <input type="date" name="date_invoice" class="form-control" required>
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
                <label for="cost_center">{{ __('messages.costCenter') }}</label>
                <select name="cost_center" class="form-control" required>
                    @foreach ($cost_centers as $cost_center)
                    <option value="{{ $cost_center->id }}">{{ $cost_center->name }}</option>
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
            <div class="form-group mt-3">
                <label for="payment_type">{{ __('messages.payment_type') }}</label>
                <select name="payment_type" class="form-control" required>
                    <option value="1">{{ __('messages.Cash') }}</option>
                    <option value="2">{{ __('messages.Receivables') }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="tax_status">{{ __('messages.tax_status') }}</label>
                <select name="tax_status" class="form-control" required>
                    <option value="1">{{ __('messages.Taxable') }}</option>
                    <option value="2">{{ __('messages.Non_Taxable') }}</option>
                    <option value="3">{{ __('messages.Zero_Tax') }}</option>
                    <option value="4">{{ __('messages.Trans') }}</option>
                    <option value="5">{{ __('messages.Not_Registered') }}</option>
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
                <label for="collected">{{ __('messages.collected') }}</label>
                <input type="collected" name="collected" class="form-control">
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





        <br>
        <table class="table table-bordered" id="products_table">
            <thead>
                <tr>
                    <th>{{ __('messages.Service') }}</th>
                    <th>{{ __('messages.Price') }}</th>
                    <th>{{ __('messages.From Date') }}</th>
                    <th>{{ __('messages.To Date') }}</th>
                    <!--<th>{{ __('messages.selling_price_without_tax') }}</th>
                    <th>{{ __('messages.selling_price_with_tax') }}</th>
                    <th>{{ __('messages.tax') }}</th>
                    <th>{{ __('messages.discount_fixed') }}</th>-->
                    <th>{{ __('messages.discount_percentage') }}</th>
                    <th>{{ __('messages.note') }}</th>
                    <th>{{ __('messages.Actions') }}</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        <button type="button" class="btn btn-primary" id="add_row">{{ __('messages.Add_Row') }}</button>

        <!-- Summary Table -->
        <div class="mt-5">
            <h4>Summary</h4>
            <table class="table table-bordered" id="summary_table">
                <tbody>
                    <tr>
                        <td>{{ __('messages.total_selling_price') }}</td>
                        <td><span id="total_selling_price">0.00</span></td>
                    </tr>
                    <tr>
                        <td>{{ __('messages.total_tax') }}</td>
                        <td><span id="total_tax">0.00</span></td>
                    </tr>
                    <tr>
                        <td>{{ __('messages.total_discount') }}</td>
                        <td><span id="total_discount">0.00</span></td>
                    </tr>
                    <tr>
                        <td>{{ __('messages.total_amount') }}</td>
                        <td><span id="total_amount">0.00</span></td>
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
</script>


@endsection
