<div class="wrapper d-flex">
    <div class="sidebar border-end vh-100 d-flex flex-column">
        <div class="sidebar-header border-bottom">
            <div>Admin Dashboard</div>
        </div>
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/admin-dashboard') }}">
                    <i class="nav-icon cil-user"></i> Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/add-users') }}">
                    <i class="nav-icon cil-user-follow"></i> Add Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/manage-users') }}">
                    <i class="nav-icon cil-user-unfollow"></i> Manage Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ '/admin-products-list' }}">
                    <i class="nav-icon cil-storage"></i> Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/add-product') }}">
                    <i class="nav-icon cil-plus"></i> Add Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ '/manage-products' }}">
                    <i class="nav-icon cil-list"></i> Manage products
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ '/get-orders-for-admin' }}">
                    <i class="nav-icon cil-cart"></i> View all orders
                </a>
            </li>

            <div class="sidebar-footer border-top p-3">
                <a class="nav-link text-danger" href="javascript:void(0);" onclick="logoutUser()">
                    <i class="nav-icon cil-account-logout"></i> Sign Out
                </a>
            </div>
        </ul>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let currentPath = window.location.pathname;

        let navItems = document.querySelectorAll(".nav-item");

        navItems.forEach(item => {

            let linkText = item.textContent.trim().toLowerCase();

            if (document.title.toLowerCase() == linkText) {
                item.classList.add("active");
                console.log("document.title.toLowerCase()", document.title.toLowerCase());
                console.log("linkText", linkText)
            } else
                item.classList.remove("active");
        });


        let menuItems = {
            "/admin-dashboard": "/admin-dashboard",
            "/add-users": "/add-users",
            "/manage-users": "/manage-users",
            "/add-products": "/add-products",
            "/manage-products": "/manage-products",
            "/view-orders": "/view-orders",
        };
    });



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
</script>
<style>
    .sidebar-nav .nav-item.active {
        color: #ffffff !important;
        background-color: #787878 !important;
        border-radius: 5px;
    }
</style>