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
use App\Http\Controllers\PageController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\WineProductController;
use App\Http\Controllers\HogProductController;
use App\Http\Controllers\CartNavController;
use App\Http\Controllers\IncubationAdminController;
use App\Models\WineProduct;

Route::get('/', function () { return view('welcome'); } );

Route::get("/login", [AuthController::class, "login"])->name('login');
Route::post("/login", [AuthController::class, "loginPost"])->name("login.post");

Route::get('/admin/login', [AdminController::class, 'tologin'])->name('admin.login');

Route::get('/admin/register', [AdminController::class, 'toregister'])->name('admin.register');
Route::post('/admin/register', [AnadminController::class, 'registerPost'])->name('admin.register');

Route::get("/register", [AuthController::class, "register"])->name('register');
Route::post("/register", [AuthController::class, "registerPost"])->name("register.post");

//Page Not Found
Route::get("/PageNotFound", [PageController::class, "Page404"])->name("page404");

//customer routes
Route::middleware("auth")->group(function(){
    Route::get("/contactUs", [ControllerName::class, "contactUs"])->name("contact");
    Route::post("contactUs", [ControllerName::class, "contactPost"])->name("contact.post");
    Route::get("aboutUs", [ControllerName::class, "aboutUs"])->name("about");
    //product_formation_
    Route::get('/home', [ProductController::class,'index'])->name('home');
    Route::get('/home/incubator', [ProductController::class,'incubator'])->name('home.incubator');
    //new modify
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/confirmation/{reference}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
    Route::get('/booking/status', [BookingController::class, 'status'])->name('booking.status');

    Route::get('/home/productformat/{product}', [ProductController::class,'show'])->name('customer.productformat');
    //My_Cart
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::delete('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('cart.remove');
    //Checkout
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    //new Products Wine
    Route::get('/wineproducts', [WineProductController::class, 'index'])->name('wine.home');
    Route::get('/home/wine/productformat/{product}', [WineProductController::class,'show'])->name('customer.wine.view');
    Route::post('/wine/add-to-cart', [WineProductController::class, 'addToCart'])->name('cart.add.wine');
    Route::delete('/wine/remove-from-cart', [WineProductController::class, 'removeFromCart'])->name('cart.remove.wine');

    //new Products Hog
    Route::get('/hogproducts', [HogProductController::class, 'index'])->name('hog.home');

    //cart Navigation
    Route::get('/cart/options/list', [CartNavController::class, 'CartOption'])->name('cart.options.list');
    Route::get('/cart/option/wine', [CartNavController::class, 'toWineCart'])->name('cart.wine.view');
    Route::get('/cart/option/hog', [CartNavController::class, 'toHogCart'])->name('cart.hog.view');
    Route::get('/FAQs', [CartNavController::class, 'toFAQ'])->name('question.page');
    Route::get('/Privacy-Policy', [CartNavController::class, 'toPrivacy'])->name('privacy-policy.page');
    
});

//admin routes
Route::middleware("auth")->group(function(){
    Route::get('/admin/dashboard', [AdminBillingController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout'); 

    //contact table
    Route::get("contactforlist", [ControllerName::class, "index"])->name("contactforlist");

    //personal
    Route::get('/admin/personal', [AnadminController::class, 'index'])->name('admin.personal');
    Route::get('/admin/personal/create', [AnadminController::class, 'create'])->name('admin.personal.create');
    Route::post('/admin/personal/store', [AnadminController::class, 'store'])->name('admin.personal.store');
    Route::delete('/admin/personal/{id}', [AnadminController::class, 'destroy'])->name('admin.personal.destroy');

    //hardware ESP32
    Route::get('/admin/hardware-esp32', [AdminController::class, 'toHardware'])->name('admin.hardware_esp32');
    Route::get('/admin/hardware-esp32/analytics', [AdminController::class, 'toHardwareAnalytics'])->name('admin.hardwareAnalytics');
    Route::get('/admin/hardware-esp32/history', [AdminController::class, 'toHardwareHistory'])->name('admin.hardwareHistory');
    Route::get('/admin/hardware-esp32/setting', [AdminController::class, 'toHardwareSetting'])->name('admin.hardwareSetting');
    Route::get('/admin/hardware-esp32/inventory', [AdminController::class, 'toHardwareInventory'])->name('admin.hardwareInventory');
   
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

    //expenses table
    Route::get('/admin/expenses', [ExpenseController::class, 'index'])->name('admin.expense.index');
    Route::get('/admin/expenses/create', [ExpenseController::class, 'create'])->name('admin.expense.create');
    Route::get('/admin/expenses/show{id}', [ExpenseController::class, 'show'])->name('admin.expense.show');
    Route::get('/admin/expenses/{id}', [ExpenseController::class, 'edit'])->name('admin.expense.edit');
    Route::post('/admin/expenses/store', [ExpenseController::class, 'store'])->name('admin.expense.store');
    Route::put('/admin/expenses/update/{id}', [ExpenseController::class, 'update'])->name('admin.expense.update');
    Route::delete('/admin/expenses/{id}', [ExpenseController::class, 'destroy'])->name('admin.expense.destroy');

    //incubation table
    Route::get('/admin/incubation-list', [IncubationAdminController::class, 'index'])->name('admin.incubation.index');   
     Route::resource('incubation', IncubationAdminController::class)->only([
        'index', 'show', 'edit', 'update'
    ]);
    
    Route::patch('/incubation/{id}/status', [IncubationAdminController::class, 'updateStatus'])->name('incubation.update-status');
    Route::post('/incubation/{id}/candling', [IncubationAdminController::class, 'recordCandling'])->name('incubation.record-candling');
    Route::post('/incubation/{id}/hatching', [IncubationAdminController::class, 'recordHatching'])->name('incubation.record-hatching');
    Route::get('/incubation-export', [IncubationAdminController::class, 'export'])->name('incubation.export');

});
