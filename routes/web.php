<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeterController;
use App\Http\Controllers\InvoiceController;
use App\Http\Livewire\MetersTable;

Auth::routes();

Route::get('/home', [App\Http\Controllers\MeterController::class, 'index'])->name('home');
Route::get('/autocomplete', [App\Http\Controllers\MeterController::class, 'autocomplete'])->name('autocomplete');
Route::post('/excel-import', [App\Http\Controllers\MeterController::class, 'import'])->name('excel-import');
Route::get('/csv-export', [App\Http\Controllers\MeterController::class, 'export'])->name('csv-export');

Route::resource('meters', App\Http\Controllers\MeterController::class);
Route::resource('consumertable', App\Http\Controllers\MeterController::class);
Route::resource('consumptionstable', App\Http\Controllers\MeterController::class);
Route::resource('consumptionstable', App\Http\Livewire\MetersTable::class);
Route::resource('consumertable', App\Http\Livewire\MetersTable::class);

Route::post('deleterow', [MeterController::class,'destroy'])->name('deleterow');
Route::get('/invoice',[InvoiceController::class,'all_invoices'])->name('invoice');
Route::get('/export-invoices',[InvoiceController::class,'all_invoices'])->name('invoice');
Route::get('/customer-invoice/{id}',[InvoiceController::class,'customer_invoice'])->name('customer_invoice');

