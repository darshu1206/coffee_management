<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCoffeeController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminSupplierController;
use App\Http\Controllers\Admin\AdminUserController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Admin Authentication Routes (without middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Admin Protected Routes (with admin middleware)
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');
    
    // User Management
    Route::resource('users', AdminUserController::class);
    
    // Coffee Management
    Route::resource('coffees', AdminCoffeeController::class);
    
    // Category Management
    Route::resource('categories', AdminCategoryController::class);
    
    // Supplier Management
    Route::resource('suppliers', AdminSupplierController::class);
    
    // Order Management
    Route::resource('orders', AdminOrderController::class)->except(['create', 'store', 'edit', 'update']);
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');
     Route::get('/dashboard-redirect', function () {
        return redirect()->route('user.dashboard');
    })->name('dashboard');

    // Resource routes
    // Route::resource('coffees', CoffeeController::class);
    // Route::resource('orders', OrderController::class);
    // Route::resource('customers', CustomerController::class);
    // Route::resource('suppliers', SupplierController::class);
    // Route::resource('categories', CategoryController::class);
    
    // Profile routes
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])
        ->name('user.dashboard');
    
    // Home/Shop Routes
    Route::get('/', [UserDashboardController::class, 'home'])
        ->name('user.home');
    
    Route::get('/shop', [UserDashboardController::class, 'shop'])
        ->name('user.shop');
    
    Route::get('/product/{id}', [UserDashboardController::class, 'productDetail'])
        ->name('user.product.detail');
    
    // Order Routes
    Route::get('/orders', [UserDashboardController::class, 'orderHistory'])
        ->name('user.orders');
    
    Route::get('/orders/{id}', [UserDashboardController::class, 'orderDetail'])
        ->name('user.order.detail');
    
    // Profile Route
    Route::get('/profile', [UserDashboardController::class, 'profile'])
        ->name('user.profile');
    
    // Static Pages
    Route::get('/about-us', [UserDashboardController::class, 'aboutUs'])
        ->name('user.about');
    
    Route::get('/contact-us', [UserDashboardController::class, 'contactUs'])
        ->name('user.contact');
    
    Route::post('/contact-us', [UserDashboardController::class, 'submitContact'])
        ->name('user.contact.submit');
    
    // Cart Routes (you might want to create a separate CartController)
    Route::get('/cart', [CartController::class, 'index'])
        ->name('user.cart');
    
    Route::post('/cart/add', [CartController::class, 'add'])
        ->name('user.cart.add');

    Route::get('/cart/count', [CartController::class, 'getCartCount'])
        ->name('user.cart.count');

    Route::put('/cart/update/{id}', [CartController::class, 'update'])
        ->name('user.cart.update');
    
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])
        ->name('user.cart.remove');
    
    Route::get('/checkout', [CartController::class, 'checkout'])
        ->name('user.checkout');
    
    Route::post('/checkout/process', [OrderController::class, 'processOrder'])
        ->name('user.checkout.process');

});

// Public routes (accessible without login)
// Route::get('/public/shop', [UserDashboardController::class, 'shop'])
//     ->name('public.shop');

// Route::get('/public/product/{id}', [UserDashboardController::class, 'productDetail'])
//     ->name('public.product.detail');

// Route::get('/public/about-us', [UserDashboardController::class, 'aboutUs'])
//     ->name('public.about');

// Route::get('/public/contact-us', [UserDashboardController::class, 'contactUs'])
//     ->name('public.contact');

require __DIR__.'/auth.php';
