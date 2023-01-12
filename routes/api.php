<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/admin')->group(function (){
    //categorys routes
    Route::get('/categorys',[CategoryController::class,'index']);
    Route::post('/categorys',[CategoryController::class,'store']);
    Route::put('/categorys/{id}',[CategoryController::class,'edit']);
    Route::patch('/categorys/{id}',[CategoryController::class,'update']);
    Route::delete('/categorys/{id}',[CategoryController::class,'delete']);
    Route::get('/categorys/{search}',[CategoryController::class,'search']);

    //posts routes
    Route::get('/posts',[PostController::class,'index']);
    Route::post('/posts',[PostController::class,'store']);
    Route::put('/posts/{id}',[PostController::class,'edit']);
    Route::post('/posts/{id}',[PostController::class,'update']);
    Route::delete('/posts/{id}',[PostController::class,'delete']);
    Route::get('/posts/{search}',[PostController::class,'search']);

});