@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Invoice</h2>
    <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="redirect_to" id="redirect_to" value="index">

        <button type="submit" class="btn btn-primary" onclick="setRedirect('index')">{{ __('messages.Update') }}</button>
        <button type="submit" class="btn btn-primary" onclick="setRedirect('show')">{{ __('messages.Update_Print') }}</button>

        <input type="hidden" name="invoice_type_id" value="{{ $invoice->invoice_type_id }}" class="form-control" required>

        <div class="col-md-6">
            <div class="form-group">
                <label for="date_invoice">{{ __('messages.Date') }}</label>
                <input type="date" name="date_invoice" class="form-control" value="{{ $invoice->date_invoice }}" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="number">{{ __('messages.Number') }}</label>
                <input type="number" name="number" class="form-control" value="{{ $invoice->number }}" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="warehouse">{{ __('messages.Warehouse') }}</label>
                <select name="warehouse" class="form-control" required>
                    @foreach ($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}" {{ $invoice->warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="cost_center">{{ __('messages.costCenter') }}</label>
                <select name="cost_center" class="form-control" required>
                    @foreach ($cost_centers as $cost_center)
                    <option value="{{ $cost_center->id }}" {{ $invoice->cost_center_id == $cost_center->id ? 'selected' : '' }}>{{ $cost_center->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="currency">{{ __('messages.currency_id') }}</label>
                <select name="currency" class="form-control" required>
                    @foreach ($currencies as $currency)
                    <option value="{{ $currency->id }}" {{ $invoice->currency_id == $currency->id ? 'selected' : '' }}>{{ $currency->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="branch">{{ __('messages.branch') }}</label>
                <select name="branch" class="form-control" required>
                    @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ $invoice->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="payment_type">{{ __('messages.payment_type') }}</label>
                <select name="payment_type" class="form-control" required>
                    <option value="1" {{ $invoice->payment_type == 1 ? 'selected' : '' }}>{{ __('messages.Cash') }}</option>
                    <option value="2" {{ $invoice->payment_type == 2 ? 'selected' : '' }}>{{ __('messages.Receivables') }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="tax_status">{{ __('messages.tax_status') }}</label>
                <select name="tax_status" class="form-control" required>
                    <option value="1" {{ $invoice->tax_status == 1 ? 'selected' : '' }}>{{ __('messages.Taxable') }}</option>
                    <option value="2" {{ $invoice->tax_status == 2 ? 'selected' : '' }}>{{ __('messages.Non_Taxable') }}</option>
                    <option value="3" {{ $invoice->tax_status == 3 ? 'selected' : '' }}>{{ __('messages.Zero_Tax') }}</option>
                    <option value="4" {{ $invoice->tax_status == 4 ? 'selected' : '' }}>{{ __('messages.Trans') }}</option>
                    <option value="5" {{ $invoice->tax_status == 5 ? 'selected' : '' }}>{{ __('messages.Not_Registered') }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="customer">{{ __('messages.customer') }}</label>
                @include('inputs.search_select', [
                'name' => 'user',
                'value' => $invoice->user->name,
                'required' => null,
                ])
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="account">{{ __('messages.account') }}</label>
                @include('inputs.search_select2', [
                'name' => 'account',
                'value' => $invoice->account->name,
                'required' => null,
                ])
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="collected">{{ __('messages.collected') }}</label>
                <input type="number" name="collected" class="form-control" value="{{ $invoice->collected }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="in_date_currency_rate">{{ __('messages.in_date_currency_rate') }}</label>
                <input type="number" name="in_date_currency_rate" class="form-control" value="{{ $invoice->in_date_currency_rate }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="note">{{ __('messages.note') }}</label>
                <textarea name="note" class="form-control">{{ $invoice->note }}</textarea>
            </div>
        </div>

        <br>
        <table class="table table-bordered" id="products_table">
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
                    <th>{{ __('messages.Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->invoiceProducts as $index => $invoiceProduct)
                <tr>
                    <td><input type="text" class="form-control product-search" name="products[{{ $index }}][name]" value="{{ $invoiceProduct->name }}" /></td>
                    <td>
                        <select class="form-control product-unit" name="products[{{ $index }}][unit]">
                            @foreach ($invoiceProduct->units as $unit)
                            <option value="{{ $unit->id }}" {{ $invoiceProduct->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" class="form-control quantity" name="products[{{ $index }}][quantity]" value="{{ $invoiceProduct->quantity }}" /></td>
                    <td><input type="number" class="form-control selling_price_without_tax" name="products[{{ $index }}][selling_price_without_tax]" value="{{ $invoiceProduct->selling_price_without_tax }}" step="0.01" /></td>
                    <td><input type="number" class="form-control selling_price_with_tax" name="products[{{ $index }}][selling_price_with_tax]" value="{{ $invoiceProduct->selling_price_with_tax }}" step="0.01" /></td>
                    <td><input type="number" class="form-control tax" name="products[{{ $index }}][tax]" value="{{ $invoiceProduct->tax }}" step="0.01" /></td>
                    <td><input type="number" class="form-control discount_fixed" name="products[{{ $index }}][discount_fixed]" value="{{ $invoiceProduct->discount_fixed }}" step="0.01" /></td>
                    <td><input type="number" class="form-control discount_percentage" name="products[{{ $index }}][discount_percentage]" value="{{ $invoiceProduct->discount_percentage }}" step="0.01" /></td>
                    <td><input type="text" class="form-control" name="products[{{ $index }}][note]" value="{{ $invoiceProduct->note }}" /></td>
                    <td><button type="button" class="btn btn-danger remove-row">{{ __('messages.Delete') }}</button></td>
                </tr>
                @endforeach
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

    $(document).ready(function() {
        let rowIdx = {{ $invoice->invoiceProducts->count() }};

        $('#add_row').on('click', function() {
            $('#products_table tbody').append(`
                <tr>
                    <td><input type="text" class="form-control product-search" name="products[${rowIdx}][name]" /></td>
                    <td>
                        <select class="form-control product-unit" name="products[${rowIdx}][unit]">
                            <option value="">Select Unit</option>
                        </select>
                    </td>
                    <td><input type="number" class="form-control quantity" name="products[${rowIdx}][quantity]" /></td>
                    <td><input type="number" class="form-control selling_price_without_tax" name="products[${rowIdx}][selling_price_without_tax]" step="0.01" /></td>
                    <td><input type="number" class="form-control selling_price_with_tax" name="products[${rowIdx}][selling_price_with_tax]" step="0.01" /></td>
                    <td><input type="number" class="form-control tax" name="products[${rowIdx}][tax]" step="0.01" /></td>
                    <td><input type="number" class="form-control discount_fixed" name="products[${rowIdx}][discount_fixed]" step="0.01" /></td>
                    <td><input type="number" class="form-control discount_percentage" name="products[${rowIdx}][discount_percentage]" step="0.01" /></td>
                    <td><input type="text" class="form-control" name="products[${rowIdx}][note]" /></td>
                    <td><button type="button" class="btn btn-danger remove-row">{{ __('messages.Delete') }}</button></td>
                </tr>
            `);
            rowIdx++;
            initializeProductSearch();
        });

        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            updateSummary();
        });

        function initializeProductSearch() {
            $('.product-search').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: '{{ route("products.search") }}',
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
                                        units: item.units,
                                        unit: item.unit,
                                        id: item.id,
                                        tax: item.tax,
                                        selling_price: item.selling_price
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
                        const unitDropdown = selectedRow.find('.product-unit');
                        unitDropdown.empty();

                        if (ui.item.unit) {
                            unitDropdown.append(`<option value="${ui.item.unit.id}">${ui.item.unit.name}</option>`);
                        }

                        if (ui.item.units) {
                            $.each(ui.item.units, function(index, unit) {
                                unitDropdown.append(`<option value="${unit.id}">${unit.name}</option>`);
                            });
                        }

                        const sellingPriceWithTax = ui.item.selling_price;
                        const taxPercentage = ui.item.tax;
                        const sellingPriceWithoutTax = sellingPriceWithTax / (1 + taxPercentage / 100);

                        selectedRow.find('.selling_price_without_tax').val(sellingPriceWithoutTax.toFixed(2));
                        selectedRow.find('.tax').val(taxPercentage);
                        selectedRow.find('.selling_price_with_tax').val(sellingPriceWithTax.toFixed(2));

                        updateSummary();
                    }
                }
            });
        }

        $(document).on('change', '.quantity, .selling_price_with_tax, .selling_price_without_tax, .tax, .discount_fixed, .discount_percentage', function() {
            updateSummary();
        });

        function updateSummary() {
            let totalSellingPrice = 0;
            let totalTax = 0;
            let totalDiscount = 0;
            let totalAmount = 0;

            $('#products_table tbody tr').each(function() {
                const quantity = parseFloat($(this).find('.quantity').val()) || 0;
                const sellingPriceWithoutTax = parseFloat($(this).find('.selling_price_without_tax').val()) || 0;
                const taxPercentage = parseFloat($(this).find('.tax').val()) || 0;
                const discountFixed = parseFloat($(this).find('.discount_fixed').val()) || 0;
                const discountPercentage = parseFloat($(this).find('.discount_percentage').val()) || 0;

                const itemSellingPrice = sellingPriceWithoutTax * quantity;
                const itemTax = (sellingPriceWithoutTax * taxPercentage / 100) * quantity;
                const itemDiscount = discountFixed + (itemSellingPrice * discountPercentage / 100);

                totalSellingPrice += itemSellingPrice;
                totalTax += itemTax;
                totalDiscount += itemDiscount;
                totalAmount += (itemSellingPrice + itemTax - itemDiscount);
            });

            $('#total_selling_price').text(totalSellingPrice.toFixed(2));
            $('#total_tax').text(totalTax.toFixed(2));
            $('#total_discount').text(totalDiscount.toFixed(2));
            $('#total_amount').text(totalAmount.toFixed(2));
        }

        initializeProductSearch();
        updateSummary();
    });
</script>
@endsection
