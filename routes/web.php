<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeterController;
use App\Http\Controllers\InvoiceController;
use App\Http\Livewire\MetersTable;
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

Route::get('/home', MetersTable::class, function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\MeterController::class, 'index'])->name('home');
Route::get('/autocomplete', [App\Http\Controllers\MeterController::class, 'autocomplete'])->name('autocomplete');
Route::post('/excel-import', [App\Http\Controllers\MeterController::class, 'import'])->name('excel-import');
Route::get('/csv-export', [App\Http\Controllers\MeterController::class, 'export'])->name('csv-export');

//This route gives access to all functions within the controller class
Route::resource('meternumbertable', App\Http\Controllers\MeterController::class);
Route::resource('consumertable', App\Http\Controllers\MeterController::class);
Route::resource('consumertable', App\HttpLivewire\MetersTable::class);

Route::post('deleterow', [MeterController::class,'destroy'])->name('deleterow');
/*Route::get('/create', [App\Http\Controllers\MeterController::class, 'create'])->name('create');
Route::POST('/store', [App\Http\Controllers\MeterController::class, 'store'])->name('store');*/
Route::get('/invoice',[InvoiceController::class,'show'])->name('invoice');
Route::get('/SpecificInvoice',[InvoiceController::class,'showSpecificInvoice'])->name('SpecificInvoice');

