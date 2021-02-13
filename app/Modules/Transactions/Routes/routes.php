<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionsController;
use App\Http\Middleware\EnsureAPITokenIsValid;


Route::post('/twillio-webhook/{id}', [TransactionsController::class, 'twilioWebhook']);
Route::post('/verify-transaction/{id}', [TransactionsController::class, 'verifyTransaction']);

Route::middleware([EnsureAPITokenIsValid::class])->group(function () {
    Route::post('/transaction', [TransactionsController::class, 'makeTransaction']);
    Route::get('/transactions', [TransactionsController::class, 'getTransactions']);
});