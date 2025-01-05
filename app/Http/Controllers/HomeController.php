<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\Cart;
use App\Models\Catagory;
use App\Models\Order;

use Illuminate\Support\Facades\Session;

use Stripe;

use App\Models\Comment;

use App\Models\Reply;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{


    public function index()
    {
        $products = Product::paginate(6);
        $comments = Comment::all();
        $replies = Reply::all();
        return view('home.user', compact('products', 'comments', 'replies'));
    }
    public function redirect()
    {

        $userType = Auth::user()->userType;

        if ($userType == '1') {

            $total_products = Product::all()->count();
            $total_orders = Order::all()->count();
            $total_users = User::all()->count();
            $total_revenue = 0;
            foreach (Order::all() as $order) {
                $total_revenue += $order->price;
            }
            $total_delivered = Order::where('delivery_status', '=', 'Delivered')->count();
            $total_processing = Order::where('delivery_status', '=', 'processing')->count();
            return view('admin.home', compact('total_products', 'total_orders', 'total_users', 'total_revenue', 'total_delivered', 'total_processing'));
        } else {

            $products = Product::paginate(6);
            $comments = Comment::all();
            $replies = Reply::all();
            return view('home.user', compact('products', 'comments', 'replies'));
        }
    }

    // this is for the products_details
    public function products_details($id)
    {
        $products = Product::find($id);
        return view('home.products_details', compact('products'));
    }


    // this is for the add_to_cart
    public function add_cart(Request $request, $id)
    {

        if (Auth::id()) {

            $user = Auth::user();
            $userId = $user->id;

            $product = Product::find($id);

            $product_exist_id = Cart::where('product_id', '=', $id)->where('user_id', '=', $userId)->first();

            // $cart = new Cart();
            if ($product_exist_id) {
                $cart = Cart::find($product_exist_id)->first();
                $cart->quantity += $request->quantity;
                if ($product->discount_price != null) {
                    $cart->price = $product->discount_price * $request->quantity;
                } else {

                    $cart->price = $product->price * $request->quantity;
                }
                $cart->save();
                return redirect()->back();
            } else {
                $cart = new Cart();
                $cart->name = $user->name;
                $cart->email = $user->email;
                $cart->phone = $user->phone;
                $cart->address = $user->address;
                $cart->user_id = $user->id;

                $cart->product_title = $product->title;

                if ($product->discount_price != null) {
                    $cart->price = $product->discount_price * $request->quantity;
                } else {

                    $cart->price = $product->price * $request->quantity;
                }

                $cart->image = $product->image;
                $cart->product_id = $product->id;

                // this is from cart quantity
                $cart->quantity = $request->quantity;
                $cart->save();
                return redirect()->back()->with('success', 'product added successfully');
            }
        } else {
            return redirect('login');
        }
    }

    // this is for the show_Cart method

    public function show_cart()
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $carts = Cart::where('user_id', '=', $id)->get();
            return view('home.show_cart', compact('carts'));
        } else {
            return redirect('login');
        }
    }

    // remove the cart
    public function remove_cart($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        return redirect()->back()->with('success', 'Product removed successfully');
    }

    public function check_order()
    {
        $user = Auth::user();
        $userid = $user->id;

        $carts = Cart::where('user_id', '=', $userid)->get();

        foreach ($carts as $cart) {
            $order = new Order();

            $order->name = $cart->name;
            $order->email = $cart->email;
            $order->phone = $cart->phone;
            $order->address = $cart->address;
            $order->user_id = $cart->user_id;
            $order->product_title = $cart->product_title;
            $order->price = $cart->price;
            $order->quantity = $cart->quantity;
            $order->image = $cart->image;
            $order->product_id = $cart->product_id;

            $order->payment_status = 'cash on delivery';
            $order->delivery_status = 'processing';
            $order->save();

            // after placing order delete cart items
            // $cart_id = $order->id;
            // $cart = Cart::find($cart_id);
            $cart->delete();
        }

        return redirect()->back()->with('success', 'Your order has been successfully processed, please wait for your order to be processed');
    }

    // this is for the payment via card stripe service
    public function stripe($totalprice)
    {
        $user = Auth::user();
        $userid = $user->id;

        // Fetch the cart items for the logged-in user
        $carts = Cart::where('user_id', $userid)->get();

        return view('home.stripe', compact('carts', 'totalprice'));
        // return view('home.stripe', compact('totalprice'));
    }

    public function stripePost(Request $request, $totalprice)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create([
            "amount" => $totalprice * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Thanks For The Payment."
        ]);

        $user = Auth::user();
        $userid = $user->id;

        $carts = Cart::where('user_id', '=', $userid)->get();

        foreach ($carts as $cart) {
            $order = new Order();

            $order->name = $cart->name;
            $order->email = $cart->email;
            $order->phone = $cart->phone;
            $order->address = $cart->address;
            $order->user_id = $cart->user_id;
            $order->product_title = $cart->product_title;
            $order->price = $cart->price;
            $order->quantity = $cart->quantity;
            $order->image = $cart->image;
            $order->product_id = $cart->product_id;

            $order->payment_status = 'cash on delivery';
            $order->delivery_status = 'processing';
            $order->save();

            // after placing order delete cart items
            // $cart_id = $order->id;
            // $cart = Cart::find($cart_id);
            $cart->delete();
        }

        Session::flash('success', 'Payment successful!');
        return back();
    }

    public function order()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userId = $user->id;
            $orders = Order::where('user_id', '=', $userId)->get();
            return view('home.order', compact('orders'));
        } else {
            return redirect('login');
        }
    }

    // this is for the home.header.blade.php order in the menu
    public function cancel_order($id)
    {
        $order = Order::find($id);
        $order->delivery_status = "Order Canceled";
        $order->save();
        return redirect()->back()->with('success', 'Order has been canceled successfully');
    }

    // this is for the comments
    public function add_comment(Request $request)
    {
        if (Auth::id()) {
            $comment = new Comment;
            $comment->name = Auth::user()->name;
            $comment->user_id = Auth::user()->id;
            $comment->comment = $request->comment;

            $comment->save();
            return redirect()->back();
        } else {
            return redirect('login');
        }
    }

    // this is for the reply to the comments
    public function add_reply(Request $request)
    {
        if (Auth::id()) {
            $reply = new Reply;
            $reply->name = Auth::user()->name;
            $reply->user_id = Auth::user()->id;
            $reply->comment_id = $request->commentId;
            $reply->reply = $request->reply;

            $reply->save();
            return redirect()->back();
        } else {
            return redirect('login');
        }
    }

    // this is for the search functionality
    public function search_product(Request $request)
    {
        $comments = Comment::all();
        $replies = Reply::all();
        $searchText = $request->search;
        $products = Product::where('title', 'LIKE', "%$searchText%")->paginate(6);
        return view('home.user', compact('products', 'comments', 'replies'));
    }

    // filter_by_category
    // public function filter_by_category($catagoryId)
    // {
    //     $catagories = Catagory::all();
    //     $products = Product::where('id', $catagoryId)->paginate(9);
    //     return view('home.product', compact('products', 'catagories'));
    // }
}
