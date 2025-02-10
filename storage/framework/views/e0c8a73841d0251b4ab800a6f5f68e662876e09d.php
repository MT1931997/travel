<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Create Journal Entry</h2>
    <form action="<?php echo e(route('journalEntries.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="redirect_to" id="redirect_to" value="index">

        <button type="submit" class="btn btn-primary" onclick="setRedirect('index')"><?php echo e(__('messages.Submit')); ?></button>
        <button type="submit" class="btn btn-primary" onclick="setRedirect('show')"><?php echo e(__('messages.Save_Print')); ?></button>


        <div class="col-md-6">
            <div class="form-group">
                <label for="date_journal"><?php echo e(__('messages.Date')); ?></label>
                <input type="date" name="date_journal" class="form-control" required>
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
                <label for="journal"><?php echo e(__('messages.journals')); ?></label>
                <select name="journal" class="form-control" required>
                    <?php $__currentLoopData = $journals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($journal->id); ?>"><?php echo e($journal->name); ?></option>
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


        <div class="col-md-6">
            <div class="form-group">
                <label for="photo"><?php echo e(__('messages.photo')); ?></label>
                <input type="file" name="photo" class="form-control">
            </div>
        </div>


        <br>
        <table class="table table-bordered" id="accounts_table">
            <thead>
                <tr>
                    <th><?php echo e(__('messages.account')); ?></th>
                    <th><?php echo e(__('messages.costCenter')); ?></th>
                    <th><?php echo e(__('messages.depit')); ?></th>
                    <th><?php echo e(__('messages.credit')); ?></th>
                    <th><?php echo e(__('messages.note')); ?></th>
                    <th><?php echo e(__('messages.Actions')); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" class="form-control account-search" name="accounts[0][name]" /></td>
                    <td>
                        <select name="accounts[0][cost_center]" class="form-control">
                            <option value="">Select cost center</option>
                            <?php $__currentLoopData = $cost_centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cost_center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cost_center->id); ?>"><?php echo e($cost_center->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td><input type="number" class="form-control depit" name="accounts[0][depit]" /></td>

                    <td><input type="number" class="form-control credit"
                            name="accounts[0][credit]" step="0.01" /></td>

                    <td><input type="text" class="form-control" name="accounts[0][note]" /></td>
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
                        <td><?php echo e(__('messages.credit')); ?></td>
                        <td><span id="credit">0.00</span></td>
                    </tr>
                    <tr>
                        <td><?php echo e(__('messages.depit')); ?></td>
                        <td><span id="depit">0.00</span></td>
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

$(document).ready(function() {
let rowIdx = 1;

$('#add_row').on('click', function() {
$('#accounts_table tbody').append(`
    <tr>
        <td><input type="text" class="form-control account-search" name="accounts[${rowIdx}][name]" /></td>
        <td>
         <select class="form-control account-cost_center" name="accounts[${rowIdx}][cost_center]">
                    <option value="">Select cost center</option>
                    <?php $__currentLoopData = $cost_centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cost_center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cost_center->id); ?>"><?php echo e($cost_center->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </select>
        </td>
        <td><input type="number" class="form-control depit" name="accounts[${rowIdx}][depit]" /></td>
        <td><input type="number" class="form-control credit" name="accounts[${rowIdx}][credit]" step="0.01" /></td>
        <td><input type="text" class="form-control" name="accounts[${rowIdx}][note]" /></td>
        <td><button type="button" class="btn btn-danger remove-row"><?php echo e(__('messages.Delete')); ?></button></td>
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
            url: '<?php echo e(route("accounts.search")); ?>',
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\travel\resources\views/custom_pages/journal_entries/create.blade.php ENDPATH**/ ?>