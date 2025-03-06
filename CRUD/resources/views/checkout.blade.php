@extends('layout.user_dashboard')

@section('title', 'checkout')

@section('content')
    <div class="container">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-md-9">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Items in your cart</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table shoping-cart-table">
                                    <tbody id="cart-items">
                                        <!-- Cart items here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <button class="btn btn-white"><i class="fa fa-arrow-left"></i> Continue shopping</button>

                        </div>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Cart Summary</h5>
                        </div>
                        <div class="ibox-content">
                            <span>
                                Total
                            </span>
                            <h2 class="font-bold">
                                $390,00
                            </h2>

                            <hr>
                            <span class="text-muted small">
                                *For United States, France and Germany applicable sales tax will be applied
                            </span>
                            <div class="m-t-sm">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> Checkout</a>
                                    <a href="#" class="btn btn-white btn-sm"> Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Support</h5>
                        </div>
                        <div class="ibox-content text-center">
                            <h3><i class="fa fa-phone"></i> +43 100 783 001</h3>
                            <span class="small">
                                Please contact with us if you have any questions. We are avalible 24h.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let cartItemsContainer = document.getElementById("cart-items");
    let totalAmount = 0;

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = `<tr><td colspan="5" class="text-center">Your cart is empty</td></tr>`;
        return;
    }

    const token = localStorage.getItem("authToken");
    if (!token) {
        console.error("No token found. User is not authenticated.");
        return;
    }

    // Extract product IDs from the cart
    let productIds = cart.map(item => item.id);

    // Fetch product details from the API
    $.ajax({
        url: "{{ url('api/getallproducts') }}",
        type: "GET",
        headers: {
            Authorization: `Bearer ${token}`,
            Accept: "application/json",
        },
        success: function (products) {
            let filteredProducts = products.filter(product => productIds.includes(product.id));

            filteredProducts.forEach((product, index) => {
                let cartItem = cart.find(item => item.id === product.id);
                
                // Ensure price is converted to a number
                let price = parseFloat(product.price) || 0;
                let originalPrice = product.original_price ? parseFloat(product.original_price) : null;
                let itemTotal = price * cartItem.quantity;
                totalAmount += itemTotal;

                let cartItemHTML = `
                    <tr data-index="${index}">
                        <td width="90">
                            <div class="cart-product-imitation">
                                <img src="${product.image}" width="80" height="80" alt="${product.name}">
                            </div>
                        </td>
                        <td class="desc">
                            <h3>
                                <a href="#" class="text-navy">${product.name}</a>
                            </h3>
                            <p class="small">${product.description}</p>
                            <dl class="small m-b-none">
                                <dt>Description</dt>
                                <dd>${product.short_description || "No additional details available."}</dd>
                            </dl>
                            <div class="m-t-sm">
                                <a href="javascript:void(0);" class="text-muted remove-item" data-index="${index}">
                                    <i class="fa fa-trash"></i> Remove item
                                </a>
                            </div>
                        </td>
                        <td>
                            $${price.toFixed(2)}
                            ${originalPrice ? `<s class="small text-muted">$${originalPrice.toFixed(2)}</s>` : ""}
                        </td>
                        <td width="65">
                            <input type="number" class="form-control quantity" value="${cartItem.quantity}" min="1" data-index="${index}">
                        </td>
                        <td>
                            <h4>$${itemTotal.toFixed(2)}</h4>
                        </td>
                    </tr>
                `;

                cartItemsContainer.innerHTML += cartItemHTML;
            });

            document.querySelector(".font-bold").innerText = `$${totalAmount.toFixed(2)}`;

            // Remove item from cart
            document.querySelectorAll(".remove-item").forEach(btn => {
                btn.addEventListener("click", function () {
                    let index = this.getAttribute("data-index");
                    cart.splice(index, 1);
                    localStorage.setItem("cart", JSON.stringify(cart));
                    location.reload();
                });
            });

            // Update quantity and total price
            document.querySelectorAll(".quantity").forEach(input => {
                input.addEventListener("change", function () {
                    let index = this.getAttribute("data-index");
                    cart[index].quantity = parseInt(this.value);
                    localStorage.setItem("cart", JSON.stringify(cart));
                    location.reload();
                });
            });
        },
        error: function (error) {
            console.error("Error fetching product details:", error);
        }
    });
});



</script>
@endsection
<style>
    body {
        margin-top: 20px;
        background: #eee;
    }

    h3 {
        font-size: 16px;
    }

    .text-navy {
        color: #1ab394;
    }

    .cart-product-imitation {
        text-align: center;
        padding-top: 30px;
        height: 80px;
        width: 80px;
        background-color: #f8f8f9;
    }

    .product-imitation.xl {
        padding: 120px 0;
    }

    .product-desc {
        padding: 20px;
        position: relative;
    }

    .ecommerce .tag-list {
        padding: 0;
    }

    .ecommerce .fa-star {
        color: #d1dade;
    }

    .ecommerce .fa-star.active {
        color: #f8ac59;
    }

    .ecommerce .note-editor {
        border: 1px solid #e7eaec;
    }

    table.shoping-cart-table {
        margin-bottom: 0;
    }

    table.shoping-cart-table tr td {
        border: none;
        text-align: right;
    }

    table.shoping-cart-table tr td.desc,
    table.shoping-cart-table tr td:first-child {
        text-align: left;
    }

    table.shoping-cart-table tr td:last-child {
        width: 80px;
    }

    .ibox {
        clear: both;
        margin-bottom: 25px;
        margin-top: 0;
        padding: 0;
    }

    .ibox.collapsed .ibox-content {
        display: none;
    }

    .ibox:after,
    .ibox:before {
        display: table;
    }

    .ibox-title {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        background-color: #ffffff;
        border-color: #e7eaec;
        border-image: none;
        border-style: solid solid none;
        border-width: 3px 0 0;
        color: inherit;
        margin-bottom: 0;
        padding: 14px 15px 7px;
        min-height: 48px;
    }

    .ibox-content {
        background-color: #ffffff;
        color: inherit;
        padding: 15px 20px 20px 20px;
        border-color: #e7eaec;
        border-image: none;
        border-style: solid solid none;
        border-width: 1px 0;
    }

    .ibox-footer {
        color: inherit;
        border-top: 1px solid #e7eaec;
        font-size: 90%;
        background: #ffffff;
        padding: 10px 15px;
    }
</style>