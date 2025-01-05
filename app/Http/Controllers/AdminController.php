<?php

namespace App\Http\Controllers;

use App\Models\Catagory;
use App\Models\Product;
use App\Models\Order;

use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\PDF;

use Illuminate\Notifications\Notification;
use App\Notifications\SendEmailNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    // list categories
    public function view_catagory()
    {
        if (Auth::id()) {
            $catagories = Catagory::all();
            return view('admin.view_catagory', compact('catagories'));
        } else {
            return redirect('login');
        }
    }

    public function add_catagory(Request $request)
    {
        if (Auth::id()) {
            $catagory = new Catagory();
            $catagory->catagory_name = $request->catagory_name;
            $catagory->save();
            return redirect()->back()->with('success', 'Catagory added successfully');
        } else {
            return redirect('login');
        }
    }

    // this is for deleting categories
    public function delete_catagory($id)
    {
        if (Auth::id()) {
            $catagory = Catagory::find($id);
            $catagory->delete();
            return redirect()->back()->with('success', 'Catagory deleted successfully');
        } else {
            return redirect('login');
        }
    }


    // this is for the product
    public function view_product()
    {
        if (Auth::id()) {
            $catagories = Catagory::all();
            return view('admin.view_product', compact('catagories'));
        } else {
            return redirect('login');
        }
    }

    // this is for adding products

    public function add_product(Request $request)
    {
        if (Auth::id()) {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'catagory_name' => 'required|exists:catagories,id',
                'quantity' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $product = new Product();
            $product->title = $request->title;
            $product->description = $request->description;
            $product->catagory = $request->catagory_name;
            $product->quantity = $request->quantity;
            $product->price = $request->price;
            $product->discount_price = $request->discount_price;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $imageName);
                $product->image = $imageName;
            }

            $product->save();

            return redirect()->back()->with('success', 'Product added successfully');
        } else {
            return redirect('login');
        }
    }


    // this is for showing the product
    public function show_product()
    {
        if (Auth::id()) {
            $products = Product::all();
            return view('admin.show_product', compact('products'));
        } else {
            return redirect('login');
        }
    }

    // this is for deleting the product
    public function delete_product($id)
    {
        if (Auth::id()) {
            $product = Product::find($id);
            $product->delete();
            return redirect()->back()->with('success', 'Product deleted successfully');
        } else {
            return redirect('login');
        }
    }

    // this is for updating the product
    public function edit_product($id)
    {
        if (Auth::id()) {
            $product = Product::find($id);
            $catagories = Catagory::all();
            return view('admin.update_product', compact('product', 'catagories'));
        } else {
            return redirect('login');
        }
    }

    // this is for updating the product
    public function update_product(Request $request, $id)
    {
        if (Auth::id()) {
            // Validate the input fields
            $request->validate([
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'catagory_name' => 'nullable|exists:catagories,id',
                'quantity' => 'nullable|integer|min:1',
                'price' => 'nullable|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Find the product by its ID
            $product = Product::find($id);

            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }

            // Update fields only if provided
            if ($request->filled('title')) {
                $product->title = $request->title;
            }

            if ($request->filled('description')) {
                $product->description = $request->description;
            }

            if ($request->filled('catagory_name')) {
                $product->catagory = $request->catagory_name;
            }

            if ($request->filled('quantity')) {
                $product->quantity = $request->quantity;
            }

            if ($request->filled('price')) {
                $product->price = $request->price;
            }

            if ($request->filled('discount_price')) {
                $product->discount_price = $request->discount_price;
            }

            // Handle image upload only if a new image is provided
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Delete the old image
                if ($product->image) {
                    File::delete(public_path('uploads/products/' . $product->image));
                }

                // Save the new image
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $imageName);

                // Update the product's image field
                $product->image = $imageName;
            }

            // Save the updated product
            $product->save();

            return redirect()->back()->with('success', 'Product updated successfully');
        } else {
            return redirect('login');
        }
    }


    // this is for showing the order
    public function show_order()
    {
        if (Auth::id()) {
            $orders = Order::all();
            return view('admin.show_order', compact('orders'));
        } else {
            return redirect('login');
        }
    }

    // this is for the delivered
    public function delivered($id)
    {
        if (Auth::id()) {
            $order = Order::find($id);
            $order->delivery_status = 'Delivered';
            $order->payment_status = 'Paid';

            $order->save();

            return redirect()->back()->with('success', 'Order delivered successfully');
        } else {
            return redirect('login');
        }
    }

    // this is for the searched
    public function searchdata(Request $request)
    {
        if (Auth::id()) {
            $searchText = $request->search;
            $orders = Order::where('name', 'LIKE', "%$searchText%")->get();
            return view('admin.show_order', compact('orders'));
        } else {
            return redirect('login');
        }
    }

    // this is for the deliverd 
    public function generate_pdf($id)
    {
        if (Auth::id()) {
            // Find the order by ID
            $order = Order::find($id);

            // Check if the order exists
            if (!$order) {
                return abort(404, 'Order not found.');
            }

            // Set the title and date variables
            $title = "Order Details for #{$id}";
            $date = now()->format('F d, Y'); // Format the date to your preference

            // Instantiate the PDF class
            $pdf = app(PDF::class);

            // Load the view and pass the necessary data
            $pdf = $pdf->loadView('admin.pdf', compact('order', 'title', 'date'));

            // Download the PDF
            return $pdf->download('order_detail.pdf');
        } else {
            return redirect('login');
        }
    }


    // there is issues in the following
    // see email to the order
    public function send_email($id)
    {
        if (Auth::id()) {
            $order = Order::find($id);
            return view('admin.send-email', compact('order'));
        } else {
            return redirect('login');
        }
    }

    // send send_user_email to different users
    public function send_user_email(Request $request, $id)
    {
        if (Auth::id()) {
            $order = Order::find($id);
            if (!$order || !$order->user) {
                return redirect()->back()->with('error', 'Order or associated user not found.');
            }

            $details = [
                'greeting' => $request->emailGreeting,
                'firstline' => $request->emailFirstLine,
                'body' => $request->emailBody,
                'button' => $request->emailButtonName,
                'url' => $request->emailLink,
                'lastline' => $request->emailLastLine,
            ];

            // Notification::send($order->user, new SendEmailNotification($details));

            return redirect()->back()->with('success', 'Email sent successfully.');
        } else {
            return redirect('login');
        }
    }
}
