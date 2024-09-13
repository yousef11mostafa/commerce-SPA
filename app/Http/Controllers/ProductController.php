<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ProductRequest;


use App\Traits\SlugTrait;



class ProductController extends Controller
{

    use ApiResponse , SlugTrait;
    /**
     * Display a listing of the resource.
     */
    public function __construct(){

       $this->middleware(['auth:api'])->except(['index','show']);

    }

    public function index()
    {
        //
        $products=Product::with(["user:id,name","categories:id,name,slug"])->get();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        //



        Gate::authorize('create',Product::class);

        $user = auth()->user();
        $data=[
            'name'=>$request->input('name'),
            'user_id'=>$user->id,
            'description'=>$request->input('description'),
            'price'=>$request->input('price'),
            'slug'=>$this->createUniqueSlug($request->input('name')),
        ];

        $product=Product::create($data);

        $product->categories()->attach($request->input("category_id"));


        return $this->successResponse(message:"product created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        //
        $product=Product::with("categories:id,name,slug")->where('slug',$slug)->get();
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        //
        $product=Product::where('slug',$slug)->first();
        Gate::authorize('update',$product);

        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'price'=>'required',
        ]);

        $product->name=$request->input("name");
        $product->description=$request->input("description");
        $product->price=$request->input("price");

        $product->save();

        return $this->successResponse(message:"product updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        //
        $product=Product::where('slug',$slug)->first();
        Gate::authorize('delete',$product);

        $product->delete();

        return $this->successResponse(message:"product deleted succcesfullly");

        return 'deleted';
    }
}
