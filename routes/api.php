<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailsController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function(){
    Route::post("/logout",[AuthController::class,"logout"])->name("");
    Route::apiResource("category",CategoryController::class);
    Route::apiResource("product",ProductController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('order_details',OrderDetailsController::class);
    Route::get("/order_details/by-order/{order_id}",[OrderDetailsController::class,"getByOrderId"]);
});
Route::post("/register",[AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);
Route::post("/check",[AuthController::class,"checkCredentials"]);

