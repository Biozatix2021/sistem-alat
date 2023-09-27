<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DataAlatTerpasangController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\GaransiController;
use App\Http\Controllers\ManualBookController;
use App\Http\Controllers\PemasanganAlatController;
use App\Http\Controllers\RumahSakitController;
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

Route::get('auth', [AuthController::class, 'index']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['session']], function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::resource('brand', BrandController::class);
    Route::resource('rumahsakit', RumahSakitController::class);
    Route::resource('alat', AlatController::class);
    Route::resource('garansi', GaransiController::class);
    Route::resource('faqs', FaqsController::class);
    Route::resource('manual-book', ManualBookController::class);
    Route::post('ckeditor/upload', [FaqsController::class, 'upload'])->name('ckeditor.upload');

    Route::controller(PemasanganAlatController::class)->group(function () {
        Route::resource('pemasangan-alat', PemasanganAlatController::class);
        Route::post('/get_rs', 'get_rs')->name('get_rs');
    });

    Route::resource('data-alat-terpasang', DataAlatTerpasangController::class);
});
