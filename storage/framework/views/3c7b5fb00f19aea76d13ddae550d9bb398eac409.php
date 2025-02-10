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
    var tableBody = document.querySelector("#products_table tbody");

    searchInput.addEventListener('input', function () {
        var query = searchInput.value;

        if (query.length > 0) {
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
            var userId = e.target.getAttribute('data-value');
            var text = e.target.textContent;

            hiddenInput.value = userId;
            searchInput.value = text;
            resultsContainer.innerHTML = '';

            // Call AJAX to fetch bookings
            fetchUserBookings(userId);
        }
    });

    function fetchUserBookings(userId) {
        fetch('<?php echo e(route('getUserBookings', '')); ?>/' + userId)
            .then(response => response.json())
            .then(data => {
                tableBody.innerHTML = ''; // Clear previous entries

                if (data.booking.length > 0) {
                    data.booking.forEach((booking, index) => {
                     
                     if (booking.hotels.length > 0) {

                            booking.hotels.forEach((hotel) => {
                                
                                console.log(hotel);

                                tableBody.innerHTML += `
                                    <tr>
                                        <td><input type="text" class="form-control" name="products[${index}][name]" value="${hotels_service || 'N/A'}" /></td>
                                        <td><input type="number" class="form-control" name="products[${index}][quantity]" value="${hotel.selling_price}" /></td>
                                        <td><input type="text" class="form-control" name="products[${index}][selling_price_without_tax]" value="${hotel.from_date}" readonly /></td>
                                        <td><input type="text" class="form-control" name="products[${index}][selling_price_with_tax]" value="${hotel.to_date}" readonly /></td>
                                        <td><input type="number" class="form-control" name="products[${index}][discount_fixed]" value="" step="0.01" /></td>
                                        <td><input type="number" class="form-control" name="products[${index}][discount_percentage]" value="" step="0.01" /></td>
                                        <td><input type="text" class="form-control" name="products[${index}][note]" value="" /></td>
                                        <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
                                    </tr>
                                `;
                            });
                        }

                     if (booking.visas.length > 0) {

                            booking.visas.forEach((visa) => {
                                
                                tableBody.innerHTML += `
                                    <tr>
                                        <td><input type="text" class="form-control" name="products[${index}][name]" value="${visa_service || 'N/A'}" /></td>
                                        <td><input type="number" class="form-control" name="products[${index}][quantity]" value="${visa.selling_price}" /></td>
                                        <td><input type="text" class="form-control" name="products[${index}][selling_price_without_tax]" value="${visa.from_date}" readonly /></td>
                                        <td><input type="text" class="form-control" name="products[${index}][selling_price_with_tax]" value="${visa.to_date}" readonly /></td>
                                        <td><input type="number" class="form-control" name="products[${index}][discount_fixed]" value="" step="0.01" /></td>
                                        <td><input type="number" class="form-control" name="products[${index}][discount_percentage]" value="" step="0.01" /></td>
                                        <td><input type="text" class="form-control" name="products[${index}][note]" value="" /></td>
                                        <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
                                    </tr>
                                `;
                            });
                        }

                     if (booking.trips.length > 0) {

                            booking.trips.forEach((trip) => {
                                
                                tableBody.innerHTML += `
                                    <tr>
                                        <td><input type="text" class="form-control" name="products[${index}][name]" value="${trip_service || 'N/A'}" /></td>
                                        <td><input type="number" class="form-control" name="products[${index}][quantity]" value="${trip.selling_price}" /></td>
                                        <td><input type="text" class="form-control" name="products[${index}][selling_price_without_tax]" value="${trip.from_date}" readonly /></td>
                                        <td><input type="text" class="form-control" name="products[${index}][selling_price_with_tax]" value="${trip.to_date}" readonly /></td>
                                        <td><input type="number" class="form-control" name="products[${index}][discount_fixed]" value="" step="0.01" /></td>
                                        <td><input type="number" class="form-control" name="products[${index}][discount_percentage]" value="" step="0.01" /></td>
                                        <td><input type="text" class="form-control" name="products[${index}][note]" value="" /></td>
                                        <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
                                    </tr>
                                `;
                            });
                        }

                     if (booking.tickets.length > 0) {

                            booking.tickets.forEach((ticket) => {
                                
                                tableBody.innerHTML += `
                                    <tr>
                                        <td><input type="text" class="form-control" name="products[${index}][name]" value="${ticket_service || 'N/A'}" /></td>
                                        <td><input type="number" class="form-control" name="products[${index}][quantity]" value="${ticket.selling_price}" /></td>
                                        <td><input type="text" class="form-control" name="products[${index}][selling_price_without_tax]" value="${ticket.from_date}" readonly /></td>
                                        <td><input type="text" class="form-control" name="products[${index}][selling_price_with_tax]" value="${ticket.to_date}" readonly /></td>
                                        <td><input type="number" class="form-control" name="products[${index}][discount_fixed]" value="" step="0.01" /></td>
                                        <td><input type="number" class="form-control" name="products[${index}][discount_percentage]" value="" step="0.01" /></td>
                                        <td><input type="text" class="form-control" name="products[${index}][note]" value="" /></td>
                                        <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
                                    </tr>
                                `;
                            });
                        }

                     if (booking.transports.length > 0) {

                            booking.transports.forEach((transport) => {
                                
                                tableBody.innerHTML += `
                                    <tr>
                                        <td><input type="text" class="form-control" name="products[${index}][name]" value="${transport_service || 'N/A'}" /></td>
                                        <td><input type="number" class="form-control" name="products[${index}][quantity]" value="${transport.selling_price}" /></td>
                                        <td><input type="text" class="form-control" name="products[${index}][selling_price_without_tax]" value="${transport.from_date}" readonly /></td>
                                        <td><input type="text" class="form-control" name="products[${index}][selling_price_with_tax]" value="${transport.to_date}" readonly /></td>
                                        <td><input type="number" class="form-control" name="products[${index}][discount_fixed]" value="" step="0.01" /></td>
                                        <td><input type="number" class="form-control" name="products[${index}][discount_percentage]" value="" step="0.01" /></td>
                                        <td><input type="text" class="form-control" name="products[${index}][note]" value="" /></td>
                                        <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
                                    </tr>
                                `;
                            });
                        }

                    });
                } else {
                    tableBody.innerHTML = `<tr><td colspan="10" class="text-center">No bookings found</td></tr>`;
                }
            })
            .catch(error => console.error('Error fetching bookings:', error));
    }

    // Remove row event listener
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-row")) {
            e.target.closest("tr").remove();
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
<?php /**PATH D:\xampp8.1.6\htdocs\travel\resources\views/inputs/search_select.blade.php ENDPATH**/ ?>