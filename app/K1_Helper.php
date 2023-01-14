<?php

use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

use App\Models\k1\K1_Category;
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

