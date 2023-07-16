<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    // ham goi view index
    public function index()
    {
        //luu db cua 2 ds sp lay du lieu
        $menProducts = Product::where('featured', true)->where('product_category_id', 1)->get();
        $womenProducts = Product::where('featured', true)->where('product_category_id', 2)->get();

        //lay danh sach 3 Blog moi nhat
        $blogs = Blog::orderBy('id', 'desc')->limit(3)->get();

        // dd($menProducts);

        return view('front.index', compact('menProducts', 'womenProducts', 'blogs'));
    }
}
