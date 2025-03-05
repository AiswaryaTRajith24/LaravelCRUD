@extends('layout.admin_dashboard')

@section('title', 'Add Products')

@section('admincontent')

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <form style="width: 26rem;" id="addProductForm">
        <h1>Add Product</h1>

        <!-- Success/Error Messages -->
        <div id="errorMessages" class="alert d-none"></div>

        <!-- CSRF Token (Required for Laravel) -->
        @csrf

        <!-- Name input -->
        <div class="form-outline mb-3">
            <label class="form-label" for="name">Name</label>
            <input type="text" id="name" class="form-control" />
        </div>
        
        <!-- Description input -->
        <div class="form-outline mb-3">
            <label class="form-label" for="description">Description</label>
            <textarea class="form-control" id="description" rows="3"></textarea>
        </div>

        <!-- Price input -->
        <div class="form-outline mb-3">
            <label class="form-label" for="price">Price</label>
            <input type="text" id="price" class="form-control" />
        </div>

        <!-- Stock input -->
        <div class="form-outline mb-3">
            <label class="form-label" for="stock">stock</label>
            <input type="text" id="stock" class="form-control" />
        </div>

        <!-- image input -->
        <div class="form-outline mb-3">
            <label class="form-label" for="image">Upload image</label>
            <input type="file" id="image" class="form-control" />
        </div>

        <!-- Submit button -->
        <button type="button" class="btn btn-info btn-block mb-4 text-white" onclick="submitForm()">Submit</button>
    </form>
</div>

<script>
async function submitForm() {
    let errors = [];
    let errorDiv = document.getElementById("errorMessages");
    errorDiv.classList.add("d-none");

   
    const token = localStorage.getItem("authToken");
    if (!token) {
        errors.push("You are not authorized to perform this action. Please log in.");
    }

   
    let name = document.getElementById("name").value.trim();
    let description = document.getElementById("description").value.trim();
    let price = document.getElementById("price").value.trim();
    let stock = document.getElementById("stock").value.trim();
    
    let imageInput = document.getElementById("image");
    if (!imageInput) {
        console.error("Image input field not found!");
        return;
    }
    let image = imageInput.files.length > 0 ? imageInput.files[0] : null;

    if (name === "" || name.length > 255) errors.push("Name is required.");
    if (description === "" || description.length > 255) errors.push("Description is required.");
    if (price === "" || !/^\d{1,8}(\.\d{1,2})?$/.test(price) || isNaN(price) || parseFloat(price) <= 0) 
        errors.push("Price is required, must be a valid number with up to 2 decimal places, and cannot be negative.");
    if (stock === "" || !/^\d+$/.test(stock) || parseInt(stock) < 0) errors.push("Stock is required and must be a non-negative integer.");

    if (image) {
        let validExtensions = ["jpeg", "png", "jpg", "gif", "svg"];
        let fileExtension = image.name.split(".").pop().toLowerCase();

        if (!validExtensions.includes(fileExtension)) {
            errors.push("Invalid image format. Allowed formats: jpeg, png, jpg, gif, svg.");
        }

        if (image.size > 2 * 1024 * 1024) { 
            errors.push("Image size must not exceed 2MB.");
        }
    }

    if (errors.length > 0) {
        errorDiv.innerHTML = errors.join("<br>");
        errorDiv.className = "alert alert-danger";
        errorDiv.classList.remove("d-none");
        return;
    }

    let csrfToken = document.querySelector('input[name="_token"]').value;

    let formData = new FormData();
    formData.append("name", name);
    formData.append("description", description);
    formData.append("price", price);
    formData.append("stock", stock);
    if (image) formData.append("image", image);

    try {
        let response = await fetch("{{ url('api/createproduct') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Authorization": `Bearer ${token}`
            },
            body: formData 
        });

        let result = await response.json();

        if (response.ok) {
            errorDiv.innerHTML = "Product Added successfully!";
            errorDiv.className = "alert alert-success";
            errorDiv.classList.remove("d-none");

            document.getElementById("addProductForm").reset();
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
