@extends('layout.admin_dashboard')

@section('title', 'Users List')

@section('admincontent')

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <form style="width: 26rem;" id="addUserForm">
        <h1>Add User</h1>

        <!-- Success/Error Messages -->
        <div id="errorMessages" class="alert d-none"></div>

        <!-- CSRF Token (Required for Laravel) -->
        @csrf

        <!-- Name input -->
        <div class="form-outline mb-3">
            <label class="form-label" for="name">Name</label>
            <input type="text" id="name" class="form-control" />
        </div>

        <!-- Email input -->
        <div class="form-outline mb-3">
            <label class="form-label" for="email">Email address</label>
            <input type="email" id="email" class="form-control" />
        </div>

        <!-- Password input (Auto-generated) -->
        <div class="form-outline mb-3 position-relative">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" class="form-control" readonly />
            <button type="button" class="btn btn-light position-absolute" 
                style="top: 72%; right: 0px; transform: translateY(-50%);" 
                onclick="togglePassword()">
                <i id="togglePasswordIcon" class="fas fa-eye-slash"></i>
            </button>
        </div>

        <!-- Phone Number input -->
        <div class="form-outline mb-3">
            <label class="form-label" for="phone_number">Phone Number</label>
            <input type="text" id="phone_number" class="form-control" 
                maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'')" />
        </div>

        <!-- Address input -->
        <div class="form-outline mb-3">
            <label class="form-label" for="address">Address</label>
            <textarea class="form-control" id="address" rows="3"></textarea>
        </div>

        <!-- Role select -->
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role">
                <option value="">Choose a role</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <!-- Submit button -->
        <button type="button" class="btn btn-info btn-block mb-4 text-white" onclick="submitForm()">Submit</button>
    </form>
</div>

<script>
    // Auto-generate password on page load
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("password").value = generatePassword(10);
    });

    function generatePassword(length) {
        let chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$!";
        let password = "";
        for (let i = 0; i < length; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return password;
    }

    function togglePassword() {
        let passwordField = document.getElementById("password");
        let toggleIcon = document.getElementById("togglePasswordIcon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        }
    }

    async function submitForm() {
    let errors = [];
    let errorDiv = document.getElementById("errorMessages");
    errorDiv.classList.add("d-none"); // Hide error div initially

    // Check authentication token
    const token = localStorage.getItem("authToken");
    if (!token) {
        errors.push("You are not authorized to perform this action. Please log in.");
    }

    // Get form values
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();
    let phoneNumber = document.getElementById("phone_number").value.trim();
    let address = document.getElementById("address").value.trim();
    let role = document.getElementById("role").value;

    // Validation checks
    if (name === "" || name.length > 255) errors.push("Name is required and should be less than 255 characters.");
    if (email === "" || !/^\S+@\S+\.\S+$/.test(email)) errors.push("Valid email is required.");
    if (password.length < 6) errors.push("Password must be at least 6 characters.");
    if (!/^\d{10}$/.test(phoneNumber)) errors.push("Phone number must be exactly 10 digits.");
    if (address === "" || address.length > 500) errors.push("Address is required and should be less than 500 characters.");
    if (role === "") errors.push("Role is required.");

    // Display errors if any
    if (errors.length > 0) {
        errorDiv.innerHTML = errors.join("<br>");
        errorDiv.className = "alert alert-danger";
        errorDiv.classList.remove("d-none");
        return;
    }

    // CSRF Token
    let csrfToken = document.querySelector('input[name="_token"]').value;

    // API Request
    try {
        let response = await fetch("{{ url('api/createuser') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "Authorization": `Bearer ${token}` // Include auth token
            },
            body: JSON.stringify({ name, email, password, phone_number: phoneNumber, address, role })
        });

        let result = await response.json();

        if (response.ok) {
            errorDiv.innerHTML = "User created successfully!";
            errorDiv.className = "alert alert-success";
            errorDiv.classList.remove("d-none");

            // Clear form after success
            document.getElementById("addUserForm").reset();
            document.getElementById("password").value = generatePassword(10);
        } else {
            errorDiv.innerHTML = result.message || "Something went wrong!";
            errorDiv.className = "alert alert-danger";
            errorDiv.classList.remove("d-none");
        }
    } catch (error) {
        errorDiv.innerHTML = "Failed to connect to the server!";
        errorDiv.className = "alert alert-danger";
        errorDiv.classList.remove("d-none");
    }
}

</script>

@endsection
