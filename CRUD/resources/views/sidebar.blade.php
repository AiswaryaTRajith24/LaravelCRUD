<div class="wrapper d-flex">
<div class="sidebar border-end vh-100 d-flex flex-column">
  <div class="sidebar-header border-bottom">
    <div class="sidebar-brand">Admin Dashboard</div>
  </div>
  <ul class="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link active" href="{{ url('/admin-dashboard') }}">
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
      <a class="nav-link" href="#">
        <i class="nav-icon cil-list"></i> Manage products
      </a>
    </li>
    
    <li class="nav-item">
      <a class="nav-link" href="#">
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
   document.addEventListener("DOMContentLoaded", function () {
    let currentPath = window.location.pathname;

    // Remove 'active' class from all nav links
    document.querySelectorAll(".sidebar-nav .nav-link").forEach(link => {
        link.classList.remove("active");

        // Add click event to maintain 'active' class
        link.addEventListener("click", function () {
            document.querySelectorAll(".sidebar-nav .nav-link").forEach(l => l.classList.remove("active"));
            this.classList.add("active");
        });
    });

    // Define mapping of URLs to menu item IDs
    let menuItems = {
        "/admin-dashboard": "/admin-dashboard",
        "/add-users": "/add-users",
        "/manage-users": "/manage-users",
        "/add-products": "/add-products",
        "/manage-products": "/manage-products",
        "/view-orders": "/view-orders",
    };

    // Find the matching menu item and add 'active' class
    document.querySelectorAll(".sidebar-nav .nav-link").forEach(link => {
        if (link.getAttribute("href") === menuItems[currentPath]) {
            link.classList.add("active");
        }
    });
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
            localStorage.removeItem('authToken'); // Remove token from local storage
            window.location.href = "{{ url('/') }}"; // Redirect to login page
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
    .sidebar-nav .nav-link {
    color: #6c757d;
}

.sidebar-nav .nav-link.active {
    color: #ffffff !important; /* Ensure active link is highlighted */
    background-color: #007bff !important; /* Highlight background */
    border-radius: 5px;
}

</style>