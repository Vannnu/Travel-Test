<?php declare(strict_types=1);

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TravelController;
use Illuminate\Support\Facades\Route;

// http://localhost:8080/travels
Route::prefix('travels')->group(static function (): void {
    Route::get('', [TravelController::class, 'index'])
         ->name('travels.index');
    Route::get('{uuid}', [TravelController::class, 'show'])
         ->name('travels.show');
});

// http://localhost:8080/carts
Route::prefix('carts')->group(static function (): void {
    Route::post('', [CartController::class, 'create'])
         ->name('carts.create');
    Route::get('', [CartController::class, 'index'])
         ->name('carts.index');
});

// http://localhost:8080/orders
Route::prefix('orders')->group(static function (): void {
    Route::post('', [OrderController::class, 'create'])
         ->name('orders.create');
});

// http://localhost:8080/payments
Route::prefix('payments')->group(static function (): void {
    Route::get('', [PaymentController::class, 'index'])
        ->name('payments.index');
    Route::post('fake', [PaymentController::class, 'pay'])
         ->name('payments.pay');
});
