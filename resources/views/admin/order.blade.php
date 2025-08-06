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
    }

    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .table td:last-child {
        white-space: nowrap;
        justify-content: center;
        gap: 8px;
    }

    .table tbody tr {
        height: 70px;
    }
    .search-bar{
        padding: 10px;
        padding-left:400px;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="container-fluid">
            <h2 class="text-center mb-4" style="font-size: 40px; color: white">All Orders</h2>
            <div class="search-bar">
                <form action="{{url('search')}}" method="get">
                    @csrf
                    <input type="text" name="search" placeholder="search for something">
                    <input type="submit" value="search" class="btn btn-outline-primary">
                </form>
            </div>
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Payment Status</th>
                            <th>Delivery Status</th>
                            <th>Send Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->product_title }}</td>
                                <td>
                                    @if($order->image)
                                        <img src="{{ asset('product/' . $order->image) }}" class="img-thumbnail">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $order->quantity }}</td>
                                <td><strong>₹{{ $order->price }}</strong></td>
                                <td>{{ $order->payment_status }}</td>

                                <td>{{ ucfirst($order->delivery_status) }}</td>
                                {{-- <td>
                                    <a href="{{ url('order/invoice/' . $order->id) }}" class="btn btn-sm btn-outline-success" target="_blank">Download PDF</a>
                                </td> --}}
                                <td>
                                    <a href="{{ url('order/send-email/' . $order->id) }}" class="btn btn-sm btn-outline-info">Send Email</a>
                                </td>
                                <td>
                                    <form action="{{ url('order/update-status/' . $order->id) }}" method="POST">
                                        @csrf
                                        <select name="delivery_status" class="form-control mb-2">
                                            <option value="processing" {{ $order->delivery_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ $order->delivery_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ $order->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        </select>
                                        <button type="submit" class="btn btn-outline-primary">Update</button>
                                    </form>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="16">No Data Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.script')
