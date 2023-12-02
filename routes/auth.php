<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'api'], function () {
        Route::post('/save-inward-entry', [InventoryController::class, 'saveInwardEntry']);
        Route::post('/save-outward-entry', [InventoryController::class, 'saveOutwardEntry']);
        Route::post('/update-outward-entry', [InventoryController::class, 'updateOutwardEntry']);

        Route::get('/get-inward-entry-list', [InventoryController::class, 'getInwardEntryList']);
        Route::delete('/inward/{inward_entry}', [InventoryController::class, 'deleteInwardEntry']);

        Route::get('/get-outward-entry-list', [InventoryController::class, 'getOutwardEntryList']);
        Route::get('/get-last-outward-entry', [InventoryController::class, 'nextVoucherNumber']);
        Route::delete('/outward/{outward_entry}', [InventoryController::class, 'deleteOutwardEntry']);

        Route::post('/product-by-sku', [InventoryController::class, 'productBySKU']);
        Route::post('/product-by-stone-name', [InventoryController::class, 'getProductByStoneName']);

        Route::group(['prefix' => 'master'], function () {
            Route::post('/add-user', [UserController::class, 'addUser']);
            Route::post('/create-or-update-dealer', [DealerController::class, 'createOrUpdateDealer']);
            Route::delete('/delete/dealer/{dealer}', [DealerController::class, 'deleteDealer']);

            Route::post('/create-or-update-product', [ProductController::class, 'createOrUpdateProduct']);
            Route::delete('/delete/product/{product}', [ProductController::class, 'deleteProduct']);
            Route::get('/get-product-list', [ProductController::class, 'getProductList']);
            Route::get('/get-dealer-list', [DealerController::class, 'getDealersList']);
            Route::get('/get-supplier-list', [SupplierController::class, 'getSuppliersList']);

            Route::post('/create-or-update-supplier', [SupplierController::class, 'createOrUpdateSupplier']);
            Route::delete('/delete/supplier/{supplier}', [SupplierController::class, 'deleteSupplier']);

            Route::get('/get-ledger-list', [LedgerController::class, 'getLedgersList']);
            Route::post('/create-or-update-ledger', [LedgerController::class, 'createOrUpdateLedger']);
            Route::delete('/delete/ledger/{ledger}', [LedgerController::class, 'deleteLedger']);

            // Reports Data
            Route::get('/get-inwared-entry-report', [ReportController::class, 'getInwardEntries']);
            Route::get('/get-outward-entry-report', [ReportController::class, 'getOutwardEntries']);
        });

        //Get ledgers for report
        Route::get('reports/ledgers', [ReportController::class, 'getLedgersInReport']);

    });
});
