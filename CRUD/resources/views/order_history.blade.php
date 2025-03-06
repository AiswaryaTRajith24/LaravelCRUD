@extends('layout.user_dashboard')

@section('title', 'order history')

@section('content')
<div class="container mt-5">
    <h2>Order History</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Invoice ID</th>
                <th>Products</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Grand Total</th>
                <th>Invoice Date</th>
            </tr>
        </thead>
        <tbody id="orderTableBody">
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const userId = localStorage.getItem("userId");
        fetchOrders(userId);
    });

    function fetchOrders(userId) {

        const token = localStorage.getItem('authToken');
        if (!token) {
            console.error("No token found. User is not authenticated.");
            return;
        }
        $.ajax({
            url: `/api/ordershistory/${userId}`,
            headers: {
                "Authorization": `Bearer ${token}`,
                "Accept": "application/json"
            },
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if (data.success) {
                    populateOrderTable(data.data);
                } else {
                    console.error("Error fetching orders:", data);
                    alert("Error fetching orders.");
                }
            },
            error: function(error) {
                console.error("Error fetching orders:", error);
                alert("Error fetching orders.");
            }
        });
    }

    function populateOrderTable(orders) {
        const tableBody = document.getElementById("orderTableBody");
        tableBody.innerHTML = ""; // Clear existing rows

        orders.forEach(order => {
            const row = document.createElement("tr");

            const invoiceIdCell = document.createElement("td");
            invoiceIdCell.textContent = order.invoice.order_id;
            row.appendChild(invoiceIdCell);

            const productsCell = document.createElement("td");
            const productList = document.createElement("ul");
            order.order_items.forEach(item => {
                const productItem = document.createElement("li");
                productItem.textContent = `${item.product.name}`;
                productList.appendChild(productItem);
            });
            productsCell.appendChild(productList);
            row.appendChild(productsCell);

            const quantityCell = document.createElement("td");
            const quantityList = document.createElement("ul");
            order.order_items.forEach(item => {
                const quantityItem = document.createElement("li");
                quantityItem.textContent = `${item.count}`;
                quantityList.appendChild(quantityItem);
            });
            quantityCell.appendChild(quantityList);
            row.appendChild(quantityCell);

            const unitPriceCell = document.createElement("td");
            const unitPriceList = document.createElement("ul");
            order.order_items.forEach(item => {
                const unitPriceItem = document.createElement("li");
                unitPriceItem.textContent = `$${item.product.price}`;
                unitPriceList.appendChild(unitPriceItem);
            });
            unitPriceCell.appendChild(unitPriceList);
            row.appendChild(unitPriceCell);

            const grandTotalCell = document.createElement("td");
            grandTotalCell.textContent = `$${order.grand_total}`;
            row.appendChild(grandTotalCell);

            const invoiceDateCell = document.createElement("td");
            invoiceDateCell.textContent = new Date(order.invoice.created_at).toLocaleDateString();
            row.appendChild(invoiceDateCell);

            tableBody.appendChild(row);
        });
    }
</script>
@endsection