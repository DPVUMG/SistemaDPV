<?php

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

Route::get('/', function () {return view('welcome');})->name('welcome')->middleware('guest');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login')->middleware('guest');
Route::post('login', 'Auth\LoginController@login')->middleware('guest');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm')->middleware('auth');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm')->middleware('auth');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');


Route::group(['middleware' => ['auth','system']], function () {
    Route::name('sistema.')->group(function () {
        Route::get('/dashboard', 'HomeController@index')->name('home');
    });

    Route::name('brand.')->group(function () {
        Route::get('brand', 'BrandController@index')->name('index');
        Route::post('brand/store', 'BrandController@store')->name('store');
        Route::get('brand/{brand}/edit', 'BrandController@edit')->name('edit');
        Route::put('brand/update/{brand}', 'BrandController@update')->name('update');
        Route::delete('brand/delete/{brand}', 'BrandController@delete')->name('delete');
    });

    Route::name('category.')->group(function () {
        Route::get('category', 'CategoryController@index')->name('index');
        Route::post('category/store', 'CategoryController@store')->name('store');
        Route::get('category/{category}/edit', 'CategoryController@edit')->name('edit');
        Route::put('category/update/{category}', 'CategoryController@update')->name('update');
        Route::delete('category/delete/{category}', 'CategoryController@delete')->name('delete');
        Route::get('category/{category}', 'CategoryController@show')->name('show');
    });

    Route::name('sub_category.')->group(function () {
        Route::post('sub_category/store', 'SubCategoryController@store')->name('store');
        Route::get('sub_category/{sub_category}/edit', 'SubCategoryController@edit')->name('edit');
        Route::put('sub_category/update/{sub_category}', 'SubCategoryController@update')->name('update');
        Route::delete('sub_category/delete/{sub_category}', 'SubCategoryController@delete')->name('delete');
    });

    Route::name('product.')->group(function () {
        Route::get('product', 'ProductController@index')->name('index');
        Route::post('product/store', 'ProductController@store')->name('store');
        Route::get('product/{product}/edit', 'ProductController@edit')->name('edit');
        Route::put('product/update/{product}', 'ProductController@update')->name('update');
        Route::delete('product/delete/{product}', 'ProductController@delete')->name('delete');
        Route::get('product/{product}', 'ProductController@show')->name('show');
        Route::get('product/{product}/offer', 'ProductController@offer')->name('offer');
    });

    Route::name('image.')->group(function () {
        Route::put('image/store/{product}', 'ImageController@store')->name('store');
        Route::delete('image/delete/{image}', 'ImageController@delete')->name('delete');
    });

    Route::name('order.')->group(function () {
        Route::get('order', 'OrderController@index')->name('index');
        Route::get('order/{order}/detail', 'OrderController@show')->name('show');
        Route::get('order/update/{order}', 'OrderController@update')->name('update');
    });

    Route::name('user.')->group(function () {
        Route::get('user', 'UserController@index')->name('index');
        Route::post('user/store', 'UserController@store')->name('store');
        Route::get('user/{user}/edit', 'UserController@edit')->name('edit');
        Route::put('user/update/{user}', 'UserController@update')->name('update');
        Route::delete('user/delete/{user}', 'UserController@delete')->name('delete');
        Route::get('user/system/{user}', 'UserController@system')->name('system');
        Route::get('user/perfil', 'UserController@perfil')->name('perfil');
        Route::put('user/{user}/password/reset', 'UserController@password_reset')->name('password_reset');
    });

    Route::name('company.')->group(function () {
        Route::get('company/page', 'CompanyController@index_pagina')->name('index_pagina');
        Route::put('company/update/{company}', 'CompanyController@update')->name('update');
        Route::put('company/phone/{company}', 'CompanyController@phone_store')->name('phone_store');
        Route::put('company/direction/{company}', 'CompanyController@direction_store')->name('direction_store');
        Route::delete('company/phone_delete/{phone}', 'CompanyController@phone_delete')->name('phone_delete');
        Route::delete('company/direction_delete/{direction}', 'CompanyController@direction_delete')->name('direction_delete');
    });

    Route::name('credit.')->group(function () {
        Route::get('credit', 'CreditController@index')->name('index');
        Route::get('credit/history', 'CreditController@history')->name('history');
        Route::put('credit/update/{credit}', 'CreditController@update')->name('update');
    });
});


Route::group(['middleware' => ['auth','admin']], function () {
    Route::name('order.')->group(function () {
        Route::delete('order/delete/{order}', 'OrderController@delete')->name('delete');
    });

    Route::name('credit.')->group(function () {
        Route::delete('credit/delete/{credit}', 'CreditController@destroy')->name('delete');
    });

    Route::name('report.')->group(function () {
        Route::get('report/traicing', 'ReportController@traicing')->name('traicing');
        Route::get('report/credit', 'ReportController@credit')->name('credit');
        Route::get('report/client', 'ReportController@client')->name('client');
    });

    Route::name('pdf.')->group(function () {
        Route::get('pdf/traicing/{month}', 'PDFController@traicing')->name('traicing');
        Route::get('pdf/credit/{date_start}/{date_end}', 'PDFController@credit')->name('credit');
        Route::get('pdf/client/{user_id}', 'PDFController@client')->name('client');
    });
});


Route::group(['middleware' => ['auth']], function () {
    Route::name('company.')->group(function () {
        Route::get('company/system', 'CompanyController@index_sistema')->name('index_sistema');
        Route::post('company/store', 'CompanyController@store')->name('store');
    });
});
