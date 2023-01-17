<?php

use App\Http\Controllers\API\K1\CategoryController;
use App\Http\Controllers\API\K1\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\P1\UserController;
use App\Http\Controllers\API\K1\ProductController;
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

/**---- supplier----- */
Route::get('get_supplier',[SupplierController::class,'get_allSupplier_con']);
Route::get('get_supplierById',[SupplierController::class,'get_SupplierById_con']);
Route::get('ajax_getPhoneSupplier',[SupplierController::class,'ajaxGetPhoneSupplier']);
Route::post('post_supplier',[SupplierController::class,'post_Supplier_con']);
Route::post('update_supplier',[SupplierController::class,'update_Supplier_con']);
Route::post('delete_supplier',[SupplierController::class,'delete_Supplier_con']);

/**---- supplier----- */

/**---- Product Start----- */
Route::get('get_allProduct',[ProductController::class, 'getAllProduct_con']);
Route::get('get_ProductByid',[ProductController::class, 'getProductById_con']);
Route::post('post_Product',[ProductController::class, 'postProduct_con']);//->ok
Route::post('update_Product',[ProductController::class, 'updateProduct_con']);
Route::post('delete_Product',[ProductController::class, 'deleteProduct_con']);
/**---- Product End----- */

/** api K1 END */