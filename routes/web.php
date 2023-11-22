<?php

use App\Http\Controllers\Refactoring\MutableDataController;
use App\Http\Controllers\Refactoring\DuplicateCodeController;
use App\Http\Controllers\Refactoring\DuplicateCodeFinalController;
use App\Http\Controllers\Refactoring\GlobalDataController;
use App\Http\Controllers\Refactoring\LongParameterListController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::controller(DuplicateCodeController::class)->group(function () {
    Route::prefix('/duplicate-code')->group(function () {
        Route::get('/invoice/{id}', 'printInvoice')->name('printInvoice');
        Route::get('/invoice-refactored/{id}', 'printInvoiceRefactored')->name('printInvoiceRefactored');

        Route::get('/outstanding-invoice/{id}', 'printOutstandingInvoice')->name('printOutstandingInvoice');
        Route::get('/outstanding-invoice-refactored/{id}', 'printOutstandingInvoiceRefactored')->name('printOutstandingInvoiceRefactored');

        Route::get('/invoice-merged/{id}', 'printInvoiceMerged')->name('printInvoiceMerged');
    });
});


Route::controller(DuplicateCodeFinalController::class)->group(function () {
    Route::prefix('/duplicate-code')->group(function () {
        Route::get('/invoice-final/{id}', 'printInvoiceFinal')->name('printInvoiceFinal');
    });
});


Route::controller(GlobalDataController::class)->group(function () {
    Route::prefix('/global-data')->group(function () {
        Route::get('/get-count/{addOneToCount?}', 'getCount')->name('getCount');
    });
});


Route::controller(LongParameterListController::class)->group(function () {
    Route::prefix('/long-parameter-list')->group(function () {
        Route::get('/invoice/{id}/{printOutstandingAmount}', 'printInvoice')->name('printInvoiceLongList');
        Route::get('/invoice-array/{id}/{printOutstandingAmount}', 'printInvoiceArray')->name('printInvoiceArray');
        Route::get('/invoice-value-object/{id}/{printOutstandingAmount}', 'printInvoiceValueObject')->name('printInvoiceValueObject');
    });
});


Route::controller(MutableDataController::class)->group(function () {
    Route::prefix('/mutable-data')->group(function () {
        Route::get('/violate-encapsulation/{amount}', 'updateBalanceViolateEncapsulation')->name('updateBalanceViolateEncapsulation');
        Route::get('/violate-encapsulation-setter/{amount}', 'updateBalanceViolateEncapsulationWithSetter')->name('updateBalanceViolateEncapsulationSetter');
        Route::get('/dont-violate-encapsulation/{amount}', 'updateBalanceDontViolateEncapsulation')->name('updateBalanceDontViolateEncapsulation');
        Route::get('/dont-violate-encapsulation-readonly/{amount}', 'updateReadonlyBalanceDontViolateEncapsulation')->name('updateReadonlyBalanceDontViolateEncapsulation');
    });
});


Route::get('/', function () {
    return view('welcome');
});
