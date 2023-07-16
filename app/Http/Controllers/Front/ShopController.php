<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Brand;
use App\Models\ProductComment;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    //ham hien rhi ttsp theo id

    public function show($id)
    {
        // truy van ban ghi theo id
         //get categories, brands
         $categories = ProductCategory::all();
         $brands = Brand::all();

        $product = Product::findOrFail($id);

        $avgRating = 0;
        $sumRating = array_sum(array_column($product->productComments->toArray(), 'rating'));
        $countRating = count($product->productComments);
        if ($countRating != 0) {
            $avgRating = $sumRating / $countRating;
        }

        //hien thij sp lien quan den sp hien tai
        $relatedProducts = Product::where('product_category_id', $product->product_category_id)
            ->where('tag', $product->tag)
            ->limit(4)
            ->get();

        return view('front.shop.show', compact('product',  'categories','brands','avgRating', 'relatedProducts'));
    }

    //ham gui binh luan

    public function postComment(Request $request)
    {
        //them du lieeuj form vao Product_comment
        ProductComment::create($request->all());
        return redirect()->back();
    }


    public function index(Request $request)
    {
        //get categories, brands
        $categories = ProductCategory::all();
        $brands = Brand::all();

        //get products
        $perPage = $request->show ?? 3;
        $sortBy = $request->sort_by ?? 'latest';

        $search = $request->search ?? '';

        $products = Product::where('name', 'like', '%' . $search . '%');
        $products = $this->filter($products, $request);

        $products = $this->sortAndPagination($products, $sortBy, $perPage);



        return view('front.shop.index', compact('products', 'categories', 'brands'));
    }

    public function category($categoryName, Request $request)
    {
        //get categories, brands
        $categories = ProductCategory::all();
        $brands = Brand::all();


        //get products:

        $perPage = $request->show ?? 3;
        $sortBy = $request->sort_by ?? 'latest';

        $products = ProductCategory::where('name', $categoryName)->first()->products->toQuery();
        $products = $this->filter($products, $request);


        $products = $this->sortAndPagination($products, $sortBy, $perPage);


        return view('front.shop.index', compact('products', 'categories', 'brands'));
    }

    public function sortAndPagination($products, $sortBy, $perPage)
    {
        switch ($sortBy) {
            case 'latest':
                $products = $products->orderBy('id');
                break;
            case 'oldest':
                $products = $products->orderByDesc('id');
                break;

            case 'name-ascending':
                $products = $products->orderBy('name');
                break;
            case 'name-descendng':
                $products = $products->orderByDesc('name');
                break;
            case 'price-ascending':
                $products = $products->orderBy('price');
                break;
            case 'price-descending':
                $products = $products->orderByDesc('price');
                break;
            default:
                $products = $products->orderBy('id');
                break;
        }
        //lay  db
        $products = $products->paginate($perPage);
        $products->appends(['sort_by' => $sortBy, 'show' => $perPage]);

        return $products;
    }

    public function filter($products, Request $request)
    {
        //Brand
        $brands = $request->brand ?? [];
        $brand_ids = array_keys($brands);
        $products = $brand_ids != null ? $products->whereIn('brand_id', $brand_ids) : $products;

        //Price
        $priceMin = $request->price_min;
        $priceMax = $request->price_max;

        $priceMin = str_replace('$', '', $priceMin);
        $priceMax = str_replace('$', '', $priceMax);

        $products = ($priceMin != null && $priceMax != null) ? $products->whereBetween('price', [$priceMin, $priceMax]) : $products;

        //Color
        $color = $request->color;
        $products = $color != null
            ? $products->whereHas('productDetails', function ($query) use ($color) {
                return $query->where('color', $color)->where('qty', '>', 0);
            })
            : $products;

        //size
        $size = $request->size;
        $products = $size  != null
            ? $products->whereHas('productDetails', function ($query) use ($size ) {
                return $query->where('size', $size )->where('qty', '>', 0);
            })
            : $products;


        return $products;
    }
}
