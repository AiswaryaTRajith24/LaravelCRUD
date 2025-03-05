@extends('layout.user_dashboard')

@section('title', 'Product List')

@section('content')
  <section style="background-color: #eee;">
    <div class="text-center container py-5">
      <h4 class="mt-4 mb-5"><strong>Bestsellers</strong></h4>
      <div class="row" id="product-list">
         <!-- Products will be inserted here dynamically -->
      </div>
    </div>
  </section>
@endsection

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetchProducts();
    });

    function fetchProducts() {
        const token = localStorage.getItem('authToken');
        if (!token) {
            console.error("No token found. User is not authenticated.");
            return;
        }

        axios.get("{{ url('api/getallproducts') }}", {
            headers: {
                "Authorization": `Bearer ${token}`,
                "Accept": "application/json"
            }
        })
        .then(response => {
            console.log(response.data);
            let productList = document.getElementById("product-list");
            productList.innerHTML = ""; // Clear existing products
            
            response.data.forEach(product => {
                let productCard = `
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card">
                            <div class="bg-image hover-zoom ripple img-container" data-mdb-ripple-color="light">
                                <img src="${product.image}" class="w-100 img-fluid" alt="${product.name}" />
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-3">${product.name}</h5>
                                <p>${product.category || 'Uncategorized'}</p>
                                <h6 class="mb-3"><strong>$${product.price}</strong></h6>
                                <button class="btn btn-primary add-to-cart" onclick="addToCart(${product.id})">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                productList.innerHTML += productCard;
            });
        })
        .catch(error => console.error("Error fetching products:", error));
    }

    function addToCart(productId) {
        alert("Product " + productId + " added to cart!"); // Implement actual cart logic here
    }
</script>

<style>
  .img-container {
    width: 100%;         /* Full width of the card */
    height: 200px;       /* Fixed height */
    display: flex;       /* Flexbox to center image */
    justify-content: center;
    align-items: center;
    overflow: hidden;     /* Hide overflow if image is too large */
}

.img-container img {
    height: 100%;        /* Ensure image fills the container */
    width: auto;         /* Maintain aspect ratio */
    object-fit: cover;   /* Crop image while maintaining proportions */
}

</style>
