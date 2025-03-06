<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</head>

<body>
    <div class="card">
        <div class="card-body">
            <div class="container mb-5 mt-3">
                <div class="row d-flex align-items-baseline">
                    <div class="col-xl-9">
                        <p style="color: #7e8d9f;font-size: 20px;">Invoice</p>
                    </div>
                    <hr>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-xl-8">
                            <ul class="list-unstyled" id="customer-details">
                            </ul>
                        </div>
                        <div class="col-xl-4">
                            <p class="text-muted">Invoice</p>
                            <ul class="list-unstyled" id="invoice-details">
                            </ul>
                        </div>
                    </div>

                    <div class="row my-2 mx-1 justify-content-center">
                        <table class="table table-striped table-borderless">
                            <thead style="background-color:#84B0CA ;" class="text-white">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody id="order-items">
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div>
                            <p class="text-black float-end"><span class="text-black me-3"> Total Amount</span><span
                                    style="font-size: 25px;" id="total-amount">$0.00</span></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-10">
                            <p>Thank you for your purchase</p>
                        </div>
                        <div class="col-xl-2">
                            <button type="button" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-primary text-capitalize" style="background-color:#60bdf3 ;" id="downloadButton">Download</button>
                        </div>
                    </div>

                    <a href="{{ "/user-dashboard" }}">Back to products</a>

                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchOrders();
    });

    function fetchOrders() {
        const token = localStorage.getItem('authToken');
        const orderIdForInvoice = localStorage.getItem('orderIdForInvoice');

        if (!token) {
            console.error("No token found. User is not authenticated.");
            return;
        }

        if (!orderIdForInvoice) {
            console.error("No orderId found in localStorage.");
            return;
        }

        $.ajax({
            url: `/api/orders/${orderIdForInvoice}`,
            type: "GET",
            headers: {
                "Authorization": `Bearer ${token}`,
                "Accept": "application/json"
            },
            success: function(response) {
                if (response && response.success && response.data) {
                    console.log("Order details:", response.data);
                    populateInvoice(response.data); // Populate the UI
                } else {
                    console.error("Error fetching order details:", response);
                    alert("Error fetching order details.");
                }
            },
            error: function(error) {
                console.error("Error fetching order details:", error);
                alert("Error fetching order details.");
            }
        });
    }

    function populateInvoice(order) {
        // Customer Details
        $('#customer-details').html(`
            <li class="text-muted">To: <span style="color:#5d9fc5 ;">${order.user.name}</span></li>
            <li class="text-muted">${order.user.address}</li>
            <li class="text-muted">${order.user.email}</li>
            <li class="text-muted"><i class="fas fa-phone"></i> ${order.user.phone_number}</li>
        `);

        // Invoice Details
        $('#invoice-details').html(`
            <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span class="fw-bold">Creation Date: </span>${new Date(order.invoice.created_at).toLocaleDateString()}</li>
            <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span class="me-1 fw-bold">Status:</span><span class="badge bg-success text-white fw-bold">Paid</span></li>
        `);

        // Order Items
        let orderItemsHtml = '';
        order.order_items.forEach((item, index) => {
            orderItemsHtml += `
                <tr>
                    <th scope="row">${index + 1}</th>
                    <td>${item.product.name}</td>
                    <td>${item.count}</td>
                    <td>$${item.product.price}</td>
                    <td>$${item.total}</td>
                </tr>
            `;
        });
        $('#order-items').html(orderItemsHtml);

        // Total Amount
        $('#total-amount').text(`$${order.grand_total}`);
    }

    document.getElementById('downloadButton').addEventListener('click', downloadPDF);

    function downloadPDF() {
        const element = document.querySelector('.card');

        const opt = {
            margin: 10,
            filename: 'invoice.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'mm',
                format: 'a5',
                orientation: 'portrait'
            }
        };

        html2pdf().from(element).set(opt).save();
    }
</script>

</html>