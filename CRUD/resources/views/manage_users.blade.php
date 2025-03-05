<!-- @extends('layout.admin_dashboard') -->

<!-- @section('title', 'Manage users') -->

@section('admincontent')
<div>
    <h1>Manage Users</h1>
    <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="usersTableBody">
            <!-- Data will be inserted here dynamically -->
        </tbody>
    </table>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetchUsers();
});

function fetchUsers() {
    const token = localStorage.getItem('authToken');
    if (!token) {
        console.error("No token found. User is not authenticated.");
        return;
    }
    axios.get('/api/getallusers',{
        headers: {
            'Authorization': `Bearer ${token}`
        }
    })
        .then(response => {
            let users = response.data;
            let tableBody = document.getElementById("usersTableBody");
            tableBody.innerHTML = ""; // Clear existing content

            users.forEach(user => {
                let row = `<tr data-id="${user.id}">
                    <td>${user.id}</td>
                    <td><span class="text">${user.name}</span><input type="text" class="form-control d-none edit-input" value="${user.name}"></td>
                    <td><span class="text">${user.email}</span><input type="email" class="form-control d-none edit-input" value="${user.email}"></td>
                    <td><span class="text">${user.phone_number || 'N/A'}</span><input type="text" class="form-control d-none edit-input" value="${user.phone_number || ''}"></td>
                    <td><span class="text">${user.address || 'N/A'}</span><input type="text" class="form-control d-none edit-input" value="${user.address || ''}"></td>
                    <td><span class="text">${user.role}</span><input type="text" class="form-control d-none edit-input" value="${user.role}"></td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                            <button class="btn btn-sm btn-success save-btn d-none">Save</button>
                            <button class="btn btn-sm btn-danger delete-btn">Delete</button>
                        </div>
                    </td>
                </tr>`;
                tableBody.innerHTML += row;
            });

            document.querySelectorAll(".edit-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let row = this.closest("tr");
                    toggleEditMode(row, true);
                });
            });

            document.querySelectorAll(".save-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let row = this.closest("tr");
                    saveUser(row);
                });
            });

            document.querySelectorAll(".delete-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let row = this.closest("tr"); //Find the closest row
                    let userId = row.getAttribute("data-id"); //Get user ID from row
                    deleteUser(userId);
                });
            });


        })
        .catch(error => {
            console.error("Error fetching users:", error);
        });
}

function deleteUser(userId) {
    const token = localStorage.getItem('authToken');
    if (!token) {
        console.error("No token found. User is not authenticated.");
        return;
    }

    if (confirm("Are you sure you want to delete this user?")) {
        axios.post(`/api/deleteuser/${userId}`, {}, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => {
            alert("User deleted successfully!");
            fetchUsers(); // Refresh the list
        })
        .catch(error => {
            console.error("Error deleting user:", error);
        });
    }
}

// Function to toggle edit mode
function toggleEditMode(row, isEditing) {
    row.querySelectorAll(".text").forEach(el => el.classList.toggle("d-none", isEditing));
    row.querySelectorAll(".edit-input").forEach(el => el.classList.toggle("d-none", !isEditing));

    row.querySelector(".edit-btn").classList.toggle("d-none", isEditing);
    row.querySelector(".save-btn").classList.toggle("d-none", !isEditing);
}

</script>
@endsection