<div class="form-group" style="position: relative;">
    <input type="text" class="form-control" id="<?php echo e($name); ?>_search" name="<?php echo e($name); ?>_search" autocomplete="off" value="<?php echo e($value ?? ''); ?>">
    <div id="<?php echo e($name); ?>_search_results" class="search-results"></div>
    <input type="hidden" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>">
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var searchInput = document.getElementById('<?php echo e($name); ?>_search');
        var resultsContainer = document.getElementById('<?php echo e($name); ?>_search_results');
        var hiddenInput = document.getElementById('<?php echo e($name); ?>');

        searchInput.addEventListener('input', function () {
            var query = searchInput.value;

            if (query.length > 1) {
                fetch('<?php echo e(route('search')); ?>?query=' + query + '&model=<?php echo e(addslashes($model_search_select)); ?>')
                    .then(response => response.text())
                    .then(data => {
                        resultsContainer.innerHTML = data;
                    });
            } else {
                resultsContainer.innerHTML = '';
            }
        });

        resultsContainer.addEventListener('click', function (e) {
            if (e.target && e.target.matches('.search-item:not(.not-found)')) {
                var value = e.target.getAttribute('data-value');
                var text = e.target.textContent;
                hiddenInput.value = value;
                searchInput.value = text;
                resultsContainer.innerHTML = '';
            }
        });
    });
</script>

<style>
.search-results {
    border: 1px solid #ddd;
    border-top: none;
    max-height: 200px;
    overflow-y: auto;
    background-color: #fff;
    position: absolute;
    width: 100%;
    z-index: 1000;
}

.search-item {
    padding: 10px;
    cursor: pointer;
}

.search-item:hover {
    background-color: #f1f1f1;
}

.search-item.not-found {
    color: #999;
    cursor: default;
}
</style>
<?php /**PATH C:\xampp\htdocs\travel\resources\views/inputs/search_select.blade.php ENDPATH**/ ?>