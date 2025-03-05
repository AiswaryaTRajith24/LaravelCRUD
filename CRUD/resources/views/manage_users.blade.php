@extends('layout.admin_dashboard')

@section('title', 'Manage users')

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
    
    $.ajax({
        url: '/api/getallusers',
        type: 'GET',
        headers: { 'Authorization': `Bearer ${token}` },
        success: function (users) {
            let tableBody = $("#usersTableBody");
            tableBody.empty();
            
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
                tableBody.append(row);
            });

            $(".edit-btn").on("click", function () {
                let row = $(this).closest("tr");
                toggleEditMode(row, true);
            });

            $(".save-btn").on("click", function () {
                let row = $(this).closest("tr");
                saveUser(row);
            });

            $(".delete-btn").on("click", function () {
                let row = $(this).closest("tr"); 
                let userId = row.data("id"); 
                deleteUser(userId);
            });
        },
        error: function (error) {
            alert("Error fetching users");
        }
    });
}

function deleteUser(userId) {
    const token = localStorage.getItem('authToken');
    if (!token) {
        console.error("No token found. User is not authenticated.");
        return;
    }

    if (confirm("Are you sure you want to delete this user?")) {
        $.ajax({
            url: `/api/deleteuser/${userId}`,
            type: 'POST',
            headers: { 'Authorization': `Bearer ${token}` },
            success: function () {
                alert("User deleted successfully!");
                fetchUsers();
            },
            error: function (error) {
                alert("Error deleting user");
            }
        });
    }
}

function toggleEditMode(row, isEditing) {
    row.find(".text").toggleClass("d-none", isEditing);
    row.find(".edit-input").toggleClass("d-none", !isEditing);
    row.find(".edit-btn").toggleClass("d-none", isEditing);
    row.find(".save-btn").toggleClass("d-none", !isEditing);
}

function saveUser(row) {
    const token = localStorage.getItem('authToken');
    if (!token) {
        console.error("No token found. User is not authenticated.");
        return;
    }

    let userId = row.data("id");
    let updatedData = {
        name: row.find("td:nth-child(2) input").val(),
        email: row.find("td:nth-child(3) input").val(),
        phone_number: row.find("td:nth-child(4) input").val() || null,
        address: row.find("td:nth-child(5) input").val() || null,
        role: row.find("td:nth-child(6) input").val()
    };

    $.ajax({
        url: `/api/updateuser/${userId}`,
        type: 'POST',
        headers: { 'Authorization': `Bearer ${token}` },
        data: updatedData,
        success: function () {
            alert("User updated successfully!");
            fetchUsers();
        },
        error: function (error) {
            alert("Error updating user");
        }
    });
}

</script>
@endsection