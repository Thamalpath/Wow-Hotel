<?php

use App\Http\Controllers\Other\RegistrationController;
use App\Http\Controllers\Other\ReservationController;
use App\Http\Controllers\Other\BillingItemController;
use App\Http\Controllers\Other\TransactionController;
use App\Http\Controllers\Other\DashboardController;
use App\Http\Controllers\Other\CheckoutController;
use App\Http\Controllers\Other\CategoryController;
use App\Http\Controllers\Other\RoomController;
use App\Http\Controllers\Other\RateController;
use App\Http\Controllers\Other\ItemController;
use App\Http\Controllers\Other\StaffController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});


Auth::routes();

Route::middleware(['auth'])->group(function() {
    Route::prefix('dashboard')->group(function() {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/checkout/{hash}', [DashboardController::class, 'checkout'])->name('dashboard.checkout');
        Route::get('/registration', [DashboardController::class, 'printRegistration'])->name('dashboard.print-registration');
        Route::post('/reservation-report', [DashboardController::class, 'getReservationReport'])->name('dashboard.reservation-report');
        Route::post('/registration-report', [DashboardController::class, 'getRegistrationReport'])->name('dashboard.registration-report');
        Route::post('/registration-history-report', [DashboardController::class, 'getRegistrationHistoryReport'])->name('dashboard.registration-history-report');
        Route::post('/summary-report', [DashboardController::class, 'getSummaryReport'])->name('dashboard.summary-report');
        Route::post('/day-end-report', [DashboardController::class, 'getDayEndReport'])->name('dashboard.day-end-report');
        Route::post('/transaction-report', [DashboardController::class, 'getTransactionReport'])->name('dashboard.transaction-report');
        Route::post('/check-available-rooms', [DashboardController::class, 'checkAvailableRooms'])->name('dashboard.check-available-rooms');
    });

    // Category Routes
    Route::prefix('categories')->group(function() {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
        Route::post('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    // Rate Routes
    Route::prefix('rate')->group(function() {
        Route::get('/', [RateController::class, 'index'])->name('rate.index');
        Route::post('/', [RateController::class, 'update'])->name('rate.update');
    });

    // Room Routes
    Route::prefix('rooms')->group(function() {
        Route::get('/', [RoomController::class, 'index'])->name('rooms.index');
        Route::post('/', [RoomController::class, 'store'])->name('rooms.store');
        Route::post('/{id}/destroy', [RoomController::class, 'destroy'])->name('rooms.destroy');
    });

    // Item Routes
    Route::prefix('items')->group(function() {
        Route::get('/', [ItemController::class, 'index'])->name('items.index');
        Route::post('/', [ItemController::class, 'store'])->name('items.store');
        Route::post('/{id}/destroy', [ItemController::class, 'destroy'])->name('items.destroy');
    });

    // Staff Routes
    Route::prefix('staff')->group(function() {
        Route::get('/', [StaffController::class, 'index'])->name('staff.index');
        Route::post('/', [StaffController::class, 'store'])->name('staff.store');
        Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
        Route::put('/{staff}', [StaffController::class, 'update'])->name('staff.update');
        Route::post('/{id}/destroy', [StaffController::class, 'destroy'])->name('staff.destroy');
        Route::post('/upload-image/{staff}', [StaffController::class, 'uploadImage'])->name('staff.upload-image');
    });

    // Transaction Routes
    Route::prefix('transactions')->group(function() {
        Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
        Route::post('/expense', [TransactionController::class, 'storeExpense'])->name('transactions.store.expense');
        Route::post('/income', [TransactionController::class, 'storeIncome'])->name('transactions.store.income');
        Route::post('/{id}/destroy', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    });

    // Reservation Routes
    Route::prefix('reservations')->group(function() {
        Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');
        Route::post('/', [ReservationController::class, 'store'])->name('reservations.store');
        Route::put('/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
        Route::delete('/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    });
    
    // Registration Routes
    Route::prefix('registration')->group(function() {
        Route::get('/', [RegistrationController::class, 'index'])->name('registration.index');
        Route::post('/', [RegistrationController::class, 'store'])->name('registration.store');
        Route::put('/{registration}/update', [RegistrationController::class, 'update'])->name('registration.update');
        Route::post('/fetch-reservation', [RegistrationController::class, 'fetchReservation'])->name('registration.fetch-reservation');
        Route::get('/{id}', [RegistrationController::class, 'getRegistration'])->name('registration.get');
        Route::delete('/{id}', [RegistrationController::class, 'destroy'])->name('registration.destroy');
        Route::post('/upload-image', [RegistrationController::class, 'uploadImage'])->name('registration.upload-image');
        Route::post('/print', [RegistrationController::class, 'printRegistration'])->name('registration.print');
    });

    // Billing Routes
    Route::prefix('billing')->group(function() {
        Route::get('/', [BillingItemController::class, 'index'])->name('billing.index');
        Route::get('/other', [BillingItemController::class, 'otherBillingIndex'])->name('other-billing.index');
        Route::post('/', [BillingItemController::class, 'store'])->name('billing.store');
        Route::post('/other', [BillingItemController::class, 'store'])->name('other-billing.store');
        Route::get('/latest', [BillingItemController::class, 'getLatestBillings'])->name('billing.latest');
        Route::get('/other/latest', [BillingItemController::class, 'getLatestOtherBillings'])->name('other-billing.latest');
        Route::delete('/{bill_no}/delete-all', [BillingItemController::class, 'destroyAll'])->name('billing.destroy-all');
    });

    
    // Checkout Routes
    Route::prefix('checkout')->group(function() {
        Route::get('/{hash}', [CheckoutController::class, 'show'])->name('checkout.show');
        Route::post('/{hash}/advance-payment', [CheckoutController::class, 'advancePayment'])->name('checkout.advance-payment');
        Route::get('/{hash}/print-summary', [CheckoutController::class, 'printSummary'])->name('checkout.print-summary');
        Route::get('/{hash}/print-details', [CheckoutController::class, 'printDetails'])->name('checkout.print-details');
        Route::post('/checkout/{hash}/send-bill', [CheckoutController::class, 'sendBillEmail'])->name('checkout.send-bill');
        Route::post('/{hash}/process', [CheckoutController::class, 'process'])->name('checkout.process');
    });
});
