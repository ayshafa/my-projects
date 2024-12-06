<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogPostController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [BlogPostController::class, 'index'])->name('blog-posts');
Route::resource('blog-posts', BlogPostController::class);
