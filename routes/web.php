<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PharmachyController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SaleController;

use App\Http\Controllers\GenericController;
use App\Http\Controllers\AdminController;


use App\Http\Controllers\BrachStockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware'=>'role:admin'],function(){

 Route::resource('users', UserController::class);


Route::resource('permissions', PermissionController::class);
Route::resource('roles', RoleController::class);
Route::get('roles/{roleId}/givePermission', [RoleController::class, 'givePermission'])->name('roles.givePermission');
Route::put('roles/{roleId}/givePermission', [RoleController::class, 'updatePermissions'])->name('roles.updatePermissions');

Route::resource('pharmacies', PharmachyController::class);
Route::resource('medicines', MedicineController::class);
Route::resource('stocks', StockController::class);
Route::resource('generics', GenericController::class);
Route::resource('companies', CompanyController::class);
Route::resource('sales', SaleController::class);
Route::post('/sales/addTempSale', [SaleController::class, 'addTempSale'])->name('sales.addTempSale');







});
Route::group(['middleware'=>'role:branch'],function(){
    Route::get('brach/stock', [BrachStockController::class, 'index'])->name('brachStock.index');
    Route::post('/sales/addTempSale', [SaleController::class, 'addTempSale'])->name('sales.addTempSale');



});
Route::get('/dashboard', [AdminController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('role:Admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

