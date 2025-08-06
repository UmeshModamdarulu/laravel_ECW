@include('admin.header')
<style>
    .div_center {
        text-align: center;
        padding: 40px;

    }

    .h2_font {
        font-size: 40px;
        padding-bottom: 40px
    }

    .input_colour {
        color: black;
    }

    .center {
        margin: auto;
        width: 30%;
        text-align: center;
        margin-top: 30px;
        border: 2px solid white;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        @if (session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                {{session()->get('message')}}
            </div>
        @endif
        <div class="div_center">
            <h2 class="h2_font">Add catagory</h2>
            <form action="{{url('/add_catagory')}}" method="post">
                @csrf
                <input type="text" class="input_colour" name="catagory" placeholder="Write catagory name">
                <input type="submit" class="btn btn-primary" name="submit" value="Add Catagory">
            </form>
        </div>
        <table class="center">
            <tr>
                <td>Catagory name</td>
                <td>Action</td>
            </tr>
            @foreach ($data as $data)
                <tr>
                    <td>{{$data->catagory_name}}</td>
                    <td>
                        <a class="btn btn-danger btn-sm" href="{{ url('delete_catagory', $data->id) }}"
                            onclick="return confirm('Are you sure?');">
                            Delete
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>


@include('admin.script')
