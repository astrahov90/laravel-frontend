<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('posts');
})->name('best-posts');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contacts', function () {
    return view('contacts');
})->name('contacts');

Route::get('/newest', function () {
    return view('posts');
})->name('newest-posts');

Route::get('/authors/{author_id:id}/posts', function (int $author_id) {
    return view('authors-posts', compact(['author_id']));
})->name('authors-posts');

Route::get('/authors', function () {
    return view('authors');
})->name('authors');

Route::get('/new-post', function () {
    return view('new-post');
})->name('new-post');

Route::get('/posts/{post_id:id}/comments', function (int $post_id) {
    return view('comments',compact(['post_id']));
})->name('comments');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
