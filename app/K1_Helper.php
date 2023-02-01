<?php

use Illuminate\Support\Facades\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\k1\K1_User;
use App\Models\k1\K1_Category;
use App\Models\k1\K1_Product;
use App\Models\k1\K1_Product_category;
use App\Models\k1\K1_Product_supplier;
use App\Models\K1\K1_Role_user;
use App\Models\k1\K1_Supplier;
use App\Models\k1\K1_Generate_New_Transaction;
use App\Models\k1\K1_Product_stock;
use App\Models\K1\K1_Setting_promo_transaction;
use App\Models\K1\K1_Transaction_detail;
use App\Models\K1\K1_Transacion_struck;
use App\Models\K1\K1_Voucher_for_transaction;

if (!function_exists('cekCategoryId')) {
   function cekCategoryId($id){
        $data = K1_Category::query()->where('id',$id)->first();
        if ($data != NULL) {
           return $data;
        }else{
            return null;
        }
   }
}
if (!function_exists('cekEmailUser')) {
   function cekEmailUser($email){
     $data = K1_User::query()->where('email',$email)->first();
     if ($data != NULL) {
        return $data;
     }else{
        return null;
     }
   }
}

if (!function_exists('cekIdUser')) {
    function cekIdUser($id){
      $data = K1_User::query()->where('id',$id)->first();
      if ($data != NULL) {
         return $data;
      }else{
         return null;
      }
    }
 }

if (!function_exists('cekRuleIdForUser')) {
    function cekRuleIdForUser($id){
      $data = K1_Role_user::find($id);
      if ($data != NULL) {
         return $data;
      }else{
         return null;
      }
    }
 }
if (!function_exists('cekCategoryName')) {
    function cekCategoryName($name){
        $data = K1_Category::query()->where('name_category',$name)->first();
        if ($data != NULL) {
           return $data;
        }else{
            return null;
        }
    }
}

if (!function_exists('cekPhoneNumberSupplier')) {
    function cekPhoneNumberSupplier($phone){
        $data = K1_Supplier::query()->where('phone_number',$phone)->first();
        if ($data != NULL) {
           return $data;
        }else{
            return null;
        }
    }
}

if (!function_exists('cekSupplierById')) {
    function cekSupplierById($id){
        $data = K1_Supplier::query()->where('id',$id)->first();
        if ($data != NULL) {
           return $data;
        }else{
            return null;
        }
    }
}

if(!function_exists('cekInputSupplierName')){
    function cekInputSupplierName($data_old,$name){
        if (!empty($name)) {
           return $data_old->name = $name;
        }
        return $data_old->name = $data_old->name;
    }
}
if (!function_exists('cekInputSupplierPhone')) {
    function cekInputSupplierPhone($data_old,$phone){
        if (!empty($phone)) {
            return $data_old->phone_number = $phone;
        }
        return $data_old->phone_number = $data_old->phone_number;
    }
}
if (!function_exists('cekInputSupplierPt')) {
   function cekInputSupplierPt($data_old, $pt){
    if (!empty($pt)) {
        return $data_old->name_pt = $pt;
    }
    return $data_old->name_pt = $data_old->name_pt;
   }
}

if (!function_exists('searchAllSupplierInRelation')) { //ARRAY
    function searchAllSupplierInRelation($idProduct){
        $search = K1_Product_supplier::query()->where('id_product',$idProduct)->get();
        if (sizeof($search)>0) {
            return $search;
        }else{
            return null;
        }
    }
 }

 if (!function_exists('cekCategoryRelationProdByIdCategory')) {
    function cekCategoryRelationProdByIdCategory($idCategory){
        $data = K1_Product_category::query()->where('id_category',$idCategory)->first();
        if ($data != NULL) {
            return $data;
        }else{
            return null;
        }
    }
 }
 
 if (!function_exists('cekSupplierRelationProdByIdSupplier')) {
    function cekSupplierRelationProdByIdSupplier($idSupplier){
        $data = K1_Product_supplier::query()->where('id_supplier',$idSupplier)->first();
        if ($data != null) {
            return $data;
        }else{
            return null;
        }
    }
 }


 if (!function_exists('getLastIdUser_k1')) {
    function getLastIdUser_k1(){
        $data =  K1_User::max('id');
        return intval($data)+1;
    }
 }

 if (!function_exists('getLastIdProd')) {
    function getLastIdProd(){
        $data =  K1_Product::max('id');
        if ($data == NULL) {
            return 0+1;
        }else{
            return intval($data)+1;
        }
    }
 }

 if (!function_exists('getProductById')) {
    function getProductById($idProd){
        $data =  K1_Product::query()->where('id',$idProd)->first();
        if ($data != NULL) {
            return $data;
        }else{
            return null;
        }
    }
 }

 if (!function_exists('getProductStockAndPrice')) {
    function getProductStockAndPrice($idProd){
        $data =  K1_Product_stock::query()->where('id',$idProd)->first();
        if ($data != NULL) {
            return $data;
        }else{
            return null;
        }
    }
 }

 if (!function_exists('getProductByName')) {
    function getProductByName($name){
        $data =  K1_Product::query()->where('name_product',$name)->first();
        if ($data != NULL) {
            return $data;
        }else{
            return null;
        }
    }
 }

 if (!function_exists('cekNameProduct')) {
    function cekNameProduct($name){
        $search = K1_Product::query()->where('name_product',$name)->first();
        if ($search != NULL) {
            return $search;
        }else{
            return null;
        }
    }
 }

 if (!function_exists('searchSupplierInRelationById')) {//FIRST
    function searchSupplierInRelationById($idProduct){
        $search = K1_Product_supplier::query()->where('id_product',$idProduct)->first();
        if ($search != NULL) {
            return $search;
        }else{
            return null;
        }
    }
 }
 /*** update product */
 if (!function_exists('cekInputNameProd')){
    function cekInputNameProd($data, $name){
        if (!empty($name)) {
            return $data->name_product = $name;
        }
        return $data->name_product = $data->name_product;
    }
 }
 if (!function_exists('cekExpiredProd')){
    function cekExpiredProd($data, $date){
        if (!empty($date)) {
            return $data->expired_date = $date;
        }
        return $data->expired_date = $data->expired_date;
    }
 }
 if (!function_exists('cekInputCategoryProd')){
    function cekInputCategoryProd($data, $idCategory){
        if (!empty($idCategory)) {
           return $data->id_category = $idCategory;
        }
        return $data->id_category = $data->id_category;
    }
 }
 if (!function_exists('cekInputSupplierProd')){
    function cekInputSupplierProd($data, $idSupplier){
        if (!empty($idSupplier)) {
           return $data->id_supplier = $idSupplier;
        }
        return $data->id_supplier = $data->id_supplier; 
    }
 }
 if (!function_exists('cekInputStockProd')){
    function cekInputStockProd($data, $stock){
        if (!empty($stock)) {
            return $data->stock = $stock;
        }
        return $data->stock = $data->stock;
    }
 }
 if (!function_exists('cekInputHargaJual')){
    function cekInputHargaJual($data, $sell){
        if (!empty($sell)) {
           return $data->harga_jual = $sell;
        }
        return $data->harga_jual =  $data->harga_jual;
    }
 }
 if (!function_exists('cekInputHargaBeli')){
    function cekInputHargaBeli($data, $buy){
        if (!empty($buy)) {
            return $data->harga_beli = $buy;
        }
        return $data->harga_beli = $data->harga_beli;
    }
 }
/**-- transaction */

if (!function_exists('getCodeGenerateTransaction')) {
   function getCodeGenerateTransaction($kode){
     $data = K1_Generate_New_Transaction::query()->where('kode_transaction',$kode)->first();
     if ($data != null) {
        return $data;
     }else{
        return null;
     }
   }
}

if (!function_exists('cekTransactionSameProdId')) {
    function cekTransactionSameProdId($idProd,$kode){
      $data = K1_Transaction_detail::query()->where('id_product',$idProd)
        ->where('kode_transaction',$kode)->first();
      if ($data != null) {
         return $data;
      }else{
         return null;
      }
    }
 }

 if (!function_exists('cekTransactionCodeInDetails')) {
    function cekTransactionCodeInDetails($kode){
      $data = K1_Transaction_detail::query()
        ->where('kode_transaction',$kode)->first();
      if ($data != null) {
         return $data;
      }else{
         return null;
      }
    }
 }

 if (!function_exists('cekTransactionCodeInStruck')) {
    function cekTransactionCodeInStruck($kode){
      $data = K1_Transacion_struck::query()
        ->where('kode_transaction_inStruck',$kode)->first();
      if ($data != null) {
         return $data;
      }else{
         return null;
      }
    }
 }
if (!function_exists('cekSettingVoucer')) {
    function cekSettingVoucer(){
        $data = K1_Setting_promo_transaction::find(1)->first();
        if ($data != null) {
           return $data;
        }else{
           return null;
        }
    }
}

if(!function_exists('generateRandomStringForVoucher')){
    function generateRandomStringForVoucher($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
if (!function_exists('voucher_from_date')) {
    function voucher_from_date(){
        $new_code = date('Y-m-d h:i:sa');
        $vo = str_replace(" ","L",str_replace(":","",str_replace("-","",$new_code)));
        return $vo;
    }
}

if (!function_exists('cekVoucherCode')) {
    function cekVoucherCode($code){
        $data = K1_Voucher_for_transaction::query()->where('kode_voucher',$code)->first();
        if ($data != null) {
            return $data;
        }else{
            return null;
        }
    }
}

if (!function_exists('cekCodeTransInVocuher')) {
    function cekCodeTransInVocuher($codeTrans){
        $data = K1_Voucher_for_transaction::query()->where('code_transaction',$codeTrans)->first();
        if ($data != null) {
            return $data;
        }else{
            return null;
        }
    }
}