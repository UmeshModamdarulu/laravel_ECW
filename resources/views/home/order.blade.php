@include('home.header')

@section('content')
<style>
    .product-img {
        width: 100px;
        height: auto;
        object-fit: contain;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 4px;
        background-color: #fff;
    }

    .checkout-box {
        margin-top: 2rem;
        text-align: right;
    }

    .checkout-box h4 {
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .checkout-box .btn {
        min-width: 160px;
    }
</style>

<div class="container py-5">
    <h2 class="mb-4">My Orders</h2>

    @if(session()->has('message'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ session()->get('message') }}
        </div>
    @endif

    @if(session('message'))
        <script>
            alert(@json(session('message')));
        </script>
    @endif

    @if($cart_items->isEmpty())
        <div class="alert alert-info">Your cart is empty.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Product Image</th>
                    <th>Title</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Payment Status</th>
                    <th>Delivery Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $total_price = 0; @endphp
                @foreach($cart_items as $item)
                    @php $total_price += $item->price * $item->quantity; @endphp
                    <tr>
                        <td><img src="{{ asset('product/' . $item->image) }}" class="product-img" alt="Product Image"></td>
                        <td>{{ $item->product_title }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ $item->price }}</td>
                        <td>{{ $item->payment_status}}</td>
                        <td>{{ $item->delivery_status}}</td>

                        <td>
                            @if ($item->delivery_status == 'processing')
                                <a onclick="return confirm('Are You Sure to Cancel this Order !!!')" class="btn btn-danger"
                                    href="{{ url('cancel_order', $item->id) }}">Cancel Order</a>
                            @else
                                <p style="color: blue;">Not Allowed</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total Price & Checkout Section -->
        <div class="checkout-box">
            <h4>Total Price: ${{ $total_price }}</h4>
            <p>Procced to pay</p>
            <a href="{{ url('cash_order') }}" class="btn btn-primary me-2">Cash on Delivery</a>
            <a href="{{ url('checkout') }}" class="btn btn-success">Checkout</a>
        </div>
    @endif
</div>

@include('home.footer')