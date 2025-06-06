<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Web\ProductsController; // Consistent capitalization
// use App\Http\Controllers\Web\UsersController;
// use App\Http\Controllers\Web\SellerController;


// Route::get('/', function () {
//     return view('welcome');
// });



// Route::get('register', [UsersController::class, 'register'])->name('register');
// Route::post('do_Register', [UsersController::class, 'doRegister'])->name('do_register');
// Route::get('login', [UsersController::class, 'login'])->name('login');
// Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
// Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');

// Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');

// Route::middleware(['auth'])->group(function () {
//     // Users routes
//     Route::get('/users', [UsersController::class, 'manageUsers'])->name('users.manage');
//     Route::post('/users/store', [UsersController::class, 'store'])->name('users.store');
//     Route::post('/users/update', [UsersController::class, 'update'])->name('users.update');
//     Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

//     // Products routes
//     Route::get('/products', [ProductsController::class, 'index'])->name('products_list');
//     Route::post('/products/add-to-cart', [ProductsController::class, 'addToCart'])->middleware('auth')->name('products.addToCart');
//     Route::get('/cart', [ProductsController::class, 'viewCart'])->name('cart.view');
//     Route::delete('/cart/remove/{id}', [ProductsController::class, 'removeFromCart'])->name('cart.remove');
//     Route::post('/cart/update-quantity/{id}', [ProductsController::class, 'updateCartQuantity'])->name('cart.updateQuantity');
//     Route::get('/checkout', [ProductsController::class, 'viewCheckout'])->name('checkout.view');
//     Route::post('/checkout', [ProductsController::class, 'placeOrder'])->name('checkout.placeOrder');
//     Route::get('/orders', [ProductsController::class, 'viewOrders'])->name('orders.view');


// });



// Route::group(['middleware' => 'auth'], function () {
//     Route::get('seller/manage', [SellerController::class, 'manage'])->name('seller.manage');
//     Route::post('seller/manage', [SellerController::class, 'store'])->name('seller.manage');
//     Route::put('seller/manage', [SellerController::class, 'update'])->name('seller.manage');
//     Route::delete('seller/manage', [SellerController::class, 'destroy'])->name('seller.manage');
//     Route::get('products', [ProductsController::class, 'index'])->name('products.index');
// });

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\SellerController;
use App\Http\Controllers\Web\EmployeeController;
use App\Http\Controllers\Web\SpatieController;

Route::get('/', [UsersController::class, 'welcomePage'])->name('welcome');

// Registration and Authentication routes
Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('do_Register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');

// email verification route
Route::get('verify', [UsersController::class, 'verify'])->name('verify');
Route::post('resend-verification', [UsersController::class, 'resendVerificationEmail'])->name('resend.verification');

// Google login routes
Route::get('/auth/google',[UsersController::class, 'redirectToGoogle'])->name('login_with_google');
Route::get('/auth/google/callback',[UsersController::class, 'handleGoogleCallback']);

// Microsoft login routes
Route::get('/auth/microsoft', [UsersController::class, 'redirectToMicrosoft'])->name('login_with_microsoft');
Route::get('/auth/microsoft/callback', [UsersController::class, 'handleMicrosoftCallback']);

// Password reset routes
Route::get('password/forgot', [UsersController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('password/email', [UsersController::class, 'sendResetPassword'])->name('password.email');
Route::get('/password/change', [UsersController::class, 'showChangePasswordForm'])->name('password.change');
Route::post('/password/change', [UsersController::class, 'updatePassword'])->name('password.update');

// Banned 
Route::get('banned', function () {
    return view('users.banned');
})->name('banned_page');

Route::middleware(['auth'])->group(function () {
    // Users routes

    Route::post('/users/store', [UsersController::class, 'store'])->name('users.store');
    Route::post('/users/update', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

    // Products routes
    Route::get('/products', [ProductsController::class, 'index'])->name('products_list');
    Route::post('/products/add-to-cart', [ProductsController::class, 'addToCart'])->middleware('auth')->name('products.addToCart');
    Route::get('/cart', [ProductsController::class, 'viewCart'])->name('cart.view');
    Route::delete('/cart/remove/{id}', [ProductsController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/update-quantity/{id}', [ProductsController::class, 'updateCartQuantity'])->name('cart.updateQuantity');
    Route::get('/checkout', [ProductsController::class, 'viewCheckout'])->name('checkout.view');
    Route::post('/checkout', [ProductsController::class, 'placeOrder'])->name('checkout.placeOrder');
    Route::get('/orders', [ProductsController::class, 'viewOrders'])->name('orders.view');

    // Order return request
    Route::post('/order/request-return/{orderItem}', [ProductsController::class, 'requestReturn'])->name('order.requestReturn');
    // Order cancel
    Route::post('/order/cancel/{order}', [ProductsController::class, 'cancelOrder'])->name('order.cancel');

    // Seller routes
    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
    Route::match(['get', 'post', 'put', 'delete'], '/seller/manage', [SellerController::class, 'manage'])->name('seller.manage');

    // Employee management routes (NO role middleware)
    Route::get('/employee/manage-seller', [EmployeeController::class, 'manageSellers'])->name('employee.manage_seller');
    Route::post('/employee/seller/{id}/activate', [EmployeeController::class, 'activateSeller'])->name('employee.sellers.activate');
    Route::post('/employee/seller/{id}/deactivate', [EmployeeController::class, 'deactivateSeller'])->name('employee.sellers.deactivate');
    Route::get('/employee/manage-orders', [EmployeeController::class, 'manageOrders'])->name('employee.manage_orders');
    Route::post('/employee/orders/{id}/accept', [EmployeeController::class, 'acceptOrder'])->name('employee.orders.accept');
    Route::post('/employee/orders/{id}/cancel', [EmployeeController::class, 'cancelOrder'])->name('employee.orders.cancel');

    // Product approval routes
    Route::post('/employee/products/{id}/approve', [EmployeeController::class, 'approveProduct'])->name('employee.products.approve');
    Route::post('/employee/products/{id}/deny', [EmployeeController::class, 'denyProduct'])->name('employee.products.deny');

    // Put product on hold
    Route::post('/employee/product/{id}/hold', [EmployeeController::class, 'holdProduct'])->name('employee.products.hold');
    // Delete product (only if on hold)
    Route::delete('/employee/product/{id}/delete', [EmployeeController::class, 'deleteProduct'])->name('employee.products.delete');
    // Resume (approve) product from hold
    Route::post('/employee/products/{id}/resume', [EmployeeController::class, 'resumeProduct'])->name('employee.products.resume');

    // Manager routes
    Route::get('/users', [UsersController::class, 'manageUsers'])->name('users.manage');
    Route::get('/manager/dashboard', [UsersController::class, 'dashboard'])->name('manager.dashboard');

    // Admin routes
    Route::get('/admin/roles-permissions', [SpatieController::class, 'manage'])->name('spatie.manage');
    Route::post('/admin/roles/add', [SpatieController::class, 'addRole'])->name('spatie.addrole');
    Route::post('/admin/roles/edit', [SpatieController::class, 'editRole'])->name('spatie.editrole');
    Route::post('/admin/permissions/add', [SpatieController::class, 'addPermission'])->name('spatie.addpermission');
    Route::post('/admin/permissions/edit', [SpatieController::class, 'editPermission'])->name('spatie.editpermission');
    Route::post('/admin/assign-permission', [SpatieController::class, 'assignPermission'])->name('spatie.assignpermission');
    Route::post('/admin/assign-role', [SpatieController::class, 'assignRole'])->name('spatie.assignrole');
    Route::post('/admin/roles/delete', [SpatieController::class, 'deleteRole'])->name('spatie.deleterole');
    Route::post('/admin/permissions/delete', [SpatieController::class, 'deletePermission'])->name('spatie.deletepermission');

    // Employee: Approve/Deny return requests
    Route::post('/order/approve-return/{orderItem}', [ProductsController::class, 'approveReturnRequest'])->name('order.approveReturn');
    Route::post('/order/deny-return/{orderItem}', [ProductsController::class, 'denyReturnRequest'])->name('order.denyReturn');

});
