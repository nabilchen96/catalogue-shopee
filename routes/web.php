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


//LOGIN
Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('login');
Route::post('/loginProses', 'App\Http\Controllers\AuthController@loginProses');

//ABSENSI
Route::get('/front-absensi', 'App\Http\Controllers\AbsensiController@frontAbsensi');
Route::post('/absensi-store', 'App\Http\Controllers\AbsensiController@store');

Route::get('/', function () {
    return view('frontend.landing');
});

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

    //AGENDA
    Route::get('/agenda', 'App\Http\Controllers\AgendaController@index');
    Route::get('/data-agenda', 'App\Http\Controllers\AgendaController@data');
    Route::post('/store-agenda', 'App\Http\Controllers\AgendaController@store');
    Route::post('/update-agenda', 'App\Http\Controllers\AgendaController@update');
    Route::post('/delete-agenda', 'App\Http\Controllers\AgendaController@delete');


    //ANGGOTA
    Route::get('/anggota', 'App\Http\Controllers\AnggotaController@index');
    Route::get('/data-anggota', 'App\Http\Controllers\AnggotaController@data');
    Route::post('/store-anggota', 'App\Http\Controllers\AnggotaController@store');
    Route::post('/update-anggota', 'App\Http\Controllers\AnggotaController@update');
    Route::post('/delete-anggota', 'App\Http\Controllers\AnggotaController@delete');

    //SURAT MASUK
    Route::get('/surat-masuk', 'App\Http\Controllers\SuratMasukController@index');
    Route::get('/data-surat-masuk', 'App\Http\Controllers\SuratMasukController@data');
    Route::post('/store-surat-masuk', 'App\Http\Controllers\SuratMasukController@store');
    Route::post('/update-surat-masuk', 'App\Http\Controllers\SuratMasukController@update');
    Route::post('/delete-surat-masuk', 'App\Http\Controllers\SuratMasukController@delete');

    //SURAT KELUAR
    Route::get('/surat-keluar', 'App\Http\Controllers\SuratKeluarController@index');
    Route::get('/data-surat-keluar', 'App\Http\Controllers\SuratKeluarController@data');
    Route::post('/store-surat-keluar', 'App\Http\Controllers\SuratKeluarController@store');
    Route::post('/update-surat-keluar', 'App\Http\Controllers\SuratKeluarController@update');
    Route::post('/delete-surat-keluar', 'App\Http\Controllers\SuratKeluarController@delete');

    //INVENTARIS
    Route::get('/inventaris', 'App\Http\Controllers\InventarisController@index');
    Route::get('/data-inventaris', 'App\Http\Controllers\InventarisController@data');
    Route::post('/store-inventaris', 'App\Http\Controllers\InventarisController@store');
    Route::post('/update-inventaris', 'App\Http\Controllers\InventarisController@update');
    Route::post('/delete-inventaris', 'App\Http\Controllers\InventarisController@delete');

    //BARANG
    Route::get('/barang', 'App\Http\Controllers\BarangController@index');
    Route::get('/data-barang', 'App\Http\Controllers\BarangController@data');
    Route::post('/store-barang', 'App\Http\Controllers\BarangController@store');
    Route::post('/update-barang', 'App\Http\Controllers\BarangController@update');
    Route::post('/delete-barang', 'App\Http\Controllers\BarangController@delete');

    //PEMBELIAN
    Route::get('/pembelian', 'App\Http\Controllers\PembelianController@index');
    Route::get('/data-pembelian', 'App\Http\Controllers\PembelianController@data');
    Route::post('/store-pembelian', 'App\Http\Controllers\PembelianController@store');
    Route::post('/update-pembelian', 'App\Http\Controllers\PembelianController@update');
    Route::post('/delete-pembelian', 'App\Http\Controllers\PembelianController@delete');

    //Penjualan
    Route::get('/penjualan', 'App\Http\Controllers\PenjualanController@index');
    Route::get('/data-penjualan', 'App\Http\Controllers\PenjualanController@data');
    Route::post('/store-penjualan', 'App\Http\Controllers\PenjualanController@store');
    Route::post('/update-penjualan', 'App\Http\Controllers\PenjualanController@update');
    Route::post('/delete-penjualan', 'App\Http\Controllers\PenjualanController@delete');

    //cicilan
    Route::get('/cicilan', 'App\Http\Controllers\CicilanController@index');
    Route::get('/data-cicilan', 'App\Http\Controllers\CicilanController@data');
    Route::post('/store-cicilan', 'App\Http\Controllers\CicilanController@store');
    Route::post('/update-cicilan', 'App\Http\Controllers\CicilanController@update');
    Route::post('/delete-cicilan', 'App\Http\Controllers\CicilanController@delete');

    //stok
    Route::get('/stok', 'App\Http\Controllers\StokController@index');
    Route::get('/data-stok', 'App\Http\Controllers\StokController@data');
    Route::get('/export-pdf-stok', 'App\Http\Controllers\StokController@exportPdf');

    //ABSENSI
    Route::get('/absensi', 'App\Http\Controllers\AbsensiController@index');
    Route::get('/data-absensi', 'App\Http\Controllers\AbsensiController@data');
    Route::post('/delete-absensi', 'App\Http\Controllers\AbsensiController@delete');
    Route::get('/export-pdf-absensi', 'App\Http\Controllers\AbsensiController@exportPdf');

    //JURNAL UMUM
    Route::get('/jurnal-umum', 'App\Http\Controllers\JurnalUmumController@index');
    Route::get('/data-jurnal-umum', 'App\Http\Controllers\JurnalUmumController@data');
    Route::post('/store-jurnal-umum', 'App\Http\Controllers\JurnalUmumController@store');
    Route::post('/update-jurnal-umum', 'App\Http\Controllers\JurnalUmumController@update');
    Route::post('/delete-jurnal-umum', 'App\Http\Controllers\JurnalUmumController@delete');
});

//LOGOUT
Route::get('/logout', function () {
    Auth::logout();
    return redirect('login');
})->name('logout');