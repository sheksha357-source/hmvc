<?php

use Illuminate\Support\Facades\Route;

Route::prefix('posts')->group(function () {
    Route::get('/', fn () => ['message' => 'Post API module is working.']);
});
