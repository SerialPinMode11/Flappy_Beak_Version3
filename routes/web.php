<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ControllerName;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminBillingController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AnadminController;

Route::get('/', function () { return view('welcome'); } );

Route::get("/login", [AuthController::class, "login"])->name('login');
Route::post("/login", [AuthController::class, "loginPost"])->name("login.post");

Route::get('/admin/login', [AdminController::class, 'tologin'])->name('admin.login');

Route::get('/admin/register', [AdminController::class, 'toregister'])->name('admin.register');
Route::post('/admin/register', [AnadminController::class, 'registerPost'])->name('admin.register');

Route::get("/register", [AuthController::class, "register"])->name('register');
Route::post("/register", [AuthController::class, "registerPost"])->name("register.post");

//customer routes
Route::middleware("auth")->group(function(){
    Route::get("/contactUs", [ControllerName::class, "contactUs"])->name("contact");
    Route::post("contactUs", [ControllerName::class, "contactPost"])->name("contact.post");
    Route::get("aboutUs", [ControllerName::class, "aboutUs"])->name("about");
    //product_formation_
    Route::get('/home', [ProductController::class,'index'])->name('home');
    Route::get('/home/productformat/{product}', [ProductController::class,'show'])->name('customer.productformat');
    //My_Cart
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::delete('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('cart.remove');
    //Checkout
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    
});

//admin routes
Route::middleware("auth")->group(function(){
    Route::get('/admin/dashboard', [AdminBillingController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout'); 

    //personal
    Route::get('/admin/personal', [AdminController::class, 'toPersonal'])->name('admin.personal');

    //hardware ESP32
    Route::get('/admin/hardware-esp32', [AdminController::class, 'toHardware'])->name('admin.hardware_esp32');
   
    //biling
    Route::get('/admin/billing', [AdminBillingController::class, 'index'])->name('admin.billing.index');
    Route::get('/admin/billing/{id}', [AdminBillingController::class, 'show'])->name('admin.billing.show');
    Route::get('/admin/billing/{id}/edit', [AdminBillingController::class, 'edit'])->name('admin.billing.edit');
    Route::put('/admin/billing/{id}', [AdminBillingController::class, 'update'])->name('admin.billing.update');
    //product list
    Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.product.index');
    Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{id}', [AdminProductController::class, 'show'])->name('admin.products.show');
    Route::get('/admin/products/{id}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
});
