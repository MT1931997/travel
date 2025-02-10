<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Create Invoice</h2>

    <!-- Tabs for Pay and Receive -->
    <ul class="nav nav-tabs" id="payReceiveTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="pay-tab" data-bs-toggle="tab" href="#pay" role="tab" aria-controls="pay" aria-selected="true"><?php echo e(__('messages.Pay')); ?></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="receive-tab" data-bs-toggle="tab" href="#receive" role="tab" aria-controls="receive" aria-selected="false"><?php echo e(__('messages.Receive')); ?></a>
        </li>
    </ul>
    <div class="tab-content" id="payReceiveTabsContent">
        <div class="tab-pane fade show active" id="pay" role="tabpanel" aria-labelledby="pay-tab"></div>
        <div class="tab-pane fade" id="receive" role="tabpanel" aria-labelledby="receive-tab"></div>
    </div>

    <form action="<?php echo e(route('payReceives.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="redirect_to" id="redirect_to" value="index">
        <input type="hidden" name="journal_id" id="journal_id" value="3">
        <input type="hidden" name="type" id="type" value="1">

        <button type="submit" class="btn btn-primary" onclick="setRedirect('index')"><?php echo e(__('messages.Submit')); ?></button>
        <button type="submit" class="btn btn-primary" onclick="setRedirect('show')"><?php echo e(__('messages.Save_Print')); ?></button>

        <div class="col-md-6">
            <div class="form-group">
                <label for="date_pay_receive"><?php echo e(__('messages.Date')); ?></label>
                <input type="date" name="date_pay_receive" class="form-control" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="number"><?php echo e(__('messages.Number')); ?></label>
                <input type="number" name="number" class="form-control" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="amount"><?php echo e(__('messages.amount')); ?></label>
                <input type="amount" name="amount" class="form-control">
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
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\travel\resources\views/custom_pages/payReceives/create.blade.php ENDPATH**/ ?>