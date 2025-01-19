<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Actl\PostalCodeController;
use App\Http\Controllers\Actl\SupplierController;
use App\Http\Controllers\Actl\FamilyController;
use App\Http\Controllers\Actl\UnitMeasureController;
use App\Http\Controllers\Actl\TaxRateController;
use App\Http\Controllers\Actl\ProductController;
use App\Http\Controllers\Actl\PurchaseOrderController;

Route::get('/', function () {
    return view('welcome');
});

// Admin All Route
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin/logout', 'destroy'   )->name('admin.logout');
    Route::get('/admin/profile', 'Profile')->name('admin.profile');
    Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
    Route::post('/store/profile', 'StoreProfile')->name('store.profile');
    Route::get('/change/password', 'ChangePassword')->name('change.password');
    Route::post('/update/password', 'UpdatePassword')->name('update.password');
});

Route::controller(PostalCodeController::class)->group(function () {
    Route::get('postalCode/all', 'PostalCodeAll')->name('postalCode.all');
    Route::get('postalCode/add', 'PostalCodeAdd')->name('postalCode.add');
    Route::post('postalCode/store', 'PostalCodeStore')->name('postalCode.store');
    Route::get('postalCode/edit/{id}', 'PostalCodeEdit')->name('postalCode.edit');
    Route::post('postalCode/update', 'PostalCodeUpdate')->name('postalCode.update');
    Route::get('postalCode/delete/{id}', 'PostalCodeDelete')->name('postalCode.delete');
});

// Supplier
Route::controller(SupplierController::class)->group(function () {
    Route::get('/supplier/all', 'SupplierAll')->name('supplier.all');
    Route::get('/supplier/add', 'SupplierAdd')->name('supplier.add');
    Route::post('/supplier/store', 'SupplierStore')->name('supplier.store');
    Route::get('/supplier/edit/{id}', 'SupplierEdit')->name('supplier.edit');
    Route::post('/supplier/update', 'SupplierUpdate')->name('supplier.update');
    Route::get('/supplier/delete/{id}', 'SupplierDelete')->name('supplier.delete');

    Route::get('/supplier-code-to-name', [SupplierController::class, 'getSupplierName']);
});

// Family
Route::controller(FamilyController::class)->group(function () {
    Route::get('/family/all', 'FamilyAll')->name('family.all');
    Route::get('/family/add', 'FamilyAdd')->name('family.add');
    Route::post('/family/store', 'FamilyStore')->name('family.store');
    Route::get('/family/edit/{id}', 'FamilyEdit')->name('family.edit');
    Route::post('/family/update', 'FamilyUpdate')->name('family.update');
    Route::get('/family/delete/{id}', 'FamilyDelete')->name('family.delete');
});

// Unit Measure
Route::controller(unitMeasureController::class)->group(function () {
    Route::get('/unitMeasure/all', 'UnitMeasureAll')->name('unitMeasure.all');
    Route::get('/unitMeasure/add', 'UnitMeasureAdd')->name('unitMeasure.add');
    Route::post('/unitMeasure/store', 'UnitMeasureStore')->name('unitMeasure.store');
    Route::get('/unitMeasure/edit/{id}', 'UnitMeasureEdit')->name('unitMeasure.edit');
    Route::post('/unitMeasure/update', 'UnitMeasureUpdate')->name('unitMeasure.update');
    Route::get('/unitMeasure/delete/{id}', 'UnitMeasureDelete')->name('unitMeasure.delete');
});

// Tax Rates
Route::controller(TaxRateController::class)->group(function () {
    Route::get('/taxRate/all', 'TaxRateAll')->name('taxRate.all');
    Route::get('/taxRate/add', 'TaxRateAdd')->name('taxRate.add');
    Route::post('/taxRate/store', 'TaxRateStore')->name('taxRate.store');
    Route::get('/taxRate/edit/{id}', 'TaxRateEdit')->name('taxRate.edit');
    Route::post('/taxRate/update', 'TaxRateUpdate')->name('taxRate.update');
    Route::get('/taxRate/delete/{id}', 'TaxRateDelete')->name('taxRate.delete');
});

// Products
Route::controller(ProductController::class)->group(function () {
    Route::get('/product/all', 'ProductAll')->name('product.all');
    Route::get('/product/add', 'ProductAdd')->name('product.add');
    Route::post('/product/store', 'ProductStore')->name('product.store');
    Route::get('/product/edit/{id}', 'ProductEdit')->name('product.edit');
    Route::post('/product/update', 'ProductUpdate')->name('product.update');
    Route::get('/product/delete/{id}', 'ProductDelete')->name('product.delete');

    Route::get('/products-by-family', [ProductController::class, 'getProductsByFamily']);
    Route::get('/product-by-selected', [ProductController::class, 'getProductsSelected']);
});

// Purchase Orders
Route::controller(PurchaseOrderController::class)->group(function () {
    Route::get('/purchaseOrder/all', 'PurchaseOrderAll')->name('purchaseOrder.all');
    Route::get('/purchaseOrder/add', 'PurchaseOrderAdd')->name('purchaseOrder.add');
    Route::post('/purchaseOrder/store', 'PurchaseOrderStore')->name('purchaseOrder.store');
    Route::get('/purchaseOrder/edit/{pONumber}', 'PurchaseOrderEdit')->name('purchaseOrder.edit');
    Route::post('/purchaseOrder/update', 'PurchaseOrderUpdate')->name('purchaseOrder.update');
    Route::get('/purchaseOrderC/disable/{pONumber}', 'PurchaseOrderCDisable')->name('purchaseOrderC.disable');
    Route::get('/purchaseOrderC/delete/{id}', 'PurchaseOrderCDelete')->name('purchaseOrderC.delete');
    Route::get('/purchaseOrderD/delete/{id}', 'PurchaseOrderDDelete')->name('purchaseOrderD.delete');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
