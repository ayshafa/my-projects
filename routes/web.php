<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogPostController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('blog-posts', BlogPostController::class);
