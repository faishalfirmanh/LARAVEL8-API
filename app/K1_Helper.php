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
use PhpParser\Node\Stmt\Else_;

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
