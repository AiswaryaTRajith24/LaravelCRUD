@extends('layout.admin_dashboard')

@section('title', 'View all orders')

@section('admincontent')
<div class="container mt-5">
    <h2>Order History</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Invoice ID</th>
                <th>User Name</th>
                <th>Products</th>
                <th>Unit Price</th>
                <th>Grand Total</th>
                <th>Invoice Date</th>
            </tr>
        </thead>
        <tbody id="orderTableBody">
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchOrderHistoryForAdmin();
    });

    function fetchOrderHistoryForAdmin() {
        const token = localStorage.getItem('authToken');
        if (!token) {
            console.error("No token found. User is not authenticated.");
            return;
        }
        $(document).ready(function() {
            $.ajax({
                url: '/api/getordersforadmin',
                type: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                success: function(response) {
                    if (response.success) {
                        populateTable(response.data);
                    } else {
                        alert('Failed to fetch orders: ' + response.message);
                    }
                },
                error: function(error) {
                    console.error('Error fetching orders:', error);
                    alert('Error fetching orders.');
                }
            });

            function populateTable(orders) {
                const tableBody = $('#orderTableBody');
                tableBody.empty();

                orders.forEach(order => {
                    const row = $('<tr>');
                    row.append($('<td>').text(order.invoice.order_id));
                    row.append($('<td>').text(order.user.name));

                    let productsHtml = '<ul>';
                    order.order_items.forEach(item => {
                        productsHtml += `<li>${item.product.name} (Qty: ${item.count})</li>`;
                    });
                    productsHtml += '</ul>';
                    row.append($('<td>').html(productsHtml));

                    let unitPriceHtml = '<ul>';
                    order.order_items.forEach(item => {
                        unitPriceHtml += `<li>$${item.product.price}</li>`;
                    });
                    unitPriceHtml += '</ul>';
                    row.append($('<td>').html(unitPriceHtml));

                    row.append($('<td>').text('$' + order.grand_total));
                    row.append($('<td>').text(new Date(order.invoice.created_at).toLocaleDateString()));

                    tableBody.append(row);
                });
            }
        });
    }
</script>
@endsection