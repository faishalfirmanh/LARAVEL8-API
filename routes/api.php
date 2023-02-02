<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\P1\UserController;
use App\Http\Controllers\API\P1\ProductController;
use App\Http\Controllers\API\K1\ProductControllerK1;
use App\Http\Controllers\API\K1\CategoryControllerK1;
use App\Http\Controllers\API\K1\SupplierControllerK1;
use App\Http\Controllers\API\K1\TransactionControllerK1;
use App\Http\Controllers\API\K1\UserControllerK1;
use App\Http\Controllers\API\K1\SettingPromoControllerK1;
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
Route::get('get_category',[CategoryControllerK1::class,'index'])->name('get_category');
Route::get('get_category_ParamId/{id}',[CategoryControllerK1::class,'getCategoryIdCon'])->name('get_category_byId');
Route::get('get_category_ParamName/{name}',[CategoryControllerK1::class,'getCategoryByNameCon'])->name('get_category_byName');
//for api----

/**------- User ----------- */
Route::post('register_userK1',[UserControllerK1::class,'RegisterUserCon']);//ok
Route::post('login_userK1',[UserControllerK1::class, 'LoginUserCon']);//ok
Route::get('get_userByIdk1',[UserControllerK1::class,'getUserByIdCon']);
/**------- User End ----------- */


Route::get('get_category_id',[CategoryControllerK1::class,'getCategory_IdCon'])->name('get_category_id');//->done
Route::get('get_category_name',[CategoryControllerK1::class,'getCategory_NameCon'])->name('get_category_name');
Route::post('post_category',[CategoryControllerK1::class,'postCategory_Con']);//->done
Route::post('update_category',[CategoryControllerK1::class,'updateCategory_Con']);//->done
Route::post('delete_category',[CategoryControllerK1::class,'deleteCategory_Con']);//->done
/**------ category end------- */

/**---- supplier----- */
Route::middleware('auth:sanctum')->group(function () { //use auth:sanctum wrap in hire
    Route::get('get_supplier',[SupplierControllerK1::class,'get_allSupplier_con']);
});

Route::get('get_supplierById',[SupplierControllerK1::class,'get_SupplierById_con']);
Route::get('ajax_getPhoneSupplier',[SupplierControllerK1::class,'ajaxGetPhoneSupplier']);
Route::post('post_supplier',[SupplierControllerK1::class,'post_Supplier_con']);
Route::post('update_supplier',[SupplierControllerK1::class,'update_Supplier_con']);
Route::post('delete_supplier',[SupplierControllerK1::class,'delete_Supplier_con']);

/**---- supplier----- */

/**---- Product Start----- */
Route::get('get_allProduct',[ProductControllerK1::class, 'getAllProduct_con']);
Route::get('get_ProductByid',[ProductControllerK1::class, 'getProductById_con']);
Route::post('post_Product',[ProductControllerK1::class, 'postProduct_con']);//->ok
Route::post('update_Product',[ProductControllerK1::class, 'updateProduct_con']);
Route::post('delete_Product',[ProductControllerK1::class, 'deleteProduct_con']);
/**---- Product End----- */

/**---- Transaction start------ */
Route::post('generate_new_trans',[TransactionControllerK1::class, 'GenerateNewTransaction_con']);
Route::post('post_transaction',[TransactionControllerK1::class, 'PostTransaction_con']);
Route::post('print_transaction',[TransactionControllerK1::class, 'PrintTransaction_con']);
Route::put('print_transaction_update',[TransactionControllerK1::class, 'UpdateTransaction_con']);
Route::get('get_transaction_struck',[TransactionControllerK1::class, 'GetTransactionStruck_con']);
/**---- Transaction end------ */

/**-----Setting  ----------*/
Route::get('get_setting_byId',[SettingPromoControllerK1::class, 'GetSettingPromoCon']);
Route::put('update_setting',[SettingPromoControllerK1::class, 'UpdateSettingPromoCon']);
/**----- -----------*/
/** api K1 END */