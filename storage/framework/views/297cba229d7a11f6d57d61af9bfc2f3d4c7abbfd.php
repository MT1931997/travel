<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Create Invoice</h2>
    <form action="<?php echo e(route('invoices.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="redirect_to" id="redirect_to" value="index">

        <button type="submit" class="btn btn-primary" onclick="setRedirect('index')"><?php echo e(__('messages.Submit')); ?></button>
        <button type="submit" class="btn btn-primary" onclick="setRedirect('show')"><?php echo e(__('messages.Save_Print')); ?></button>

        <input type="hidden" name="invoice_type_id" value="<?php echo e($invoice_type_id); ?>" class="form-control" required>

        <div class="col-md-6">
            <div class="form-group">
                <label for="date_invoice"><?php echo e(__('messages.Date')); ?></label>
                <input type="date" name="date_invoice" class="form-control" required>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group">
                <label for="number"><?php echo e(__('messages.Number')); ?></label>
                <input type="number" name="number" class="form-control" required>
            </div>
        </div>



        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="cost_center"><?php echo e(__('messages.costCenter')); ?></label>
                <select name="cost_center" class="form-control" required>
                    <?php $__currentLoopData = $cost_centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cost_center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cost_center->id); ?>"><?php echo e($cost_center->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="currency"><?php echo e(__('messages.currency_id')); ?></label>
                <select name="currency" class="form-control" required>
                    <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($currency->id); ?>"><?php echo e($currency->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="branch"><?php echo e(__('messages.branch')); ?></label>
                <select name="branch" class="form-control" required>
                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="payment_type"><?php echo e(__('messages.payment_type')); ?></label>
                <select name="payment_type" class="form-control" required>
                    <option value="1"><?php echo e(__('messages.Cash')); ?></option>
                    <option value="2"><?php echo e(__('messages.Receivables')); ?></option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="tax_status"><?php echo e(__('messages.tax_status')); ?></label>
                <select name="tax_status" class="form-control" required>
                    <option value="1"><?php echo e(__('messages.Taxable')); ?></option>
                    <option value="2"><?php echo e(__('messages.Non_Taxable')); ?></option>
                    <option value="3"><?php echo e(__('messages.Zero_Tax')); ?></option>
                    <option value="4"><?php echo e(__('messages.Trans')); ?></option>
                    <option value="5"><?php echo e(__('messages.Not_Registered')); ?></option>
                </select>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="customer"><?php echo e(__('messages.customer')); ?></label>
                <?php echo $__env->make('inputs.search_select', [
                'name' => 'user',
                'required' => null,
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="account"><?php echo e(__('messages.account')); ?></label>
                <?php echo $__env->make('inputs.search_select2', [
                'name' => 'account',
                'required' => null,
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group">
                <label for="collected"><?php echo e(__('messages.collected')); ?></label>
                <input type="collected" name="collected" class="form-control">
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group">
                <label for="in_date_currency_rate"><?php echo e(__('messages.in_date_currency_rate')); ?></label>
                <input type="in_date_currency_rate" name="in_date_currency_rate" class="form-control">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="note"><?php echo e(__('messages.note')); ?></label>
                <textarea name="note" class="form-control"></textarea>
            </div>
        </div>





        <br>
        <table class="table table-bordered" id="products_table">
            <thead>
                <tr>
                    <th><?php echo e(__('messages.product')); ?></th>
                    <th><?php echo e(__('messages.unit')); ?></th>
                    <th><?php echo e(__('messages.quantity')); ?></th>
                    <th><?php echo e(__('messages.selling_price_without_tax')); ?></th>
                    <th><?php echo e(__('messages.selling_price_with_tax')); ?></th>
                    <th><?php echo e(__('messages.tax')); ?></th>
                    <th><?php echo e(__('messages.discount_fixed')); ?></th>
                    <th><?php echo e(__('messages.discount_percentage')); ?></th>
                    <th><?php echo e(__('messages.note')); ?></th>
                    <th><?php echo e(__('messages.Actions')); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" class="form-control product-search" name="products[0][name]" /></td>
                    <td>
                        <select class="form-control product-unit" name="products[0][unit]">
                            <option value="">Select Unit</option>
                        </select>
                    </td>
                    <td><input type="number" class="form-control quantity" name="products[0][quantity]" /></td>
                    <td><input type="number" class="form-control selling_price_without_tax"
                            name="products[0][selling_price_without_tax]" step="0.01" /></td>

                    <td><input type="number" class="form-control selling_price_with_tax"
                            name="products[0][selling_price_with_tax]" step="0.01" /></td>
                    <td><input type="number" class="form-control tax" name="products[0][tax]" step="0.01"/></td>
                    <td><input type="number" class="form-control discount_fixed" name="products[0][discount_fixed]" step="0.01" />
                    </td>
                    <td><input type="number" class="form-control discount_percentage"
                            name="products[0][discount_percentage]" step="0.01" /></td>
                    <td><input type="text" class="form-control" name="products[0][note]" /></td>
                    <td><button type="button" class="btn btn-danger remove-row"><?php echo e(__('messages.Delete')); ?></button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-primary" id="add_row"><?php echo e(__('messages.Add_Row')); ?></button>

        <!-- Summary Table -->
        <div class="mt-5">
            <h4>Summary</h4>
            <table class="table table-bordered" id="summary_table">
                <tbody>
                    <tr>
                        <td><?php echo e(__('messages.total_selling_price')); ?></td>
                        <td><span id="total_selling_price">0.00</span></td>
                    </tr>
                    <tr>
                        <td><?php echo e(__('messages.total_tax')); ?></td>
                        <td><span id="total_tax">0.00</span></td>
                    </tr>
                    <tr>
                        <td><?php echo e(__('messages.total_discount')); ?></td>
                        <td><span id="total_discount">0.00</span></td>
                    </tr>
                    <tr>
                        <td><?php echo e(__('messages.total_amount')); ?></td>
                        <td><span id="total_amount">0.00</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript">
    function setRedirect(value) {
document.getElementById('redirect_to').value = value;
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\travel\resources\views/custom_pages/invoices/create.blade.php ENDPATH**/ ?>