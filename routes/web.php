<?php

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ShopController;
use Illuminate\Support\Facades\Route;



// Route::get('/', function () {
// //   return view('front.index');
//     return \App\Models\Product::find(1)->productImages;
// });


//trang index
Route::get('/', [HomeController::class, 'index']);



Route::prefix('shop')->group(function () {

    //trang hien thi ttsp
    Route::get('/product/{id}', [ShopController::class, 'show']);

    Route::post('/product/{id}', [ShopController::class, 'postComment']);

    // danh sach sp

    Route::get('/', [ShopController::class, 'index']);

    Route::get('/{categoryName}', [ShopController::class, 'category']);


});

Route::prefix('cart')->group(function(){
    Route::get('add/{id}',[CartController::class, 'add']);







});
