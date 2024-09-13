<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




//--------------- authintication routes -------------

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::get('profile', [AuthController::class, 'profile'])->middleware('auth:api');
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name("password.reset");


Route::get('test',[TestController::class,'index']);




//-------------User profile  routes ------------------------

Route::prefix('user')->middleware('auth:api')->name("user.")->group(function(){
    Route::get('/',[ProfileController::class,'index']);
    Route::post('/updateProfile',[ProfileController::class,'updateProfile']);
    Route::post('/changePassword',[ProfileController::class,'changePassword']);
    Route::get('/getroles',[ProfileController::class,'getroles']);
    Route::get('/getorders',[ProfileController::class,'getorders']);
    Route::get('/getproducts',[ProfileController::class,'getproducts'])->middleware('Role:seller');
});



// ------------- Product routes ---------------

Route::prefix("v1")->name("skill.")->group(function(){
    // Route::get('products',[ProductsController::class,'index']);
    // Route::get('products/{product}',[ProductsController::class,'show']);
    Route::apiResource('products',ProductController::class);

    Route::post("purcashe",[UsersController::class,'index']);
});


Route::prefix("categories")->group(function(){
         Route::get("/",[CategoryController::class,'index']);
});


//-----------------User controller --------------------

Route::prefix('admin')->middleware(['auth:api','Role:admin'])->group(function(){
           Route::get("/users",[UsersController::class,'users']);
           Route::post("/user/update/{user}",[UsersController::class,'update']);
           Route::delete("/user/destroy/{user}",[UsersController::class,'destroy']);
});


//-----------------Order controller --------------------

Route::prefix('admin')->middleware(['auth:api','Role:admin'])->group(function(){
           Route::get("/orders",[OrderController::class,'index']);
           Route::delete("/order/{order}/destroy",[OrderController::class,'destroy']);
});


// --------------- Seller routes ---------------------

Route::prefix('seller')->middleware(['auth:api'])->group(function(){
       Route::get("/",[SellerController::class,'index'])->middleware('Role:admin');
});





//--------------Admin routes -------------------------


Route::prefix('admin')->middleware('Role:admin')->group(function(){

        // Route::get("/",[AdminController::class,'index']);
        // Route::get("/users",[AdminController::class,'users']);
        // Route::delete("/users/{user}",[AdminController::class,'deleteuser']);
        // Route::get("/orders",[AdminController::class,'orders']);
});












// npm install --save-dev @vitejs/plugin-vue
//  npm install vue-router@4
