<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\blogController;
use App\Http\Controllers\commentController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'loginview'])->name('login');
Route::get('/register', [AuthController::class, 'registerview'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/', [blogController::class, 'show'])->name('home');
Route::get('/home/comments/{id}', [commentController::class, 'getBlogComments'])->name('blogs.comments');
Route::get('/home/blog/{id}', [blogController::class, 'view'])->name('blog.view');
Route::delete('/home/blog/delete/{id}', [blogController::class, 'delete'])->name('blog.delete');
Route::get('/home/edit-blog/{id}', [BlogController::class, 'edit'])->name('blog.edit');
Route::put('/home/update-blog/{id}', [BlogController::class, 'update'])->name('blog.update');
Route::delete('/home/blog/comment/{id}', [commentController::class, 'delete'])->name('comment.delete');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::post('/home', [BlogController::class, 'store'])->name('blog.post');
    Route::post('/home/comments/{id}', [commentController::class, 'store'])->name('comments.post');
    
});
