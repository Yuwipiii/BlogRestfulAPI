<?php

use App\Http\Controllers\Api\V1\Admin\PostController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::resource('users', UserController::class)->except(['create', 'edit','update','store']);
    Route::apiResource('posts', PostController::class);
    Route::post('posts/search', [PostController::class, 'search'])->name('posts.search');
});
