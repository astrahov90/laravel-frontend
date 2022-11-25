<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('authors/me', [UserController::class, 'me']);
Route::apiResource('authors', UserController::class)
    ->only(['index','show'])
    ->parameters(['authors' => 'user'])
    ->missing(fn()=>(response('Not found',404)));

Route::get('posts/{post}/rating', [PostController::class, 'rating']);
Route::post('posts/{post}/like', [PostController::class, 'like']);
Route::post('posts/{post}/dislike', [PostController::class, 'dislike']);

Route::apiResource('posts', PostController::class)
    ->only(['index','store','show'])
    ->missing(fn()=>(response('Not found',404)));

Route::apiResource('posts.comments', CommentController::class)
    ->only(['index','store','show'])
    ->scoped(['comment' => 'id'])
    ->missing(fn()=>(response('Not found',404)));
