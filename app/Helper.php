<?php

use Illuminate\Support\Facades\Request;
use Carbon\Carbon;
use App\Models\P1\ProductImage;
use App\Models\P1\OnlineShop;
use App\Models\P1\UserApi;
use App\Models\P1\Category;
use App\Models\P1\Product;
use App\Models\P1\LinkOnlineShopProduct;
use Intervention\Image\Facades\Image as Image;
use League\Flysystem\Filesystem;


//1
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

//2
if(!function_exists('cekStringSubCobalagi')){ //untuk sub domain hapus path cobalgip1/public
    function cekStringSubCobalagi($url){
        if (strpos($url, 'cobalagip1') !== false) {
           $toar = explode(".",$url);
           $replace_fix = str_replace("public/","",str_replace("cobalagip1/","",$toar[2]));
           $toar[2] = $replace_fix;
           $final_path = implode(".",$toar);
           return $final_path;
        }else{
           return $url;
        }
     }
}

//cek string space replace with _
if (!function_exists('cekStringAvailableSpace')) {
    function cekStringAvailableSpace($string){
        if ( preg_match('/\s/',$string) ){
            return str_replace(" ","_",$string);
        } else {
            return $string;
        }
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

if (!function_exists('cek_LinkMarketById')) { 
    function cek_LinkMarketById($id){
        $cek = LinkOnlineShopProduct::query()->where('id',$id)->first();
        if ($cek == NULL) {
            return 'null link';
        }else{
           return $cek;
        }   
    }
}

if (!function_exists('cek_CategoryProductById')) { 
    function cek_CategoryProductById($id){
         $cek = Category::query()->where('id',$id)->first();
         if ($cek == NULL) {
             return null;
         }else{
            return $cek->name;
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

 if (!function_exists('cek_nameUserById')) {
    function cek_nameUserById($id){
        $cek = UserApi::find($id);
        if ($cek != NULL) {
           return $cek->name;
        }else{
            return null;
        }
    }
 }

 if (!function_exists('cek_NameMareketBaseOnUrl')) { 
    function cek_NameMareketBaseOnUrl($name){
        if (strpos($name, 'tokopedia') !== false) {
           return "tokopedia";
        }else if (strpos($name, 'bukalapak') !== false) {
            return "bukalapak";
        }else if (strpos($name, 'shopee') !== false) {
            return "shopee";
        }else if (strpos($name, 'blibli') !== false) {
            return "blibli";
        }else if (strpos($name, 'lazada') !== false) {
            return "lazada";
        }else{
            return null;
        }
    }
 }