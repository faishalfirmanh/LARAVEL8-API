<?php

namespace App\Http\Controllers\API\K1;

use App\Http\Controllers\Controller;
use App\Models\k1\K1_Product;
use App\Models\k1\K1_Product_supplier;
use App\Models\P1\Product;
use Illuminate\Http\Request;
use App\Service\K1\Product\ProductService;

class ProductController extends Controller
{
    //
    private $service_product;
    public function __construct(ProductService $service_product)
    {
        $this->service_product = $service_product;
    }
    public function getAllProduct_con(){
       
    }
    
    public function getProductById_con(Request $request){
        $id = $request->product_id;
        $cek = searchAllSupplierInRelation($id);
        if ($cek != NULL) {
            $product = K1_Product::query()->where('id',$id)->select('id','name_product','expired_date')->first();
            return response()->json([
                'product'=>$product,
                'data_supplier'=>$product->supplierProduct[0][0],
            ]);
        }else{
            return response()->json([
              'msg'=>'data no found'
            ],404);
        }
       
        //var_dump();
       // unset($product->supplierProduct[0]);
     
        
    }

    public function postProduct_con(Request $request){
        return $this->service_product->postProductService($request);
    }

    public function updateProduct_con(Request $request){
        $id = $request->id_product;
        return $this->service_product->updateProductService($id, $request);
    }

    public function deleteProduct_con(Request $request){

    }
}
