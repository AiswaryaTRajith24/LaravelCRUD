@extends('layout.admin_dashboard')

@section('title', 'Products')

@section('admincontent')
<div>
    <h1>Products List</h1>
    <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
            <tr>
                <th>SL No</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody id="productsTableBody">
            <!-- Data will be inserted here dynamically -->
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchProducts();
    });

    function fetchProducts() {
        const token = localStorage.getItem('authToken');
        if (!token) {
            console.error("No token found. User is not authenticated.");
            return;
        }
        $.ajax({
            url: '/api/getallproducts',
            type: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: function(products) {
                console.log(products);
                let tableBody = $("#productsTableBody");
                tableBody.empty();

                products.forEach((product, index) => {
                    let row = `<tr>
                        <td>${index + 1}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="${product.image}" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                                <div class="ms-3">
                                    <p class="fw-bold mb-1">${product.name}</p>
                                </div>
                            </div>
                        </td>
                        <td>${product.description}</td>
                        <td>${product.price}</td>
                        <td>${product.stock}</td>
                    </tr>`;
                    tableBody.append(row);
                });
            },
            error: function(error) {
                alert("Error fetching products");
            }
        });
    }
</script>
@endsection