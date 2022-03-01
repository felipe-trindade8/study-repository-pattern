<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/catestore')->name('api.v1.catestore.')->group(function () {
    Route::get('cart', CartController::class)->name('cart');
    Route::prefix('credit-card')->name('creditcard.')->group(function () {
        Route::get('', [PaymentMethodController::class, 'index'])->name('index');
        Route::get('{id}', [PaymentMethodController::class, 'show'])->name('show');
        Route::post('', [PaymentMethodController::class, 'store'])->name('store');
        Route::put('{id}', [PaymentMethodController::class, 'update'])->name('update');
        Route::delete('{id}', [PaymentMethodController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::get('', [TransactionController::class, 'index'])->name('index');
        Route::get('/user/{userId}', [TransactionController::class, 'userTransactions'])->name('user_transactions');
        Route::post('', [TransactionController::class, 'store'])->name('store');
    });
});
