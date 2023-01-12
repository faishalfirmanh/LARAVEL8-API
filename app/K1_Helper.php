<?php

use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

use App\Models\k1\K1_Category;
use App\Models\k1\K1_Supplier;

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
