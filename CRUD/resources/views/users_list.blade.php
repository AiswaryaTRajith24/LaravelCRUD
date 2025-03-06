@extends('layout.admin_dashboard')

@section('title', 'users')

@section('admincontent')
<div>
    <h1>Users</h1>
    <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody id="usersTableBody">
            <!-- Data will be inserted here dynamically -->
        </tbody>
    </table>
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary mt-3" onclick="exportToExcel()">Export</button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchUsers();
    });

    function fetchUsers() {
        const token = localStorage.getItem('authToken');
        if (!token) {
            console.error("No token found. User is not authenticated.");
            return;
        }

        $.ajax({
            url: "/api/getallusers",
            type: "GET",
            headers: {
                "Authorization": `Bearer ${token}`,
                "Accept": "application/json"
            },
            success: function(users) {
                let tableBody = $("#usersTableBody");
                tableBody.empty();

                users.forEach(user => {
                    let row = `<tr>
                        <td>${user.id}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.phone_number || 'N/A'}</td>
                        <td>${user.address || 'N/A'}</td>
                        <td>${user.role}</td>
                    </tr>`;
                    tableBody.append(row);
                });
            },
            error: function(error) {
                alert("Error fetching users");
            }
        });
    }

    function exportToExcel() {
        let table = document.querySelector("table");
        let wb = XLSX.utils.table_to_book(table, {
            sheet: "Users Data"
        });
        XLSX.writeFile(wb, "Users_List.xlsx");
    }
</script>
@endsection