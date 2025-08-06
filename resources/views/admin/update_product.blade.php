@include('admin.header')

<style>
    .div_center {
        text-align: center;
        padding: 40px;
        max-width: 500px;
        margin: auto;
        background-color: #000;
        border-radius: 10px;
    }

    .h2_font {
        font-size: 40px;
        padding-bottom: 30px;
        color: white;
        text-align: center;
    }

    .input_group {
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .input_group label {
        font-size: 16px;
        margin-bottom: 5px;
        color: white;
    }

    .text_input {
        width: 100%;
        padding: 8px 10px;
        font-size: 14px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .submit_btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .submit_btn:hover {
        background-color: #0069d9;
    }

    .current_image {
        margin-top: 10px;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper">
        <form action="{{ url('update_product_confirm', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="div_center">
                <h1 class="h2_font">Update Product</h1>
                @if (session('message'))
                    <div
                        style="background-color: #d4edda; color: #155724; padding: 10px 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="input_group">
                    <label>Product Title :</label>
                    <input class="text_input" type="text" name="title" value="{{ $product->title }}">
                </div>

                <div class="input_group">
                    <label>Product Description :</label>
                    <input class="text_input" type="text" name="description" value="{{ $product->description }}">
                </div>

                <div class="input_group">
                    <label>Product Price :</label>
                    <input class="text_input" type="number" name="price" value="{{ $product->price }}">
                </div>

                <div class="input_group">
                    <label>Discount Price :</label>
                    <input class="text_input" type="number" name="discount_price"
                        value="{{ $product->discount_price }}">
                </div>

                <div class="input_group">
                    <label>Product Quantity :</label>
                    <input class="text_input" type="number" name="quantity" value="{{ $product->quantity }}">
                </div>

                <div class="input_group">
                    <label>Product Category :</label>
                    <select class="text_input" name="catagory">
                        <option value="{{ $product->catagory }}" selected>{{ $product->catagory }}</option>
                        @foreach ($catagory as $catagory)

                            <option value="{{$catagory->catagory_name}}">{{$catagory->catagory_name}}</option>
                        @endforeach
                    </select>

                </div>

                <div class="input_group">
                    <label>Current Image :</label>
                    <div class="current_image">
                        <img src="{{ asset('product/' . $product->image) }}" width="100">
                    </div>
                </div>

                <div class="input_group">
                    <label>Change Image :</label>
                    <input class="text_input" type="file" name="image">
                </div>

                <div class="input_group">
                    <button type="submit" class="submit_btn">Update Product</button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('admin.script')
