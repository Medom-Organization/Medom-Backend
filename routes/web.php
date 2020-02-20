<?php

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
    return view('welcome');
});

Route::get('/welcome', function () {
    return view('mails.user-welcome');
});
Route::get('/hospital/welcome', function () {
    return view('mails.hospital-welcome');
});

Route::get('/password/reset', function () {

    return view('mails.password-reset');
})->name('password-reset');

Route::get('/order', function () {
    return view('mails.order2');
});
