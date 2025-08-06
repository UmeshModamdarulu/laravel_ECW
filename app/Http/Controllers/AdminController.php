<?php

namespace App\Http\Controllers;

use App\Models\Catagory;
use App\Models\Product;
use App\Models\Order;


use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Mail\OrderStatusMail;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function view_catagory()
    {
        $data  = catagory::all();
        return view("admin.catagory", compact("data"));
    }

    public function add_catagory(Request $request)
    {
        $data = new Catagory();
        $data->catagory_name = $request->catagory;
        $data->save();
        return redirect()->back()->with("message", "Catagory Added Successfully");
    }

    public function delete_catagory($id)
    {
        $data = catagory::find($id);
        $data->delete();

        return redirect()->back()->with("message", "Catagory Deleted Successfully");
    }


    public function view_products()
    {
        $catagory = catagory::all();
        return view("admin.product", compact("catagory"));
    }

    public function add_product(Request $request)
    {
        $product = new product;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->quantity = $request->quantity;
        $product->catagory = $request->catagory;

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $image = $request->image;
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('product', $imagename);
            $product->image = $imagename;
        }


        $product->save();

        return redirect()->back()->with('message', 'Product added successfully!');
    }


    public function show_products()
    {
        $product = product::all();
        return view("admin.show_product", compact("product"));
    }


    public function delete_product($id)
    {
        $data = product::find($id);
        $data->delete();
        return redirect()->back()->with("message", "Catagory Deleted Successfully");
    }

    public function update_product($id)
    {
        $product = product::find($id);
        $catagory  = catagory::all();

        return view("admin.update_product", compact("product", "catagory"));
    }

    public function update_product_confirm(Request $request, $id)
    {
        $product = Product::find($id);

        $catagory = catagory::all();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->catagory = $request->catagory;
        $product->quantity = $request->quantity;

        if ($request->hasFile('image')) {
            $image = $request->image;
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('product'), $imagename);
            $product->image = $imagename;
        }

        $product->save();

        return redirect()->back()->with('message', 'Product updated successfully.');
    }

    public function order(Request $request)
    {
        $orders = Order::all();
        return view('admin.order', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'delivery_status' => 'required|in:processing,shipped,delivered',
        ]);

        $order = \App\Models\Order::findOrFail($id);
        $order->delivery_status = $request->delivery_status;
        $order->save();

        return redirect()->back()->with('message', 'Order status updated successfully!');
    }

    public function showSendEmailForm($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.send_email', compact('order'));
    }

    public function sendOrderMail(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $details = [
            'greeting' => $request->greeting,
            'firstline' => $request->firstline,
            'body' => $request->body,
            'button' => $request->button,
            'url' => $request->url,
            'lastline' => $request->lastline,
        ];

        Mail::to($order->email)->send(new OrderStatusMail($details));

        return redirect()->back()->with('message', 'Mail sent to user!');
    }
    public function searchdata(Request $request){
        $searchText = $request->search;
        $orders = Order::where('name','Like',"%$searchText%")->get();
        return view('admin.order',compact('orders'));
    }

    // public function downloadOrderInvoice($id)
    // {
    //     $order = Order::findOrFail($id);
    //     $pdf = PDF::loadView('admin.invoice', compact('order'));
    //     return $pdf->download('invoice_order_' . $order->id . '.pdf');
    // }
}
