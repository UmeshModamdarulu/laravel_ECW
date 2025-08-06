@include('home.header')
<style>
    .box {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
        text-align: center;
        padding-bottom: 20px;
    }

    .box:hover {
        transform: translateY(-5px);
    }

    .img-box {
        width: 100%;
        height: 320px;
        overflow: hidden;
        background: #f7f7f7;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .img-box img {
        width: 100%;
        height: auto;
        object-fit: contain;
        max-height: 100%;
    }

    .detail-box {
        padding: 20px;
    }

    .detail-box h5 {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
    }

    .detail-box h6 {
        margin: 5px 0;
        font-size: 16px;
    }

    .btn-box {
        display: flex;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 8px 16px;
        font-size: 14px;
        border-radius: 5px;
    }

    /* Responsive adjustments */
    @media (max-width: 767.98px) {
        .img-box {
            height: 250px;
        }

        .detail-box h5 {
            font-size: 16px;
        }

        .detail-box h6 {
            font-size: 14px;
        }

        .btn {
            font-size: 13px;
            padding: 6px 12px;
        }
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-sm-10 col-md-6 col-lg-4">
            <div class="product-box p-3 shadow rounded">
                <div class="img-box text-center mb-3">
                    <img src="{{ asset('product/' . $product->image) }}" alt="{{ $product->title }}"
                        class="img-fluid rounded">
                </div>

                <div class="detail-box">
                    <h5 class="fw-bold">{{ $product->title }}</h5>

                    <p class="text-muted mb-1"><strong>Description:</strong> {{ $product->description }}</p>
                    <p class="mb-1"><strong>Category:</strong> {{ $product->catagory }}</p>
                    <p class="mb-1"><strong>Quantity:</strong> {{ $product->quantity }}</p>

                    @if ($product->discount_price != null)
                        <p class="mb-1 text-danger"><strong>Discount Price:</strong> ₹{{ $product->discount_price }}</p>
                        <p class="mb-1 text-decoration-line-through text-muted"><strong>Original Price:</strong>
                            ₹{{ $product->price }}</p>
                    @else
                        <p class="mb-1 text-primary"><strong>Price:</strong> ₹{{ $product->price }}</p>
                    @endif


                    <form action="{{url('add_cart', $product->id)}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <input type="number" name="quantity" value="1" min="1" style="width:100px;">
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Add To Cart">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@include('home.footer')
