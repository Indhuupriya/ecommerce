<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserProfiles;
use App\Http\Controllers\PayPalController;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $products = Product::all();
    $cartItems = Cart::where('user_id', Auth::id())->get();
    return view('welcome', compact('products','cartItems'));
})->name('/');


Route::post('/register', [RegistrationController::class, 'register'])->name('register'); 
Route::post('/login', [RegistrationController::class, 'login'])->name('login');
Route::post('/forget-password', [RegistrationController::class, 'forget_password'])->name('forget-password');

Route::get('reset-password/{token}', [RegistrationController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [RegistrationController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::get('/logout', [RegistrationController::class, 'logout'])->name('logout');
Route::get('auth/google', [RegistrationController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [RegistrationController::class, 'handleGoogleCallback']);

Route::middleware(['auth:sanctum',  'role:Admin|SuperAdmin'])->get('/admin/dashboard', function () {
    return view('admin');
})->name('admin/dashboard');
// products routes
Route::middleware(['auth:sanctum', 'role:Admin|SuperAdmin'])
    ->get('/admin/products', [ProductController::class, 'index'])
    ->name('admin.products');

Route::middleware(['auth:sanctum', 'role:Admin|SuperAdmin'])
->get('/admin/create', [ProductController::class, 'create'])
->name('admin.create');

Route::middleware(['auth:sanctum', 'role:Admin|SuperAdmin'])
    ->post('/admin/store', [ProductController::class, 'store'])
    ->name('admin.store');

Route::middleware(['auth:sanctum', 'role:Admin|SuperAdmin'])
    ->get('/admin/{id}/edit', [ProductController::class, 'edit'])
    ->name('admin.edit');

Route::middleware(['auth:sanctum', 'role:Admin|SuperAdmin'])
    ->post('/admin/{id}/update', [ProductController::class, 'update'])
    ->name('admin.update');

Route::middleware(['auth:sanctum', 'role:Admin|SuperAdmin'])
    ->get('/admin/{id}/delete', [ProductController::class, 'destroy'])
    ->name('admin.delete');

//orders

Route::middleware(['auth:sanctum', 'role:Admin|SuperAdmin'])
    ->get('/admin/orders', [OrderController::class, 'index'])
    ->name('admin.orders');

Route::middleware(['auth:sanctum', 'role:Admin|SuperAdmin'])
    ->get('/admin/orders/{id}/invoice', [OrderController::class, 'showInvoice'])
    ->name('admin.orders.invoice');

Route::middleware(['auth:sanctum', 'role:Admin|SuperAdmin'])
    ->post('/admin/orders/update-status', [OrderController::class, 'updateStatus'])
    ->name('admin.orders.updateStatus');

//settings
Route::middleware(['auth:sanctum', 'role:Admin|SuperAdmin'])->group(function () {
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.updateSettings');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/profile', [AdminController::class, 'updateprofile'])->name('admin.updateprofile');
});


// Checkout routes
Route::middleware(['auth:sanctum','role:User'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/save-address', [CheckoutController::class, 'saveAddress'])->name('checkout.saveAddress');
    Route::get('/checkout/payment', [CheckoutController::class, 'showPaymentPage'])->name('checkout.payment');
    Route::post('/checkout/process-payment', [CheckoutController::class, 'processPayment'])->name('checkout.processPayment');
    Route::post('/checkout/stripePost', [CheckoutController::class, 'stripePost'])->name('stripe.post');
    Route::get('/orders/{order}/invoice', [CheckoutController::class, 'downloadInvoice'])->name('download.invoice');

    Route::get('paypal', [PayPalController::class, 'index'])->name('paypal');
    Route::get('paypal/payment', [PayPalController::class, 'payment'])->name('paypal.payment');
    Route::get('paypal/payment/success', [PayPalController::class, 'paymentSuccess'])->name('paypal.payment.success');
    Route::get('paypal/payment/cancel', [PayPalController::class, 'paymentCancel'])->name('paypal.payment.cancel');

});
Route::middleware(['auth:sanctum','role:User'])->group(function () {
    Route::get('myaccount',[UserProfiles::class,'index'])->name('myaccount');
    Route::post('update_profile',[UserProfiles::class,'update']); 
    Route::get('/change-password', [UserProfiles::class,'change_password'])->name('password.change');
    Route::post('/change-password', [UserProfiles::class,'update_password']);
    Route::get('/myaccount/add_address', [UserProfiles::class,'add_new_address'])->name('add_address');
    Route::post('/myaccount/add_address', [UserProfiles::class,'add_address']);
});

Route::middleware(['auth:sanctum','role:User'])->group(function () {
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist'); 
});

Route::get('/product/{product_id}', [ProductController::class, 'show'])->name('product.details');
