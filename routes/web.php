<?php

use App\Http\Controllers\WEB\k1\HomeControllerWeb_k1;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\P1\HomeController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[HomeControllerWeb_k1::class,'index']);
Route::get('/admin',[HomeControllerWeb_k1::class,'Dashboard'])->name('admin_k1_web');
Route::get('/Product',[HomeControllerWeb_k1::class,'GetProduct'])->name('product_k1_web');
Route::get('/Supplier',[HomeControllerWeb_k1::class,'GetSupplier'])->name('supplier_k1_web');