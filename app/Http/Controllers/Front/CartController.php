<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function add($id){
        $product = Product::findOrFail($id);

        Cart::add([
            'id'=> $id,
            'name'=> $product->name,
            'qty'=> 1,
            'price'=> $product->discount ?? $product->price,
            'weight'=> $product->weight ?? 0,
            'options'=> [
                'images'=> $product->productImages,
            ],

        ]);

        // dd(Cart:: content());
        return back();

    }
    //
}
