<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-info navbar-dark">
    <!-- Container wrapper -->
    <div class="container-fluid">
        <!-- Navbar brand -->
        <a class="navbar-brand" href="{{ "/user-dashboard" }}">User Dashboard</a>

        <!-- Icons -->
        <ul class="navbar-nav d-flex flex-row me-1">
            <li class="nav-item me-3 me-lg-0 text-white">
                <a class="nav-link text-danger" href="{{ "/order-history" }}">Order History
                </a>
            </li>
            <li class="nav-item me-3 me-lg-0">
                <a class="nav-link text-white" href="#">
                    <i class="fas fa-shopping-cart" onclick="redirectToCheckout()"></i>
                    <span id="cart-count" class="badge bg-danger">0</span>
                </a>
            </li>
            <li class="nav-item me-3 me-lg-0 text-white">
                <a class="nav-link text-danger" href="javascript:void(0);" onclick="logoutUser()">
                    <i class="fas fa-sign-out-alt"></i> Sign Out
                </a>
            </li>
        </ul>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        updateCartCount();
    });

    function updateCartCount() {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        document.getElementById("cart-count").innerText = cart.length;
    }

    async function logoutUser() {
        const token = localStorage.getItem('authToken');
        if (!token) {
            alert("You are already logged out.");
            return;
        }

        try {
            let response = await fetch("{{ url('/api/logout') }}", {
                method: "POST",
                headers: {
                    "Authorization": `Bearer ${token}`,
                    "Content-Type": "application/json"
                }
            });

            let result = await response.json();

            if (response.ok) {
                localStorage.removeItem('authToken');
                window.location.href = "{{ url('/') }}";
            } else {
                alert(result.message || "Logout failed!");
            }
        } catch (error) {
            console.error("Logout error:", error);
            alert("Failed to connect to the server!");
        }
    }

    function redirectToCheckout() {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];

        if (cart.length === 0) {
            alert("Your cart is empty!");
        } else {
            window.location.href = "{{ url('/checkout') }}";
        }
    }
</script>