<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\OrderController;




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


route::get('redirect',[HomeController::class,'redirect'])->middleware('auth','verified');


//welcome page
route::get('/',[HomeController::class,'index']);


route::get('/view_catagory',[AdminController::class,'view_catagory']);

route::post('/add_catagory',[AdminController::class,'add_catagory']);

route::get('/delete_catagory/{id}',[AdminController::class,'delete_catagory']);



route::get('/view_products',[AdminController::class,'view_products']);

route::post('/add_product',[AdminController::class,'add_product']);

route::get('/show_products',[AdminController::class,'show_products']);

route::get('/delete_product/{id}',[AdminController::class,'delete_product']);

route::get('/update_product/{id}',[AdminController::class,'update_product']);

route::post('/update_product_confirm/{id}', [AdminController::class,'update_product_confirm']);

route::get('/order', [AdminController::class,'order']);
Route::post('/order/update-status/{id}', [AdminController::class, 'updateOrderStatus'])->name('order.updateStatus');
Route::get('/order/invoice/{id}', [AdminController::class, 'downloadOrderInvoice'])->name('order.downloadInvoice');
Route::get('/order/send-email/{id}', [AdminController::class, 'showSendEmailForm'])->name('order.showSendEmailForm');
Route::post('/order/send-mail/{id}', [AdminController::class, 'sendOrderMail'])->name('order.sendMail');


route::get('/search', [AdminController::class,'searchdata']);




route::get('/product_details/{id}',[HomeController::class,'product_details']);

route::post('/add_cart/{id}',[HomeController::class,'add_cart']);

route::get('/show_cart',[HomeController::class,'show_cart'])->name('show_cart');

Route::post('/remove_cart/{id}', [HomeController::class, 'remove_cart'])->name('remove_cart');

route::get('/cash_order',[HomeController::class,'cash_order']);

Route::get('/checkout', [HomeController::class, 'checkout']);
Route::post('/place_order', [HomeController::class, 'place_order'])->name('place_order');


route::get('/show_order',[HomeController::class,'show_order']);

route::get('/cancel_order/{id}',[HomeController::class,'cancel_order']);
