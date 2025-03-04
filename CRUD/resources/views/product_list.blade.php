@extends('user_dashboard')

@section('title', 'Product List')

@section('product_list')
  <section style="background-color: #eee;">
    <div class="text-center container py-5">
      <h4 class="mt-4 mb-5"><strong>Bestsellers</strong></h4>
      <div class="row">
        <div class="col-lg-4 col-md-12 mb-4">
          <div class="card">
            <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light"
              data-mdb-ripple-color="light">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Products/belt.webp"
                class="w-100" />
            </div>
            <div class="card-body">
              <a href="" class="text-reset">
                <h5 class="card-title mb-3">Product name</h5>
              </a>
              <a href="" class="text-reset">
                <p>Category</p>
              </a>
              <h6 class="mb-3">$61.99</h6>
              <button class="btn btn-primary add-to-cart">
                Add to Cart
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card">
            <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light"
              data-mdb-ripple-color="light">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Products/img%20(4).webp"
                class="w-100" />
            </div>
            <div class="card-body">
              <a href="" class="text-reset">
                <h5 class="card-title mb-3">Product name</h5>
              </a>
              <a href="" class="text-reset">
                <p>Category</p>
              </a>
              <h6 class="mb-3">$61.99</h6>
              <button class="btn btn-primary add-to-cart">
                Add to Cart
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card">
            <div class="bg-image hover-zoom ripple" data-mdb-ripple-color="light">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Products/shoes%20(3).webp"
                class="w-100" />
            </div>
            <div class="card-body">
              <a href="" class="text-reset">
                <h5 class="card-title mb-3">Product name</h5>
              </a>
              <a href="" class="text-reset">
                <p>Category</p>
              </a>
              <h6 class="mb-3">
                <s>$61.99</s><strong class="ms-2 text-danger">$50.99</strong>
              </h6>
              <button class="btn btn-primary add-to-cart">
                Add to Cart
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-12 mb-4">
          <div class="card">
            <div class="bg-image hover-zoom ripple" data-mdb-ripple-color="light">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Products/img%20(23).webp"
                class="w-100" />
            </div>
            <div class="card-body">
              <a href="" class="text-reset">
                <h5 class="card-title mb-3">Product name</h5>
              </a>
              <a href="" class="text-reset">
                <p>Category</p>
              </a>
              <h6 class="mb-3">
                <s>$61.99</s><strong class="ms-2 text-danger">$50.99</strong>
              </h6>
              <button class="btn btn-primary add-to-cart">
                Add to Cart
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card">
            <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light"
              data-mdb-ripple-color="light">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Products/img%20(17).webp"
                class="w-100" />
            </div>
            <div class="card-body">
              <a href="" class="text-reset">
                <h5 class="card-title mb-3">Product name</h5>
              </a>
              <a href="" class="text-reset">
                <p>Category</p>
              </a>
              <h6 class="mb-3">$61.99</h6>
              <button class="btn btn-primary add-to-cart">
                  Add to Cart
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card">
            <div class="bg-image hover-zoom ripple" data-mdb-ripple-color="light">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Products/img%20(30).webp"
                class="w-100" />
            </div>
            <div class="card-body">
              <a href="" class="text-reset">
                <h5 class="card-title mb-3">Product name</h5>
              </a>
              <a href="" class="text-reset">
                <p>Category</p>
              </a>
              <h6 class="mb-3">
                <s>$61.99</s><strong class="ms-2 text-danger">$50.99</strong>
              </h6>
              <button class="btn btn-primary add-to-cart">
                Add to Cart
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection