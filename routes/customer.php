<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ItemCategoryController;
use App\Http\Controllers\Admin\ItemMasterController;
use App\Http\Controllers\Admin\SubBrandController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Customer\OrderController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Auth'], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout')->name('logout');
});

Route::group(['middleware' => 'auth:customer'], function () {
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('dashboard');

    Route::get('/order/create',[OrderController::class,'create'])->name('order.create');
    Route::post('/order/create',[OrderController::class,'store'])->name('order.store');
    Route::post('/order/price',[OrderController::class,'price'])->name('order.price');
    Route::delete('/order/delete/{id}',[OrderController::class,'destroy'])->name('order.destroy');
    Route::get('/order/edit/{id}',[OrderController::class,'edit'])->name('order.edit');

});