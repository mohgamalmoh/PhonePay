<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\EnsureAPITokenIsValid;

Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);


Route::middleware([EnsureAPITokenIsValid::class])->group(function () {
    Route::get('/wallet-balance', [UsersController::class, 'walletBalance']);
});