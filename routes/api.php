<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix("v1")->name("skill.")->group(function(){

    // Route::apiResource('skills', SkillController::class );



    // products
    Route::get('products',[ProductsController::class,'index']);
    Route::get('products/{product}',[ProductsController::class,'show']);

    Route::post("purcashe",[UsersController::class,'index']);
});



// npm install --save-dev @vitejs/plugin-vue
//  npm install vue-router@4
