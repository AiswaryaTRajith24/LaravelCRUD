@extends('layout.admin_dashboard')

@section('title', 'Manage products')

@section('admincontent')

<div>
    <h1>Manage Products</h1>
    <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
            <tr>
                <th>SL No</th>
                <th>Name</th>
                <th>Image</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="productTableBody">
            <!-- Data will be inserted here dynamically -->
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
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
                console.log("AAAAAAa", products);
                let tableBody = $("#productTableBody");
                tableBody.empty();

                products.forEach((product, index) => {
                    let row = `<tr data-id="${product.id}">
                        <td>${index + 1}</td>
                        <td>
                            <span class="text">${product.name}</span>
                            <input type="text" class="form-control d-none edit-input" value="${product.name}">
                        </td>
                        <td>
                            <img src="${product.image}" style="width: 100px; height: 100px; object-fit: cover;" alt="${product.name}" />
                            <input type="file" class="form-control d-none edit-input" id="image"/>
                        </td>
                        <td>
                            <span class="text">${product.description}</span>
                            <input type="text" class="form-control d-none edit-input" value="${product.description}">
                        </td>
                        <td>
                            <span class="text">${product.price}</span>
                            <input type="number" class="form-control d-none edit-input" value="${product.price}">
                        </td>
                        <td>
                            <span class="text">${product.stock}</span>
                            <input type="number" class="form-control d-none edit-input" value="${product.stock}">
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                                <button class="btn btn-sm btn-success save-btn d-none">Save</button>
                                <button class="btn btn-sm btn-danger delete-btn">Delete</button>
                            </div>
                        </td>
                    </tr>`;
                    tableBody.append(row);
                });

                $(".edit-btn").click(function() {
                    let row = $(this).closest("tr");
                    toggleEditMode(row, true);
                });

                $(".save-btn").click(function() {
                    let row = $(this).closest("tr");
                    saveProduct(row);
                });

                $(".delete-btn").click(function() {
                    let row = $(this).closest("tr");
                    let productId = row.attr("data-id");
                    deleteProduct(productId);
                });
            },
            error: function(error) {
                alert("Error fetching products");
            }
        });
    }

    function deleteProduct(productId) {
        const token = localStorage.getItem('authToken');
        if (!token) {
            console.error("No token found. User is not authenticated.");
            return;
        }

        if (confirm("Are you sure you want to delete this product?")) {
            $.ajax({
                url: `/api/deleteproduct/${productId}`,
                type: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                success: function() {
                    alert("Product deleted successfully!");
                    fetchProducts();
                },
                error: function(error) {
                    alert("Error deleting product");
                }
            });
        }
    }

    function saveProduct(row) {
        const token = localStorage.getItem('authToken');
        if (!token) {
            console.error("No token found. User is not authenticated.");
            return;
        }

        let productId = row.attr("data-id");
        let updatedData = {
            name: row.find("td:nth-child(2) input").val(),
            description: row.find("td:nth-child(4) input").val(),
            price: row.find("td:nth-child(5) input").val(),
            stock: row.find("td:nth-child(6) input").val(),
        };
        let formData = new FormData();
        formData.append('name', updatedData.name);
        formData.append('description', updatedData.description);
        formData.append('price', updatedData.price);
        formData.append('stock', updatedData.stock);

        let imageInput = row.find("td:nth-child(3) input")[0];
        if (imageInput && imageInput.files.length > 0) {
            console.log("✅ Image selected:", imageInput.files[0]);
            formData.append('image', imageInput.files[0]);
        }

        $.ajax({
            url: `/api/updateproduct/${productId}`,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function() {
                alert("Product updated successfully!");
                fetchProducts();
            },
            error: function(error) {
                alert("Error updating product");
            }
        });
    }

    function toggleEditMode(row, isEditing) {
        row.find(".text").toggleClass("d-none", isEditing);
        row.find("img").toggleClass("d-none", isEditing);

        row.find(".edit-input").toggleClass("d-none", !isEditing);

        row.find(".edit-btn").toggleClass("d-none", isEditing);
        row.find(".save-btn").toggleClass("d-none", !isEditing);
    }
</script>

@endsection