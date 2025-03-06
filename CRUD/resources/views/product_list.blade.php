@extends('layout.user_dashboard')

@section('title', 'Product List')

@section('content')
<section style="background-color: #eee;">
    <div class="text-center container py-5">
        <h4 class="mt-4 mb-5"><strong>Bestsellers</strong></h4>
        <div class="row" id="product-list">
            <!-- Products will be inserted here dynamically -->
        </div>
    </div>
</section>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchProducts();
    });

    function fetchProducts() {
        const token = localStorage.getItem("authToken");
        if (!token) {
            console.error("No token found. User is not authenticated.");
            return;
        }

        $.ajax({
            url: "{{ url('api/getallproducts') }}",
            type: "GET",
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
            success: function(products) {
                let productList = $("#product-list");
                productList.empty();

                let cart = JSON.parse(localStorage.getItem("cart")) || [];

                products.forEach((product) => {
                    let isAdded = cart.some((item) => item.id === product.id);

                    let productCard = `
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card">
                            <div class="bg-image hover-zoom ripple img-container" data-mdb-ripple-color="light">
                                <img src="${product.image}" class="w-100 img-fluid" alt="${product.name}" />
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-3">${product.name}</h5>
                                <p>${product.category || "Uncategorized"}</p>
                                <h6 class="mb-3"><strong>$${product.price}</strong></h6>
                                <button class="btn btn-primary add-to-cart" data-product-id="${product.id}" 
                                    onclick="addToCart(${product.id})" ${isAdded ? "disabled" : ""}>
                                    ${isAdded ? "Added to Cart" : "Add to Cart"}
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                    productList.append(productCard);
                });
            },
            error: function(error) {
                alert("Error fetching products");
            },
        });
    }


    function addToCart(productId) {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        let existingProduct = cart.find(item => item.id === productId);

        if (existingProduct) {
            existingProduct.quantity += 1;
        } else {
            cart.push({
                id: productId,
                quantity: 1
            });
        }

        localStorage.setItem("cart", JSON.stringify(cart));

        updateCartCount();

        let button = document.querySelector(`button[data-product-id="${productId}"]`);
        if (button) {
            button.innerText = "Added to Cart";
            button.disabled = true;
        }
    }


    function updateCartCount() {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        let totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);

        document.getElementById("cart-count").innerText = totalItems;
    }

    document.addEventListener("DOMContentLoaded", function() {
        updateCartCount();
    });
</script>


<style>
    .img-container {
        width: 100%;
        height: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .img-container img {
        height: 100%;
        width: auto;
        object-fit: cover;
    }
</style>