<?php

use App\Http\Controllers\DealerController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/', function () {
        return redirect('/inventory/inward-entry');
    });

    Route::group(['prefix' => '/inventory'], function () {
        Route::get('/inward-entry', [InventoryController::class, 'showInwardEntry']);
        Route::get('/edit/inward/{inward_entry}', [InventoryController::class, 'editInwardEntry']);
        Route::get('/manage-inward-entry', [InventoryController::class, 'showManageInwardEntry']);

        Route::get('/outward-entry', [InventoryController::class, 'showOutwardEntry']);
        Route::get('/edit/outward/{outward_entry}', [InventoryController::class, 'editOutwardEntry']);
        Route::get('/manage-outward-entry', [InventoryController::class, 'showManageOutwardEntry']);
    });
    Route::group(['prefix' => '/master'], function () {
        Route::get('/add-user', [UserController::class, 'showAddUserPage']);
        Route::get('/add-dealer', [DealerController::class, 'showAddDealerPage']);
        Route::get('/manage-dealer', [DealerController::class, 'showManageDealerPage']);
        Route::get('/edit/dealer/{dealer}', [DealerController::class, 'editDealer']);

        Route::get('/add-supplier', [SupplierController::class, 'showAddSupplierPage']);
        Route::get('/manage-supplier', [SupplierController::class, 'showManageSupplierPage']);
        Route::get('/edit/supplier/{supplier}', [SupplierController::class, 'editSupplier']);

        Route::get('/add-product', [ProductController::class, 'showAddProductPage']);
        Route::get('/manage-product', [ProductController::class, 'showManageProductPage']);
        Route::get('/edit/product/{product}', [ProductController::class, 'editProduct']);

        Route::get('/create-user', [MasterController::class, 'showCreateUser']);
        Route::get('/manage-units', [MasterController::class, 'showManageUnits']);
    });

    Route::group(['prefix' => '/ledger'], function () {
        Route::get('/index', [LedgerController::class, 'index']);
        Route::get('/create', [LedgerController::class, 'create']);
        Route::get('/view', [LedgerController::class, 'view']);
        Route::get('/edit/{ledger}', [LedgerController::class, 'editLedger']);
    });

    Route::group(['prefix' => '/sales'], function () {
        Route::get('/index', [SalesController::class, 'index']);
        Route::get('/create', [SalesController::class, 'create']);
        Route::get('/edit', [SalesController::class, 'edit']);
        Route::get('/view', [SalesController::class, 'view']);
    });

    Route::group(['prefix' => '/report'], function () {
        Route::get('/inward', [ReportController::class, 'showInwardEntryReport']);
        Route::get('/inward-entry-items', [ReportController::class, 'showInwardEntryItemsReport']);
        Route::get('/outward', [ReportController::class, 'showOutwardEntryReport']);
        Route::get('/outward-entry-items', [ReportController::class, 'showOutwardEntryItemsReport']);
        Route::get('/stock', [ReportController::class, 'stockItems']);
        Route::get('/stock/{sku}/details', [ReportController::class, 'stockItemsDetails']);
        Route::get('/stock/export-to-csv', [ReportController::class, 'exportStockToCsv']);

        Route::get('/ledger', [ReportController::class, 'ledgerItems']);
        Route::get('/ledger/{sku}/details', [ReportController::class, 'ledgerItemsDetails']);
        Route::get('/ledger/export-to-csv', [ReportController::class, 'exportLedgerToCsv']);
        // Route::get('/incoming-report', [ReportController::class, 'showOutwardEntry']);
        // Route::get('/outgoing-report', [ReportController::class, 'showOutwardEntry']);
    });
});

require __DIR__.'/auth.php';
