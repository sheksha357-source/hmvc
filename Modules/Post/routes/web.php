<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::post('/posts', [PostController::class, 'store'])->middleware('auth')->name('posts.store');
