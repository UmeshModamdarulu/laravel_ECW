<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;

use App\Models\User;

class HomeController extends Controller
{
    public function redirect()
    {
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;

            if ($usertype == '1') {
                $total_products = Product::all()->count();
                $total_orders = Order::all()->count();
                $total_users = User::all()->count();
                $order = order::all();
                $total_revenue = 0;
                foreach ($order as $order) {
                    $total_revenue = $total_revenue + $order->price;
                }

                $total_delivered_order = Order::where('delivery_status', '=', 'delivered')->get()->count();

                $total_processing_order = Order::where('delivery_status', '=', 'processing')->get()->count();

                return view('admin.home', compact('total_products', 'total_orders', 'total_users', 'total_revenue', 'total_delivered_order', 'total_processing_order'));
            } else {
                $products = Product::paginate(3);
                return view('home.userpage', compact('products'));
            }
        } else {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }
    }

    public function index()
    {
        $products = Product::paginate(3);
        return view('home.userpage', compact('products'));
    }


    public function product_details($id)
    {
        $product = product::find($id);

        return view('home.product_details', compact('product'));
    }

    public function add_cart(Request $request, $id)
    {
        if (Auth::id()) {

            $user = Auth::user();
            $product = Product::find($id);
            $cart = new cart();
            $cart->name = $user->name;
            $cart->email = $user->email;
            $cart->phone = $user->phone;
            $cart->address = $user->address;

            $cart->product_title = $product->title;
            $cart->price = $product->discount_price != null ? $product->discount_price : $product->price;
            $cart->quantity = $request->quantity;
            $cart->image = $product->image;
            $cart->Product_id = $product->id;
            $cart->user_id = $user->id;

            $cart->save();

            return redirect()->back()->with('success', 'Product added to cart!');
        } else {
            return redirect('login');
        }
    }



    public function show_cart()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $cart_items = Cart::where('user_id', $user->id)->get();

            return view('home.showcart', compact('cart_items'));
        } else {
            return redirect('login');
        }
    }


    public function remove_cart($id)
    {
        $cart = cart::find($id);
        $cart->delete();
        return redirect()->back()->with('message', 'Product removed Successfully from Cart');
    }


    public function cash_order()
    {
        $user = Auth::user();
        $userid = $user->id;

        // Get all cart items for the user
        $cartItems = Cart::where('user_id', $userid)->get();

        // Loop through each cart item and create an order
        foreach ($cartItems as $item) {
            $order = new Order;

            $order->name = $item->name;
            $order->email = $item->email;
            $order->phone = $item->phone;
            $order->address = $item->address;
            $order->user_id = $item->user_id;

            $order->product_title = $item->product_title;
            $order->quantity = $item->quantity;
            $order->price = $item->price;
            $order->image = $item->image;
            $order->product_id = $item->Product_id;

            $order->payment_status = 'cash on delivery';
            $order->delivery_status = 'processing';

            $order->save();

            // If you want to delete each cart item after saving:
            $cart = Cart::find($item->id);
            if ($cart) {
                $cart->delete();
            }
        }

        return redirect()->back()->with('message', 'Order placed successfully with Cash on Delivery!');
    }


    public function checkout()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $cart_items = Cart::where('user_id', $user->id)->get();
            $razorpayKey = config('services.razorpay.key');
            return view('home.checkout', compact('cart_items', 'razorpayKey'));
        } else {
            return redirect('login');
        }
    }

    public function place_order(Request $request)
    {
        if (!Auth::id()) {
            return redirect('login');
        }
        $user = Auth::user();
        $userid = $user->id;

        // Calculate total amount (subtotal + shipping)
        $cartItems = Cart::where('user_id', $userid)->get();
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->price * $item->quantity;
        }
        $shipping_cost = 50.00;
        $total_amount = $subtotal + $shipping_cost;

        // Store payment record
        Payment::create([
            'user_id' => $userid,
            'razorpay_payment_id' => $request->razorpay_payment_id ?? null,
            'amount' => $total_amount,
            'status' => 'success',
        ]);

        foreach ($cartItems as $item) {
            $order = new Order;
            $order->name = $item->name;
            $order->email = $item->email;
            $order->phone = $item->phone;
            $order->address = $item->address;
            $order->user_id = $item->user_id;
            $order->product_title = $item->product_title;
            $order->quantity = $item->quantity;
            $order->price = $item->price;
            $order->image = $item->image;
            $order->product_id = $item->Product_id;
            $order->payment_status = 'Paid via Razorpay';
            $order->delivery_status = 'processing';
            $order->save();
            // Delete cart item
            $cart = Cart::find($item->id);
            if ($cart) {
                $cart->delete();
            }
        }
        // Redirect to cart page with a success message (absolute URL)
        return redirect(url('/show_cart'))->with('message', 'Payment successful! Your order has been placed.');
    }


    public function show_order()
    {
        if (Auth::id()) {

            $user = Auth::user();
            $user_id = $user->id;
            $cart_items = Order::where('user_id', $user_id)->get();

            return view('home.order', compact('cart_items'));
        } else {
            return view('login');
        }
    }


    public function cancel_order($id){
        $order = order::find($id);
        $order->delivery_status = 'You cancel the order';
        $order->save();
        return redirect()->back();
    }
}
