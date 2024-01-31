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

// SITEMAP
Route::get('/sitemap.xml', 'App\Http\Controllers\SitemapController@index');

//api
Route::get('/api-barang', 'App\Http\Controllers\api\BarangController@index');


//LOGIN
Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('login');
Route::post('/loginProses', 'App\Http\Controllers\AuthController@loginProses');


//BARANG
Route::get('/produk/{id}', 'App\Http\Controllers\BarangController@front');
Route::get('/', 'App\Http\Controllers\BarangController@frontC');
Route::get('/detail-barang/{id}', 'App\Http\Controllers\BarangController@detailBarang');

//BACKEND
Route::group(['middleware' => 'auth'], function () {

    //DASHBOARD
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index');

    //USER
    Route::get('/user', 'App\Http\Controllers\UserController@index');
    Route::get('/data-user', 'App\Http\Controllers\UserController@data');
    Route::post('/store-user', 'App\Http\Controllers\UserController@store');
    Route::post('/update-user', 'App\Http\Controllers\UserController@update');
    Route::post('/delete-user', 'App\Http\Controllers\UserController@delete');

    //BARANG
    Route::get('/barang', 'App\Http\Controllers\BarangController@index');
    Route::get('/data-barang', 'App\Http\Controllers\BarangController@data');
    Route::post('/store-barang', 'App\Http\Controllers\BarangController@store');
    Route::post('/update-barang', 'App\Http\Controllers\BarangController@update');
    Route::post('/delete-barang', 'App\Http\Controllers\BarangController@delete');
    Route::post('/import-barang', 'App\Http\Controllers\BarangController@import');
    Route::post('/upload-gambar-barang', 'App\Http\Controllers\BarangController@uploadGambar');
});

//LOGOUT
Route::get('/logout', function () {
    Auth::logout();
    return redirect('login');
})->name('logout');