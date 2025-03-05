@extends('layout.admin_dashboard')

@section('title', 'Users List')

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
            tableBody.innerHTML = ""; 

            users.forEach(user => {
                let row = `<tr>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.phone_number || 'N/A'}</td>
                    <td>${user.address || 'N/A'}</td>
                    <td>${user.role}</td>
                </tr>`;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => {
            console.error("Error fetching users:", error);
        });
}

// Export Data to Excel
function exportToExcel() {
    let table = document.querySelector("table");
    let wb = XLSX.utils.table_to_book(table, {sheet: "Users Data"});
    XLSX.writeFile(wb, "Users_List.xlsx");
}

</script>
@endsection