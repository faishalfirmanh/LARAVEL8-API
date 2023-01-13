<?php

use App\Http\Controllers\API\K1\CategoryController;
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
Route::get('get_product_by_id', [ProductController::class, 'getDataProductById']);//use
Route::get('get_product_all', [ProductController::class, 'getDataAllProduct']);//use
Route::get('search_product', [ProductController::class, 'searchProduct']); //param page and keyword

/** api K1 START */

/**------ category start------- */
/** --- testing repo patern--- */
Route::get('get_category',[CategoryController::class,'index'])->name('get_category');
Route::get('get_category_ParamId/{id}',[CategoryController::class,'getCategoryIdCon'])->name('get_category_byId');
Route::get('get_category_ParamName/{name}',[CategoryController::class,'getCategoryByNameCon'])->name('get_category_byName');
//for api----
Route::get('get_category_id',[CategoryController::class,'getCategory_IdCon'])->name('get_category_id');//->done
Route::get('get_category_name',[CategoryController::class,'getCategory_NameCon'])->name('get_category_name');
Route::post('post_category',[CategoryController::class,'postCategory_Con']);//->done
Route::post('update_category',[CategoryController::class,'updateCategory_Con']);//->done
Route::post('delete_category',[CategoryController::class,'deleteCategory_Con']);//->done
/**------ category end------- */

/** api K1 END */