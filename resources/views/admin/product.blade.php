@include('admin.header')

<style>
    .div_center {
        text-align: center;
        padding: 40px;

    }

    .h2_font {
        font-size: 40px;
        padding-bottom: 20px
    }

    .text_color {
        color: black;
        padding-bottom: 2px;
    }

    .div_center {
        max-width: 500px;
        margin: auto;
        background-color: #000;
        /* or any dark background */
        padding: 40px;
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
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .submit_btn:hover {
        background-color: #218838;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <form action="{{ url('/add_product') }}" method="POST" enctype="multipart/form-data">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                    {{session()->get('message')}}
                </div>
            @endif
            @csrf
            <div class="div_center">
                <h1 class="h2_font">Add Product</h1>

                <div class="input_group">
                    <label>Product Title :</label>
                    <input class="text_input" type="text" name="title" placeholder="Write a title">
                </div>

                <div class="input_group">
                    <label>Product Description :</label>
                    <input class="text_input" type="text" name="description" placeholder="Write a description">
                </div>

                <div class="input_group">
                    <label>Product Price :</label>
                    <input class="text_input" type="number" name="price" placeholder="Write a price">
                </div>

                <div class="input_group">
                    <label>Discount Price :</label>
                    <input class="text_input" type="number" name="discount_price" placeholder="Write a discount">
                </div>

                <div class="input_group">
                    <label>Product Quantity :</label>
                    <input class="text_input" type="number" min="0" name="quantity" placeholder="Write a quantity">
                </div>

                <div class="input_group">
                    <label>Product Category :</label>
                    <select class="text_input" name="catagory">
                        <option value="">Select Category</option>
                        @foreach ($catagory as $catagory)

                            <option value="{{$catagory->catagory_name}}">{{$catagory->catagory_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="input_group">
                    <label>Product Image :</label>
                    <input class="text_input" type="file" name="image">
                </div>

                <div class="input_group">
                    <button type="submit" class="submit_btn">Add Product</button>
                </div>
            </div>
        </form>

    </div>
</div>


@include('admin.script')
