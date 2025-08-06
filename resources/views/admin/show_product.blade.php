@include('admin.header')
<style>
    .table-responsive {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        background: white;
        border-radius: 10px;
        overflow-x: auto;
        padding: 10px;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        vertical-align: middle;
        background-color: #212529;
        color: #fff;
        border: none;
    }

    .table tbody td {
        vertical-align: middle;
        background-color: #f8f9fa;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #ffffff;
    }

    .table-striped tbody tr:nth-of-type(even) {
        background-color: #f1f1f1;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #dee2e6;
    }

    .table img {
        object-fit: cover;
        border-radius: 8px;
        height: 70px;
        width: 70px;
        border: 1px solid #ddd;
        transition: transform 0.2s ease-in-out;
    }

    .table img:hover {
        transform: scale(1.2);
        z-index: 10;
    }

    .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: #fff;
    }

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    h2 {
        font-weight: 600;
        color: #333;
    }

    .table td .btn {
        margin: 2px 4px;
        padding: 5px 12px;
        min-width: 70px;
        font-size: 14px;
        border-radius: 6px;
        white-space: nowrap;
        display: inline-block;
        /* keeps them on the same line */
    }

    /* Align buttons in one line and center */
    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .table td:last-child {
        white-space: nowrap;
        justify-content: center;
        gap: 8px;
    }

    /* Optional: consistent table row height */
    .table tbody tr {
        height: 70px;
    }
</style>


<div class="main-panel">
    <div class="content-wrapper">

        <div class="container-fluid">
            <h2 class="text-center mb-4" style="font-size: 40px;color: white">All Products</h2>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                    {{session()->get('message')}}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Discount Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->title }}</td>
                                <td>{{ Str::limit($product->description, 30) }}</td>
                                <td>
                                    <img src="{{ asset('product/' . $product->image) }}" height="100px" width="100px"
                                        class="img-thumbnail">
                                </td>
                                <td>{{ $product->catagory }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td><strong>₹{{ $product->price }}</strong></td>
                                <td><strong>₹{{ $product->discount_price }}</strong></td>

                                <td>
                                    <a href="{{ url('update_product', $product->id) }}"
                                        class="btn btn-sm btn-outline-primary mb-1">Update</a>
                                    <a href="{{ url('delete_product', $product->id) }}"
                                        onclick="return confirm('Are you sure you want to delete this product?')"
                                        class="btn btn-sm btn-outline-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>



@include('admin.script')
