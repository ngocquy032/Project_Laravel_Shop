<?php

use App\Http\Controllers\Front\AccountController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckOutController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ShopController;

use Illuminate\Support\Facades\Route;



// Route::get('/', function () {
// //   return view('front.index');
//     return \App\Models\Product::find(1)->productImages;
// });


// Route::get('/', function (\App\Service\Product\ProductServiceInterface $productService){
//     return $productService->find(1);
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
   Route::get('/', [CartController::class , 'index']);
   Route::get('delete/{rowId}', [CartController::class, 'delete']);
   Route::get('/destroy', [CartController::class, 'destroy']);
   Route::get('/update', [CartController::class, 'update']);

});

Route::prefix('checkout')->group(function(){
   Route::get('/',[CheckOutController::class, 'index']);
   Route::post('/',[CheckOutController::class, 'addOrder']);
   Route::get('/vnPayCheck',[CheckOutController::class, 'vnPayCheck']);
   Route::get('/result',[CheckOutController::class, 'result']);

});


Route::prefix('account')->group(function(){
   Route::get('login', [AccountController::class, 'login']);
   Route::post('login', [AccountController::class, 'checkLogin']);

   Route::get('logout', [AccountController::class, 'logout']);

   Route::get('register', [AccountController::class, 'register']);

   Route::post('register', [AccountController::class, 'postRegister']);

   Route::prefix('my-order')->group(function(){
        Route::get('/', [AccountController::class, 'myOrderIndex']);
        Route::get('{id}', [AccountController::class, 'myOrderShow']);

   });


});

