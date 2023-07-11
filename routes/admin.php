<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ItemCategoryController;
use App\Http\Controllers\Admin\ItemMasterController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SubBrandController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Role_Permission\RoleController;
use App\Http\Controllers\UserController;
use App\Models\ItemMaster;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Auth'], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout')->name('logout');
});

Route::group(['middleware' => 'auth:admin'], function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/itemcategory',[ItemCategoryController::class,'create'])->name('category.create');
    Route::post('/itemcategory',[ItemCategoryController::class,'store'])->name('category.store');
    Route::get('/itemcategory/edit/{id}',[ItemCategoryController::class,'edit'])->name('category.edit');
    Route::delete('/itemcategory/delete/{id}',[ItemCategoryController::class,'destroy'])->name('category.destroy');

    Route::get('/subcategory',[SubCategoryController::class,'create'])->name('subcategory.create');
    Route::post('/subcategory',[SubCategoryController::class,'store'])->name('subcategory.store');
    Route::get('/subcategory/edit/{id}',[SubCategoryController::class,'edit'])->name('subcategory.edit');
    Route::post('/subcategory/update',[SubCategoryController::class,'update'])->name('subcategory.update');
    Route::delete('/subcategory/delete/{id}',[SubCategoryController::class,'destroy'])->name('subcategory.destroy');

    Route::get('/brand',[BrandController::class,'create'])->name('brand.create');
    Route::post('/brand/create',[BrandController::class,'store'])->name('brand.store');
    Route::get('/brand/edit/{id}',[BrandController::class,'edit'])->name('brand.edit');
    Route::delete('/brand/delete/{id}',[BrandController::class,'destroy'])->name('brand.destroy');

    Route::get('/subbrand',[SubBrandController::class,'create'])->name('subbrand.create');
    Route::post('/subbrand',[SubBrandController::class,'store'])->name('subbrand.store');
    Route::get('/subbrand/edit/{id}',[SubBrandController::class,'edit'])->name('subbrand.edit');
    Route::delete('/subbrand/delete/{id}',[SubBrandController::class,'destroy'])->name('subbrand.destroy');

    Route::get('/customer',[CustomerController::class,'create'])->name('customer.create');
    Route::post('/customer',[CustomerController::class,'store'])->name('customer.store');
    Route::get('/customer/edit/{id}',[CustomerController::class,'edit'])->name('customer.edit');
    Route::delete('/customer/delete/{id}',[CustomerController::class,'destroy'])->name('customer.destroy');

    Route::get('/itemmaster',[ItemMasterController::class,'create'])->name('itemmaster.create');
    Route::post('/itemmaster',[ItemMasterController::class,'store'])->name('itemmaster.store');
    Route::get('/itemmaster/edit/{id}',[ItemMasterController::class,'edit'])->name('itemmaster.edit');
    Route::delete('/itemmaster/delete/{id}',[ItemMasterController::class,'destroy'])->name('itemmaster.destroy');
    Route::post('/itemmaster/brand',[ItemMasterController::class,'brand'])->name('itemmaster.brand');
    Route::post('/itemmaster/category',[ItemMasterController::class,'category'])->name('itemmaster.category');
    // Route::get('/itemmaster/barcode/{id}',[ItemMasterController::class,'barcode'])->name('itemmaster.barcode');
    Route::get('/itemmaster/pdf',[ItemMasterController::class,'pdf'])->name('itemmaster.pdf');
    Route::get('/itemmaster/excel',[ItemMasterController::class,'excel'])->name('itemmaster.excel');

    Route::get('/order/list',[OrderController::class,'list'])->name('order.list');

    Route::get('/role/create',[RoleController::class,'create'])->name('role.create');
    Route::post('/role/store',[RoleController::class,'store'])->name('role.store');
    Route::get('/role/index',[RoleController::class,'index'])->name('role.index');
    Route::get('/role/edit/{id}',[RoleController::class,'edit'])->name('role.edit');
    Route::post('/role/update/{id}',[RoleController::class,'update'])->name('role.update');
    Route::delete('/role/delete/{id}',[RoleController::class,'delete'])->name('role.delete');

    Route::get('/user/create',[UserController::class,'create'])->name('user.create');
    Route::post('/user/store',[UserController::class,'store'])->name('user.store');
    Route::get('/user/edit/{id}',[UserController::class,'edit'])->name('user.edit');
    Route::delete('/user/delete/{id}',[UserController::class,'destroy'])->name('user.destroy');


});


   