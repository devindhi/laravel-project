<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Middleware\Custom\TokenHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::middleware(['auth:api'])->group(function () {
//     
// });