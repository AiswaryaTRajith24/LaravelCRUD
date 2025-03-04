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
            loginButton.disabled = true;
        } else {
            errorMessages.innerHTML = "";
            loginButton.disabled = false;
        }
    }

    emailField.addEventListener("input", validateFields);
    passwordField.addEventListener("input", validateFields);

    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();
        validateFields();

        if (loginButton.disabled) return; // Prevent API call if validation fails

        let formData = {
            email: emailField.value.trim(),
            password: passwordField.value.trim(),
        };

        // jQuery AJAX request
        axios.post("/api/login", formData, {
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        })
        .then(response => {        
            if (response.data.token) {
                localStorage.setItem("authToken", response.data.token);
                localStorage.setItem("userRole", response.data.role); 
        
                // Redirect based on user role
                if (response.data.role === "admin") {
                    window.location.href = "/admin-dashboard";
                } else {
                    window.location.href = "/user-dashboard";
                }
            } else {
                errorMessages.innerHTML = `<span class="text-danger">${response.data.error || "Login failed"}</span>`;
            }
        })
        .catch(error => {
            if (error.response) {
                errorMessages.innerHTML = `<span class="text-danger">${error.response.data.error || "An error occurred. Please try again."}</span>`;
            }else{
                errorMessages.innerHTML = `<span class="text-danger">An error occurred. Please try again.</span>`;

            }
        });
        
    });
});
