@include('home.header')

<style>
    /* New styles specifically for the 'Your Order' section */
    .your-order-section {
        background-color: #ffffff; /* White background for the order box */
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-top: 2rem;
        font-family: Arial, sans-serif; /* Common font */
    }

    .your-order-section h4 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 25px;
        color: #333;
    }

    .order-summary-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 25px;
    }

    .order-summary-table th,
    .order-summary-table td {
        padding: 12px 0;
        text-align: left;
        border-bottom: 1px solid #eee; /* Light separator */
    }

    .order-summary-table th {
        font-weight: normal;
        color: #555;
        font-size: 1rem;
    }

    .order-summary-table td {
        color: #333;
        font-size: 1rem;
    }

    .order-summary-table .product-name {
        width: 60%; /* Adjust as needed */
    }

    .order-summary-table .quantity-display {
        text-align: center;
        width: 15%;
    }

    .order-summary-table .total-price {
        text-align: right;
        width: 25%;
    }

    /* Specific styles for Subtotal, Shipping, Total rows */
    .order-summary-table .summary-row td {
        font-weight: bold;
        padding-top: 15px;
        border-bottom: none; /* No border for these rows visually */
    }

    .order-summary-table .summary-row.total-row td {
        font-size: 1.25rem;
        color: #d9534f; /* Reddish color for total as in image */
        padding-bottom: 0;
        border-bottom: none;
    }

    /* Payment Methods Section - Now just a container for the form */
    .payment-methods-section {
        margin-top: 30px;
    }

    /* Revised Terms & Conditions Styling */
    .terms-conditions-row {
        display: flex;
        justify-content: flex-end; /* Push content to the right */
        align-items: center; /* Vertically center checkbox and text */
        margin-top: 20px; /* Space from payment methods (now removed) */
        margin-bottom: 25px; /* Space above the button */
    }

    .terms-conditions-row .terms-conditions-label {
        font-size: 0.95rem;
        color: #555;
        margin-right: 8px; /* Space between text and checkbox */
        white-space: nowrap; /* Keep text on one line */
    }

    .terms-conditions-row .terms-conditions-label a {
        color: #dc3545; /* Red link for terms */
        font-weight: bold;
        text-decoration: none;
    }

    .terms-conditions-row .terms-conditions-label a:hover {
        text-decoration: underline;
    }

    .terms-conditions-row input[type="checkbox"] {
        transform: scale(1.2); /* Make checkbox slightly larger */
        accent-color: #dc3545; /* Red accent for selected checkbox */
    }

    .proceed-button {
        width: 100%;
        padding: 15px;
        font-size: 1.2rem;
        font-weight: bold;
        border-radius: 30px; /* Pill shape */
        background-color: #dc3545; /* Red color */
        color: #fff;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .proceed-button:hover {
        background-color: #c82333; /* Darker red on hover */
    }

    /* Hide the original Razorpay button as it's replaced */
    #rzp-button {
        display: none;
    }
</style>

<div class="container py-5">
    @if(session()->has('message'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ session()->get('message') }}
        </div>
    @endif

    @if($cart_items->isEmpty())
        <div class="alert alert-info">Your cart is empty.</div>
    @else
        @php
            // Initialize $total_amount outside the table loop to ensure it's always defined
            $subtotal = 0;
            $shipping_cost = 50.00; // Flat Rate: $50.00 as per image
            foreach($cart_items as $item) {
                $subtotal += $item->price * $item->quantity;
            }
            $total_amount = $subtotal + $shipping_cost;
        @endphp

        <div class="your-order-section">
            <h4>Your Order</h4>

            <table class="order-summary-table">
                <thead>
                    <tr>
                        <th class="product-name">Product</th>
                        <th class="total-price">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart_items as $item)
                        <tr>
                            <td>{{ $item->product_title }} x {{ $item->quantity }}</td>
                            <td class="total-price">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach

                    <tr class="summary-row">
                        <td>SUBTOTAL</td>
                        <td class="total-price">${{ number_format($subtotal, 2) }}</td>
                    </tr>
                    <tr class="summary-row">
                        <td>SHIPPING</td>
                        <td class="total-price">Flat Rate: ${{ number_format($shipping_cost, 2) }}</td>
                    </tr>
                    <tr class="summary-row total-row">
                        <td>TOTAL</td>
                        <td class="total-price">${{ number_format($total_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="payment-methods-section">
                <form id="checkout-form" action="{{ url('place_order') }}" method="POST">
                    @csrf

                    {{-- Terms & Conditions - now directly in the form --}}
                    <div class="terms-conditions-row">
                        <label for="terms_conditions" class="terms-conditions-label">
                            I've read and accept the <a href="#">terms & conditions</a>*
                        </label>
                        <input type="checkbox" id="terms_conditions" name="terms_conditions" required>
                    </div>

                    <button type="submit" class="proceed-button">PLACE ORDER</button>
                </form>
            </div>
        </div>
    @endif
</div>

@include('home.footer')

@if(session('message'))
    <script>
        alert(@json(session('message')));
    </script>
@endif

<script>
    // Debug: Log Razorpay Key from backend
    console.log('Razorpay Key:', '{{ $razorpayKey }}');
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js" onerror="console.error('Failed to load Razorpay script'); alert('Failed to load Razorpay payment gateway. Please try again later.');"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkoutForm = document.getElementById('checkout-form');
        const termsCheckbox = document.getElementById('terms_conditions');

        // Debug: Log if DOMContentLoaded runs
        console.log('DOMContentLoaded event fired');

        checkoutForm.addEventListener('submit', function(e) {
            console.log('Submit handler triggered'); // Debug
            e.preventDefault(); // Prevent default form submission always

            if (!termsCheckbox.checked) {
                alert('You must accept the terms & conditions.');
                return false;
            }

            // The total amount for Razorpay, ensure this variable is correctly passed from Blade.
            const totalAmountForRazorpay = parseFloat({{ $total_amount ?? 0 }}); // Use 0 as default if not set
            console.log('Total Amount for Razorpay:', totalAmountForRazorpay); // Debug

            // Debug: Check Razorpay key
            var razorpayKey = "{{ $razorpayKey }}";
            if (!razorpayKey || razorpayKey === '' || razorpayKey === 'null') {
                alert('Razorpay Key is missing. Please contact support.');
                console.error('Razorpay Key is missing.');
                return false;
            }

            if (totalAmountForRazorpay <= 0 || isNaN(totalAmountForRazorpay)) {
                alert('Cannot process an order with zero or negative total amount.');
                return false;
            }

            var options = {
                "key": razorpayKey, // Razorpay Key ID
                "amount": totalAmountForRazorpay * 100, // Amount in paise
                "currency": "INR",
                "name": "Your Store Name",
                "description": "Order Payment",
                "image": "{{ asset('images/logo.png') }}", // Optional logo
                "handler": function (response){
                    const hiddenInputPaymentId = document.createElement('input');
                    hiddenInputPaymentId.type = 'hidden';
                    hiddenInputPaymentId.name = 'razorpay_payment_id';
                    hiddenInputPaymentId.value = response.razorpay_payment_id;
                    checkoutForm.appendChild(hiddenInputPaymentId);

                    // Submit the form with the payment_id
                    checkoutForm.submit();
                },
                "prefill": {
                    "name": "{{ Auth::user()->name ?? 'Customer' }}",
                    "email": "{{ Auth::user()->email ?? 'email@example.com' }}",
                    "contact": "{{ Auth::user()->phone ?? '9999999999' }}"
                },
                "theme": {
                    "color": "#dc3545" // Match the button red
                }
            };

            var rzp = new Razorpay(options);
            rzp.open();
        });
    });
</script>