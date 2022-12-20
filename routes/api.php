<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\P1\UserController;
use App\Http\Controllers\API\P1\ProductController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('loginuser', [UserController::class, 'login'])->name('api.loginuser');
Route::post('register', [UserController::class, 'Register']);
Route::post('login', [UserController::class, 'Login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login_api', [UserController::class, 'LoginApi']);//jwt
Route::group(['middleware' => ['jwt.verify']], function() { //jwt
    Route::resource('products', ProductController::class);
    Route::post('delete_products',[ProductController::class,'deleteProduct']);//use
    Route::post('update_products',[ProductController::class,'updateProduct']);
    Route::post('linkProduct', [ProductController::class, 'addLinkMarketplaceToProduct']);
    Route::post('deleteLinkProduct', [ProductController::class, 'deleteLinkMarketPlace']);
    Route::post('logout_api', [UserController::class, 'logoutApi']);
});
Route::get('coba', [ProductController::class, 'addLinkMarketplaceToProduct']);
Route::get('get_product', [ProductController::class, 'getDataProduct']);
Route::get('get_product_by_id', [ProductController::class, 'getDataProductById']);//use
