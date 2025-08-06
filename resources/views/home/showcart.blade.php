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
    <h2 class="mb-4">My Cart</h2>

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
                    <th>Total</th>
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
                        <td>${{ $item->price * $item->quantity }}</td>
                        <td>
                            <form action="{{ route('remove_cart', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Remove item from cart?')">
                                    Remove
                                </button>
                            </form>
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
