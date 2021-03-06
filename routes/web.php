<?php

use App\Http\Controllers\InvoiceController;
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

Route::get('/', [InvoiceController::class, 'index'])->name('index');

Route::get('/get-all', [InvoiceController::class, 'getAll'])->name('get.all');

Route::post('/create', [InvoiceController::class, 'create'])->name('create');

Route::put('/update', [InvoiceController::class, 'update'])->name('update');

Route::post('/delete', [InvoiceController::class, 'delete'])->name('delete');
