<?php

use App\Http\Controllers\Api\V1\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::resource('users', UserController::class)->except(['create', 'edit','update','store']);
});
