<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// for the redirect of admin
Route::get('/redirect', [HomeController::class, 'redirect']);

// this is for view_catagory
Route::get('/view_catagory', [AdminController::class, 'view_catagory']);

// this is for adding catagory to database
Route::post('/add_catagory', [AdminController::class, 'add_catagory']);

// this is for deleting catagory from database
Route::delete('/delete_catagory/{id}', [AdminController::class, 'delete_catagory']);


// this is for the product
Route::get('/view_product', [AdminController::class, 'view_product']);
Route::post('/add_product', [AdminController::class, 'add_product']);

// for show products
Route::get('/show_product', [AdminController::class, 'show_product']);
// for delete products
Route::delete('/delete_product/{id}', [AdminController::class, 'delete_product']);

// this is for updating products
Route::get('/edit_product/{id}', [AdminController::class, 'edit_product']);
Route::post('/update_product/{id}', [AdminController::class, 'update_product']);

Route::get('show_order', [AdminController::class, 'show_order']);

Route::get('delivered/{id}', [AdminController::class, 'delivered']);

Route::get('pdf/{id}', [AdminController::class, 'generate_pdf']);

// send-email to customer just to check the page or laod
Route::get('/send-email/{id}', [AdminController::class, 'send_email']);

// this is for the send email to customer 
Route::post('/send_user_email/{id}', [AdminController::class, 'send_user_email']);

// this is for the search
Route::get('/search', [AdminController::class, 'searchdata']);





// this is for the products_details when someone clicks on a products_details
Route::get('/products_details/{id}', [HomeController::class, 'products_details']);

// this is for the add_cart when someone clicks on add_cart on the product
Route::post('/add_cart/{id}', [HomeController::class, 'add_cart']);

// this is for the show_cart when someone clicks on show_cart on the product
Route::get('/show_cart', [HomeController::class, 'show_cart']);

// this is for the remove_cart when someone clicks on
Route::get('/remove_cart/{id}', [HomeController::class, 'remove_cart']);

// this is for check_order
Route::get('/check_order', [HomeController::class, 'check_order']);

// this is for the payment via card
Route::get('/stripe/{totalprice}', [HomeController::class, 'stripe']);

Route::post('stripe/{totalprice}', [HomeController::class, 'stripePost'])->name('stripe.post');

// this is for the home.header.blade.php order in the menu
Route::get('/order', [HomeController::class, 'order']);
Route::get('/cancel_order/{id}', [HomeController::class, 'cancel_order']);

// this is for the comments
Route::post('/add_comment', [HomeController::class, 'add_comment']);
// this is for the replies
Route::post('/add_reply', [HomeController::class, 'add_reply']);
// this is for the search_product
Route::get('/search_product', [HomeController::class, 'search_product']);

// filter_by_category
// Route::get('/filter_by_category/{id}', [HomeController::class, 'filter_by_category']);