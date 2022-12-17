<?php

use Illuminate\Support\Facades\Request;
use Carbon\Carbon;
use App\Models\P1\ProductImage;
use App\Models\P1\OnlineShop;
use App\Models\P1\Product;
use Intervention\Image\Facades\Image as Image;
use League\Flysystem\Filesystem;


if(!function_exists('path_save')){
    function path_save($path){
        $path_img_brief = base_path($path);
        $change_path_brief =  preg_replace('/\\\\/', '/', $path_img_brief);
        $to_arr_brief = explode("/",$change_path_brief);
        $arr_brief = array_splice($to_arr_brief, 5, 8);
        $final_path_can_access = url('/') .'/'. implode("/",$arr_brief);
        $to_arr2  = explode("/",$final_path_can_access); 
        $arr_delete = [0=>'',1=>'',2=>'',3=>'',4=>'',5=>'',6=>''];
        $aa = \array_diff_key($to_arr2, $arr_delete);
        $to_str_ = implode('/',$aa);
        $base_url = url('/').'/'.$to_str_;
        return $base_url;
    }
}

//helper tidak bisa mengembalikan json
if (!function_exists('cek_marketplaceById')) { //if null marketplace
   function cek_marketplaceById($id){
        $cek = OnlineShop::query()->where('id',$id)->first();
        if ($cek == NULL) {
            return 'null marketplace';
        }else{
            return $cek;
        }   
   }
}

if (!function_exists('cek_ProductById')) { 
    function cek_ProductById($id){
         $cek = Product::query()->where('id',$id)->first();
         if ($cek == NULL) {
             return 'null product';
         }else{
            return $cek;
         }   
    }
 }