<?php

use App\Http\Controllers\Admin\AdminAuthor;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscribeController as AdminSubscribeController;
use App\Http\Controllers\Frontend\CommentController as FrontendCommentController;
use App\Http\Controllers\Frontend\Contact;
use App\Http\Controllers\Frontend\GetPostController;
use App\Http\Controllers\Frontend\SubscribeController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

//all these route are protected
Route::middleware('auth:sanctum')->group(function()
{
    //Controllers/Admin
    Route::prefix('/admin')->group(function (){
        //route login
        Route::post('/login', [AdminAuthor::class, 'login']);
        Route::get('admins', [AdminAuthor::class, 'admins']);
        Route::post('/logout', [AdminAuthor::class, 'logout']);

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

        //setting routes
        Route::get('/settings',[SettingController::class,'index']);
        Route::post('/setting/{id}',[SettingController::class,'update']);

        //contact routes
        Route::get('/contacts',[ContactController::class,'getContacts']);
        Route::delete('/contacts/{id}',[ContactController::class,'deleteContacts']);

        //subscribe routes/Admin
        Route::get('/subscribes',[AdminSubscribeController::class,'index']);
        Route::delete('/subscribes/{id}',[AdminSubscribeController::class,'delete']);

        //comment routes/Admin
        Route::get('/comments',[CommentController::class,'getComments']);
        Route::delete('/comments/{id}',[CommentController::class,'delete']);

    });
});

//Controllers/Frontend
Route::prefix('/front')->group(function(){
    //get-post routes
    Route::get('/posts', [GetPostController::class, 'index']);
    Route::get('/view-Posts', [GetPostController::class, 'viewPosts']);
    Route::get('/detail-Posts/{id}', [GetPostController::class, 'getPostsById']);
    Route::get('/category-Posts/{id}', [GetPostController::class, 'getPostsByCategory']);
    Route::get('/search-post/{search}',[GetPostController::class,'searchPost']);

    //contact routes
    Route::post('/contact',[Contact ::class,'store']);

    //subscribe route/Frontend
    Route::post('/subscribe',[SubscribeController ::class,'store']);

     //comment route/Frontend
     Route::get('/comments',[FrontendCommentController::class,'getComments']);
     Route::post('/comments/{id}',[FrontendCommentController::class,'store']);
});