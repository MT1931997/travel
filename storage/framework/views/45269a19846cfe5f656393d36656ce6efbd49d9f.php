<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Create Journal Entry Cheque</h2>
    <form action="<?php echo e(route('journalEntryCheques.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="redirect_to" id="redirect_to" value="index">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" onclick="setRedirect('index')"><?php echo e(__('messages.Submit')); ?></button>
                    <button type="submit" class="btn btn-primary" onclick="setRedirect('show')"><?php echo e(__('messages.Save_Print')); ?></button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date_journal_entry_cheque"><?php echo e(__('messages.Date')); ?></label>
                    <input type="date" name="date_journal_entry_cheque" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="number"><?php echo e(__('messages.Number')); ?></label>
                    <input type="number" name="number" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="row">
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
        </div>

        <div class="row">
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
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="checkPortfolio"><?php echo e(__('messages.checkPortfolios')); ?></label>
                    <select name="checkPortfolio" class="form-control" required>
                        <?php $__currentLoopData = $checkPortfolios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checkPortfolio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($checkPortfolio->id); ?>"><?php echo e($checkPortfolio->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="journal_entry_type"><?php echo e(__('messages.journal_entry_type')); ?></label>
                    <select name="journal_entry_type" class="form-control" required>
                        <option value="1"><?php echo e(__('messages.Pay')); ?></option>
                        <option value="2"><?php echo e(__('messages.Receive')); ?></option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="cheque_collection_type"><?php echo e(__('messages.cheque_collection_type')); ?></label>
                    <select name="cheque_collection_type" class="form-control" required>
                        <option value="1"><?php echo e(__('messages.Portfolio')); ?></option>
                        <option value="2"><?php echo e(__('messages.Cash')); ?></option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="customer"><?php echo e(__('messages.customer')); ?></label>
                    <?php echo $__env->make('inputs.search_select', [
                        'name' => 'user',
                        'required' => null,
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="account"><?php echo e(__('messages.cash_check_account')); ?></label>
                    <?php echo $__env->make('inputs.search_select2', [
                        'name' => 'account',
                        'required' => null,
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>

        <br>
        <table class="table table-bordered" id="products_table">
            <thead>
                <tr>
                    <th><?php echo e(__('messages.Number')); ?></th>
                    <th><?php echo e(__('messages.amount')); ?></th>
                    <th><?php echo e(__('messages.date_collection')); ?></th>
                    <th><?php echo e(__('messages.cheque_collection_type')); ?></th>
                    <th><?php echo e(__('messages.bank_name')); ?></th>
                    <th><?php echo e(__('messages.bank_branch')); ?></th>
                    <th><?php echo e(__('messages.costCenter')); ?></th>
                    <th><?php echo e(__('messages.note')); ?></th>
                    <th><?php echo e(__('messages.Actions')); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" class="form-control number" name="cheques[0][number]" /></td>
                    <td><input type="amount" class="form-control amount" name="cheques[0][amount]" /></td>
                    <td><input type="date" class="form-control date_collection" name="cheques[0][date_collection]" /></td>
                    <td>
                        <select class="form-control cheque_collection_type" name="cheques[0][cheque_collection_type]">
                            <option value="1"><?php echo e(__('messages.Co')); ?></option>
                            <option value="2"><?php echo e(__('messages.Mujir')); ?></option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control bank_name" name="cheques[0][bank_name]" /></td>
                    <td><input type="text" class="form-control bank_branch" name="cheques[0][bank_branch]" /></td>
                    <td>
                        <select name="cheques[0][costCenter]" class="form-control costCenter">
                            <?php $__currentLoopData = $costCenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costCenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($costCenter->id); ?>"><?php echo e($costCenter->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="cheques[0][note]" /></td>
                    <td><button type="button" class="btn btn-danger remove-row"><?php echo e(__('messages.Delete')); ?></button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-primary" id="add_row"><?php echo e(__('messages.Add_Row')); ?></button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
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
                            <option value="1"><?php echo e(__('messages.Co')); ?></option>
                            <option value="2"><?php echo e(__('messages.Mujir')); ?></option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control bank_name" name="cheques[${rowIdx}][bank_name]" /></td>
                    <td><input type="text" class="form-control bank_branch" name="cheques[${rowIdx}][bank_branch]" /></td>
                    <td>
                        <select name="cheques[${rowIdx}][costCenter]" class="form-control costCenter">
                            <?php $__currentLoopData = $costCenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costCenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($costCenter->id); ?>"><?php echo e($costCenter->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="cheques[${rowIdx}][note]" /></td>
                    <td><button type="button" class="btn btn-danger remove-row"><?php echo e(__('messages.Delete')); ?></button></td>
                </tr>
            `);
            rowIdx++;
        });

        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\travel\resources\views/custom_pages/journalEntryCheques/create.blade.php ENDPATH**/ ?>