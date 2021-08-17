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

Route::get('/', function () {
    return view('dashboard');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', 'MainController@index')->name('dashboard');  

    Route::get('/accounts', 'AccountController@index')->name('accounts');    
    Route::get('/account/create', 'AccountController@create')->name('create-account');
    Route::post('/account/save', 'AccountController@store')->name('save-account');
    
});


require __DIR__.'/auth.php';
