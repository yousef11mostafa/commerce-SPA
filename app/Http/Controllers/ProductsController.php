<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class ProductsController extends Controller
{
    //
    public function index(){
        $products=Product::with("categories:id,name,slug")->get();
        return response()->json($products);
    }

    public function show($slug){
        $product=Product::with("categories:id,name,slug")->where('slug',$slug)->get();
        return response()->json($product);
    }
}
