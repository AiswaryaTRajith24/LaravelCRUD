document.addEventListener("DOMContentLoaded", function () {
    let loginForm = document.getElementById("loginForm");
    let emailField = document.getElementById("email");
    let passwordField = document.getElementById("password");
    let errorMessages = document.getElementById("errorMessages");
    let loginButton = document.getElementById("loginButton");

    function validateFields() {
        let email = emailField.value.trim();
        let password = passwordField.value.trim();
        let errors = [];

        // Validate email
        if (email === "") {
            errors.push("Email is required.");
        } else if (!/\S+@\S+\.\S+/.test(email)) {
            errors.push("Enter a valid email address.");
        }

        // Validate password
        if (password === "") {
            errors.push("Password is required.");
        } else if (password.length < 6) {
            errors.push("Password must be at least 6 characters long.");
        }

        if (errors.length > 0) {
            errorMessages.innerHTML = errors.join("<br>");
        } else {
            errorMessages.innerHTML = "";
        }
    }

    emailField.addEventListener("input", validateFields);
    passwordField.addEventListener("input", validateFields);

    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();
        validateFields();

        let formData = {
            email: emailField.value.trim(),
            password: passwordField.value.trim(),
        };

        $.ajax({
            url: "/api/login",
            type: "POST",
            data: JSON.stringify(formData),
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.token) {
                    localStorage.setItem("authToken", response.token);
                    localStorage.setItem("userRole", response.role);

                    // Redirect based on user role
                    if (response.role === "admin") {
                        window.location.href = "/admin-dashboard";
                    } else {
                        window.location.href = "/user-dashboard";
                    }
                } else {
                    errorMessages.innerHTML = `<span class="text-danger">${response.error || "Login failed"}</span>`;
                }
            },
            error: function (xhr) {
                let errorMsg = xhr.responseJSON?.error || "An error occurred. Please try again.";
                errorMessages.innerHTML = `<span class="text-danger">${errorMsg}</span>`;
            },
        });
    });
});
